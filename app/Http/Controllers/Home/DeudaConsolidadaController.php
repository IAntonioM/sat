<?php

namespace App\Http\Controllers\Home;

use App\Http\Requests\Opciones\DeudaConsolidadaRequest;
use App\Models\DeudaConsolidada;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DeudaConsolidadaController extends Controller
{
    /**
     * Constructor
     */

    /**
     * Mostrar la vista de deudas consolidadas
     *
     * @param DeudaConsolidadaRequest $request
     * @return \Illuminate\View\View
     */
    public function index(DeudaConsolidadaRequest $request)
    {
        // Obtener el código del contribuyente (puede venir de sesión, auth, etc.)
        $codigoContribuyente = session('codigo_contribuyente') ??
        session('cod_usuario') ?? null; // Valor por defecto para pruebas

        if (!$codigoContribuyente) {
            // Si no hay código de contribuyente, redirigir al login
            return redirect()->route('login')->with([
                'alert' => [
                    'type' => 'error',
                    'title' => 'Sesión inválida',
                    'message' => 'No se encontró el código de contribuyente en la sesión'
                ]
            ]);
        }

        // Obtener los filtros de la solicitud
        $anio = $request->input('anio', '%');
        $tipoTributo = $request->input('tipo_tributo', '%');

        // Adaptar el tipo de tributo al formato esperado por el procedimiento
        if ($tipoTributo == 'predial') {
            $tipoTributo = '02.01';
        } elseif ($tipoTributo == 'arbitrios') {
            $tipoTributo = '11';
        }

        // Obtener datos del contribuyente
        $contribuyente = DeudaConsolidada::obtenerDatosContribuyente($codigoContribuyente);

        // Obtener la deuda total actual
        $deudaTotal = DeudaConsolidada::obtenerDeudaTotal($codigoContribuyente);

        // Obtener el detalle de las deudas
        $detalleDeudas = DeudaConsolidada::obtenerDetalleDeudas($codigoContribuyente, $anio, $tipoTributo);

        // Obtener los años disponibles para el filtro
        $aniosDisponibles = DeudaConsolidada::obtenerAniosDisponibles($codigoContribuyente);

        // Agrupar las deudas por año para la visualización
        $deudasAgrupadas = collect($detalleDeudas)->groupBy('año');

        // Calcular totales por año
        $totalesPorAnio = [];
        foreach ($deudasAgrupadas as $año => $deudas) {
            $totalesPorAnio[$año] = [
                'imp_insol' => $deudas->sum('imp_insol'),
                'imp_reaj' => $deudas->sum('imp_reaj'),
                'mora' => $deudas->sum('mora'),
                'costo_emis' => $deudas->sum('costo_emis'),
                'total' => $deudas->sum('total')
            ];
        }

        return view('consolidado', compact(
            'contribuyente',
            'deudaTotal',
            'deudasAgrupadas',
            'totalesPorAnio',
            'aniosDisponibles',
            'anio',
            'tipoTributo'
        ));
    }

    /**
     * Preparar para el pago de las deudas seleccionadas
     *
     * @param DeudaConsolidadaRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function prepararPago(DeudaConsolidadaRequest $request)
    {
        $recibosSeleccionados = $request->input('recibos_seleccionados', []);

        if (empty($recibosSeleccionados)) {
            return redirect()->back()->with('error', 'No se han seleccionado deudas para pagar.');
        }

        // Guardar los IDs de los recibos seleccionados en la sesión para usarlos en el proceso de pago
        Session::put('recibos_seleccionados', $recibosSeleccionados);

        return redirect()->route('pagos.crear');
    }

    /**
     * Generar reporte de deudas consolidadas para imprimir
     *
     * @param DeudaConsolidadaRequest $request
     * @return \Illuminate\Http\Response
     */
    public function imprimirDeudas(DeudaConsolidadaRequest $request)
    {
        // Obtener el código del contribuyente
        $codigoContribuyente = session('codigo_contribuyente') ?? '0000001';

        // Obtener los filtros de la solicitud
        $anio = $request->input('anio', '%');
        $tipoTributo = $request->input('tipo_tributo', '%');

        // Adaptar el tipo de tributo al formato esperado por el procedimiento
        if ($tipoTributo == 'predial') {
            $tipoTributo = '02.01';
        } elseif ($tipoTributo == 'arbitrios') {
            $tipoTributo = '11';
        }

        // Obtener datos del contribuyente
        $contribuyente = DeudaConsolidada::obtenerDatosContribuyente($codigoContribuyente);

        // Obtener el detalle de las deudas
        $detalleDeudas = DeudaConsolidada::obtenerDetalleDeudas($codigoContribuyente, $anio, $tipoTributo);

        // Aquí implementarías la lógica para generar un PDF o una vista para imprimir
        // Por ejemplo, usando una librería como Dompdf

        // Para este ejemplo, solo devolvemos una vista específica para impresión
        return view('deudas.imprimir', compact('contribuyente', 'detalleDeudas'));
    }
}
