<?php

namespace App\Http\Controllers\Home;

use App\Http\Requests\Opciones\DeudaConsolidadaRequest;
use App\Models\DeudaConsolidada;
use App\Models\Contribuyente;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\Session;

class DeudaConsolidadaController extends Controller
{
    /**
     * Mostrar la vista de deudas consolidadas
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Obtener el código del contribuyente de la sesión o del parámetro
        $codigoContribuyente = session('codigo_contribuyente') ??
        session('cod_usuario') ?? null; // Valor por defecto para pruebas

        $usuario = Contribuyente::obtenerDatosContri($codigoContribuyente);

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

        // Guardar el código en sesión para futuras consultas
        $request->session()->put('codigo_contribuyente', $codigoContribuyente);

        // Obtener datos del contribuyente
        $contribuyente = DeudaConsolidada::obtenerDatosContribuyente($codigoContribuyente);

        if (!$contribuyente) {
            return redirect()->route('login')->with('error', 'No se encontró el contribuyente');
        }

        // Obtener el total de la deuda
        $totalDeuda = DeudaConsolidada::obtenerTotalDeuda($codigoContribuyente);

        // Obtener los filtros
        $anioSeleccionado = $request->anio ?? '%';
        $tipoTributo = $request->tipo_tributo ?? '%';

        // Obtener las deudas detalladas
        $deudas = DeudaConsolidada::obtenerDeudasDetalladas($codigoContribuyente, $anioSeleccionado, $tipoTributo);

        // Preparar datos para la vista
        $deudas = collect($deudas)->groupBy('año');
        $aniosDisponibles = DeudaConsolidada::obtenerAniosDisponibles($codigoContribuyente);
        $tiposTributo = DeudaConsolidada::obtenerTiposTributo($codigoContribuyente);
        $fechaActual = Carbon::now()->format('d/m/Y');

        Debugbar::info($contribuyente);

        return view('consolidado', compact(
            'contribuyente',
            'totalDeuda',
            'deudas',
            'aniosDisponibles',
            'tiposTributo',
            'anioSeleccionado',
            'tipoTributo',
            'fechaActual',
            'usuario'
        ));
    }

    /**
     * Filtra las deudas por año y tipo de tributo
     *
     * @param DeudaConsolidadaRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function pagar(DeudaConsolidadaRequest $request)
    {
        $codigoConsolidado = $request->tipo_tributo;
        $tipoConsolidado = $request->tipo_tributo;
        $anoConsolidado = $request->tipo_tributo;
        DeudaConsolidada::pagarConsolidado($codigoConsolidado, $tipoConsolidado, $anoConsolidado);
        return view('consolidado');
    }
}
