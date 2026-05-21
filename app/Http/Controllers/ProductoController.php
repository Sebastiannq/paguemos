<?php

namespace App\Http\Controllers;

use App\Models\Prenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{
    public function index()
    {
        $prendas = DB::table('prenda')
            ->join('genero_prend', 'prenda.fk_id_genero', '=', 'genero_prend.id_genero_prend')
            ->join('t_prendas', 'prenda.fk_idt_prendas', '=', 't_prendas.idt_prendas')
            ->join('Color', 'prenda.fk_id_color', '=', 'Color.id_color')
            ->select('prenda.*', 'genero_prend.tipo_genero', 't_prendas.talla_prend', 'Color.nom_color')
            ->get();

        // Agregamos las ventas para enviarlas al staff.blade.php
        $ventas = DB::table('venta')->orderBy('fecha_venta', 'desc')->get();
        
        $usuarios = DB::table('users')->get();
        $generos  = DB::table('genero_prend')->get();
        $tallas   = DB::table('t_prendas')->get();
        $colores  = DB::table('Color')->get();

        return view('dashboard.staff', compact('prendas', 'ventas', 'usuarios', 'generos', 'tallas', 'colores'));
    }

    /**
     * Catálogo público de prendas para clientes
     */
    public function catalog()
    {
        $prendas = DB::table('prenda')
            ->join('genero_prend', 'prenda.fk_id_genero', '=', 'genero_prend.id_genero_prend')
            ->join('t_prendas', 'prenda.fk_idt_prendas', '=', 't_prendas.idt_prendas')
            ->join('Color', 'prenda.fk_id_color', '=', 'Color.id_color')
            ->select('prenda.*', 'genero_prend.tipo_genero', 't_prendas.talla_prend', 'Color.nom_color')
            ->where('prenda.estado', 1)
            ->orderBy('prenda.nombre_prend')
            ->get()
            ->map(function ($item) {
                $item->imagen_url = $item->imagen_prend
                    ? 'data:image/jpeg;base64,' . base64_encode($item->imagen_prend)
                    : null;
                return $item;
            });

        return view('client.home', compact('prendas'));
    }
    /**
     * Guardar nueva Prenda
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo_barras'     => 'required|string|max:50|unique:prenda,codigo_barras',
            'nombre_prend'      => 'required|string|max:25',
            'descripcion_prend' => 'required|string|max:35',
            'precio'            => 'required|integer|min:0',
            'stock'             => 'required|integer|min:0',
            'min_stock'         => 'required|integer|min:0',
            'max_stock'         => 'required|integer|min:0',
            'fk_id_genero'      => 'required|integer',
            'fk_idt_prendas'    => 'required|integer',
            'fk_id_color'       => 'required|integer',
        ]);

        $imagen = null;
        if ($request->hasFile('imagen_prend')) {
            $imagen = file_get_contents($request->file('imagen_prend')->getRealPath());
        }

        Prenda::create(array_merge($validated, [
            'estado'         => 1,
            'fecha_registro' => now(),
            'imagen_prend'   => $imagen,
        ]));

        return redirect()->back()->with('success', 'Prenda agregada exitosamente.');
    }

    /**
     * Actualizar Prenda
     */
    public function update(Request $request, $codigo_barras)
    {
        $prenda = Prenda::findOrFail($codigo_barras);

        $validated = $request->validate([
            'codigo_barras'     => 'required|string|max:50|unique:prenda,codigo_barras,' . $codigo_barras . ',codigo_barras',
            'nombre_prend'      => 'required|string|max:25',
            'descripcion_prend' => 'required|string|max:35',
            'precio'            => 'required|integer|min:0',
            'stock'             => 'required|integer|min:0',
            'min_stock'         => 'required|integer|min:0',
            'max_stock'         => 'required|integer|min:0',
            'fk_id_genero'      => 'required|integer',
            'fk_idt_prendas'    => 'required|integer',
            'fk_id_color'       => 'required|integer',
            'estado'            => 'required|integer',
        ]);

        if ($request->hasFile('imagen_prend')) {
            $prenda->imagen_prend = file_get_contents($request->file('imagen_prend')->getRealPath());
        }

        $prenda->update($validated);

        return redirect()->back()->with('success', 'Prenda actualizada correctamente.');
    }

    /**
     * Eliminar Prenda
     */
    public function destroy($codigo_barras)
    {
        $prenda = Prenda::findOrFail($codigo_barras);
        $prenda->delete();
        return redirect()->back()->with('success', 'Prenda eliminada.');
    }

    /**
     * Buscar prenda por código de barras — responde siempre en JSON.
     * FIX: urldecode() para manejar caracteres especiales codificados en la URL.
     */
    public function buscarPorCodigo($codigo_barras)
    {
        // urldecode por si el código viene con caracteres especiales codificados desde el fetch
        $codigo_limpio = trim(urldecode($codigo_barras));

        // FIX: se excluye imagen_prend del SELECT porque es un BLOB binario
        // que rompe json_encode() con "Malformed UTF-8 characters".
        // La imagen no se necesita en el módulo de ventas.
        $prenda = DB::table('prenda')
            ->join('genero_prend', 'prenda.fk_id_genero', '=', 'genero_prend.id_genero_prend')
            ->join('t_prendas', 'prenda.fk_idt_prendas', '=', 't_prendas.idt_prendas')
            ->join('Color', 'prenda.fk_id_color', '=', 'Color.id_color')
            ->select(
                'prenda.codigo_barras',
                'prenda.nombre_prend',
                'prenda.descripcion_prend',
                'prenda.precio',
                'prenda.stock',
                'prenda.min_stock',
                'prenda.max_stock',
                'prenda.estado',
                'prenda.fecha_registro',
                'prenda.fk_id_genero',
                'prenda.fk_idt_prendas',
                'prenda.fk_id_color',
                'genero_prend.tipo_genero',
                't_prendas.talla_prend',
                'Color.nom_color'
            )
            ->where('prenda.codigo_barras', $codigo_limpio)
            ->first();

        if (!$prenda) {
            return response()->json([
                'success' => false,
                'message' => 'El código "' . $codigo_limpio . '" no está registrado.',
            ], 404);
        }

        if ((int) $prenda->estado === 0) {
            return response()->json([
                'success' => false,
                'message' => 'La prenda está marcada como inactiva.',
            ], 400);
        }

        if ((int) $prenda->stock <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'No hay existencias disponibles (Stock: 0).',
            ], 400);
        }

        return response()->json(['success' => true, 'prenda' => $prenda], 200);
    }
}