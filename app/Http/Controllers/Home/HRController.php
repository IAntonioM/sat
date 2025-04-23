<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Contribuyente;
use App\Models\HR;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Barryvdh\Debugbar\Facades\Debugbar;

class HRController extends Controller
{
    public function index(Request $request)
    {
        //Fecha Actual
        $fechaActual = Carbon::now()->format('d/m/Y');
        //Año actual
        $year = date("Y");

        $codigo_contribuyente = Session::get('codigo_contribuyente');
        $usuario = Contribuyente::obtenerDatosContri($codigo_contribuyente);

        // Get user data from model
        $rw = HR::validarDatosCont(Session::get('codigo_contribuyente'));

        $contribuyente = HR::obtenerDatosContribuyente(Session::get('codigo_contribuyente'));
    //     if (!$rw) {
    //         return view('HR', [
    //             'fechaActual' => $fechaActual,
    //             'contribuyente' => $contribuyente,
    //             'usuario'=>$usuario,
    //         ]);
    //    }
        $vdirecc = isset($rw) && !empty($rw->dirfiscal) ? $rw->dirfiscal : '&nbsp;';
        $cidpers = $request->input('cidpers');

        if ($rw) {
            $vnombre = str_replace('Ñ', '&Ntilde;', $rw->nombre ?? '');
            $vnrdoc = $rw->num_doc ?? '';
        } else {
            $vnombre = '&nbsp;';
            $vnrdoc = '';
        }

        Session::put('vnrdoc', $vnrdoc);
        $cejerci = $request->input('cejerci');

        //Valdiar resumen
        $fecha = $request->input('fecha') ?? '';
        $resumenData = HR::getResumenData(Session::get('codigo_contribuyente'), $fecha, $cejerci);

        $totalg = 0;
        if ($resumenData) {
            $totalg = $resumenData->total;
        }

        $relacionPredios = HR::obtenerRelacionPredios(Session::get('codigo_contribuyente'),$year);
        $totales = HR::obtenerTotales(Session::get('codigo_contribuyente'),$year);
        Debugbar::info('relacionPredios', $relacionPredios);
        Debugbar::info('totales', $totales);

        return view('HR', [
            'fechaActual' => $fechaActual,
            'contribuyente' => $contribuyente,
            'relacionPredios'=> $relacionPredios,
            'usuario'=>$usuario,
            'totales'=> $totales,
            'userData' => $rw,
            'vdirecc' => $vdirecc,
            'vnombre' => $vnombre,
            'cidpers' => $cidpers,
            'vnrdoc' => $vnrdoc,
            'cejerci' => $cejerci,
            'totalg' => $totalg
        ]);
    }

}

