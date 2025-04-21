<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\PUModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\Date;

class PUController extends Controller
{
    public function index(Request $request)
    {
        // Get current date formatted as dd/mm/yyyy
        $fechaActual = Carbon::now()->format('d/m/Y');
        $year = Date('Y');

        $usuario = Session::get('usuario');
        $codigo_contribuyente = trim(Session::get('codigo_contribuyente'));

        // Get user data from model
        $rw = PUModel::getUserData($codigo_contribuyente);

        if (!$rw) {
            return redirect()->route('login')->with('error', 'No se encontraron datos de usuario');
        }
        $vnrdoc = $rw->num_doc ?? '';
        Session::put('vnrdoc', $vnrdoc);

        // Get the property ID from the request
        $xid_anexo = $request->input('xid_anexo');

        // Data to send to the view
        $viewData = [
            'fechaActual' => $fechaActual,
            'usuario' => $usuario,
            'year' => $year,
        ];

        // Get property data regardless of whether xid_anexo is provided
        $datos_predio = PUModel::getPredioDatos($codigo_contribuyente, $xid_anexo);
        $viewData['datos_predio'] = $datos_predio;

        return view('PU', $viewData);
    }
}
