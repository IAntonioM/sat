<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Reports\HRReport;
use App\Reports\PUReport;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function reporte(Request $request, $tipo)
    {
        switch ($tipo) {
            case 'reporteHR':
                $report = new HRReport();
                return $report->generarPDF();
                break;

            case 'reportePU':
                $xid_anexo = $request->input('xid_anexo');
                $report = new PUReport($xid_anexo);
                return $report->generarPDF();
                break;

            default:
                return redirect()->back()->with('error', 'Tipo de reporte no válido');
                break;
        }
    }
}
