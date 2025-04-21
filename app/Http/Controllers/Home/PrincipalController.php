<?php

namespace App\Http\Controllers\Home;

use Barryvdh\Debugbar\Facades\Debugbar;
use App\Http\Controllers\Controller;
use App\Models\Contribuyente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PrincipalController extends Controller
{
    public function viewPrincipal(){

        $codigo_contribuyente = Session::get('codigo_contribuyente');

        // Lo muestra en Debugbar
        $usuario = Contribuyente::obtenerDatosContri($codigo_contribuyente);

        Debugbar::info('📄 Datos contribuyente:', $usuario);

        return view('principal', compact('usuario'));
    }
}
