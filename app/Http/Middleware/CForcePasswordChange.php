<?php

namespace App\Http\Middleware;

use App\Models\Contribuyente;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class CForcePasswordChange
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar si el usuario está autenticado


        $codigo_contribuyente = Session::get('codigo_contribuyente');
        $usuario = Contribuyente::obtenerDatosContri($codigo_contribuyente);

        // Si el usuario necesita cambiar su clave
        if (isset($usuario->vpreg) && $usuario->vpreg === '1') {
            // Permitir acceso solo a ruta de cambio de clave y logout
            return redirect()->route('principal');
        }


        return $next($request);
    }
}
