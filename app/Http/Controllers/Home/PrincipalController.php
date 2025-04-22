<?php

namespace App\Http\Controllers\Home;

use Barryvdh\Debugbar\Facades\Debugbar;
use App\Http\Controllers\Controller;
use App\Models\Contribuyente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PrincipalController extends Controller
{
    public function viewPrincipal()
    {
        $codigo_contribuyente = Session::get('codigo_contribuyente');

        // Obtener datos del contribuyente
        $usuario = Contribuyente::obtenerDatosContri($codigo_contribuyente);

        Debugbar::info('📄 Datos contribuyente:', $usuario);

        // Validar el estado y retornar la vista correspondiente
        if (in_array($usuario->vestado, ['002', '003'])) {
            return view('principalAdmin', compact('usuario'));
        }

        return view('principal', compact('usuario'));
    }
}
