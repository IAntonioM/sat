<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\SolicitudAcceso;
use App\Models\Contribuyente;
use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\Date;

class PerfilController extends Controller
{
    public function index(Request $request)
    {
        $codigoContribuyente = session('codigo_contribuyente') ;
        $usuario = Contribuyente::obtenerDatosContri($codigoContribuyente);
        $listarCuentas = Usuario::listarCuentasPorNroDoc($usuario->vnrodoc);
        $fechaActual = Carbon::now()->format('d/m/Y');
        Debugbar::info('Datos:', $listarCuentas);
        return view('perfil', compact('usuario','fechaActual','listarCuentas'));
    }

    public function select(Request $request, $codigo)
    {
        $codigoSeleccionado = trim($codigo); // desde la URL como parámetro
        Debugbar::info('Código seleccionado:', $codigoSeleccionado);

        $codigoContribuyente = session('codigo_contribuyente');
        $usuario = Contribuyente::obtenerDatosContri($codigoContribuyente);

        // Validar si existe una cuenta activa con ese vnrodoc y el código seleccionado
        $cuentaValida = Usuario::validarNroDocyCodigo($usuario->vnrodoc, $codigoSeleccionado);

        if (!$cuentaValida) {
            return redirect()->route('perfil')->with([
                'alert' => [
                    'type' => 'error',
                    'title' => 'Error al seleccionar cuenta',
                    'message' => 'Error al seleccionar el código ' . $codigoSeleccionado . '.',
                ]
            ]);
        }

        session([
            'codigo_contribuyente' => $codigoSeleccionado
        ]);

        // Si todo está bien, redirigir al principal
        return redirect()->route('principal')->with([
            'alert' => [
                'type' => 'success',
                'title' => 'Cuenta seleccionada',
                'message' => 'Cuenta con código ' . $codigoSeleccionado . ' ha sido seleccionada correctamente.',
            ]
        ]);
    }




}
