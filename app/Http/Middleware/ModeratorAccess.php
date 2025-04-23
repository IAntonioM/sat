<?php

namespace App\Http\Middleware;

use App\Models\Contribuyente;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class ModeratorAccess
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {



        $codigo_contribuyente = Session::get('codigo_contribuyente');
        $usuario = Contribuyente::obtenerDatosContri($codigo_contribuyente);

        // Verificar si el usuario está activo
        if ($usuario->vestado === '004') {
            session()->flush();
            return redirect()->route('login')->with([
                'alert' => [
                    'type' => 'error',
                    'title' => 'Usuario Inactivo',
                    'message' => 'Tu cuenta se encuentra inactiva. Contacta al administrador.'
                ]
            ]);
        }

        // Verificar que el usuario tenga permiso de administrador (002)
          // Verificar que el usuario tenga permiso de moderador (002) o admin (003)
          if (!in_array($usuario->vestado, ['002', '003'])) {
            return redirect()->route('principal')->with([
                'alert' => [
                    'type' => 'error',
                    'title' => 'Acceso Denegado',
                    'message' => 'No tienes permisos para acceder al área de moderador.'
                ]
            ]);
        }

        // Continuar con la solicitud
        return $next($request);
    }
}
