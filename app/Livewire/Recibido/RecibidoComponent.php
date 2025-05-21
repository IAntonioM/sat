<?php

namespace App\Livewire\Recibido;

use Livewire\Component;
use Barryvdh\Debugbar\Facades\Debugbar;
use App\Models\Contribuyente;
use App\Services\RecibidoService;
use Illuminate\Support\Facades\Session;

class RecibidoComponent extends Component
{
    public $documentos = [];
    public $search = '';
    protected RecibidoService $service;

    // Quita el debounce de la propiedad y mejor lo aplicamos en la vista

    public function boot(RecibidoService $service)
    {
        $this->service = $service;
    }

    public function mount()
    {
        $this->buscarDocumentos();
    }

    // Este método puede que no se ejecute correctamente con el debounce
    public function updatedSearch()
    {
        $this->buscarDocumentos();
    }

    // Este método es el que se llamará desde el botón y desde Enter
    public function buscar()
    {
        $this->buscarDocumentos();
    }

    //Selcionar un documento para pasar el correlativo y mostrar la
    public function seleccionarDocumento($nu_emi)
    {
        $this->dispatch('documentoSeleccionado', nu_emi: $nu_emi);
    }


    public function buscarDocumentos()
    {
        $codigo_contribuyente = Session::get('codigo_contribuyente');

        $usuario = Contribuyente::obtenerDatosContri($codigo_contribuyente);
        $anioActual = date('Y');

        $resultado = $this->service->buscar([
            'pagina' => 1,
            'registros_por_pagina' => 10,
            'anio' => (int)$anioActual,
            'tipo_documento_emitido_id' => 1,
            'receptor_id' => $usuario->vcodcontr,
            'asunto' => $this->search ?: null,  // si search vacío, enviar null
        ]);

        Debugbar::info('📄 RESULTADOS:', $resultado);
        $this->documentos = $resultado ?? [];
    }

    public function render()
    {
        return view('livewire.recibido.recibido-component', [
            'documentos' => $this->documentos
        ]);
    }
}
