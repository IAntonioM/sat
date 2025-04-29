<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Reports\HRReport;
use App\Reports\PUReport;
use App\Reports\RecordReport;
use App\Reports\PendientesReport;
use App\Reports\UsuariosAdminReport;
use App\Reports\ConsolidadoReport;
use App\Reports\DetalladoReport;
use App\Reports\PagosReport;
use App\Reports\PRReport;
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

            case 'reporteRecordPapeletas':
                $termBusq = $request->input('termBusq');
                $report = new RecordReport($termBusq);
                return $report->generarPDF();
                break;

            case 'reportePendientes':
                $estadoSeleccionado = $request->input('estadoSeleccionado', '%');
                $report = new PendientesReport($estadoSeleccionado);
                return $report->generarPDF();
                break;

            case 'reporteUsuariosAdmin':
                $tipoAdministrador = $request->input('tipoAdministrador', '%');
                $estado = $request->input('estadoSeleccionado', '%');
                $report = new UsuariosAdminReport($tipoAdministrador, $estado);
                return $report->generarPDF();
                break;

                case 'reporteConsolidado':
                $codigoContribuyente = $request->input('codigo_contribuyente');
                $anioSeleccionado = $request->input('anio', '%');
                $tipoTributo = $request->input('tipo_tributo', '%');
                $report = new ConsolidadoReport($codigoContribuyente, $anioSeleccionado, $tipoTributo);
                return $report->generarPDF();
                break;

            case 'reporteDetallado':
                $codigoContribuyente = $request->input('codigo_contribuyente');
                $anioSeleccionado = $request->input('anio', '%');
                $tipoTributo = $request->input('tipo_tributo', '%');
                $report = new DetalladoReport($codigoContribuyente, $anioSeleccionado, $tipoTributo);
                return $report->generarPDF();
                break;

            case 'reportePR':
                $vcodcontr = $request->input('vcodcontr');
                $idanexo = $request->input('idanexo');
                $report = new PRReport($vcodcontr, $idanexo);
                return $report->generarPDF();
                break;

                case 'PagosReport':
                    $vcodcontr = $request->input('vcodcontr');
                    $idanexo = $request->input('idanexo');
                    $report = new PagosReport($vcodcontr, $idanexo);
                    return $report->generarPDF();
                    break;

            default:
                return redirect()->back()->with('error', 'Tipo de reporte no válido');
                break;
        }
    }
}
