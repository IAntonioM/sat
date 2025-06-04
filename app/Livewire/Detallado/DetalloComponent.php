<?php

namespace App\Livewire\Detallado;

use App\Models\Detallado;
use App\Models\Contribuyente;
use Livewire\Component;
use Carbon\Carbon;
use Barryvdh\Debugbar\Facades\Debugbar;

class DetalloComponent extends Component
{
    public $codigoContribuyente;
    public $contribuyente;
    public $usuario;
    public $totalDeuda;
    public $deudas;
    public $aniosDisponibles;
    public $tiposTributo;
    public $fechaActual;

    // Filtros
    public $anioSeleccionado = '%';
    public $tipoTributo = '%';

    // Recibos seleccionados para pago
    public $recibosSeleccionados = [];
    public $totalSeleccionado = 0;
    public $selectAll = false;

    public function mount()
    {
        $this->codigoContribuyente = session('codigo_contribuyente') ?? session('cod_usuario');

        if (!$this->codigoContribuyente) {
            return redirect()->route('login')->with([
                'alert' => [
                    'type' => 'error',
                    'title' => 'Sesión inválida',
                    'message' => 'No se encontró el código de contribuyente en la sesión'
                ]
            ]);
        }

        session(['codigo_contribuyente' => $this->codigoContribuyente]);

        $this->usuario = Contribuyente::obtenerDatosContri($this->codigoContribuyente);
        $this->contribuyente = Detallado::obtenerDatosContribuyente($this->codigoContribuyente);

        if (!$this->contribuyente) {
            return redirect()->route('login')->with('error', 'No se encontró el contribuyente');
        }

        $this->cargarDatos();
    }

    public function cargarDatos()
    {
        $this->totalDeuda = Detallado::obtenerTotalDeuda($this->codigoContribuyente);
        $this->aniosDisponibles = Detallado::obtenerAniosDisponibles($this->codigoContribuyente);
        $this->tiposTributo = Detallado::obtenerTiposTributo($this->codigoContribuyente);
        $this->fechaActual = Carbon::now()->format('d/m/Y');

        $this->filtrarDeudas();
    }

    /**
     * Método que se ejecuta cuando cambia la selección de recibos
     */
    public function updatedRecibosSeleccionados()
    {
        $this->calcularTotalSeleccionado();

        // Filtrar solo los items activos (marcados)
        $itemsActivos = array_filter($this->recibosSeleccionados, function ($item) {
            return !empty($item);
        });

        // Guardar en sesión el array actualizado
        session(['recibos_seleccionados_detallado' => $itemsActivos]);

        // Debug cuando se selecciona/deselecciona un item
        Debugbar::info('Recibos seleccionados actualizados', $itemsActivos);
        Debugbar::info('Array guardado en sesión', session('recibos_seleccionados_detallado'));
        Debugbar::info('Cantidad de recibos seleccionados', count($itemsActivos));

        // Verificar si todos están seleccionados para el checkbox "select all"
        $totalItems = 0;
        foreach ($this->deudas as $deudasAnio) {
            $totalItems += count($deudasAnio);
        }

        $this->selectAll = count($itemsActivos) === $totalItems;
    }

    /**
     * Método para manejar el checkbox "Seleccionar Todo"
     */
    public function updatedSelectAll()
    {
        if ($this->selectAll) {
            $this->recibosSeleccionados = [];
            foreach ($this->deudas as $deudasAnio) {
                foreach ($deudasAnio as $deuda) {
                    // CORREGIR: Usar el formato correcto con tipo incluido
                    $this->recibosSeleccionados[] = "{$this->codigoContribuyente}|{$deuda->tipo}|{$deuda->ano}-{$deuda->periodo}";
                }
            }
            Debugbar::info('Seleccionados TODOS los recibos', $this->recibosSeleccionados);
        } else {
            $this->recibosSeleccionados = [];
            Debugbar::info('Deseleccionados TODOS los recibos');
        }

        session(['recibos_seleccionados_detallado' => array_filter($this->recibosSeleccionados)]);
        $this->calcularTotalSeleccionado();
    }

