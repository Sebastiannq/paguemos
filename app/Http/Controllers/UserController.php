<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // Seguridad por sesión (mantiene tu lógica original)
        if(session('rol') != 'admin' && session('rol') != 'administrador'){
            return redirect('/');
        }

        // Trae todos los registros de la tabla 'usuario'
        $usuarios = User::all();

        // Retorna la nueva vista dentro de la carpeta admin
        return view('admin.usuarios', compact('usuarios'));
    }

    public function store(Request $request)
    {
        User::create([
            'primer_nom'    => $request->primer_nom,
            'segund_nom'    => $request->segund_nom,
            'primer_apelli' => $request->primer_apelli,
            'segund_apelli' => $request->segund_apelli,
            'correo'        => $request->correo,
            'contrasena'    => Hash::make($request->contrasena),
            'estado'        => $request->estado,
            'fecha_ingreso' => now()
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario registrado exitosamente.');
    }

    public function update(Request $request, $id)
    {
        $usuario = User::findOrFail($id);

        $usuario->primer_nom    = $request->primer_nom;
        $usuario->segund_nom    = $request->segund_nom;
        $usuario->primer_apelli = $request->primer_apelli;
        $usuario->segund_apelli = $request->segund_apelli;
        $usuario->correo        = $request->correo;
        $usuario->estado        = $request->estado;
        
        // Solo actualiza la contraseña si se escribe algo en el campo
        if ($request->filled('contrasena')) {
            $usuario->contrasena = Hash::make($request->contrasena);
        }

        $usuario->save();

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy($id)
    {
        $usuario = User::findOrFail($id);
        $usuario->delete();

        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado de la base de datos.');
    }
}