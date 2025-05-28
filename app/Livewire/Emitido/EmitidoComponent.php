<?php

namespace App\Livewire\Emitido;

use App\Models\Contribuyente;
use Livewire\Component;
use App\Services\EmitidoService;
use Barryvdh\Debugbar\Facades\Debugbar;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Session;

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

        $codigo_contribuyente = Session::get('codigo_contribuyente');

        $usuario = Contribuyente::obtenerDatosContri($codigo_contribuyente);
        if (!$this->nu_emi) {
            $this->documentos = [];
            $this->padre = null;
            $this->hijos = [];
            return;
        }

        $resultado = $this->service->buscar([
            'nu_emi' => $this->nu_emi,
            'anio' => $this->anio ?? date('Y'),
            'receptor_id' => $usuario->vcodcontr
        ]);

        $this->documentos = $resultado ?? [];

        // Separar padre e hijos
        $this->padre = collect($this->documentos)->firstWhere('nu_emi', $this->nu_emi);
        $this->hijos = collect($this->documentos)
            ->where('nu_emi_padre', $this->nu_emi)
            ->values();
        $this->dispatch('actualizarRecibido');
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

    public function marcarFavorito($nu_emi)
    {
        $codigo_contribuyente = Session::get('codigo_contribuyente');

        $resultado = $this->service->accionFavorito([
            'nu_emi' => $nu_emi,
            'receptor_id' => $codigo_contribuyente
        ]);

        Debugbar::info('📌 Resultado marcador:', $resultado);

        // Opcionalmente puedes actualizar la lista de documentos o marcar solo el documento afectado
        $this->buscarDocumento(); // Para refrescar
    }


}
