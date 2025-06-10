<?php

namespace App\Livewire\NuevaCasilla;

use Livewire\Component;
use Livewire\WithFileUploads;
use Barryvdh\Debugbar\Facades\Debugbar;
use App\Services\EmitidoService;
use App\Services\RecibidoService;
use App\Services\UsuarioService;
use App\Services\TipoDocumentoService; // Agregar este servicio
use Illuminate\Support\Facades\Session;

use App\Models\Contribuyente;

class NuevaCasillaComponent extends Component
{
    use WithFileUploads;

    protected EmitidoService $service;
    protected UsuarioService $usuarioService;
    protected RecibidoService $tipoDocumentoService; // Agregar esta propiedad

    public $to = '';
    public $cc = '';
    public $bcc = '';
    public $subject = '';
    public $message = '';
    public $attachments = [];     // Lista de archivos ya agregados
    public $newAttachments = [];  // Nuevos archivos temporales
    public $esUsuarioNormal = false; // Nueva propiedad para identificar tipo de usuario
    // Propiedades para usuario
    public $usuarios = [];
    public $mostrarListaUsuarios = false;
    public $selectedIndex = -1;
    public $usuarioSeleccionado = null;

    // Propiedades para tipo de documento/área
    public $tipoDocumentoEmitidoId = '';
    public $tiposDocumento = [];

    protected $rules = [
        'to' => 'required|string|min:1',
        'subject' => 'required|string|min:1',
        'message' => 'required|string|min:1',
        'tipoDocumentoEmitidoId' => 'required|integer|min:1',
    ];

    protected $messages = [
        'to.required' => 'El campo Para es obligatorio',
        'subject.required' => 'El asunto es obligatorio',
        'message.required' => 'El mensaje es obligatorio',
        'tipoDocumentoEmitidoId.required' => 'Debe seleccionar un área/tipo de documento',
    ];

    public function boot(EmitidoService $service, UsuarioService $usuarioService, RecibidoService $tipoDocumentoService)
    {
        $this->service = $service;
        $this->usuarioService = $usuarioService;
        $this->tipoDocumentoService = $tipoDocumentoService;
    }
    public function establecerAdminPorDefecto()
    {
        // Crear objeto admin por defecto
        $adminPorDefecto = (object) [
            'cidusu' => '0000005092',
            'vnombre' => 'ADMIN',
            'vrazon' => '',
            'vpater' => '',
            'vmater' => '',
            'vnrodoc' => 'admin',
            'vcorreo' => '',
            'vusuario' => 'ADMIN',
            'vcodcontr' => 'admin'
        ];

        $this->usuarioSeleccionado = $adminPorDefecto;
        $this->to = 'ADMIN';

        Debugbar::info('👤 Admin establecido por defecto para usuario normal');
    }
    public function mount()
    {
        $codigo_contribuyente = Session::get('codigo_contribuyente');
        $usuario = Contribuyente::obtenerDatosContri($codigo_contribuyente);
        // Verificar si es usuario normal (estado '001')
        $this->esUsuarioNormal = ($usuario && $usuario->vestado === '001');

        // Si es usuario normal, establecer admin por defecto
        if ($this->esUsuarioNormal) {
            $this->establecerAdminPorDefecto();
        }
        // Cargar los tipos de documento al inicializar el componente
        $this->cargarTiposDocumento();
    }

    public function cargarTiposDocumento()
    {
        try {
            // Aquí debes ajustar según tu servicio o modelo
            $this->tiposDocumento = $this->tipoDocumentoService->getAllMenu([]);

            Debugbar::info('📋 Tipos de documento cargados:', $this->tiposDocumento);
        } catch (\Exception $e) {
            Debugbar::error('❌ Error al cargar tipos de documento:', $e->getMessage());
            $this->tiposDocumento = [];
        }
    }


    public function updatedTo()
    {
        // Si es usuario normal, no permitir cambios en el destinatario
        if ($this->esUsuarioNormal) {
            $this->to = 'ADMIN';
            return;
        }

        // Lógica original para usuarios admin
        $this->selectedIndex = -1;
        $this->usuarioSeleccionado = null;

        if (strlen(trim($this->to)) >= 2) {
            $this->buscarUsuarios();
        } else {
            $this->usuarios = [];
            $this->mostrarListaUsuarios = false;
        }
    }
    public function buscarUsuarios()
    {
        // Solo permitir búsqueda si NO es usuario normal
        if ($this->esUsuarioNormal) {
            return;
        }

        $params = [
            'term' => $this->to,
            'accion' => 1
        ];

        $this->usuarios = $this->usuarioService->buscarUsuario($params);
        $this->mostrarListaUsuarios = count($this->usuarios) > 0;
        $this->selectedIndex = -1;

        Debugbar::info('👤 Usuarios encontrados:', $this->usuarios);
    }

