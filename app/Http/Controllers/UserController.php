<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{

    public function index()
    {
        if(session('rol') != 'admin'){
            return redirect('/');
        }

        $usuarios = User::all();

        return view('admin', compact('usuarios'));
    }

    public function show($id)
    {
        $usuario = User::findOrFail($id);

        return view('show', compact('usuario'));
    }

    public function edit($id)
    {
        $usuario = User::findOrFail($id);

        return view('edit', compact('usuario'));
    }

    public function update(Request $request, $id)
    {
        $usuario = User::findOrFail($id);

        $usuario->name = $request->name;

        $usuario->email = $request->email;

        $usuario->rol = $request->rol;

        $usuario->save();

        return redirect('/admin');
    }

    public function destroy($id)
    {
        $usuario = User::findOrFail($id);

        $usuario->delete();

        return redirect('/admin');
    }

}