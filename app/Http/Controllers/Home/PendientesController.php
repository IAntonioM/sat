<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\SolicitudAcceso;
use App\Models\Contribuyente;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\Date;

class PendientesController extends Controller
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
        $contribuyente = SolicitudAcceso::obtenerDatosContribuyente($codigoContribuyente);

        if (!$contribuyente) {
            return redirect()->route('login')->with('error', 'No se encontró el contribuyente');
        }

        // Obtener los filtros
        $estadoSeleccionado  = $request->estadoSeleccionado ?? '%';

        // Obtener las usuarios detalladas
        $usuarios = SolicitudAcceso::obtenerSolicitudes($estadoSeleccionado );

        // Preparar datos para la vista
        $estados = SolicitudAcceso::obtenerEstadosDisponibles();
        $fechaActual = Carbon::now()->format('d/m/Y');

        $viewData = [
            'contribuyente' => $contribuyente,
            'Pendientes'=> $usuarios,
            'estadosDisponibles'=> $estados,
            'estadoSeleccionado'=> $estadoSeleccionado ,
            'fechaActual'=> $fechaActual,
            'usuario' => $usuario
        ];

        Debugbar::info('Datos:', $viewData);

        return view('pendientes', $viewData);
    }

}
