<?php

namespace App\Http\Controllers\Home;

use Barryvdh\Debugbar\Facades\Debugbar;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PrincipalController extends Controller
{
    public function viewPrincipal(){

        $usuario = Session::get('usuario');

        // Lo muestra en Debugbar
        Debugbar::info('👤 Usuario logueado:', $usuario);


        return view('principal', compact('usuario'));
    }
}
