<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\SolicitudAcceso;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\Date;

class PendientesController extends Controller
{
    public function index(Request $request)
    {
        $usuario = Session::get('usuario');
        $estado = $request->estado ?? null;
        $nombreRuc = $request->nombreRuc ?? null;
        $asunto = $request->asunto ?? null;
        $fechaRegistro = $request->fechaRegistro ?? null;
        $fechaActualizacion = $request->fechaActualizacion ?? null;

        // Preparar parámetros para el procedimiento almacenado
        $params = [
            'nFlgEstado' => $estado,
            'NombreRuc' => $nombreRuc,
            'cAsunto' => $asunto,
            'dFechaSolicitud' => $fechaRegistro,
            'dFechaActualizacion' => $fechaActualizacion,
        ];

        // Obtener las solicitudes
        $solicitudes = SolicitudAcceso::listarSolicitud($params);

        // Fecha de actualización para mostrar en la vista
        $fechaActual = Carbon::now()->format('d/m/Y');

        // Data to send to the view
        $viewData = [
            'usuario' => $usuario,
            'solicitudes' => $solicitudes,
            'fechaActual' => $fechaActual,
            'filtros' => [
                'estado' => $estado,
                'nombreRuc' => $nombreRuc,
                'asunto' => $asunto,
                'fechaRegistro' => $fechaRegistro,
                'fechaActualizacion' => $fechaActualizacion,
            ]
        ];

        return view('pendientes', $viewData);
    }

    public function filtrar(Request $request)
    {
        // Esta función redirige al index con los parámetros de filtro
        return $this->index($request);
    }

    public function actualizar(Request $request, $id)
    {
        // Buscar la solicitud por ID
        $solicitud = SolicitudAcceso::findOrFail($id);

        // Actualizar únicamente el estado
        $solicitud->nFlgEstado = $request->estado;
        $solicitud->cUsuarioActualizacion = Session::get('usuario')['cUsuario'] ?? 'sistema';
        $solicitud->dFechaActualizacion = now();
        $solicitud->cEstacionActualizacion = $request->ip();

        // Guardar los cambios
        $solicitud->save();

        return redirect()->route('Pendiente')->with('success', 'Estado de solicitud actualizado correctamente');
    }
}
