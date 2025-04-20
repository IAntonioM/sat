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
        $year = '2020';

        $usuario = Session::get('usuario');
        $codigo_contribuyente = trim(Session::get('codigo_contribuyente'));

        // Get user data from model
        $rw = PUModel::getUserData($codigo_contribuyente);

        if (!$rw) {
            return redirect()->route('login')->with('error', 'No se encontraron datos de usuario');
        }

        $vdirecc = strlen($rw->dirfiscal ?? '') == 0 ? '&nbsp;' : $rw->dirfiscal;
        $vnombre = str_replace('Ñ', '&Ntilde;', $rw->nombre ?? '');
        $cidpers = $request->input('cidpers');
        $vnrdoc = $rw->num_doc ?? '';
        Session::put('vnrdoc', $vnrdoc);

        // Get the property ID from the request
        $xid_anexo = $request->input('xid_anexo');

        // Data to send to the view
        $viewData = [
            'fechaActual' => $fechaActual,
            'usuario' => $usuario,
            'userData' => $rw,
            'vdirecc' => $vdirecc,
            'vnombre' => $vnombre,
            'cidpers' => $cidpers,
            'vnrdoc' => $vnrdoc,
            'year' => $year,
        ];

        // If property ID is provided, get property details
        if ($xid_anexo) {
            $propertyDetails = PUModel::getPredioDatos($codigo_contribuyente, $year, $xid_anexo);
            if ($propertyDetails) {
                $viewData['propertyDetails'] = $propertyDetails;
            } else {
                // Establece valores predeterminados o un mensaje de error
                $viewData['propertyDetails'] = (object)[
                    'direccion' => 'No disponible',
                    'condicion' => 'No disponible',
                    // ...otros campos con valores predeterminados
                ];
            }
            $viewData['xid_anexo'] = $xid_anexo;
        }

        \Debugbar::info('PU Query Result:', ['result' => $viewData]);

        return view('PU', $viewData);
    }
}