    public function seleccionarUsuario($index)
    {
        // Solo permitir selección si NO es usuario normal
        if ($this->esUsuarioNormal) {
            return;
        }

        if (isset($this->usuarios[$index])) {
            $usuario = $this->usuarios[$index];
            $this->usuarioSeleccionado = $usuario;
            $this->to = trim($usuario->vnombre . ' ' . $usuario->vpater . ' ' . $usuario->vmater);
            $this->cerrarListaUsuarios();

            Debugbar::info('👤 Usuario seleccionado:', $usuario);
        }
    }

    public function seleccionarUsuarioConTeclado()
    {
        if ($this->selectedIndex >= 0 && isset($this->usuarios[$this->selectedIndex])) {
            $this->seleccionarUsuario($this->selectedIndex);
        }
    }

    public function cerrarListaUsuarios()
    {
        $this->mostrarListaUsuarios = false;
        $this->selectedIndex = -1;
    }

    public function limpiarSeleccion()
    {
        // Si es usuario normal, mantener admin por defecto
        if ($this->esUsuarioNormal) {
            $this->establecerAdminPorDefecto();
            return;
        }

        // Lógica original para usuarios admin
        $this->to = '';
        $this->usuarios = [];
        $this->mostrarListaUsuarios = false;
        $this->selectedIndex = -1;
        $this->usuarioSeleccionado = null;
    }

    // 📌 Manejador para los nuevos archivos temporales
    public function updatedNewAttachments()
    {
        if ($this->newAttachments) {
            foreach ($this->newAttachments as $file) {
                $this->attachments[] = $file;
            }
            $this->newAttachments = [];
        }
    }

    public function removeAttachment($index)
    {
        unset($this->attachments[$index]);
        $this->attachments = array_values($this->attachments);
    }

    public function send()
    {
        $this->validate();

        $codigo_contribuyente = Session::get('codigo_contribuyente');

        $params = [
            'contenido' => $this->message,
            'asunto' => $this->subject,
            'emisor_id' => $codigo_contribuyente,
            'tipo_documento_emitido_id' => $this->tipoDocumentoEmitidoId, // Usar el valor seleccionado
            'estado_emitido_id' => 1,
            'usuario_creacion' => 1,
            'anio' => date('Y'),
        ];

        if ($this->usuarioSeleccionado) {
            $params['receptor_id'] = $this->usuarioSeleccionado->vcodcontr;
        }

        // 📎 Procesar archivos adjuntos
        $anexosArray = [];

        foreach ($this->attachments as $attachment) {
            try {
                $originalName = $attachment->getClientOriginalName();
                $extension = $attachment->getClientOriginalExtension();
                $fileName = time() . '_' . uniqid() . '.' . $extension;
                $filePath = $attachment->storeAs('archivos_casilla_electronica', $fileName);

                $anexosArray[] = [
                    'nombre_archivo' => $originalName,
                    'url_archivo' => $fileName,
                    'extension_tipo' => $extension
                ];

                Debugbar::info('📎 Archivo guardado:', [
                    'original' => $originalName,
                    'almacenado_como' => $fileName,
                    'ext' => $extension,
                ]);
            } catch (\Exception $e) {
                Debugbar::error('❌ Error archivo:', [
                    'file' => $attachment->getClientOriginalName(),
                    'error' => $e->getMessage()
                ]);

                session()->flash('error', 'Error al subir archivo: ' . $attachment->getClientOriginalName());
            }
        }

        if (!empty($anexosArray)) {
            $params['json_anexos'] = json_encode($anexosArray);
        }

        Debugbar::info('📤 Parámetros finales:', $params);

        $resultado = $this->service->crear($params);

        Debugbar::info('📨 Resultado creación:', $resultado);

        // Limpiar formulario
        $this->reset([
            'to',
            'cc',
            'bcc',
            'subject',
            'message',
            'tipoDocumentoEmitidoId',
            'attachments',
            'usuarios',
            'mostrarListaUsuarios',
            'selectedIndex',
            'usuarioSeleccionado'
        ]);

        session()->flash('success', 'Mensaje enviado correctamente');
    }

    public function limpiarFormulario()
    {
        $this->reset([
            'to',
            'cc',
            'bcc',
            'subject',
            'message',
            'tipoDocumentoEmitidoId',
            'attachments',
            'usuarios',
            'mostrarListaUsuarios',
            'selectedIndex',
            'usuarioSeleccionado'
        ]);
    }

    public function render()
    {
        return view('livewire.nueva-casilla.nueva-casilla-component');
    }
}
