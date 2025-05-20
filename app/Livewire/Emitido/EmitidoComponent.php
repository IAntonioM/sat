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
    public $correlativo = '';
    public $anio = null;
    public $visible = false;
    protected EmitidoService $service;

    public function boot(EmitidoService $service)
    {
        $this->service = $service;
    }

    #[On('documentoSeleccionado')]
    public function cargarDocumento($correlativo)
    {
        $this->visible = true;
        $this->correlativo = $correlativo;
        $this->buscarDocumento();
    }

    public function buscarDocumento()
    {
        if (!$this->correlativo) {
            $this->documentos = [];
            $this->padre = null;
            $this->hijos = [];
            return;
        }

        $resultado = $this->service->buscar([
            'correlativo' => $this->correlativo,
            'anio' => $this->anio ?? date('Y'),
        ]);

        $this->documentos = $resultado ?? [];

        // Separar padre e hijos
        $this->padre = collect($this->documentos)->firstWhere('correlativo', $this->correlativo);
        $this->hijos = collect($this->documentos)
            ->where('padre_correlativo', $this->correlativo)
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
}
