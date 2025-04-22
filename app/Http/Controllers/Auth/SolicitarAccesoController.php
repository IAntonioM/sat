<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SolicitudAcceso;
use Barryvdh\Debugbar\Facades\Debugbar;
use App\Models\TipoDocumento;
use Illuminate\Http\Request;

class SolicitarAccesoController extends Controller
{
    public function index(){
        $tiposDocumento = TipoDocumento::obtenerTipoDocs();

        return view('registro', compact('tiposDocumento'));
    }

    public function insertarSolcitudAcceso(Request $request)
{
    // Obtener todos los datos directamente
    $data = $request->all();
    $data['cExtension'] = 'pdf';
    $data['cRutaFile'] = '/hola/';
    $data['cSizeFile'] = 100;
    $data['cEstacionSolicitud'] = $request->ip(); // IP del cliente

    Debugbar::info($data);

    try {
        $resultado = SolicitudAcceso::registrarSolicitud($data);

        if (!empty($resultado)) {
            $solicitud = $resultado[0]; // El primer (y único) resultado del SP

            return redirect()->route('login')->with([
                'alert' => [
                    'type' => 'success',
                    'title' => 'Solicitud registrada exitosamente',
                    'message' => 'Tu solicitud ha sido registrada correctamente. DNI: ' . ($solicitud->nNumDocuId ?? 'N/D')
                ]
            ]);
        }

        return redirect()->route('solicitarAcceso')->with([
            'alert' => [
                'type' => 'error',
                'title' => 'Error inesperado',
                'message' => 'No se obtuvo una respuesta del sistema. Intenta nuevamente.'
            ]
        ]);
    } catch (\Exception $e) {
        return redirect()->route('solicitarAcceso')->with([
            'alert' => [
                'type' => 'error',
                'title' => 'Error al registrar solicitud',
                'message' => $e->getMessage()
            ]
        ]);
    }
}

}
