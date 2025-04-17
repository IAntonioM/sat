<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticatedCustom
{
    /**
     * Maneja una solicitud entrante.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Si hay sesión activa (usuario ya autenticado), redirige a /principal
        if (session()->has('usuario')) {
            return redirect()->route('principal');
        }

        // Si no hay sesión, continúa normalmente
        return $next($request);
    }
}
