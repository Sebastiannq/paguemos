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
            'codigo_barras'    => 'required|string|exists:prenda,codigo_barras',
            'cantidad_vendida' => 'required|integer|min:1',
            'precio_unitario'  => 'required|integer|min:0',
            'tipo_proceso'     => 'required|string|in:venta,apartado,cambio,devolucion',
            'fk_id_cliente'    => 'required|integer',
        ]);

        $codigo    = trim($request->codigo_barras);
        $cantidad  = (int) $request->cantidad_vendida;
        $precio    = (int) $request->precio_unitario;
        $tipo      = $request->tipo_proceso;
        $idUsuario = session('user_id');
        $idCliente = (int) $request->fk_id_cliente;

        \Log::info('VENTA datos procesados', [
            'codigo'    => $codigo,
            'cantidad'  => $cantidad,
            'precio'    => $precio,
            'tipo'      => $tipo,
            'idUsuario' => $idUsuario,
            'idCliente' => $idCliente,
        ]);

        $prenda = DB::table('prenda')->where('codigo_barras', $codigo)->lockForUpdate()->first();

        if (!$prenda) {
            return redirect()->back()->with('error', 'La prenda no existe.');
        }

        $esAdmin    = DB::table('administrador')->where('fkpk_id_administrador', $idUsuario)->exists();
        $esEmpleado = DB::table('empleado')->where('fkpk_id_empleado', $idUsuario)->exists();

        \Log::info('VENTA roles', ['esAdmin' => $esAdmin, 'esEmpleado' => $esEmpleado]);

        if (!$esAdmin && !$esEmpleado) {
            return redirect()->back()->with('error', 'Tu usuario no tiene perfil de administrador o empleado registrado en el sistema.');
        }

        $subtotal = $precio * $cantidad;
        $total    = ($tipo === 'devolucion') ? $subtotal * -1 : $subtotal;

        try {
            DB::transaction(function () use (
                $prenda, $codigo, $cantidad, $precio, $subtotal, $total,
                $tipo, $idUsuario, $idCliente, $esAdmin
            ) {
                if ($tipo === 'devolucion') {
                    DB::table('prenda')->where('codigo_barras', $codigo)->increment('stock', $cantidad);
                } else {
                    if ($prenda->stock < $cantidad) {
                        throw new \Exception('Stock insuficiente. Disponible: ' . $prenda->stock);
                    }
                    DB::table('prenda')->where('codigo_barras', $codigo)->decrement('stock', $cantidad);
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
                    'cantidad'            => $cantidad,
                    'precio_unitario'     => $precio,
                    'subtotal'            => $subtotal,
                    'fk_id_administrador' => $idAdmin,
                    'fk_id_cliente'       => $idCliente,
                    'fk_id_empleado'      => $idEmpleado,
                ]);

                DB::table('venta_prenda')->insert([
                    'fkpk_id_venta'      => $idVenta,
                    'fkpk_codigo_barras' => $codigo,
                    'cantidad_vendida'   => $cantidad,
                ]);
            });
        } catch (\Exception $e) {
            \Log::error('VENTA error en transacción: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al registrar: ' . $e->getMessage());
        }

        $mensajes = [
            'venta'      => 'Venta registrada correctamente.',
            'apartado'   => 'Apartado registrado correctamente.',
            'cambio'     => 'Cambio registrado correctamente.',
            'devolucion' => 'Devolución procesada correctamente.',
        ];

        return redirect()->back()->with('success', $mensajes[$tipo] ?? 'Operación registrada.');
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