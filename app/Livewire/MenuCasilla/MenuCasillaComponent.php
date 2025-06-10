<?php

namespace App\Livewire\MenuCasilla;

use Livewire\Component;
use App\Services\RecibidoService;
use App\Models\Contribuyente;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Session;

class MenuCasillaComponent extends Component
{
    public $conteoTipos = [];
    public $tipoSeleccionado; // Para saber qué menú está activo

    public function mount()
    {
        // Obtener el tipo actual de la URL
        $this->tipoSeleccionado = request()->get('tipo', 1);
        $this->cargarConteoTipos();

        // Compartir datos globalmente
        $this->compartirDatosGlobales();
    }

    #[On('actualizarMenuConteo')]
    public function actualizarConteo()
    {
        $this->cargarConteoTipos();
        $this->compartirDatosGlobales();
    }

    #[On('cambiarTipoSeleccionado')]
    public function cambiarTipo($tipo)
    {
        $this->tipoSeleccionado = $tipo;
    }

    private function cargarConteoTipos()
    {
        $codigo_contribuyente = Session::get('codigo_contribuyente');

        if (!$codigo_contribuyente) {
            $this->conteoTipos = [];
            return;
        }

        $usuario = Contribuyente::obtenerDatosContri($codigo_contribuyente);

        if (!$usuario) {
            $this->conteoTipos = [];
            return;
        }

        $service = new RecibidoService();
        $resultado = $service->getDataMenu(['receptor_id' => $usuario->vcodcontr]);

        $this->conteoTipos = [];
        foreach ($resultado as $item) {
            $this->conteoTipos[$item->tipo_id] = (int)$item->cant_no_leidos;
        }
    }

    private function compartirDatosGlobales()
    {
        // Compartir datos con otros componentes usando sesión de Livewire
        Session::put('livewire_conteo_tipos', $this->conteoTipos);
        Session::put('livewire_tipo_seleccionado', $this->tipoSeleccionado);

        // También emitir evento global para otros componentes
        $this->dispatch('conteoTiposActualizado', $this->conteoTipos);
    }

    public function render()
    {
        return view('livewire.menu-casilla-admin.menu-casilla-admin-component');
    }
}
