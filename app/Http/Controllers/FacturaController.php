<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FacturaController extends Controller
{
    public function showCheckout()
    {
        $empleados = DB::table('usuario as u')
            ->join('usuario_rol as ur', 'ur.fkpk_id_usuario', '=', 'u.id_usuario')
            ->join('rol', 'ur.fkpk_id_rol', '=', 'rol.id_rol')
            ->whereRaw('LOWER(rol.nom_rol) = ?', ['empleado'])
            ->select('u.id_usuario', 'u.primer_nom', 'u.primer_apelli')
            ->get();

        return view('client.checkout', [
            'empleados' => $empleados,
            'clienteNombre' => session('user_name'),
            'clienteEmail' => session('user_email'),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'carrito_items' => 'required|string',
            'cedula' => 'nullable|string|max:100',
            'fk_id_empleado' => 'required|integer',
            'nombre_cliente' => 'required|string|max:255',
            'correo_cliente' => 'required|email|max:255',
        ]);

        $items = json_decode($validated['carrito_items'], true);

        if (empty($items) || !is_array($items)) {
            return redirect()->back()->with('error', 'El carrito está vacío. Agrega prendas antes de continuar.');
        }

        $idCliente = session('user_id');
        if (!$idCliente) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para completar la compra.');
        }

        DB::beginTransaction();
        try {
            foreach ($items as $item) {
                $cantidad = $item['cantidad'] ?? 1;
                $precioUnitario = $item['precio'];
                $subtotal = $precioUnitario * $cantidad;
                $total = $subtotal;

                DB::table('venta')->insert([
                    'fecha_venta' => now(),
                    'total' => $total,
                    'cantidad' => $cantidad,
                    'precio_unitario' => $precioUnitario,
                    'subtotal' => $subtotal,
                    'fk_id_administrador' => null,
                    'fk_id_cliente' => $idCliente,
                    'fk_id_empleado' => null,
                ]);

                // Decrementar el stock de la prenda
                if (!empty($item['codigo_barras'])) {
                    DB::table('prenda')
                        ->where('codigo_barras', $item['codigo_barras'])
                        ->decrement('stock', $cantidad);
                }
            }

            DB::commit();
            return redirect()->route('client.checkout')->with('success', 'Su pedido ha sido registrado.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error al procesar el pedido: ' . $e->getMessage());
        }
    }

    public function indexAdmin()
    {
        $facturas = DB::table('facturas')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard.facturas', compact('facturas'));
    }

    public function showAdmin($id)
    {
        $factura = DB::table('facturas')->where('id_factura', $id)->first();
        if (!$factura) {
            return redirect()->route('dashboard.facturas')->with('error', 'Factura no encontrada.');
        }

        $items = DB::table('factura_prenda')->where('fkpk_id_factura', $id)->get();

        return view('dashboard.factura_detalle', compact('factura', 'items'));
    }

    public function accept($id)
    {
        $factura = DB::table('facturas')->where('id_factura', $id)->first();
        if (!$factura) {
            return redirect()->route('dashboard.facturas')->with('error', 'Factura no encontrada.');
        }

        DB::table('facturas')->where('id_factura', $id)->update([
            'estado' => 'aceptada',
            'updated_at' => now(),
        ]);

        return redirect()->route('dashboard.ventas', ['factura_id' => $id])->with('success', 'Factura aceptada. Ya puedes registrar la venta.');
    }
}
