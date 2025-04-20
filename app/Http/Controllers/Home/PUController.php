<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\PUModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Barryvdh\Debugbar\Facades\Debugbar;

class PUController extends Controller
{
    public function index(Request $request)
    {
        // Get current date formatted as dd/mm/yyyy
        $fechaActual = Carbon::now()->format('d/m/Y');
        $year = date("Y");

        $usuario = Session::get('usuario');
        // Get user data from model
        $rw = PUModel::getUserData(Session::get('codigo_contribuyente'));

        if (!$rw) {
            return redirect()->route('login')->with('error', 'No se encontraron datos de usuario');
        }

        $vdirecc = strlen($rw->dirfiscal) == 0 ? '&nbsp;' : $rw->dirfiscal;
        $vnombre = str_replace('Ñ', '&Ntilde;', $rw->nombre);
        $cidpers = $request->input('cidpers');
        $vnrdoc = $rw->num_doc;
        Session::put('vnrdoc', $vnrdoc);
        $cejerci = $request->input('cejerci');

        // Get count from model
        $contribuyente = PUModel::obtenerDatosContribuyente(Session::get('codigo_contribuyente'));

        return view('PU', [
            'fechaActual' => $fechaActual,
            'contribuyente' => $contribuyente,
            'usuario'=>$usuario,
            'userData' => $rw,
            'vdirecc' => $vdirecc,
            'vnombre' => $vnombre,
            'cidpers' => $cidpers,
            'vnrdoc' => $vnrdoc,
            'cejerci' => $cejerci,
        ]);
    }

    public function detallePredio(Request $request)
    {
        $xid_anexo = $request->input('xid_anexo');
        $year = $request->input('year');

        // Fetch property details using the model
        $propertyDetails = PUModel::getPredioDatos(Session::get('codigo_contribuyente'), $year, $xid_anexo);

        return view('PU', [
            'propertyDetails' => $propertyDetails
        ]);
    }
}

