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
    public $newAttachments = []; // Nueva propiedad para archivos temporales
    public $tipoSeleccionado = 1; // Valor por defecto

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
        $this->tipoSeleccionado = request()->get('tipo', 1) ?? 1;
        $this->padre = $padre;
        $codigo_contribuyente = Session::get('codigo_contribuyente');

        if ($padre) {
            if ($padre->emisor_id == $codigo_contribuyente) {
                $this->to = $padre->nombre_receptor ?? '';
            } else {
                $this->to = $padre->nombre_emisor ?? '';
            }

            if (isset($padre->asunto)) {
                $this->subject = "RE: " . $padre->asunto;
            }
        }
    }

    // Método para manejar nuevos archivos
    public function updatedNewAttachments()
    {
        if ($this->newAttachments) {
            // Agregar los nuevos archivos a la lista existente
            foreach ($this->newAttachments as $file) {
                $this->attachments[] = $file;
            }

            // Limpiar la propiedad temporal
            $this->newAttachments = [];
        }
    }

    public function removeAttachment($index)
    {
        unset($this->attachments[$index]);
        $this->attachments = array_values($this->attachments);
    }

    // Método para obtener la URL temporal del archivo
    public function getFileUrl($index)
    {
        if (isset($this->attachments[$index])) {
            $file = $this->attachments[$index];
            // Obtener el path temporal de Livewire
            $temporaryPath = $file->getFilename();
            return route('ver.archivoCasilla', $temporaryPath);
        }
        return null;
    }

    public function send()
    {
        Debugbar::info('📥 padre en EmitirMensajeComponent:', $this->padre);

        $this->validate([
            'to' => 'required',
            'message' => 'required',
        ]);

        $codigo_contribuyente = Session::get('codigo_contribuyente');
        $receptor_id = ($this->padre->emisor_id == $codigo_contribuyente)
            ? $this->padre->receptor_id
            : $this->padre->emisor_id;

        // Procesar archivos adjuntos para generar JSON
        $anexosArray = [];

        if (!empty($this->attachments)) {
            foreach ($this->attachments as $attachment) {
                try {
                    // Nombre original del archivo subido por el usuario
                    $originalName = $attachment->getClientOriginalName();

                    // Extraer extensión del archivo, ej: 'pdf', 'docx'
                    $extension = $attachment->getClientOriginalExtension();

                    // Generar nombre único para el archivo guardado
                    $fileName = time() . '_' . uniqid() . '.' . $extension;

                    // Guardar archivo en storage/app/archivos_casilla_electronica
                    $filePath = $attachment->storeAs('archivos_casilla_electronica', $fileName);

                    // Agregar al array de anexos con nombre original y archivo almacenado
                    $anexosArray[] = [
                        'nombre_archivo' => $originalName,  // ← lo que pidió el usuario
                        'url_archivo' => $fileName,         // ← lo que guardaste físicamente
                        'extension_tipo' => $extension
                    ];

                    Debugbar::info('📎 Archivo procesado:', [
                        'original' => $originalName,
                        'stored_as' => $fileName,
                        'path' => $filePath,
                        'ext' => $extension,
                        'size' => $attachment->getSize()
                    ]);
                } catch (\Exception $e) {
                    Debugbar::error('❌ Error subiendo archivo:', [
                        'file' => $attachment->getClientOriginalName(),
                        'error' => $e->getMessage()
                    ]);

                    session()->flash('error', 'Error al subir el archivo: ' . $attachment->getClientOriginalName());
                }
            }
        }


        $params = [
            'contenido' => $this->message,
            'asunto' => $this->subject,
            'emisor_id' => $codigo_contribuyente,
            'receptor_id' => $receptor_id,
            'json_anexos' => !empty($anexosArray) ? json_encode($anexosArray) : null,
        ];

        if ($this->padre) {
            if (isset($this->padre->anio)) {
                $params['anio'] = $this->padre->anio;
            }
            if (isset($this->padre->nu_emi)) {
                $params['nu_emi_padre'] = $this->padre->nu_emi;
            }
            $params['tipo_documento_emitido_id'] = $this->tipoSeleccionado;
            $params['estado_emitido_id'] = 1;
            $params['usuario_creacion'] = 1;
        }

        Debugbar::info('📄 Parámetros finales:', $params);
        Debugbar::info('📎 JSON Anexos generado:', $anexosArray);

        $resultado = $this->service->crear($params);

        Debugbar::info('📨 Resultado creación emitido:', $resultado);

        $this->reset(['cc', 'bcc', 'subject', 'message', 'attachments']);
        $this->dispatch('messageSent')->to('emitido.emitido-component');
    }
    public function limpiarMensaje()
    {
        $this->message = '';
    }
}