    /**
     * Calcular el total de los recibos seleccionados
     */
    private function calcularTotalSeleccionado()
    {
        $this->totalSeleccionado = 0;
        $detalleCalculos = [];

        foreach ($this->recibosSeleccionados as $item) {
            if ($item) {
                // Verificar si es formato consolidado o idrecibo
                if (strpos($item, '|') !== false) {
                    // Formato consolidado: codigo|tipo|periodo
                    $parts = explode('|', $item);
                    if (count($parts) === 3) {
                        $codigo = $parts[0];  // Agregar esta línea
                        $tipo = $parts[1];
                        $periodo = $parts[2];

                        // Buscar el total en las deudas cargadas
                        foreach ($this->deudas as $deudasAnio) {
                            foreach ($deudasAnio as $deuda) {
                                $deudaPeriodo = $deuda->ano . '-' . $deuda->periodo;
                                // CORREGIR: Comparar también el código del contribuyente si es necesario
                                if ($deuda->tipo === $tipo && $deudaPeriodo === $periodo) {
                                    $this->totalSeleccionado += $deuda->total;
                                    $detalleCalculos[] = [
                                        'codigo' => $codigo,
                                        'tipo' => $tipo,
                                        'periodo' => $periodo,
                                        'total' => $deuda->total,
                                        'mtipo' => $deuda->mtipo ?? 'N/A'
                                    ];
                                    break 2;
                                }
                            }
                        }
                    }
                } else {
                    // Formato original: idrecibo
                    foreach ($this->deudas as $deudasAnio) {
                        foreach ($deudasAnio as $deuda) {
                            if ($deuda->idrecibo == $item) {
                                $this->totalSeleccionado += $deuda->total;
                                $detalleCalculos[] = [
                                    'idrecibo' => $item,
                                    'total' => $deuda->total,
                                    'mtipo' => $deuda->mtipo ?? 'N/A'
                                ];
                                break 2;
                            }
                        }
                    }
                }
            }
        }

        Debugbar::info('Detalle de cálculo total seleccionado', $detalleCalculos);
        Debugbar::info('Total seleccionado calculado', $this->totalSeleccionado);
    }

    public function filtrarDeudas()
    {
        try {
            Debugbar::info('Filtro aplicado', [
                'anio' => $this->anioSeleccionado,
                'tipoTributo' => $this->tipoTributo
            ]);

            $deudas = Detallado::obtenerDetalleDeudas(
                $this->codigoContribuyente,
                $this->anioSeleccionado,
                $this->tipoTributo
            );

            // Determinar la clave correcta para agrupar
            $keyAnio = 'año';
            if (!empty($deudas) && !isset($deudas[0]->$keyAnio)) {
                $firstRecord = (array)$deudas[0];
                $possibleKeys = ['año', 'ano', 'anio', 'year'];

                foreach ($possibleKeys as $key) {
                    if (array_key_exists($key, $firstRecord)) {
                        $keyAnio = $key;
                        break;
                    }
                }
            }

            $this->deudas = collect($deudas)->groupBy($keyAnio);
        } catch (\Exception $e) {
            Debugbar::error('Error al filtrar deudas', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            session()->flash('error', 'Error al filtrar las deudas: ' . $e->getMessage());
        }
    }

    public function updatedAnioSeleccionado()
    {
        $this->filtrarDeudas();
    }

    public function updatedTipoTributo()
    {
        $this->filtrarDeudas();
    }

    public function prepararPago()
    {
        if (empty($this->recibosSeleccionados)) {
            session()->flash('error', 'Debe seleccionar al menos una deuda para pagar');
            return;
        }

        session(['recibos_seleccionados' => $this->recibosSeleccionados]);
        return redirect()->route('deudas.pago');
    }

    /**
     * Generar la URL para el reporte - NUEVO MÉTODO
     */
    public function getReporteUrlProperty()
    {
        $recibosSeleccionados = implode(',', array_filter($this->recibosSeleccionados));

        return route('reporte', [
            'tipo' => 'reporteDetallado',
            'codigo_contribuyente' => $this->codigoContribuyente,
            'anio' => $this->anioSeleccionado,
            'tipo_tributo' => $this->tipoTributo,
            'items_seleccionados' => $recibosSeleccionados  // Cambiar de 'recibos_seleccionados' a 'items_seleccionados'
        ]);
    }

    public function render()
    {
        return view('livewire.detallado.detallo-component')
            ->extends('layouts.cabecera')
            ->section('content');
    }
}
