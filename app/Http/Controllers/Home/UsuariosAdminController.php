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
        // Obtener el código del contribuyente de la sesión o del parámetro
        $codigoContribuyente = session('codigo_contribuyente') ??
        session('cod_usuario') ?? null; // Valor por defecto para pruebas

        $usuario =  Session::get('usuario');

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

        Debugbar::info('Data:', $viewData);

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

            $codigoContribuyente = $request->session()->get('codigo_contribuyente');
            $tipoAdministrador = $request->tipoAdministrador ?? '%';
            $estadoSeleccionado  = $request->estadoSeleccionado ?? '%';

            if (!$codigoContribuyente) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No se encontró el código de contribuyente en la sesión'
                ], 400);
            }

            // Obtener las deudas detalladas
            $deudas = UsuariosAdmins::obtenerUsuarios($tipoAdministrador, $estadoSeleccionado );

            // Verificar si hay una propiedad 'año' en los registros
            // El nombre de la propiedad podría variar según la codificación
            $keyAnio = 'año';
            if (!empty($deudas) && !isset($deudas[0]->$keyAnio)) {
                // Buscamos la clave correcta para agrupar
                $firstRecord = (array)$deudas[0];
                $possibleKeys = ['año', 'ano', 'anio', 'year'];

                foreach ($possibleKeys as $key) {
                    if (array_key_exists($key, $firstRecord)) {
                        $keyAnio = $key;
                        break;
                    }
                }

                Debugbar::info('Clave de agrupación encontrada', ['keyAnio' => $keyAnio]);
            }

            // Agrupar por la clave identificada
            $deudas = collect($deudas)->groupBy($keyAnio);

            Debugbar::info('Deudas encontradas', ['cantidad' => count($deudas)]);

            return response()->json([
                'status' => 'success',
                'deudas' => $deudas,
            ]);
        } catch (\Exception $e) {
            Debugbar::error('Error al filtrar deudas', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Error al filtrar las deudas: ' . $e->getMessage()
            ], 500);
        }
    }
}
