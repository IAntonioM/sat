<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\TipoDocumento;
use Illuminate\Http\Request;

class SolicitarAccesoController extends Controller
{
    public function index(){
        $tiposDocumento = TipoDocumento::obtenerTipoDocs();

        return view('registro', compact('tiposDocumento'));
    }
}
