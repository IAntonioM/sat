<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\PUModel;
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

        // Data to send to the view
        $viewData = [
            'usuario' => $usuario,
        ];

        return view('usuarios', $viewData);
    }
}
