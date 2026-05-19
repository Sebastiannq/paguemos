<?php

namespace App\Http\Controllers;

use App\Models\Prenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{
    // Mostrar Dashboard con el Listado
    public function index()
    {
        // Traemos las prendas haciendo Join con sus tablas maestras para ver nombres reales
        $prendas = DB::table('prenda')
            ->join('genero_prend', 'prenda.fk_id_genero', '=', 'genero_prend.id_genero_prend')
            ->join('t_prendas', 'prenda.fk_idt_prendas', '=', 't_prendas.idt_prendas')
            ->join('Color', 'prenda.fk_id_color', '=', 'Color.id_color')
            ->select('prenda.*', 'genero_prend.tipo_genero', 't_prendas.talla_prend', 'Color.nom_color')
            ->get();

        // Datos para los formularios de Crear/Editar
        $generos = DB::table('genero_prend')->get();
        $tallas = DB::table('t_prendas')->get();
        $colores = DB::table('Color')->get();

        return view('dashboard.staff', compact('prendas', 'generos', 'tallas', 'colores'));
    }

    // Guardar nueva Prenda
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_prend' => 'required|string|max:25',
            'descripcion_prend' => 'required|string|max:35',
            'precio' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'max_stock' => 'required|integer|min:0',
            'fk_id_genero' => 'required|integer',
            'fk_idt_prendas' => 'required|integer',
            'fk_id_color' => 'required|integer',
        ]);

        // Manejo básico de imagen (lo guardamos vacío o binario según tu BDD blob)
        $imagen = ''; 
        if ($request->hasFile('imagen_prend')) {
            $imagen = file_get_contents($request->file('imagen_prend')->getRealPath());
        }

        Prenda::create(array_merge($validated, [
            'estado' => 1,
            'fecha_registro' => now(),
            'imagen_prend' => $imagen
        ]));

        return redirect()->back()->with('success', 'Prenda agregada exitosamente.');
    }

    // Actualizar Prenda
    public function update(Request $request, $id)
    {
        $prenda = Prenda::findOrFail($id);

        $validated = $request->validate([
            'nombre_prend' => 'required|string|max:25',
            'descripcion_prend' => 'required|string|max:35',
            'precio' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'max_stock' => 'required|integer|min:0',
            'fk_id_genero' => 'required|integer',
            'fk_idt_prendas' => 'required|integer',
            'fk_id_color' => 'required|integer',
            'estado' => 'required|integer'
        ]);

        if ($request->hasFile('imagen_prend')) {
            $prenda->imagen_prend = file_get_contents($request->file('imagen_prend')->getRealPath());
        }

        $prenda->update($validated);

        return redirect()->back()->with('success', 'Prenda actualizada correctamente.');
    }

    // Eliminar Prenda
    public function destroy($id)
    {
        $prenda = Prenda::findOrFail($id);
        $prenda->delete();

        return redirect()->back()->with('success', 'Prenda eliminada del inventario.');
    }
}