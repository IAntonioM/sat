<?php

namespace App\Http\Middleware;

use App\Models\Contribuyente;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class ForcePasswordChange
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
        if (isset($usuario->vpreg) && $usuario->vpreg === '0') {
            // Permitir acceso solo a ruta de cambio de clave y logout
            if (!$request->is('cambiarClave') && !$request->is('logout')) {
                return redirect()->route('cambiarClave')->with([
                    'alert' => [
                        'type' => 'warning',
                        'title' => 'Cambio de Clave Requerido',
                        'message' => 'Por favor, cambia tu clave para continuar.'
                    ]
                ]);
            }
        }

        return $next($request);
    }
}
