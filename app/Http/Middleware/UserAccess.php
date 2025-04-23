<?php

namespace App\Http\Middleware;

use App\Models\Contribuyente;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class UserAccess
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

        // Verificar que el usuario tenga un estado válido (001, 002 o 003)
        if (!in_array($usuario->vestado, ['001', '002', '003'])) {
            session()->flush();
            return redirect()->route('login')->with([
                'alert' => [
                    'type' => 'error',
                    'title' => 'Estado de usuario no válido',
                    'message' => 'Tu cuenta tiene un estado no reconocido. Contacta al administrador.'
                ]
            ]);
        }

        // Continuar con la solicitud
        return $next($request);
    }
}
