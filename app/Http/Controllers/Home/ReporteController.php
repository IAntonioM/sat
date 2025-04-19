<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\PDFHelper;
use App\Reports\HRReport;

class ReporteController extends Controller
{
    public function reporte($tipo)
    {
        switch ($tipo) {
            case 'reporteHR':
                return $this->reporteHR(new HRReport());
            case 'reportePU':
                return $this->reporteHR(new HRReport());
            case 'reporteHLA':
                return $this->reporteHR(new HRReport());
            default:
                abort(404, 'Tipo de reporte no encontrado');
        }

        abort(404, 'Tipo de reporte no válido');
    }

    public function reporteHR()
    {
        $report = new HRReport();      // 👈 crea la instancia
        $pdf = $report->generarPDF();  // ✅ llamado correctamente

        return response($pdf, 200)
            ->header('Content-Type', 'application/pdf');
    }
}

