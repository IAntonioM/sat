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

        // Obtener el filtro de estado
        $estadoSeleccionado = $request->estado ?? '%';

        // Preparar parámetros para el procedimiento almacenado
        $params = [
            'vestado_cuenta' => $estadoSeleccionado
        ];

        // Obtener las solicitudes
        $usuarios = UsuariosAdmins::listarUsuarios($params);

        // Obtener estados disponibles
        $estadosDisponibles = UsuariosAdmins::obtenerEstadosDisponibles();

        // Fecha de actualización para mostrar en la vista
        $fechaActual = Carbon::now()->format('d/m/Y');

        // Data to send to the view
        $viewData = [
            'usuario' => $usuario,
            'Usuarios' => $usuarios,
            'fechaActual' => $fechaActual,
            'estadosDisponibles' => $estadosDisponibles,
            'estadoSeleccionado' => $estadoSeleccionado
        ];

        return view('usuarios', $viewData);
    }

    /**
     * Filtra los usuarios por estado
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function filtrar(Request $request)
    {
        try {
            Debugbar::info('Filtro recibido', $request->all());

            $estadoSeleccionado = $request->estado ?? '%';

            Debugbar::info('Parámetros de filtrado', [
                'estado' => $estadoSeleccionado
            ]);

            // Preparar parámetros para el procedimiento almacenado
            $params = [
                'vestado_cuenta' => $estadoSeleccionado
            ];

            // Obtener los usuarios filtrados
            $usuarios = UsuariosAdmins::listarUsuarios($params);

            Debugbar::info('Usuarios encontrados', ['cantidad' => count($usuarios)]);

            return response()->json([
                'status' => 'success',
                'usuarios' => $usuarios,
            ]);
        } catch (\Exception $e) {
            Debugbar::error('Error al filtrar usuarios', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Error al filtrar los usuarios: ' . $e->getMessage()
            ], 500);
        }
    }
}
