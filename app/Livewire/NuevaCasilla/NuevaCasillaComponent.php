<?php

namespace App\Livewire\NuevaCasilla;

use Livewire\Component;
use Livewire\WithFileUploads;
use Barryvdh\Debugbar\Facades\Debugbar;
use App\Services\EmitidoService;
use App\Services\UsuarioService;
use Illuminate\Support\Facades\Session;

class NuevaCasillaComponent extends Component
{
    use WithFileUploads;

    protected EmitidoService $service;
    protected UsuarioService $usuarioService;

    public $to = '';
    public $cc = '';
    public $bcc = '';
    public $subject = '';
    public $message = '';
    public $attachments = [];
    public $usuarios = []; // Lista de usuarios obtenidos
    public $mostrarListaUsuarios = false; // Controlar visibilidad de la lista
    public $selectedIndex = -1; // Índice del usuario seleccionado con teclado
    public $usuarioSeleccionado = null; // Usuario actualmente seleccionado

    // Reglas de validación
    protected $rules = [
        'to' => 'required|string|min:1',
        'subject' => 'required|string|min:1',
        'message' => 'required|string|min:1',
    ];

    protected $messages = [
        'to.required' => 'El campo Para es obligatorio',
        'subject.required' => 'El asunto es obligatorio',
        'message.required' => 'El mensaje es obligatorio',
    ];

    public function boot(EmitidoService $service, UsuarioService $usuarioService)
    {
        $this->service = $service;
        $this->usuarioService = $usuarioService;
    }

    public function updatedTo()
    {
        // Resetear selección cuando se cambia el texto
        $this->selectedIndex = -1;
        $this->usuarioSeleccionado = null;

        // Buscar usuarios automáticamente si hay al menos 2 caracteres
        if (strlen(trim($this->to)) >= 2) {
            $this->buscarUsuarios();
        } else {
            $this->usuarios = [];
            $this->mostrarListaUsuarios = false;
        }
    }

    public function buscarUsuarios()
    {
        if (strlen(trim($this->to)) < 2) {
            $this->usuarios = [];
            $this->mostrarListaUsuarios = false;
            return;
        }

        $params = [
            'term' => $this->to,
            'accion' => 1
        ];

        $this->usuarios = $this->usuarioService->buscarUsuario($params);
        $this->mostrarListaUsuarios = count($this->usuarios) > 0;
        $this->selectedIndex = -1; // Resetear selección

        Debugbar::info('👤 Usuarios encontrados:', $this->usuarios);
    }

    public function seleccionarUsuario($index)
    {
        if (isset($this->usuarios[$index])) {
            $usuario = $this->usuarios[$index];
            $this->usuarioSeleccionado = $usuario;

            // Formatear el texto del input según prefieras
            // Opción 1: Solo el nombre completo
            $this->to = trim($usuario->vnombre . ' ' . $usuario->vpater . ' ' . $usuario->vmater);

            // Opción 2: Nombre + correo (si tiene)
            // if (!empty($usuario->vcorreo)) {
            //     $this->to = trim($usuario->vnombre . ' ' . $usuario->vpater . ' ' . $usuario->vmater) . ' <' . $usuario->vcorreo . '>';
            // } else {
            //     $this->to = trim($usuario->vnombre . ' ' . $usuario->vpater . ' ' . $usuario->vmater);
            // }

            // Cerrar la lista
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

    // Método para obtener el usuario seleccionado completo
    public function getUsuarioSeleccionado()
    {
        return $this->usuarioSeleccionado;
    }

    // Método para limpiar la selección
    public function limpiarSeleccion()
    {
        $this->to = '';
        $this->usuarios = [];
        $this->mostrarListaUsuarios = false;
        $this->selectedIndex = -1;
        $this->usuarioSeleccionado = null;
    }

    public function send()
    {

        // Validate inputs
        $this->validate([
            'to' => 'required',
            'message' => 'required',
        ]);

        $codigo_contribuyente = Session::get('codigo_contribuyente');

        $params = [
            'contenido' => $this->message,
            'asunto' => $this->subject,
            'emisor_id' => $codigo_contribuyente,
        ];

        Debugbar::info('📨 UsuarioSelecionado:', $this->usuarioSeleccionado);
        Debugbar::info('📨 UsuarioSelecionado:', $this->usuarioSeleccionado);
        // Add padre-related fields if padre exists and has the needed properties

        $params['tipo_documento_emitido_id'] = 1;
        $params['estado_emitido_id'] = 1;
        $params['usuario_creacion'] = 1;
        $params['anio'] = date('Y');
        $params['receptor_id'] = $this->usuarioSeleccionado->vcodcontr;
        Debugbar::info('📄 param:', $params);

        $resultado = $this->service->crear($params);

        Debugbar::info('📨 Resultado creación emitido:', $resultado);

        // Reset form after sending
        $this->reset(['cc', 'bcc', 'subject', 'message', 'attachments']);

    }

    public function limpiarFormulario()
    {
        $this->to = '';
        $this->cc = '';
        $this->bcc = '';
        $this->subject = '';
        $this->message = '';
        $this->attachments = [];
        $this->usuarios = [];
        $this->mostrarListaUsuarios = false;
        $this->selectedIndex = -1;
        $this->usuarioSeleccionado = null;
    }

    public function render()
    {
        return view('livewire.nueva-casilla.nueva-casilla-component');
    }
}
