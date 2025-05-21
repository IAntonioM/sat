<?php

namespace App\Livewire\Emitido;

use Livewire\Component;
use App\Services\EmitidoService;
use Barryvdh\Debugbar\Facades\Debugbar;
use Livewire\Attributes\On;

class EmitidoComponent extends Component
{
    public $documentos = [];
    public $padre = null;
    public $hijos = [];
    public $nu_emi = '';
    public $anio = null;
    public $visible = false;
    protected EmitidoService $service;

    public function boot(EmitidoService $service)
    {
        $this->service = $service;
    }

    #[On('documentoSeleccionado')]
    public function cargarDocumento($nu_emi)
    {
        $this->visible = true;
        $this->nu_emi = $nu_emi;
        $this->buscarDocumento();
    }

    public function buscarDocumento()
    {
        if (!$this->nu_emi) {
            $this->documentos = [];
            $this->padre = null;
            $this->hijos = [];
            return;
        }

        $resultado = $this->service->buscar([
            'nu_emi' => $this->nu_emi,
            'anio' => $this->anio ?? date('Y'),
        ]);

        $this->documentos = $resultado ?? [];

        // Separar padre e hijos
        $this->padre = collect($this->documentos)->firstWhere('nu_emi', $this->nu_emi);
        $this->hijos = collect($this->documentos)
            ->where('nu_emi_padre', $this->nu_emi)
            ->values();
    }

    public function render()
    {
        Debugbar::info('📄 padre:', $this->padre);
        Debugbar::info('📄 hijos:', $this->hijos);
        return view('livewire.emitido.emitido-component', [
            'padre' => $this->padre,
            'hijos' => $this->hijos
        ]);
    }

    #[On('messageSent')]
    public function actualizarChats()
    {
        $this->buscarDocumento();
    }

}
