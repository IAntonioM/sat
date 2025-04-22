<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SolicitudAcceso;
use Barryvdh\Debugbar\Facades\Debugbar;
use App\Models\TipoDocumento;
use Illuminate\Http\Request;

class SolicitarAccesoController extends Controller
{
    public function index()
    {
        $tiposDocumento = TipoDocumento::obtenerTipoDocs();

        return view('registro', compact('tiposDocumento'));
    }

    public function insertarSolcitudAcceso(Request $request)
    {
        // Obtener todos los datos directamente
        $data = $request->all();
        // Verifica si se subió un archivo
        if ($request->hasFile('archivo') && $request->file('archivo')->isValid()) {
            $file = $request->file('archivo');

            // Guarda el archivo en storage/app/archivos_solicitudAcceso
            $ruta = $file->store('archivos_solicitudAcceso');

            // Extrae datos del archivo
            $data['cExtension'] = $file->getClientOriginalExtension();
            $data['cRutaFile'] = $ruta;
            $data['cSizeFile'] = $file->getSize();
        } else {
            // En caso no se suba nada, puedes definir valores por defecto o lanzar un error
            $data['cExtension'] = null;
            $data['cRutaFile'] = null;
            $data['cSizeFile'] = null;
        }

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
