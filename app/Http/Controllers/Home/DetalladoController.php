<?php

namespace App\Http\Controllers\Home;

use App\Http\Requests\Opciones\DetalladoRequest;
use App\Models\Detallado;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\Debugbar\Facades\Debugbar;

class DetalladoController extends Controller
{
    /**
     * Muestra la vista de deudas detalladas
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Obtener el código del contribuyente de la sesión o del parámetro
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

        // Guardar el código en sesión para futuras consultas
        $request->session()->put('codigo_contribuyente', $codigoContribuyente);

        // Obtener datos del contribuyente
        $contribuyente = Detallado::obtenerDatosContribuyente($codigoContribuyente);

        if (!$contribuyente) {
            return redirect()->route('login')->with('error', 'No se encontró el contribuyente');
        }

        // Obtener el total de la deuda
        $totalDeuda = Detallado::obtenerTotalDeuda($codigoContribuyente);

        // Obtener los filtros
        $anioSeleccionado = $request->anio ?? '%';
        $tipoTributo = $request->tipo_tributo ?? '%';

        // Obtener las deudas detalladas
        $deudas = Detallado::obtenerDetalleDeudas($codigoContribuyente, $anioSeleccionado, $tipoTributo);

        // Preparar datos para la vista
        $deudas = collect($deudas)->groupBy('año');
        $aniosDisponibles = Detallado::obtenerAniosDisponibles($codigoContribuyente);
        $tiposTributo = Detallado::obtenerTiposTributo($codigoContribuyente);
        $fechaActual = Carbon::now()->format('d/m/Y');

        return view('detallado', compact(
            'contribuyente',
            'totalDeuda',
            'deudas',
            'aniosDisponibles',
            'tiposTributo',
            'anioSeleccionado',
            'tipoTributo',
            'fechaActual'
        ));
    }

    /**
     * Filtra las deudas por año y tipo de tributo
     *
     * @param DetalladoRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function filtrar(DetalladoRequest $request)
    {
        try {
            Debugbar::info('Filtro recibido', $request->all());

            $codigoContribuyente = $request->session()->get('codigo_contribuyente');
            $anioSeleccionado = $request->anio ?? '%';
            $tipoTributo = $request->tipo_tributo ?? '%';

            Debugbar::info('Parámetros de filtrado', [
                'codigoContribuyente' => $codigoContribuyente,
                'anio' => $anioSeleccionado,
                'tipoTributo' => $tipoTributo
            ]);

            if (!$codigoContribuyente) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No se encontró el código de contribuyente en la sesión'
                ], 400);
            }

            // Obtener las deudas detalladas
            $deudas = Detallado::obtenerDetalleDeudas($codigoContribuyente, $anioSeleccionado, $tipoTributo);

            // Verificar si hay una propiedad 'año' en los registros
            // El nombre de la propiedad podría variar según la codificación
            $keyAnio = 'año';
            if (!empty($deudas) && !isset($deudas[0]->$keyAnio)) {
                // Buscamos la clave correcta para agrupar
                $firstRecord = (array)$deudas[0];
                $possibleKeys = ['año', 'ano', 'anio', 'year'];

                foreach ($possibleKeys as $key) {
                    if (array_key_exists($key, $firstRecord)) {
                        $keyAnio = $key;
                        break;
                    }
                }

                Debugbar::info('Clave de agrupación encontrada', ['keyAnio' => $keyAnio]);
            }

            // Agrupar por la clave identificada
            $deudas = collect($deudas)->groupBy($keyAnio);

            Debugbar::info('Deudas encontradas', ['cantidad' => count($deudas)]);

            return response()->json([
                'status' => 'success',
                'deudas' => $deudas,
            ]);
        } catch (\Exception $e) {
            Debugbar::error('Error al filtrar deudas', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Error al filtrar las deudas: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Prepara los datos para el pago de deudas seleccionadas
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function prepararPago(Request $request)
    {
        $idRecibos = $request->id_recibos;

        if (!$idRecibos || !is_array($idRecibos) || count($idRecibos) == 0) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Debe seleccionar al menos una deuda para pagar'
                ]);
            }
            return back()->with('error', 'Debe seleccionar al menos una deuda para pagar');
        }

        // Almacenar los ID de recibos seleccionados en la sesión
        $request->session()->put('recibos_seleccionados', $idRecibos);

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'redirect' => route('deudas.pago')
            ]);
        }

        return redirect()->route('deudas.pago');
    }

    /**
     * Muestra la vista de impresión de deudas
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function imprimir(Request $request)
    {
        $codigoContribuyente = $request->session()->get('codigo_contribuyente');
        $contribuyente = Detallado::obtenerDatosContribuyente($codigoContribuyente);
        $totalDeuda = Detallado::obtenerTotalDeuda($codigoContribuyente);

        $anioSeleccionado = $request->anio ?? '%';
        $tipoTributo = $request->tipo_tributo ?? '%';

        $deudas = Detallado::obtenerDetalleDeudas($codigoContribuyente, $anioSeleccionado, $tipoTributo);
        $deudas = collect($deudas)->groupBy('año');

        $fechaActual = Carbon::now()->format('d/m/Y');

        return view('deudas.imprimir', compact(
            'contribuyente',
            'totalDeuda',
            'deudas',
            'fechaActual'
        ));
    }
}
