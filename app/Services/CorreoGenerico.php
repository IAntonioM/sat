<?php

namespace App\Services;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CorreoGenerico extends Mailable
{
    use Queueable, SerializesModels;

    public $asunto;
    public $contenidoHtml;
    public $archivosAdjuntos;

    /**
     * Create a new message instance.
     *
     * @param string $asunto
     * @param string $contenidoHtml
     * @param array $archivosAdjuntos
     * @return void
     */
    public function __construct($asunto, $contenidoHtml, $archivosAdjuntos = [])
    {
        $this->asunto = $asunto;
        $this->contenidoHtml = $contenidoHtml;
        $this->archivosAdjuntos = $archivosAdjuntos;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->subject($this->asunto)
                      ->html($this->contenidoHtml);

        foreach ($this->archivosAdjuntos as $adjunto) {
            $email->attach($adjunto);
        }

        return $email;
    }
}
