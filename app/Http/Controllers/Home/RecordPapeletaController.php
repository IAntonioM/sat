<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Contribuyente;
use App\Models\RecordPapeleta;
use Barryvdh\Debugbar\Facades\Debugbar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RecordPapeletaController extends Controller
{
    public function index(Request $request)
    {
        $codigo_contribuyente = Session::get('codigo_contribuyente');
        $fechaActual = Carbon::now()->format('d/m/Y');
        $year = date("Y");

        $usuario = Contribuyente::obtenerDatosContri($codigo_contribuyente);
        $cejerci = $request->input('cejerci');

        $fecha = $request->input('fecha') ?? '';
        $termBusq = $request->input('termBusq') ?? null;

        $resumenData = RecordPapeleta::listarPapeletas($codigo_contribuyente, $termBusq);
        $totales = RecordPapeleta::totalPagar($codigo_contribuyente); // aquí suponemos que devuelve solo total_pagar
        $totales = $totales[0]->total_pagar;
        // Calcular totalDeuda, totalDescuento y total
        $totalDeuda = 0;
        $totalDescuento = 0;
        foreach ($resumenData as $item) {
            if ($item->estado != 0) {
                $totalDeuda += (float) $item->deuda;
                $totalDescuento += (float) $item->deuda_dscto;
            }
        }

        $total = $totalDeuda - $totalDescuento; // Si "total" significa el valor sin descuento



        return view('record', compact('usuario', 'resumenData', 'totales', 'totalDeuda', 'totalDescuento', 'total','fechaActual','termBusq'));
    }

}
