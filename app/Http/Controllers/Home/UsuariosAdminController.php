<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\UsuariosAdmins;
use Carbon\Carbon;
use App\Models\Contribuyente;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\Date;

class UsuariosAdminController extends Controller
{
    public function index(Request $request)
    {
        // Obtener el código del contribuyente de la sesión o del parámetro
        $codigoContribuyente = session('codigo_contribuyente') ??
        session('cod_usuario') ?? null; // Valor por defecto para pruebas

        $usuario = Contribuyente::obtenerDatosContri($codigoContribuyente);

        if (!$codigoContribuyente) {
            // Si no hay código de contribuyente, redirigir al login
            return redirect()->route('login')->with([
                'alert' => [
                    'type' => 'error',
                    'title' => 'Sesión inválida',
                    'message' => 'No se encontró el código de contribuyente en la sesión'
                ]
            ]);
        }

        // Obtener datos del contribuyente
        $contribuyente = UsuariosAdmins::obtenerDatosContribuyente($codigoContribuyente);

        if (!$contribuyente) {
            return redirect()->route('login')->with('error', 'No se encontró el contribuyente');
        }

        // Obtener los filtros
        $tipoAdministrador = $request->tipoAdministrador ?? '%';
        $estadoSeleccionado  = $request->estadoSeleccionado ?? '%';

        // Obtener las usuarios detalladas
        $usuarios = UsuariosAdmins::obtenerUsuarios($tipoAdministrador, $estadoSeleccionado );

        // Preparar datos para la vista
        $estados = UsuariosAdmins::obtenerEstadosDisponibles();
        $tiposAdmins = UsuariosAdmins::obtenerTipoAdminDisponibles();
        $fechaActual = Carbon::now()->format('d/m/Y');
        Debugbar::info('usuarios',$usuarios);
        $viewData = [
            'contribuyente' => $contribuyente,
            'Usuarios'=> $usuarios,
            'estadosDisponibles'=> $estados,
            'tipoAdministrador'=> $tipoAdministrador,
            'estadoSeleccionado'=> $estadoSeleccionado ,
            'tiposAdmins'=> $tiposAdmins,
            'fechaActual'=> $fechaActual,
            'usuario' => $usuario
        ];

        return view('usuarios', $viewData);
    }
}
