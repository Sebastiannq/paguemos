<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    /**
     * Registrar una venta, apartado, cambio o devolución.
     * Descuenta (o suma) stock según el tipo de operación.
     */
    public function store(Request $request)
    {
        // DEBUG TEMPORAL — quitar después de confirmar que funciona
        \Log::info('VENTA POST recibido', $request->all());

        $validated = $request->validate([
            'carrito_items'    => 'required_without:codigo_barras|string',
            'codigo_barras'    => 'nullable|string|exists:prenda,codigo_barras',
            'cantidad_vendida' => 'nullable|integer|min:1',
            'precio_unitario'  => 'nullable|integer|min:0',
            'tipo_proceso'     => 'required|string|in:venta,apartado,cambio,devolucion',
            'fk_id_cliente'    => 'required|integer',
        ]);

        $carritoItems = [];
        if ($request->filled('carrito_items')) {
            $carritoItems = json_decode($request->input('carrito_items'), true);
        }

        if (!is_array($carritoItems)) {
            return redirect()->route('dashboard.staff', ['section' => 'ventas'])->with('error', 'El carrito no tiene un formato válido.');
        }

        if (empty($carritoItems) && $request->filled('codigo_barras')) {
            $carritoItems[] = [
                'codigo_barras' => trim($request->codigo_barras),
                'cantidad'      => (int) $request->cantidad_vendida,
                'precio'        => (int) $request->precio_unitario,
            ];
        }

        if (empty($carritoItems)) {
            return redirect()->route('dashboard.staff', ['section' => 'ventas'])->with('error', 'El carrito está vacío. Agrega prendas antes de continuar.');
        }

        $tipo      = $request->tipo_proceso;
        $idUsuario = session('user_id');
        $idCliente = (int) $request->fk_id_cliente;

        \Log::info('VENTA datos procesados', [
            'items'     => $carritoItems,
            'tipo'      => $tipo,
            'idUsuario' => $idUsuario,
            'idCliente' => $idCliente,
        ]);

        $esAdmin    = DB::table('administrador')->where('fkpk_id_administrador', $idUsuario)->exists();
        $esEmpleado = DB::table('empleado')->where('fkpk_id_empleado', $idUsuario)->exists();

        \Log::info('VENTA roles', ['esAdmin' => $esAdmin, 'esEmpleado' => $esEmpleado]);

        if (!$esAdmin && !$esEmpleado) {
            return redirect()->route('dashboard.staff', ['section' => 'ventas'])->with('error', 'Tu usuario no tiene perfil de administrador o empleado registrado en el sistema.');
        }

        try {
            DB::transaction(function () use ($carritoItems, $tipo, $idUsuario, $idCliente, $esAdmin) {
                $total    = 0;
                $subtotal = 0;
                $cantidadTotal = 0;

                foreach ($carritoItems as $item) {
                    $codigo = trim($item['codigo_barras'] ?? '');
                    $cantidad = isset($item['cantidad']) ? (int) $item['cantidad'] : 0;
                    $precio = isset($item['precio']) ? (int) $item['precio'] : 0;

                    if (!$codigo || $cantidad < 1) {
                        throw new \Exception('Un ítem del carrito es inválido.');
                    }

                    $prenda = DB::table('prenda')->where('codigo_barras', $codigo)->lockForUpdate()->first();
                    if (!$prenda) {
                        throw new \Exception('La prenda con código ' . $codigo . ' no existe.');
                    }

                    if ($tipo === 'devolucion') {
                        DB::table('prenda')->where('codigo_barras', $codigo)->increment('stock', $cantidad);
                        $itemTotal = $precio * $cantidad * -1;
                    } else {
                        if ($prenda->stock < $cantidad) {
                            throw new \Exception('Stock insuficiente para ' . $codigo . '. Disponible: ' . $prenda->stock);
                        }
                        DB::table('prenda')->where('codigo_barras', $codigo)->decrement('stock', $cantidad);
                        $itemTotal = $precio * $cantidad;
                    }

                    $subtotal += $precio * $cantidad;
                    $total += $itemTotal;
                    $cantidadTotal += $cantidad;
                }

                if ($esAdmin) {
                    $idAdmin    = $idUsuario;
                    $idEmpleado = DB::table('empleado')->value('fkpk_id_empleado') ?? $idUsuario;
                } else {
                    $idAdmin    = DB::table('administrador')->value('fkpk_id_administrador');
                    $idEmpleado = $idUsuario;
                }

                $idVenta = DB::table('venta')->insertGetId([
                    'fecha_venta'         => now(),
                    'total'               => $total,
                    'cantidad'            => $cantidadTotal,
                    'precio_unitario'     => $carritoItems[0]['precio'] ?? 0,
                    'subtotal'            => $subtotal,
                    'fk_id_administrador' => $idAdmin,
                    'fk_id_cliente'       => $idCliente,
                    'fk_id_empleado'      => $idEmpleado,
                ]);

                foreach ($carritoItems as $item) {
                    DB::table('venta_prenda')->insert([
                        'fkpk_id_venta'      => $idVenta,
                        'fkpk_codigo_barras' => trim($item['codigo_barras']),
                        'cantidad_vendida'   => (int) $item['cantidad'],
                    ]);
                }
            });
        } catch (\Exception $e) {
            \Log::error('VENTA error en transacción: ' . $e->getMessage());
            return redirect()->route('dashboard.staff', ['section' => 'ventas'])->with('error', 'Error al registrar: ' . $e->getMessage());
        }

        $mensajes = [
            'venta'      => 'Venta registrada correctamente.',
            'apartado'   => 'Apartado registrado correctamente.',
            'cambio'     => 'Cambio registrado correctamente.',
            'devolucion' => 'Devolución procesada correctamente.',
        ];

        return redirect()->route('dashboard.staff', ['section' => 'ventas'])->with('success', $mensajes[$tipo] ?? 'Operación registrada.');
    }

    public function index(Request $request)
    {
        $acceptedInvoice = null;

        if ($request->has('factura_id')) {
            $acceptedInvoice = DB::table('facturas')->where('id_factura', $request->query('factura_id'))->first();
            if ($acceptedInvoice) {
                $acceptedInvoice->items = DB::table('factura_prenda')->where('fkpk_id_factura', $acceptedInvoice->id_factura)->get();
            }
        }

        return view('dashboard.ventas', compact('acceptedInvoice'));
    }
}