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


        return view('casilla', compact('usuario'));
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
