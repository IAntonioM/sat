<?php

namespace App\Reports;

use App\Models\PagosModel;
use Illuminate\Support\Facades\Session;
use FPDF;

class PagosReport extends FPDF
{
    protected $anio;
    protected $tipoTributo;
    protected $vcodcontr;
    protected $pagos;
    protected $usuario;
    protected $totalPagado;
    protected $fechaActual;

    public function __construct($anio = '%', $tipoTributo = '%')
    {
        parent::__construct('P', 'mm', 'A4');
        $this->vcodcontr = Session::get('codigo_contribuyente');
        $this->anio = $anio;
        $this->tipoTributo = $tipoTributo;
        $this->fechaActual = date('d/m/Y');

        // Obtener datos
        $this->pagos = PagosModel::getPagos($this->vcodcontr, $this->anio, $this->tipoTributo);
        $this->usuario = PagosModel::obtenerDatosContribuyente($this->vcodcontr);
        $totalPagado = PagosModel::obtenerTotalPagado($this->vcodcontr);
        $this->totalPagado = is_array($totalPagado) && !empty($totalPagado) && isset($totalPagado[0]->totalPagado) ?
                          $totalPagado[0]->totalPagado : 0;
    }

    // Cabecera de página
    function Header()
    {
        // Logo
        $this->Image(public_path('assets/media/logos/custom-3-h25-2.png'), 10, 8, 30);
        // Arial bold 15
        $this->SetFont('Arial', 'B', 15);
        // Movernos a la derecha
        $this->Cell(60);
        // Título
        $this->Cell(70, 10, 'REPORTE DE PAGOS', 1, 0, 'C');
        // Salto de línea
        $this->Ln(20);

        // Información del contribuyente
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'DATOS DEL CONTRIBUYENTE', 0, 1, 'L');
        $this->Ln(2);

        $this->SetFont('Arial', '', 10);
        $this->Cell(40, 7, utf8_decode('Código:'), 0, 0, 'L');
        $this->Cell(60, 7, $this->vcodcontr, 0, 0, 'L');
        $this->Cell(40, 7, 'Fecha:', 0, 0, 'L');
        $this->Cell(50, 7, $this->fechaActual, 0, 1, 'L');

        if ($this->usuario) {
            $this->Cell(40, 7, 'Contribuyente:', 0, 0, 'L');
            $this->Cell(150, 7, $this->usuario->nombre ?? 'N/A', 0, 1, 'L');

            $this->Cell(40, 7, 'DNI/RUC:', 0, 0, 'L');
            $this->Cell(60, 7, $this->usuario->dni_ruc ?? 'N/A', 0, 0, 'L');
            $this->Cell(40, 7, utf8_decode('Teléfono:'), 0, 0, 'L');
            $this->Cell(50, 7, $this->usuario->telefono ?? 'N/A', 0, 1, 'L');

            $this->Cell(40, 7, utf8_decode('Dirección:'), 0, 0, 'L');
            $this->Cell(150, 7, $this->usuario->direccion ?? 'N/A', 0, 1, 'L');
        }

        $this->Cell(40, 7, 'Total Pagado:', 0, 0, 'L');
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(150, 7, 'S/. ' . number_format($this->totalPagado, 2), 0, 1, 'L');

