<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsStaff
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Traemos el rol guardado en la sesión
        $role = session('user_role');

        // Validamos si el rol pertenece al Staff (administrador o empleado)
        if (session()->has('user_id') && ($role === 'administrador' || $role === 'empleado')) {
            return $next($request);
        }

        // Si no tiene permisos, limpiamos y denegamos el acceso enviándolo al login
        session()->forget(['user_id', 'user_name', 'user_role']);
        
        return redirect()->route('login')->withErrors(['email' => 'Acceso denegado. No tienes permisos de Staff.']);
    }
}