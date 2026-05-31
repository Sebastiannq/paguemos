<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    // Mostrar usuario en JSON (para el modal)
    public function show($id)
    {
        $user = DB::table('usuario')
            ->leftJoin('usuario_rol', 'usuario.id_usuario', '=', 'usuario_rol.fkpk_id_usuario')
            ->leftJoin('rol', 'usuario_rol.fkpk_id_rol', '=', 'rol.id_rol')
            ->select('usuario.*', 'rol.nom_rol as role')
            ->where('usuario.id_usuario', $id)
            ->first();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Usuario no encontrado.'], 404);
        }

        return response()->json(['success' => true, 'user' => $user], 200);
    }

    // Actualizar datos de usuario (incluye activar/inactivar)
    public function update(Request $request, $id)
    {
        // Soportar actualizaciones parciales vía AJAX (por ejemplo solo 'estado')
        if ($request->isJson() && !$request->has('primer_nom') && !$request->has('primer_apelli')) {
            $validated = $request->validate([
                'estado' => 'required|integer|in:0,1',
            ]);

            DB::table('usuario')->where('id_usuario', $id)->update([
                'estado' => $validated['estado'],
            ]);

            return response()->json(['success' => true, 'message' => 'Estado actualizado.'], 200);
        }

        // Actualización completa desde formulario
        $validated = $request->validate([
            'primer_nom'     => 'required|string|max:50',
            'segund_nom'     => 'nullable|string|max:50',
            'primer_apelli'  => 'required|string|max:50',
            'segund_apelli'  => 'nullable|string|max:50',
            'correo'         => 'required|email|unique:usuario,correo,' . $id . ',id_usuario',
            'estado'         => 'required|integer|in:0,1',
            'role'           => 'nullable|string|max:50',
        ]);

        DB::table('usuario')->where('id_usuario', $id)->update([
            'primer_nom'    => $validated['primer_nom'],
            'segund_nom'    => $validated['segund_nom'] ?? null,
            'primer_apelli' => $validated['primer_apelli'],
            'segund_apelli' => $validated['segund_apelli'] ?? null,
            'correo'        => $validated['correo'],
            'estado'        => $validated['estado'],
        ]);

        // Si se envía role, intentamos asignarlo en la tabla usuario_rol
        if (!empty($validated['role'])) {
            $rol = DB::table('rol')->where('nom_rol', $validated['role'])->first();
            if ($rol) {
                $exists = DB::table('usuario_rol')->where('fkpk_id_usuario', $id)->exists();
                if ($exists) {
                    DB::table('usuario_rol')->where('fkpk_id_usuario', $id)->update(['fkpk_id_rol' => $rol->id_rol]);
                } else {
                    DB::table('usuario_rol')->insert(['fkpk_id_usuario' => $id, 'fkpk_id_rol' => $rol->id_rol]);
                }
            }
        }

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Usuario actualizado.'], 200);
        }

        return redirect()->route('dashboard.staff')->with('success', 'Usuario actualizado correctamente.')->with('active_section', 'usuarios');
    }

    // Crear nuevo usuario desde dashboard (Registro por admin)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'primer_nom'     => 'required|string|max:50',
            'segund_nom'     => 'nullable|string|max:50',
            'primer_apelli'  => 'required|string|max:50',
            'segund_apelli'  => 'nullable|string|max:50',
            'correo'         => 'required|email|unique:usuario,correo',
            'contrasena'     => 'required|string|min:6',
            'estado'         => 'nullable|integer|in:0,1',
            'role'           => 'required|string|exists:rol,nom_rol',
        ]);

        $insertId = DB::table('usuario')->insertGetId([
            'primer_nom'    => $validated['primer_nom'],
            'segund_nom'    => $validated['segund_nom'] ?? null,
            'primer_apelli' => $validated['primer_apelli'],
            'segund_apelli' => $validated['segund_apelli'] ?? null,
            'correo'        => $validated['correo'],
            'contrasena'    => Hash::make($validated['contrasena']),
            'estado'        => $validated['estado'] ?? 1,
            'fecha_ingreso' => now(),
        ]);

        // Asignar rol si se proporcionó
        if (!empty($validated['role'])) {
            $rol = DB::table('rol')->where('nom_rol', $validated['role'])->first();
            if ($rol) {
                DB::table('usuario_rol')->insert([
                    'fkpk_id_usuario' => $insertId,
                    'fkpk_id_rol' => $rol->id_rol,
                ]);
            }
        }

        return redirect()->route('dashboard.staff')->with('success', 'Usuario creado correctamente.')->with('active_section', 'usuarios');
    }

    public function destroy($id)
    {
        $usuario = DB::table('usuario')->where('id_usuario', $id)->first();

        if (!$usuario) {
            return redirect()->route('dashboard.staff')->with('error', 'Usuario no encontrado.')->with('active_section', 'usuarios');
        }

        DB::table('usuario_rol')->where('fkpk_id_usuario', $id)->delete();
        DB::table('usuario')->where('id_usuario', $id)->delete();

        return redirect()->route('dashboard.staff')->with('success', 'Usuario eliminado correctamente.')->with('active_section', 'usuarios');
    }
}