        $this->Ln(5);
    }

    // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    // Tabla de pagos
    function PagosTable()
    {
        // Agrupar pagos por año
        $pagosAgrupados = [];
        $totalesPorAnio = [];

        foreach ($this->pagos as $pago) {
            $anio = explode('-', $pago->ANIO)[0];

            if (!isset($pagosAgrupados[$anio])) {
                $pagosAgrupados[$anio] = [];
            }
            $pagosAgrupados[$anio][] = $pago;

            // Calcular totales por año
            if (!isset($totalesPorAnio[$anio])) {
                $totalesPorAnio[$anio] = 0;
            }
            $totalesPorAnio[$anio] += floatval($pago->TOTAL);
        }

        // Ordenar años en orden descendente
        krsort($pagosAgrupados);

        // Filtros aplicados
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0, 7, 'FILTROS APLICADOS', 0, 1, 'L');
        $this->SetFont('Arial', '', 10);
        $this->Cell(30, 7, utf8_decode('Año:'), 0, 0, 'L');
        $this->Cell(60, 7, ($this->anio == '%') ? utf8_decode('Todos los años') : $this->anio, 0, 1, 'L');
        $this->Cell(30, 7, 'Tributo:', 0, 0, 'L');
        $this->Cell(60, 7, ($this->tipoTributo == '%') ? 'Todos los tributos' : $this->tipoTributo, 0, 1, 'L');
        $this->Ln(5);

        if (count($this->pagos) == 0) {
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(0, 10, 'No se encontraron registros de pagos con los filtros seleccionados.', 0, 1, 'C');
            return;
        }

        // Para cada año
        foreach ($pagosAgrupados as $anio => $pagosPorAnio) {
            // Título del año
            $this->SetFillColor(241, 250, 255);
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(0, 7, utf8_decode('AÑO: ') . $anio, 1, 1, 'L', true);

            // Cabecera de la tabla
            $this->SetFillColor(248, 248, 249);
            $this->SetFont('Arial', 'B', 9);
            $this->Cell(45, 7, 'Tributo', 1, 0, 'C', true);
            $this->Cell(15, 7, utf8_decode('Año'), 1, 0, 'C', true);
            $this->Cell(25, 7, 'Imp. Insoluto', 1, 0, 'C', true);
            $this->Cell(20, 7, 'Reajuste', 1, 0, 'C', true);
            $this->Cell(20, 7, 'Mora', 1, 0, 'C', true);
            $this->Cell(20, 7, utf8_decode('Emisión'), 1, 0, 'C', true);
            $this->Cell(20, 7, 'Total', 1, 0, 'C', true);
            $this->Cell(25, 7, 'Fecha Pago', 1, 1, 'C', true);

            // Datos
            $this->SetFont('Arial', '', 8);
            foreach ($pagosPorAnio as $pago) {
                // Verificar si necesitamos una nueva página
                if ($this->GetY() > 250) {
                    $this->AddPage();

                    // Repetir cabecera de tabla
                    $this->SetFillColor(248, 248, 249);
                    $this->SetFont('Arial', 'B', 9);
                    $this->Cell(45, 7, 'Tributo', 1, 0, 'C', true);
                    $this->Cell(15, 7, utf8_decode('Año'), 1, 0, 'C', true);
                    $this->Cell(25, 7, 'Imp. Insoluto', 1, 0, 'C', true);
                    $this->Cell(20, 7, 'Reajuste', 1, 0, 'C', true);
                    $this->Cell(20, 7, 'Mora', 1, 0, 'C', true);
                    $this->Cell(20, 7, 'Emisión', 1, 0, 'C', true);
                    $this->Cell(20, 7, 'Total', 1, 0, 'C', true);
                    $this->Cell(25, 7, 'Fecha Pago', 1, 1, 'C', true);
                    $this->SetFont('Arial', '', 8);
                }

                // Color de fondo según tipo de tributo
                $fillColor = ($pago->TIPO_D == "IMP.PREDIAL") ? [230, 255, 230] : [255, 230, 230];
                $this->SetFillColor($fillColor[0], $fillColor[1], $fillColor[2]);

                $this->Cell(45, 6, $pago->TIPO_D, 1, 0, 'L', true);
                $this->Cell(15, 6, $pago->ANIO, 1, 0, 'C');
                $this->Cell(25, 6, number_format(floatval($pago->IMP_INSOL), 2), 1, 0, 'R');
                $this->Cell(20, 6, '0.00', 1, 0, 'R');
                $this->Cell(20, 6, number_format(floatval($pago->MORA), 2), 1, 0, 'R');
                $this->Cell(20, 6, number_format(floatval($pago->COSTO_EMIS), 2), 1, 0, 'R');
                $this->Cell(20, 6, number_format(floatval($pago->TOTAL), 2), 1, 0, 'R');
                $this->Cell(25, 6, isset($pago->FECHA_PAGO) ? $pago->FECHA_PAGO : '', 1, 1, 'C');
            }

            // Fila de total por año
            $this->SetFillColor(241, 241, 242);
            $this->Cell(145, 7, utf8_decode('TOTAL DEL AÑO ') . $anio, 1, 0, 'R', true);
            $this->SetFont('Arial', 'B', 9);
            $this->Cell(45, 7, 'S/. ' . number_format($totalesPorAnio[$anio], 2), 1, 1, 'R');

            $this->Ln(5);
        }
    }

    public function generarPDF()
    {
        $this->AliasNbPages();
        $this->AddPage();
        $this->PagosTable();
        return $this->Output('Reporte-Pagos.pdf', 'I');
    }
}
