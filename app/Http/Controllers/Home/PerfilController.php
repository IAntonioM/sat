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
        $login = session('login');
        $codigoContribuyente = session('codigo_contribuyente');
        $usuario = Contribuyente::obtenerDatosContri($codigoContribuyente);
        $listarCuentas = Usuario::listarCuentasPorNroDoc($usuario->vnrodoc);
        $fechaActual = Carbon::now()->format('d/m/Y');
        Debugbar::info('Datos:', $listarCuentas);
        if ($login && count($listarCuentas) === 1) {
            return redirect()->route('principal')->with([
                'alert' => [
                    'type' => 'success',
                    'title' => 'Inicio de sesión exitoso',
                    'message' => 'BIENVENIDO, ' . trim(($usuario->vpater ?? '') . ' ' . ($usuario->vmater ?? '') . ' ' . ($usuario->vnombre ?? 'Usuario'))
                ]
            ]);
        }
        return view('perfil', compact('usuario', 'fechaActual', 'listarCuentas'));
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

    public function indexAdmin(Request $request)
    {
        $login = session('login');
        $codigoContribuyente = session('codigo_contribuyente');
        $usuario = Contribuyente::obtenerDatosContri($codigoContribuyente);
        $fechaActual = Carbon::now()->format('d/m/Y');
        if ($login ) {
            return redirect()->route('principal')->with([
                'alert' => [
                    'type' => 'success',
                    'title' => 'Inicio de sesión exitoso',
                    'message' => 'BIENVENIDO, ' . trim(($usuario->vpater ?? '') . ' ' . ($usuario->vmater ?? '') . ' ' . ($usuario->vnombre ?? 'Usuario'))
                ]
            ]);
        }
        return view('perfilAdmin', compact('usuario', 'fechaActual'));
    }
}
