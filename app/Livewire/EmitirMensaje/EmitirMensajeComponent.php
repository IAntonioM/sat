<?php

namespace App\Livewire\EmitirMensaje;

use Livewire\Component;
use Livewire\WithFileUploads;
use Barryvdh\Debugbar\Facades\Debugbar;
use App\Services\EmitidoService;
use Illuminate\Support\Facades\Session;

class EmitirMensajeComponent extends Component
{
    use WithFileUploads;

    protected EmitidoService $service;

    public $padre;
    public $to = '';
    public $cc = '';
    public $bcc = '';
    public $subject = '';
    public $message = '';
    public $attachments = [];

    public function boot(EmitidoService $service)
    {
        $this->service = $service;
    }

    public function render()
    {
        return view('livewire.emitir-mensaje.emitir-mensaje-component');
    }

    public function mount($padre = null)
    {
        $this->padre = $padre;
        $codigo_contribuyente = Session::get('codigo_contribuyente');

        if ($padre) {
            // Determinar si el usuario actual es el emisor
            if ($padre->emisor_id == $codigo_contribuyente) {
                // Usuario es el emisor, entonces responder al receptor
                $this->to = $padre->nombre_receptor ?? '';
            } else {
                // Usuario es el receptor, entonces responder al emisor
                $this->to = $padre->nombre_emisor ?? '';
            }

            // Prellenar asunto
            if (isset($padre->asunto)) {
                $this->subject = "RE: " . $padre->asunto;
            }
        }
    }


    public function saveAttachment($file)
    {
        $this->attachments[] = $file;
    }

    public function removeAttachment($index)
    {
        unset($this->attachments[$index]);
        $this->attachments = array_values($this->attachments);
    }

    public function send()
    {
        Debugbar::info('📥 padre en EmitirMensajeComponent:', $this->padre);

        // Validate inputs
        $this->validate([
            'to' => 'required',
            'message' => 'required',
        ]);

        $codigo_contribuyente = Session::get('codigo_contribuyente');
        $receptor_id = ($this->padre->emisor_id == $codigo_contribuyente)
            ? $this->padre->receptor_id
            : $this->padre->emisor_id;

        $params = [
            'contenido' => $this->message,
            'asunto' => $this->subject,
            'emisor_id' => $codigo_contribuyente,
            'receptor_id' => $receptor_id,
        ];

        // Add padre-related fields if padre exists and has the needed properties
        if ($this->padre) {
            if (isset($this->padre->anio)) {
                $params['anio'] = $this->padre->anio;
            }
            if (isset($this->padre->nu_emi)) {
                $params['nu_emi_padre'] = $this->padre->nu_emi;
            }
            $params['tipo_documento_emitido_id'] = 1;
            $params['estado_emitido_id'] = 1;
            $params['usuario_creacion'] = 1;
        }
        Debugbar::info('📄 param:', $params);

        // Process your email sending logic here
        $resultado = $this->service->crear($params);

        Debugbar::info('📨 Resultado creación emitido:', $resultado);

        // Reset form after sending
        $this->reset(['cc', 'bcc', 'subject', 'message', 'attachments']);
        $this->dispatch('messageSent')->to('emitido.emitido-component');

        // // Emit event or show notification
        // $this->dispatch('messageSent');
    }
}
