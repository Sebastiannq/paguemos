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
            'precio'            => 'required|integer|min:10000',
            'stock'             => 'required|integer|min:10',
            'min_stock'         => 'required|integer|min:15',
            'max_stock'         => 'required|integer|min:20',
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
            'precio'            => 'required|integer|min:10000',
            'stock'             => 'required|integer|min:10',
            'min_stock'         => 'required|integer|min:15',
            'max_stock'         => 'required|integer|min:20',
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

    public function buscarClientePorCorreo($correo)
{
    // Limpiamos el correo por si viene codificado de la URL
    $correo_limpio = trim(urldecode($correo));

    // Según tu diagrama relacional, la tabla es 'usuario' y los campos son primer_nom, primer_apelli, etc.
    $cliente = DB::table('usuario')
        ->select('id_usuario', 'primer_nom', 'primer_apelli', 'correo')
        ->where('correo', $correo_limpio)
        ->first();

    if (!$cliente) {
        return response()->json([
            'success' => false,
            'message' => 'El correo electrónico no está registrado.'
        ], 404);
    }

    return response()->json([
        'success' => true,
        'cliente' => $cliente
    ], 200);
}

   public function indexEmpleado()
{
    $prendas = DB::table('prenda')
        ->join('genero_prend', 'prenda.fk_id_genero', '=', 'genero_prend.id_genero_prend')
        ->join('t_prendas', 'prenda.fk_idt_prendas', '=', 't_prendas.idt_prendas')
        ->join('Color', 'prenda.fk_id_color', '=', 'Color.id_color')
        ->select('prenda.*', 'genero_prend.tipo_genero', 't_prendas.talla_prend', 'Color.nom_color')
        ->get();

    $usuarios = DB::table('usuario')->get();
    $generos  = DB::table('genero_prend')->get();

    // 🔄 DOBLE JOIN CON ALIAS: Uno para el cliente y otro para el empleado
    $apartados = DB::table('apartados')
        ->join('prenda', 'apartados.fk_codigo_barras', '=', 'prenda.codigo_barras')
        ->join('usuario as cliente', 'apartados.fk_id_usuario', '=', 'cliente.id_usuario') // Alias 'cliente'
        ->join('usuario as empleado', 'apartados.fk_id_empleado', '=', 'empleado.id_usuario') // Alias 'empleado'
        ->select(
            'apartados.*', 
            'prenda.nombre_prend', 
            // Datos del Cliente
            'cliente.primer_nom as cli_nom', 
            'cliente.primer_apelli as cli_ape',
            'cliente.correo as cli_correo',
            // Datos del Empleado (ID y Nombre)
            'empleado.id_usuario as emp_id',
            'empleado.primer_nom as emp_nom',
            'empleado.primer_apelli as emp_ape'
        )
        ->orderBy('apartados.fecha_apartado', 'desc')
        ->get();

    return view('empleado.home_empleado', compact('prendas', 'usuarios', 'generos', 'apartados'));
}

public function storeApartado(Request $request)
{
    // Validamos primero el cliente y los bloques del carrito
    $validated = $request->validate([
        'correo_cliente' => 'required|email|exists:usuario,correo',
        'carrito_items'  => 'required|string', // Aquí viaja el JSON del carrito desde JS
        'anticipo'       => 'required|integer|min:0',
    ]);

    // Decodificamos los productos que vienen del carrito de JavaScript
    $items = json_decode($validated['carrito_items'], true);

    if (empty($items)) {
        return redirect()->back()->with('error', 'El carrito de apartados está vacío.');
    }

    // Buscamos al cliente una sola vez
    $cliente = DB::table('usuario')->where('correo', $validated['correo_cliente'])->first();
    
    // Calculamos el total real sumando los precios del carrito para seguridad del backend
    $total_apartado = 0;
    foreach ($items as $item) {
        $total_apartado += ($item['precio'] * $item['cantidad']);
    }

    // Iniciamos una Transacción por seguridad: o se guardan todos o ninguno
    DB::beginTransaction();
    try {
        foreach ($items as $item) {
            // Insertamos cada prenda del carrito como un registro en apartados
            DB::table('apartados')->insert([
    'fk_id_usuario'    => $cliente->id_usuario, 
    'fk_id_empleado'   => session('user_id'),
    'fk_codigo_barras' => $validated['fk_codigo_barras'],
    'cantidad'         => $request->input('cantidad'), // <--- LO NUEVO
    'fecha_apartado'   => now(),
    'fecha_limite'     => $request->input('fecha_limite'),
    'anticipo'         => $validated['anticipo'],
    'total'            => $validated['total'],
    'estado'           => 'pendiente',
    'created_at'       => now()
]);

            // OPCIONAL: Aquí podrías restar el stock de la prenda si lo requieres
            // DB::table('prenda')->where('codigo_barras', $item['codigo_barras'])->decrement('stock', $item['cantidad']);
        }

        DB::commit();
        return redirect()->back()->with('success', '¡Apartado múltiple registrado con éxito!');

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Error al procesar el apartado: ' . $e->getMessage());
    }
}
}