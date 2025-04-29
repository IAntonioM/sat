<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Contribuyente;
use App\Models\PagosModel;
use Barryvdh\Debugbar\Facades\Debugbar;
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

        $vcodcontr = $request->vcodcontr;
        $anio = $request->anio;
        $tipotributo = $request->tipotributo;

        $pagos = PagosModel::getPagos($vcodcontr, $anio, $tipotributo);

        $aniosDisponibles = PagosModel::obtenerAniosDisponibles($vcodcontr);

        $tiposTributo = PagosModel::obtenerTiposTributosDisponibles($vcodcontr);

        $totalPagado = PagosModel::obtenerTotalPagado($vcodcontr);

        $viewData = [
            'fechaActual' => $fechaActual,
            'usuario' => $usuario,
            'pagos' => $pagos,
            'anio_Disponibles' => $aniosDisponibles,
            'tipos_Tributos_Disponibles' => $tiposTributo,
            'totalPagado' => $totalPagado
        ];

        return view('pagos',$viewData);
    }

}
