<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Contribuyente;
use App\Models\PagosModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PagoController extends Controller
{
    public function index(Request $request)
    {
        $codigo_contribuyente = Session::get('codigo_contribuyente');
        $usuario = Contribuyente::obtenerDatosContri($codigo_contribuyente);

        $fechaActual = Carbon::now()->format('d/m/Y');

        // Get filter parameters with defaults
        $vcodcontr = $codigo_contribuyente;
        $anio = $request->anio ?? '%'; // Default to all years if not specified
        $tipotributo = $request->tipotributo ?? '%'; // Default to all tributes if not specified

        // Pass parameters to model
        $pagos = PagosModel::getPagos($vcodcontr, $anio, $tipotributo);

        $aniosDisponibles = PagosModel::obtenerAniosDisponibles($vcodcontr);
        $tiposTributo = PagosModel::obtenerTiposTributosDisponibles($vcodcontr);
        $totalPagado = PagosModel::obtenerTotalPagado($vcodcontr);

        // Extract the total value from the query result
        $totalPagadoValue = 0;
        if (is_array($totalPagado) && !empty($totalPagado) && isset($totalPagado[0]->totalPagado)) {
            $totalPagadoValue = $totalPagado[0]->totalPagado;
        }

        $viewData = [
            'fechaActual' => $fechaActual,
            'usuario' => $usuario,
            'pagos' => $pagos,
            'aniosDisponibles' => $aniosDisponibles,
            'tiposTributo' => $tiposTributo,
            'totalPagado' => $totalPagadoValue,
            'anioSeleccionado' => $anio,
            'tipoTributo' => $tipotributo
        ];

        return view('pagos', $viewData);
    }
}
