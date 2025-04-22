<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SolicitudAccesoRequest;
use App\Models\SolicitudAcceso;
use Barryvdh\Debugbar\Facades\Debugbar;
use App\Models\TipoDocumento;
use App\Services\ServicioEmail;
use Illuminate\Http\Request;

class SolicitarAccesoController extends Controller
{
    public function index()
    {
        $tiposDocumento = TipoDocumento::obtenerTipoDocs();

        return view('registro', compact('tiposDocumento'));
    }

    public function insertarSolcitudAcceso(SolicitudAccesoRequest $request)
    {
        // 1. Obtener y preparar los datos
        $data = $request->all();

        // Obtener nombre del tipo de documento
        $nombreDocumento = TipoDocumento::obtenerTipoDocs($data['iTipoDocuId']);
        $data['nombreDocumento'] = is_array($nombreDocumento) ?
             ($nombreDocumento[0]->doc ?? '') : ($nombreDocumento->doc ?? '');
        // 4. Determinar el nombre completo o razón social
        if ($data['iTipoDocuId'] == '02') { // RUC
            $nombreCompleto = $data['cRazonSocial'];
        } else {
            // Concatenar apellidos y nombres para otros tipos de documento
            $nombreCompleto = trim(($data['cApePate'] ?? '') . ' ' . ($data['cApeMate'] ?? '') . ' ' . ($data['cNombres'] ?? ''));
            $nombreCompleto = trim($nombreCompleto); // Eliminar espacios extra
        }
        $this->prepararDatosSolicitud($data, $request);

        // 2. Validar solicitudes existentes
        $resultadoValidacion = $this->validarSolicitudExistente($data);
        if ($resultadoValidacion) {
            return $resultadoValidacion;
        }

        // 3. Procesar archivo adjunto si existe
        $this->procesarArchivoAdjunto($data, $request);
        //3.1 Enviar Correo Notificacion
        $this->enviarCorreoSolicitud($data, $data, $nombreCompleto);
        // 4. Registrar la solicitud
        return $this->registrarNuevaSolicitud($data);
    }

    private function prepararDatosSolicitud(&$data, $request)
    {


        // Formatear nombre completo según tipo de documento
        if ($data['iTipoDocuId'] == '02') { // RUC
            $data['nombreCompleto'] = $data['cRazonSocial'];
        } else {
            // Concatenar apellidos y nombres para otros tipos de documento
            $data['nombreCompleto'] = trim(
                ($data['cApePate'] ?? '') . ' ' .
                    ($data['cApeMate'] ?? '') . ' ' .
                    ($data['cNombres'] ?? '')
            );
        }

        // Añadir IP del cliente
        $data['cEstacionSolicitud'] = $request->ip();
    }

    private function validarSolicitudExistente($data)
    {
        // Validación: Solicitud pendiente
        if (SolicitudAcceso::existeSolicitudPendiente($data['nNumDocuId'])) {
            return redirect()->route('solicitarAcceso')
                ->withInput()
                ->with([
                    'alert' => [
                        'type' => 'warning',
                        'title' => 'Solicitud pendiente',
                        'message' => "Ya existe una solicitud pendiente con el {$data['nombreDocumento']} : {$data['nNumDocuId']}."
                    ]
                ]);
        }

        // Validación: Ya está registrado en MUSUARIO
        if (SolicitudAcceso::usuarioRegistrado($data['nNumDocuId'])) {
            return redirect()->route('solicitarAcceso')
                ->withInput()
                ->with([
                    'alert' => [
                        'type' => 'warning',
                        'title' => 'Usuario registrado',
                        'message' => "El {$data['nombreDocumento']} : {$data['nNumDocuId']} ya se encuentra registrado en el sistema."
                    ]
                ]);
        }

        return null;
    }

    private function procesarArchivoAdjunto(&$data, $request)
    {
        if ($request->hasFile('archivo') && $request->file('archivo')->isValid()) {
            $file = $request->file('archivo');
            $ruta = $file->store('archivos_solicitudAcceso');
            $data['cExtension'] = $file->getClientOriginalExtension();
            $data['cRutaFile'] = $ruta;
            $data['cSizeFile'] = $file->getSize();
        }

        Debugbar::info($data);
    }

    private function registrarNuevaSolicitud($data)
    {
        try {
            $resultado = SolicitudAcceso::registrarSolicitud($data);

            if (!empty($resultado)) {
                $solicitud = $resultado[0]; // El primer (y único) resultado del SP

                return redirect()->route('login')->with([
                    'alert' => [
                        'type' => 'success',
                        'title' => 'Solicitud registrada exitosamente',
                       'message' => 'Tu solicitud ha sido registrada correctamente. ' . ($data['nombreDocumento'] ?? 'Documento') . ': ' . ($solicitud->nNumDocuId ?? 'N/D')
                    ]
                ]);
            }

            return redirect()->route('solicitarAcceso')
                ->withInput()
                ->with([
                    'alert' => [
                        'type' => 'error',
                        'title' => 'Error inesperado',
                        'message' => 'No se obtuvo una respuesta del sistema. Intenta nuevamente.'
                    ]
                ]);
        } catch (\Exception $e) {
            return redirect()->route('solicitarAcceso')
                ->withInput()
                ->with([
                    'alert' => [
                        'type' => 'error',
                        'title' => 'Error al registrar solicitud',
                        'message' => $e->getMessage()
                    ]
                ]);
        }
    }

    private function enviarCorreoSolicitud($data, $solicitud, $nombreCompleto)
    {
        try {
            // Obtener el servicio de email mediante el contenedor de servicios
            $servicioEmail = app(ServicioEmail::class);


            // Usar el correo proporcionado en la solicitud
            $destinatario = $data['correoDestino'] ?? 'admin@example.com';

            // Asunto del correo
            $asunto = 'Nueva solicitud de acceso al sistema SITA';

            // Contenido del correo - simplificado solo con la información esencial
            $contenido = "
                <h2>Nueva solicitud de acceso</h2>
                <p>Se ha solicitado el registro al sistema SITA con los siguientes datos:</p>
                <ul>
                    <li><strong>{$data['nombreDocumento']}:</strong> {$solicitud->nNumDocuId}</li>
                    <li><strong>Nombres/Razón social:</strong> {$nombreCompleto}</li>
                    <li><strong>Correo electrónico:</strong> {$data['correoDestino']}</li>
                    <li><strong>Teléfono:</strong> {$data['telefono']}</li>
                </ul>
                <p>Por favor, revise esta solicitud en el panel administrativo.</p>
            ";

            // Enviar el correo
            $servicioEmail->enviar($destinatario, $asunto, $contenido);

            // Log para verificar que se está ejecutando
            DebugBar::info('Correo de notificación enviado a: ' . $destinatario);

        } catch (\Exception $e) {
            // Registrar el error pero continuar con el proceso
            DebugBar::error('Error al enviar correo de notificación: ' . $e->getMessage());
        }
    }
}
