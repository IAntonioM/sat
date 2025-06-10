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
    public $tipoSeleccionado = 1; // Valor por defecto

    public function boot(RecibidoService $service)
    {
        $this->service = $service;
    }

    public function mount()
    {

        $this->tipoSeleccionado = request()->get('tipo', 1) ?? 1;
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
        $this->dispatch('actualizarMenuConteo');
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
            'tipo_documento_emitido_id' => $this->tipoSeleccionado,
            'receptor_id' => $usuario->vcodcontr,
            'asunto' => $this->search ?: null,
            'json_recibido' => $selectedJson
        ]);

        Debugbar::info('📄 SELECCIONADOS JSON:', $selectedJson);
        Debugbar::info('📄 RESULTADOS:', $resultado);

        $this->documentos = $resultado ?? [];
    }

    // Método MEJORADO para manejar selección/deselección sin re-renderizar inmediatamente
    public function toggleRecibido($nuEmi)
    {
        if (in_array($nuEmi, $this->json_recibido)) {
            $this->json_recibido = array_diff($this->json_recibido, [$nuEmi]);
        } else {
            $this->json_recibido[] = $nuEmi;
        }

        // Reindexar el array para evitar problemas con las claves
        $this->json_recibido = array_values($this->json_recibido);

        // Disparar evento para efectos visuales (opcional)
        $this->dispatch('seleccionActualizada');

        // NO re-buscar inmediatamente para evitar el parpadeo
        // $this->buscarDocumentos();
    }

    // Método MEJORADO para seleccionar/deseleccionar todos
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

        // Reindexar para evitar problemas
        $this->json_recibido = array_values($this->json_recibido);

        $this->dispatch('seleccionActualizada');
        // No re-buscar inmediatamente
    }

    public function limpiarSeleccion()
    {
        $this->json_recibido = [];
        // Aquí sí podemos re-buscar porque es una acción explícita del usuario
        $this->buscarDocumentos();
    }

    public function procesarSeleccionados()
    {
        if (empty($this->json_recibido)) {
            $this->dispatch('mostrarAlerta', [
                'tipo' => 'warning',
                'mensaje' => 'No hay documentos seleccionados'
            ]);
            return;
        }

        $documentosSeleccionados = $this->getSelectedRecibidosData();

        Debugbar::info('🔄 PROCESANDO:', $documentosSeleccionados);

        $this->dispatch('procesarDocumentos', [
            'documentos' => $this->json_recibido,
            'datos' => $documentosSeleccionados
        ]);

        $this->dispatch('mostrarAlerta', [
            'tipo' => 'success',
            'mensaje' => 'Se procesaron ' . count($this->json_recibido) . ' documentos'
        ]);
    }

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

    public function getSelectionStats()
    {
        $documentosVisibles = collect($this->documentos)->pluck('nu_emi')->toArray();

        return [
            'total_documentos' => count($this->documentos),
            'total_seleccionados' => count($this->json_recibido),
            'seleccionados_visibles' => count(array_intersect($this->json_recibido, $documentosVisibles)),
            'todos_visibles_seleccionados' => count($this->documentos) > 0 &&
                count(array_intersect($this->json_recibido, $documentosVisibles)) === count($this->documentos)
        ];
    }



    public function marcarMarcador($nu_emi)
    {
        $codigo_contribuyente = Session::get('codigo_contribuyente');
        $usuario = Contribuyente::obtenerDatosContri($codigo_contribuyente);

        $resultado = $this->service->accionMarcador([
            'nu_emi' => $nu_emi,
            'receptor_id' => $usuario->vcodcontr
        ]);

        Debugbar::info('📌 Resultado marcador:', $resultado);

        // Opcionalmente puedes actualizar la lista de documentos o marcar solo el documento afectado
        $this->buscarDocumentos(); // Para refrescar
    }




    public function render()
    {
        return view('livewire.recibido.recibido-component', [
            'documentos' => $this->documentos,
            'stats' => $this->getSelectionStats()
        ]);
    }
}
