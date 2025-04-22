<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SolicitudAcceso;
use App\Models\TipoDocumento;
use Illuminate\Http\Request;

class SolicitarAccesoController extends Controller
{
    public function index(){
        $tiposDocumento = TipoDocumento::obtenerTipoDocs();

        return view('registro', compact('tiposDocumento'));
    }

    public function solicitarAcceso(Request $request)
    {
        $data = $request->validate([
            'iTipoDocuId' => 'required|integer',
            'nNumDocuId' => 'required|string',
            'cRazonSocial' => 'nullable|string',
            'cApePate' => 'nullable|string',
            'cApeMate' => 'nullable|string',
            'cNombres' => 'nullable|string',
            'cAsunto' => 'nullable|string',
            'cDireccion' => 'nullable|string',
            'correoDestino' => 'nullable|email',
            'cExtension' => 'nullable|string',
            'cRutaFile' => 'nullable|string',
            'cSizeFile' => 'nullable|integer',
            'cEstacionSolicitud' => 'nullable|string',
        ]);

        try {
            $resultado = SolicitudAcceso::registrarSolicitud($data);

            if (!empty($resultado)) {
                $solicitud = $resultado[0]; // El primer (y único) resultado que devuelve el SP

                return redirect()->route('login')->with([
                    'alert' => [
                        'type' => 'success',
                        'title' => 'Solicitud registrada exitosamente',
                        'message' => 'Tu solicitud ha sido registrada correctamente. DNI: ' . ($solicitud->nNumDocuId ?? 'N/D')
                    ]
                ]);
            }

            return redirect()->route('login')->with([
                'alert' => [
                    'type' => 'error',
                    'title' => 'Error inesperado',
                    'message' => 'No se obtuvo una respuesta del sistema. Intenta nuevamente.'
                ]
            ]);
        } catch (\Exception $e) {
            return redirect()->route('login')->with([
                'alert' => [
                    'type' => 'error',
                    'title' => 'Error al registrar solicitud',
                    'message' => $e->getMessage()
                ]
            ]);
        }
    }
}
