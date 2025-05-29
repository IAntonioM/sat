<?php

namespace App\Livewire\MenuCasillaAdmin;

use Livewire\Component;

use App\Services\RecibidoService;
use App\Models\Contribuyente;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Session;
class MenuCasillaAdminComponent extends Component
{
     public $conteoTipos = [];

    public function mount()
    {
        $this->cargarConteoTipos();
    }

    #[On('actualizarMenuConteo')]
    public function actualizarConteo()
    {
        $this->cargarConteoTipos();
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
            $this->conteoTipos[$item->tipo_id] = $item->cant_no_leidos;
        }
    }


    public function render()
    {
        return view('livewire.menu-casilla-admin.menu-casilla-admin-component');
    }
}
