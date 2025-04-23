<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use App\Services\CorreoGenerico;
use Exception;
use Illuminate\Support\Facades\Log;

use Barryvdh\Debugbar\Facades\Debugbar;
class ServicioEmail
{
    /**
     * Enviar un correo electrónico
     *
     * @param string $para Dirección de correo del destinatario
     * @param string $asunto Asunto del correo
     * @param string $contenido Contenido HTML del correo
     * @param array $adjuntos Array de rutas de archivos adjuntos (opcional)
     * @param array $cc Array de direcciones en copia (opcional)
     * @param array $bcc Array de direcciones en copia oculta (opcional)
     * @return bool Éxito del envío
     */
    public function enviar($para, $asunto, $contenido, $adjuntos = [], $cc = [], $bcc = [])
    {
        DebugBar::info('Iniciando envío de correo a: ' . $para);
        try {
            Mail::to($para)
                ->cc($cc)
                ->bcc($bcc)
                ->send(new CorreoGenerico($asunto, $contenido, $adjuntos));

            DebugBar::info('Correo enviado exitosamente');
            return true;
        } catch (Exception $e) {
            DebugBar::error('Error al enviar correo: ' . $e->getMessage());
            DebugBar::error('Trace: ' . $e->getTraceAsString());
            return false;
        }
    }

    /**
     * Enviar un correo con plantilla Blade
     *
     * @param string $para Dirección de correo del destinatario
     * @param string $asunto Asunto del correo
     * @param string $vista Nombre de la vista Blade
     * @param array $datos Datos para la vista
     * @param array $adjuntos Array de rutas de archivos adjuntos (opcional)
     * @return bool Éxito del envío
     */
    public function enviarConPlantilla($para, $asunto, $vista, $datos = [], $adjuntos = [])
    {
        try {
            Mail::send($vista, $datos, function ($mensaje) use ($para, $asunto, $adjuntos) {
                $mensaje->to($para)->subject($asunto);

                foreach ($adjuntos as $adjunto) {
                    $mensaje->attach($adjunto);
                }
            });

            return true;
        } catch (Exception $e) {
            Log::error('Error al enviar correo con plantilla: ' . $e->getMessage());
            return false;
        }
    }
}
