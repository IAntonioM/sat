<?php

namespace App\Http\Controllers\Casilla;

use Barryvdh\Debugbar\Facades\Debugbar;
use App\Http\Controllers\Controller;
use App\Models\Contribuyente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CasillaController extends Controller
{
    public function index()
    {
        $codigo_contribuyente = Session::get('codigo_contribuyente');

        // Obtener datos del contribuyente
        $usuario = Contribuyente::obtenerDatosContri($codigo_contribuyente);

        Debugbar::info('📄 Datos contribuyente:', $usuario);

        // Verificamos el vestado
        if ($usuario && $usuario->vestado === '001') {
            // Si es cuenta contribuyente, mostramos la vista normal
            return view('casilla', compact('usuario'));
        } elseif ($usuario && in_array($usuario->vestado, ['002', '003'])) {
            // Si es tipo administrativo, redirigimos a otra vista
            return view('casillaAdmin', compact('usuario'));
        } else {
            // En caso de vestado desconocido o null, redirigir o mostrar error
            abort(403, 'Estado de cuenta no autorizado');
        }
    }
    public function store()
    {
        $codigo_contribuyente = Session::get('codigo_contribuyente');

        // Obtener datos del contribuyente
        $usuario = Contribuyente::obtenerDatosContri($codigo_contribuyente);

        Debugbar::info('📄 Datos contribuyente:', $usuario);


        return view('casillaNuevo', compact('usuario'));
    }
}
