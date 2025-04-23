<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Contribuyente;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RecordPapeletaController extends Controller
{
    public function index()
    {
        $codigo_contribuyente = Session::get('codigo_contribuyente');

        // Obtener datos del contribuyente
        $usuario = Contribuyente::obtenerDatosContri($codigo_contribuyente);

        Debugbar::info('📄 Datos contribuyente:', $usuario);


        return view('record', compact('usuario'));
    }
}
