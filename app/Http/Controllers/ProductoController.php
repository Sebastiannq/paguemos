<?php

namespace App\Http\Controllers;

use App\Models\Prenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductoController extends Controller
{
    /**
     * Helper privado para procesar la URL de la imagen de forma unificada
     * Soporta: URLs web, Archivos físicos en 'uploads/prendas/' y datos Binarios/Base64
     */
    private function mapearImagenPrenda($item)
    {
        if ($item->imagen_prend) {
            // Caso 1: Es una URL directa de internet
            if (str_starts_with($item->imagen_prend, 'http')) {
                $item->imagen_url = $item->imagen_prend;
            } 
            // Caso 2: Es un archivo físico subido desde el computador
            elseif (file_exists(public_path('uploads/prendas/' . $item->imagen_prend))) {
                $item->imagen_url = asset('uploads/prendas/' . $item->imagen_prend);
            } 
            // Caso 3: Es un binario crudo en la base de datos (Ej: de Android/Kotlin antiguo)
            else {
                $item->imagen_url = 'data:image/jpeg;base64,' . base64_encode($item->imagen_prend);
            }
        } else {
            // Imagen de respaldo si no hay ningún archivo o string asignado
            $item->imagen_url = asset('images/default.png');
        }
        return $item;
    }

    public function index()
    {
        $prendas = DB::table('prenda')
            ->join('genero_prend', 'prenda.fk_id_genero', '=', 'genero_prend.id_genero_prend')
            ->join('t_prendas', 'prenda.fk_idt_prendas', '=', 't_prendas.idt_prendas')
            ->join('Color', 'prenda.fk_id_color', '=', 'Color.id_color')
            ->select('prenda.*', 'genero_prend.tipo_genero', 't_prendas.talla_prend', 'Color.nom_color', 'prenda.imagen_prend as imagen_url')
            ->get()
            ->map(function ($item) {
                return $this->mapearImagenPrenda($item);
            });

        $ventas = DB::table('venta')->orderBy('fecha_venta', 'desc')->get();
        
        $usuarios = DB::table('usuario')
            ->leftJoin('usuario_rol', 'usuario.id_usuario', '=', 'usuario_rol.fkpk_id_usuario')
            ->leftJoin('rol', 'usuario_rol.fkpk_id_rol', '=', 'rol.id_rol')
            ->select('usuario.*', 'rol.nom_rol as role')
            ->orderBy('usuario.id_usuario', 'asc')
            ->get();

        $roles   = DB::table('rol')->orderBy('nom_rol')->get();
        $generos = DB::table('genero_prend')->get();
        $tallas  = DB::table('t_prendas')->get();
        $colores = DB::table('Color')->get();

        return view('dashboard.staff', compact('prendas', 'ventas', 'usuarios', 'roles', 'generos', 'tallas', 'colores'));
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
            ->select('prenda.*', 'genero_prend.tipo_genero', 't_prendas.talla_prend', 'Color.nom_color', 'prenda.imagen_prend as imagen_url')
            ->where('prenda.estado', 1)
            ->orderBy('prenda.nombre_prend')
            ->get()
            ->map(function ($item) {
                return $this->mapearImagenPrenda($item);
            });

        return view('client.home', compact('prendas'));
    }

    /**
     * Guardar nueva Prenda (Soporta PNG, JPG, JPEG)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo_barras'     => 'required|string|max:50|unique:prenda,codigo_barras',
            'nombre_prend'      => 'required|string|max:25',
            'descripcion_prend' => 'required|string|max:35',
            'precio'            => 'required|integer|min:0',
            'stock'             => 'required|integer|min:0|max:60',
            'min_stock'         => 'required|integer|min:0',
            'max_stock'         => 'required|integer|min:0',
            'fk_id_genero'      => 'required|integer',
            'fk_idt_prendas'    => 'required|integer',
            'fk_id_color'       => 'required|integer',
            'imagen_prend'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagen = null;
        if ($request->hasFile('imagen_prend')) {
            $file = $request->file('imagen_prend');
            $nombreImagen = 'prenda_' . time() . '.' . $file->getClientOriginalExtension();
            $carpeta = public_path('uploads/prendas/');
            
            if (!file_exists($carpeta)) {
                mkdir($carpeta, 0755, true);
            }
            
            $file->move($carpeta, $nombreImagen);
            $imagen = $nombreImagen;
        }

        Prenda::create(array_merge($validated, [
            'estado'         => 1,
            'fecha_registro' => now(),
            'imagen_prend'   => $imagen,
        ]));

        return redirect()->back()->with('success', 'Prenda agregada exitosamente.');
    }

    /**
     * Actualizar Prenda existente (Soporta PNG, JPG, JPEG)
     */
    public function update(Request $request, $codigo_barras)
    {
        $prenda = Prenda::findOrFail($codigo_barras);

        $validated = $request->validate([
            'codigo_barras'     => 'required|string|max:50|unique:prenda,codigo_barras,' . $codigo_barras . ',codigo_barras',
            'nombre_prend'      => 'required|string|max:25',
            'descripcion_prend' => 'required|string|max:35',
            'precio'            => 'required|integer|min:0',
            'stock'             => 'required|integer|min:0|max:60',
            'min_stock'         => 'required|integer|min:0',
            'max_stock'         => 'required|integer|min:0',
            'fk_id_genero'      => 'required|integer',
            'fk_idt_prendas'    => 'required|integer',
            'fk_id_color'       => 'required|integer',
            'estado'            => 'required|integer',
            'imagen_prend'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('imagen_prend')) {
            $file = $request->file('imagen_prend');
            $nombreImagen = 'prenda_' . time() . '.' . $file->getClientOriginalExtension();
            $carpeta = public_path('uploads/prendas/');
            
            if (!file_exists($carpeta)) {
                mkdir($carpeta, 0755, true);
            }
            
            $file->move($carpeta, $nombreImagen);
            
            // Forzamos el nuevo nombre en el arreglo de datos válidos
            $validated['imagen_prend'] = $nombreImagen;
        }

        $prenda->update($validated);

        return redirect()->back()->with('success', 'Prenda actualizada con éxito.');
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
     * Buscar prenda por código de barras
     */
    public function buscarPorCodigo($codigo_barras)
    {
        $codigo_limpio = trim(urldecode($codigo_barras));

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
        $correo_limpio = trim(urldecode($correo));

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
            ->select('prenda.*', 'genero_prend.tipo_genero', 't_prendas.talla_prend', 'Color.nom_color', 'prenda.imagen_prend as imagen_url')
            ->get()
            ->map(function ($item) {
                return $this->mapearImagenPrenda($item);
            });

        $usuarios = DB::table('usuario')->get();
        $generos  = DB::table('genero_prend')->get();

        $apartados = DB::table('apartados')
            ->join('prenda', 'apartados.fk_codigo_barras', '=', 'prenda.codigo_barras')
            ->join('usuario as cliente', 'apartados.fk_id_usuario', '=', 'cliente.id_usuario')
            ->join('usuario as empleado', 'apartados.fk_id_empleado', '=', 'empleado.id_usuario')
            ->select(
                'apartados.*', 
                'prenda.nombre_prend', 
                'cliente.primer_nom as cli_nom', 
                'cliente.primer_apelli as cli_ape',
                'cliente.correo as cli_correo',
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
        $validated = $request->validate([
            'correo_cliente' => 'required|email|exists:usuario,correo',
            'carrito_items'  => 'required|string', 
            'anticipo'       => 'required|integer|min:0',
        ]);

        $items = json_decode($validated['carrito_items'], true);

        if (empty($items)) {
            return redirect()->back()->with('error', 'El carrito de apartados está vacío.');
        }

        $cliente = DB::table('usuario')->where('correo', $validated['correo_cliente'])->first();
        
        $total_apartado = 0;
        foreach ($items as $item) {
            $total_apartado += ($item['precio'] * $item['cantidad']);
        }

        DB::beginTransaction();
        try {
            foreach ($items as $item) {
                DB::table('apartados')->insert([
                    'fk_id_usuario'    => $cliente->id_usuario, 
                    'fk_id_empleado'   => session('user_id'),
                    'fk_codigo_barras' => $item['codigo_barras'],
                    'cantidad'         => $item['cantidad'],       
                    'fecha_apartado'   => now(),
                    'fecha_limite'     => $request->input('fecha_limite'),
                    'anticipo'         => $validated['anticipo'],
                    'total'            => $total_apartado,         
                    'estado'           => 'pendiente',
                    'created_at'       => now()
                ]);
            }

            DB::commit();
            return redirect()->back()->with('success', '¡Apartado múltiple registrado con éxito!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error al procesar el apartado: ' . $e->getMessage());
        }
    }

    /** * Endpoint exclusivo para registrar prendas desde la App Móvil Android (Volley)
     */
    public function registrarPrendaDesdeAndroid(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'codigo_barras'      => 'required|string|max:50',
            'nombre_prend'       => 'required|string|max:25',
            'descripcion_prend'  => 'required|string|max:35',
            'precio'             => 'required|numeric',
            'stock'              => 'required|numeric',
            'min_stock'          => 'required|numeric',
            'max_stock'          => 'required|numeric',
            'fk_id_genero_prend' => 'required|numeric',
            'fk_idt_prendas'     => 'required|numeric',
            'fk_id_color'        => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación en los datos',
                'errors'  => $validator->errors()
            ], 400);
        }

        try {
            $nombreImagen = null;
            if ($request->has('imagen_prend') && !empty($request->input('imagen_prend'))) {
                $imageData = base64_decode(str_replace(' ', '+', $request->input('imagen_prend')));
                $nombreImagen = 'prenda_' . time() . '.jpg';
                $carpeta = public_path('uploads/prendas/');
                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0755, true);
                }
                file_put_contents($carpeta . $nombreImagen, $imageData);
            }

            DB::table('prenda')->insert([
                'codigo_barras'      => trim($request->input('codigo_barras')),
                'nombre_prend'       => trim($request->input('nombre_prend')),
                'descripcion_prend'  => trim($request->input('descripcion_prend')),
                'precio'             => (int) $request->input('precio'),
                'stock'              => (int) $request->input('stock'),
                'min_stock'          => (int) $request->input('min_stock'),
                'max_stock'          => (int) $request->input('max_stock'),
                'fk_id_genero_prend' => (int) $request->input('fk_id_genero_prend'), 
                'fk_idt_prendas'     => (int) $request->input('fk_idt_prendas'),
                'fk_id_color'        => (int) $request->input('fk_id_color'),
                'estado'             => 1,
                'fecha_registro'     => now(),
                'imagen_prend'       => $nombreImagen
            ]);

            return response()->json([
                'success' => true,
                'message' => '¡Prenda registrada con éxito en Paguemenos!'
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error en la base de datos al insertar',
                'error_sql' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener parámetros de prendas (GÉNEROS, TALLAS Y COLORES REALES)
     */
    public function obtenerParametrosPrenda()
    {
        try {
            $generos = DB::table('genero_prend')->select('id_genero_prend as id', 'tipo_genero as nombre')->get();
            $tallas  = DB::table('t_prendas')->select('idt_prendas as id', 'talla_prend as nombre')->get();
            $colores = DB::table('Color')->select('id_color as id', 'nom_color as nombre')->get();

            return response()->json([
                'success' => true,
                'generos' => $generos,
                'tallas'  => $tallas,
                'colores' => $colores
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al consultar parámetros',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}