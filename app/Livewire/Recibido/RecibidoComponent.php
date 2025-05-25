<?php

namespace App\Livewire\Recibido;

use Livewire\Component;
use Barryvdh\Debugbar\Facades\Debugbar;
use App\Models\Contribuyente;
use App\Services\RecibidoService;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\On;

class RecibidoComponent extends Component
{
    public $documentos = [];
    public $search = '';
    protected RecibidoService $service;
    public $json_recibido = []; // Array de nu_emi seleccionados

    public function boot(RecibidoService $service)
    {
        $this->service = $service;
    }

    public function mount()
    {
        $this->buscarDocumentos();
    }

    public function updatedSearch()
    {
        $this->buscarDocumentos();
    }

    public function buscar()
    {
        $this->buscarDocumentos();
    }

    public function seleccionarDocumento($nu_emi)
    {
        $this->dispatch('documentoSeleccionado', nu_emi: $nu_emi);
        $this->buscarDocumentos();
    }

    #[On('actualizarRecibido')]
    public function actualizarRecibido()
    {
        $this->buscarDocumentos();
    }

    public function buscarDocumentos()
    {
        $codigo_contribuyente = Session::get('codigo_contribuyente');
        $usuario = Contribuyente::obtenerDatosContri($codigo_contribuyente);
        $anioActual = date('Y');

        // Convertir array de seleccionados a JSON
        $selectedJson = !empty($this->json_recibido) ? json_encode($this->json_recibido) : null;

        $resultado = $this->service->buscar([
            'pagina' => 1,
            'registros_por_pagina' => 10,
            'anio' => (int)$anioActual,
            'tipo_documento_emitido_id' => 1,
            'receptor_id' => $usuario->vcodcontr,
            'asunto' => $this->search ?: null,
            'json_recibido' => $selectedJson
        ]);

        Debugbar::info('📄 SELECCIONADOS JSON:', $selectedJson);
        Debugbar::info('📄 RESULTADOS:', $resultado);

        $this->documentos = $resultado ?? [];
    }

    // Método para manejar selección/deselección de documentos individuales
    public function toggleRecibido($nuEmi)
    {
        if (in_array($nuEmi, $this->json_recibido)) {
            $this->json_recibido = array_diff($this->json_recibido, [$nuEmi]);
        } else {
            $this->json_recibido[] = $nuEmi;
        }

        // Disparar evento para efectos visuales (opcional)
        $this->dispatch('seleccionActualizada');

        // Realizar nueva búsqueda para mantener los seleccionados visibles
        $this->buscarDocumentos();
    }

    // NUEVO: Método para seleccionar/deseleccionar todos los documentos visibles
    public function toggleTodos()
    {
        $documentosVisibles = collect($this->documentos)->pluck('nu_emi')->toArray();

        // Si todos los visibles están seleccionados, deseleccionar todos
        if (count(array_intersect($this->json_recibido, $documentosVisibles)) === count($documentosVisibles)) {
            $this->json_recibido = array_diff($this->json_recibido, $documentosVisibles);
        } else {
            // Sino, seleccionar todos los visibles (sin duplicar)
            $this->json_recibido = array_unique(array_merge($this->json_recibido, $documentosVisibles));
        }

        $this->dispatch('seleccionActualizada');
        $this->buscarDocumentos();
    }

    // NUEVO: Método para limpiar toda la selección
    public function limpiarSeleccion()
    {
        $this->json_recibido = [];
        $this->buscarDocumentos();
    }

    // NUEVO: Método para procesar los documentos seleccionados
    public function procesarSeleccionados()
    {
        if (empty($this->json_recibido)) {
            $this->dispatch('mostrarAlerta', [
                'tipo' => 'warning',
                'mensaje' => 'No hay documentos seleccionados'
            ]);
            return;
        }

        // Aquí puedes agregar la lógica para procesar los documentos seleccionados
        $documentosSeleccionados = $this->getSelectedRecibidosData();

        Debugbar::info('🔄 PROCESANDO:', $documentosSeleccionados);

        // Ejemplo: enviar a otro componente o ejecutar alguna acción
        $this->dispatch('procesarDocumentos', [
            'documentos' => $this->json_recibido,
            'datos' => $documentosSeleccionados
        ]);

        $this->dispatch('mostrarAlerta', [
            'tipo' => 'success',
            'mensaje' => 'Se procesaron ' . count($this->json_recibido) . ' documentos'
        ]);
    }

    // Método para obtener documentos seleccionados con sus datos completos
    public function getSelectedRecibidosData()
    {
        if (empty($this->json_recibido)) {
            return [];
        }

        return collect($this->documentos)
               ->whereIn('nu_emi', $this->json_recibido)
               ->values()
               ->toArray();
    }

    // NUEVO: Método para obtener estadísticas de selección
    public function getSelectionStats()
    {
        return [
            'total_documentos' => count($this->documentos),
            'total_seleccionados' => count($this->json_recibido),
            'seleccionados_visibles' => count(array_intersect(
                $this->json_recibido,
                collect($this->documentos)->pluck('nu_emi')->toArray()
            )),
            'todos_visibles_seleccionados' => count($this->documentos) > 0 &&
                count(array_intersect(
                    $this->json_recibido,
                    collect($this->documentos)->pluck('nu_emi')->toArray()
                )) === count($this->documentos)
        ];
    }

    public function render()
    {
        return view('livewire.recibido.recibido-component', [
            'documentos' => $this->documentos,
            'stats' => $this->getSelectionStats() // Opcional: pasar estadísticas a la vista
        ]);
    }
}
?>
