<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\UsuariosAdmins;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\Date;

class UsuariosAdminController extends Controller
{
    public function index(Request $request)
    {
        $usuario = Session::get('usuario');

        // Preparar parámetros para el procedimiento almacenado
        $params = [
        ];

        // Obtener las solicitudes
        $usuarios = UsuariosAdmins::listarUsuarios($params);

        // Fecha de actualización para mostrar en la vista
        $fechaActual = Carbon::now()->format('d/m/Y');

        // Data to send to the view
        $viewData = [
            'usuario' => $usuario,
            'Usuarios' => $usuarios,
            'fechaActual' => $fechaActual,
        ];
        Debugbar::info('Pene');
        Debugbar::info($viewData);
        return view('usuarios', $viewData);
    }
}
