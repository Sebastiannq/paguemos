<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsClient
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Validamos de forma estricta que exista la ID y que el rol sea exactamente 'cliente'
        if (session()->has('user_id') && session('user_role') === 'cliente') {
            return $next($request);
        }

        // Si la sesión no cumple, destruimos las llaves para evitar rebotes cíclicos
        session()->forget(['user_id', 'user_name', 'user_role']);

        return redirect()->route('login')->withErrors(['email' => 'Inicia sesión para continuar.']);
    }
}