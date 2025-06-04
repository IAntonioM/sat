<?php

namespace App\Livewire\Consolidado;

use App\Models\DeudaConsolidada;
use App\Models\Contribuyente;
use Livewire\Component;
use Carbon\Carbon;
use Barryvdh\Debugbar\Facades\Debugbar;

class ConsolidadoComponent extends Component
{
    // Propiedades públicas para los filtros
    public $anioSeleccionado = '%';
    public $tipoTributo = '%';

    // Propiedades para los datos
    public $contribuyente;
    public $totalDeuda;
    public $deudas;
    public $aniosDisponibles;
    public $tiposTributo;
    public $fechaActual;
    public $usuario;
    public $codigoContribuyente;

    // Propiedades para el pago
    public $itemsSeleccionados = [];
    public $totalSeleccionado = 0;
    public $selectAll = false;

    public function mount()
    {
        $this->inicializarDatos();
        $this->cargarDatos();
    }

    /**
     * Inicializar datos básicos del componente
     */
    private function inicializarDatos()
    {
        // Obtener el código del contribuyente de la sesión
        $this->codigoContribuyente = session('codigo_contribuyente') ??
            session('cod_usuario') ?? null;

        if (!$this->codigoContribuyente) {
            // Redirigir al login si no hay código de contribuyente
            return redirect()->route('login')->with([
                'alert' => [
                    'type' => 'error',
                    'title' => 'Sesión inválida',
                    'message' => 'No se encontró el código de contribuyente en la sesión'
                ]
            ]);
        }

        // Guardar el código en sesión
        session(['codigo_contribuyente' => $this->codigoContribuyente]);

        // Fecha actual
        $this->fechaActual = Carbon::now()->format('d/m/Y');
    }

    /**
     * Cargar todos los datos necesarios
     */
    private function cargarDatos()
    {
        try {
            // Obtener datos del contribuyente
            $this->contribuyente = DeudaConsolidada::obtenerDatosContribuyente($this->codigoContribuyente);
            $this->usuario = Contribuyente::obtenerDatosContri($this->codigoContribuyente);

            if (!$this->contribuyente) {
                session()->flash('error', 'No se encontró el contribuyente');
                return;
            }

            // Obtener el total de la deuda
            $this->totalDeuda = DeudaConsolidada::obtenerTotalDeuda($this->codigoContribuyente);

            // Obtener las deudas detalladas
            $deudas = DeudaConsolidada::obtenerDeudasDetalladas(
                $this->codigoContribuyente,
                $this->anioSeleccionado,
                $this->tipoTributo
            );

            // Agrupar deudas por año
            $this->deudas = collect($deudas)->groupBy('año');

            // Obtener datos para los filtros
            $this->aniosDisponibles = DeudaConsolidada::obtenerAniosDisponibles($this->codigoContribuyente);
            $this->tiposTributo = DeudaConsolidada::obtenerTiposTributo($this->codigoContribuyente);

            // Debug information
            Debugbar::info('contribuyente', $this->contribuyente);
            Debugbar::info('totalDeuda', $this->totalDeuda);
            Debugbar::info('deudas', $this->deudas);
            Debugbar::info('aniosDisponibles', $this->aniosDisponibles);
            Debugbar::info('tiposTributo', $this->tiposTributo);
        } catch (\Exception $e) {
            session()->flash('error', 'Error al cargar los datos: ' . $e->getMessage());
            Debugbar::error('Error en cargarDatos', $e);
        }
    }

    /**
     * Filtrar deudas cuando cambian los selectores
     */
    public function filtrar()
    {
        $this->cargarDatos();

        // Limpiar selección al filtrar (opcional, comentar si quieres mantener la selección)
        // $this->itemsSeleccionados = [];
        // $this->selectAll = false;

        $this->calcularTotalSeleccionado();

        session()->flash('message', 'Filtros aplicados correctamente');
    }

    /**
     * Método que se ejecuta cuando cambia el año seleccionado
     */
    public function updatedAnioSeleccionado()
    {
        $this->filtrar();
    }

    /**
     * Método que se ejecuta cuando cambia el tipo de tributo
     */
    public function updatedTipoTributo()
    {
        $this->filtrar();
    }

