<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function showLogin()
    {
        // Carga la vista directamente sin anteponer condiciones que generen bucles
        return view('login');
    }

    public function storeLogin(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        $user = User::where('correo', $validated['email'])
                    ->where('estado', 1)
                    ->first();

        if ($user) {
            // Consultar el rol real cruzando las tablas usuario_rol y rol
            $rolData = DB::table('usuario_rol')
                ->join('rol', 'usuario_rol.fkpk_id_rol', '=', 'rol.id_rol')
                ->where('usuario_rol.fkpk_id_usuario', $user->id_usuario)
                ->select('rol.nom_rol')
                ->first();

            $userRole = $rolData ? $rolData->nom_rol : 'cliente';

            if (Hash::check($validated['password'], $user->contrasena)) {
                session([
                    'user_id' => $user->id_usuario,
                    'user_name' => $user->primer_nom . ' ' . $user->primer_apelli,
                    'user_email' => $user->correo,
                    'user_role' => $userRole
                ]);

                if ($userRole === 'administrador' || $userRole === 'empleado') {
                    return redirect()->route('dashboard.staff')->with('success', 'Bienvenido');
                }
                return redirect()->route('client.home');
            }
        }

        return back()->withErrors(['email' => 'Credenciales incorrectas.'])->withInput();
    }

    public function showRegister()
    {
        return view('register');
    }

    public function storeRegister(Request $request)
    {
        $validated = $request->validate([
            'primer_nom'    => 'required|string|max:50',
            'segund_nom'    => 'nullable|string|max:50',
            'primer_apelli' => 'required|string|max:50',
            'segund_apelli' => 'nullable|string|max:50',
            'email'         => 'required|email|unique:usuario,correo',
            'password'      => 'required|string|min:8|confirmed',
        ]);

        $user = DB::transaction(function () use ($validated) {
            // 1. Crear el usuario (id_usuario es AUTO_INCREMENT en MySQL)
            $nuevoUsuario = User::create([
                'primer_nom'    => $validated['primer_nom'],
                'segund_nom'    => $validated['segund_nom'],
                'primer_apelli' => $validated['primer_apelli'],
                'segund_apelli' => $validated['segund_apelli'],
                'correo'        => $validated['email'],
                'contrasena'    => Hash::make($validated['password']),
                'estado'        => 1,
                'fecha_ingreso' => now()
            ]);

            // 2. Asignar el Rol de Cliente (id_rol 3 en tu tabla rol)
            $idRolCliente = 3; 
            DB::table('usuario_rol')->insert([
                'fkpk_id_usuario' => $nuevoUsuario->id_usuario,
                'fkpk_id_rol'     => $idRolCliente
            ]);

            // 3. Crear el registro en la tabla extendida 'cliente'
            DB::table('cliente')->insert([
                'fkpk_id_cliente' => $nuevoUsuario->id_usuario,
                'img_cliente'     => '' 
            ]);

            return $nuevoUsuario;
        });

        session([
            'user_id'   => $user->id_usuario,
            'user_name' => $user->primer_nom . ' ' . $user->primer_apelli,
            'user_role' => 'cliente'
        ]);

        return redirect()->route('client.home');
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('home');
    }
}