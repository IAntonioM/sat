<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\HR;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Barryvdh\Debugbar\Facades\Debugbar;

class HRController extends Controller
{
    // public function index(Request $request)
    // {
    //     // Obtener el código del contribuyente de la sesión o del parámetro
    //     $codigoContribuyente = session('codigo_contribuyente') ??
    //     session('cod_usuario') ?? null; // Valor por defecto para pruebas

    //     $usuario =  Session::get('usuario');

    //     return view('HR', compact(
    //         'usuario'
    //     ));
    // }
    public function index(Request $request)
    {
        // Get current date formatted as dd/mm/yyyy
        $fechaActual = Carbon::now()->format('d/m/Y');
        $year = date("Y");

        $usuario = Session::get('usuario');
        // Get user data from model
        $rw = HR::getUserData(Session::get('codigo_contribuyente'));

        if (!$rw) {
            return redirect()->route('login')->with('error', 'No se encontraron datos de usuario');
        }

        $vdirecc = strlen($rw->dirfiscal) == 0 ? '&nbsp;' : $rw->dirfiscal;
        $vnombre = str_replace('Ñ', '&Ntilde;', $rw->nombre);
        $cidpers = $request->input('cidpers');
        $vnrdoc = $rw->num_doc;
        Session::put('vnrdoc', $vnrdoc);
        $cejerci = $request->input('cejerci');

        // Get summary from model
        $fecha = $request->input('fecha') ?? '';
        $resumenData = HR::getResumenData(Session::get('codigo_contribuyente'), $fecha, $cejerci);

        $totalg = 0;
        if ($resumenData) {
            $totalg = $resumenData->total;
        }

        // Initialize variables
        $timpins = 0;
        $tcosemi = 0;
        $ttotals = 0;
        $timprea = 0;
        $timpmor = 0;

        // Get property details from model
        $propertyData = HR::getPropertyData(Session::get('codigo_contribuyente'), $year);
        // Get count from model
        $contribuyente = HR::obtenerDatosContribuyente(Session::get('codigo_contribuyente'));
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
            'totalg' => $totalg,
            'propertyData' => $propertyData
        ]);
    }

    public function detallePredio(Request $request)
    {
        $xid_anexo = $request->input('xid_anexo');

        // Fetch property details using the model
        $propertyDetails = HR::getPropertyDetails(Session::get('codigo_contribuyente'), $xid_anexo);

        return view('HR', [
            'propertyDetails' => $propertyDetails
        ]);
    }
}