    /**
     * Método que se ejecuta cuando cambia la selección de items
     */
    public function updatedItemsSeleccionados()
    {
        $this->calcularTotalSeleccionado();

        // Generar array con códigos cada vez que se marque/desmarque un check
        $itemsActivos = array_filter($this->itemsSeleccionados);

        // Preparar datos detallados de los items seleccionados
        $detallesSeleccionados = [];
        foreach ($itemsActivos as $item) {
            if ($item) {
                $parts = explode('|', $item);
                if (count($parts) === 3) {
                    $detallesSeleccionados[] = [
                        'codigo_contribuyente' => $parts[0],
                        'tipo' => $parts[1],
                        'anio' => $parts[2],
                        'valor_completo' => $item
                    ];
                }
            }
        }

        // **NUEVA LÍNEA: Guardar en sesión el array actualizado**
        session(['items_seleccionados_consolidado' => $itemsActivos]);

        // Debug cuando se selecciona/deselecciona un item
        Debugbar::info('Items seleccionados actualizados', $itemsActivos);
        Debugbar::info('Array guardado en sesión', session('items_seleccionados_consolidado'));
        Debugbar::info('Cantidad de items seleccionados', count($itemsActivos));
        Debugbar::info('Detalles de items seleccionados', $detallesSeleccionados);

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
            $this->itemsSeleccionados = [];
            foreach ($this->deudas as $deudasAnio) {
                foreach ($deudasAnio as $deuda) {
                    $this->itemsSeleccionados[] = "{$this->codigoContribuyente}|{$deuda->tipo}|{$deuda->año}";
                }
            }
            Debugbar::info('Seleccionados TODOS los items', $this->itemsSeleccionados);
        } else {
            $this->itemsSeleccionados = [];
            Debugbar::info('Deseleccionados TODOS los items');
        }

        // **NUEVA LÍNEA: Actualizar sesión también aquí**
        session(['items_seleccionados_consolidado' => array_filter($this->itemsSeleccionados)]);

        $this->calcularTotalSeleccionado();
    }

    /**
     * Calcular el total de los items seleccionados
     */
    private function calcularTotalSeleccionado()
    {
        $this->totalSeleccionado = 0;
        $detalleCalculos = [];

        foreach ($this->itemsSeleccionados as $item) {
            if ($item) {
                // Obtener el total del item basado en los datos cargados
                $parts = explode('|', $item);
                if (count($parts) === 3) {
                    $tipo = $parts[1];
                    $anio = $parts[2];

                    // Buscar el total en las deudas cargadas
                    foreach ($this->deudas as $deudasAnio) {
                        foreach ($deudasAnio as $deuda) {
                            if ($deuda->tipo === $tipo && $deuda->año == $anio) {
                                $this->totalSeleccionado += $deuda->total;
                                $detalleCalculos[] = [
                                    'tipo' => $tipo,
                                    'anio' => $anio,
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

        // Debug del cálculo
        Debugbar::info('Detalle de cálculo total seleccionado', $detalleCalculos);
        Debugbar::info('Total seleccionado calculado', $this->totalSeleccionado);
    }

    /**
     * Seleccionar o deseleccionar todos los items (método auxiliar)
     */
    public function toggleSelectAll($selectAll)
    {
        $this->selectAll = $selectAll;
        $this->updatedSelectAll();
    }

    /**
     * Procesar el pago de las deudas seleccionadas
     */
    public function pagar()
    {
        if (empty($this->itemsSeleccionados)) {
            session()->flash('error', 'Debe seleccionar al menos una deuda para pagar');
            return;
        }

        try {
            $results = [];

            foreach ($this->itemsSeleccionados as $item) {
                if ($item) {
                    $parts = explode('|', $item);
                    if (count($parts) === 3) {
                        $codigoContribuyente = $parts[0];
                        $tipoConsolidado = $parts[1];
                        $anoConsolidado = $parts[2];

                        // Llamar al método para pagar
                        $result = DeudaConsolidada::pagarConsolidado(
                            $codigoContribuyente,
                            $tipoConsolidado,
                            $anoConsolidado
                        );

                        $results[] = [
                            'codigo' => $codigoContribuyente,
                            'tipo' => $tipoConsolidado,
                            'ano' => $anoConsolidado,
                            'result' => $result
                        ];
                    }
                }
            }

            // Recargar datos después del pago
            $this->cargarDatos();
            $this->itemsSeleccionados = [];
            $this->totalSeleccionado = 0;

            session()->flash('success', 'Pagos procesados correctamente');

            // Log de resultados para debug
            Debugbar::info('Resultados del pago', $results);
        } catch (\Exception $e) {
            session()->flash('error', 'Error al procesar el pago: ' . $e->getMessage());
            Debugbar::error('Error en pagar', $e);
        }
    }

    /**
     * Generar la URL para el reporte
     */
    public function getReporteUrlProperty()
    {
        $itemsSeleccionados = implode(',', array_filter($this->itemsSeleccionados));

        return route('reporte', [
            'tipo' => 'reporteConsolidado',
            'codigo_contribuyente' => $this->codigoContribuyente,
            'anio' => $this->anioSeleccionado,
            'tipo_tributo' => $this->tipoTributo,
            'items_seleccionados' => $itemsSeleccionados
        ]);
    }

    /**
     * Render del componente
     */
    public function render()
    {
        return view('livewire.consolidado.consolidado-component');
    }
}
