<?php

namespace App\Reports;

use App\Models\Pago;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use FPDF;

class PagosReport extends FPDF
{
    protected $anioSeleccionado;
    protected $tipoTributo;
    protected $fechaActual;
    protected $pagos;
    protected $totalPagado;
    protected $codigo_contribuyente;

    public function __construct($anioSeleccionado = '%', $tipoTributo = '%')
    {
        parent::__construct('L', 'mm', 'A4');

        $this->anioSeleccionado = $anioSeleccionado;
        $this->tipoTributo = $tipoTributo;
        $this->fechaActual = date('d/m/Y');
        $this->codigo_contribuyente = Session::get('codigo_contribuyente');

        // Obtener los pagos según los filtros
        $this->pagos = $this->obtenerPagos($this->codigo_contribuyente, $this->anioSeleccionado, $this->tipoTributo);

        // Calcular el total pagado
        $this->totalPagado = $this->calcularTotalPagado($this->pagos);
    }

    /**
     * Obtiene los pagos del contribuyente según los filtros
     *
     * @param string $codigo_contribuyente
     * @param string $anio
     * @param string $tipo_tributo
     * @return array
     */
    private function obtenerPagos($codigo_contribuyente, $anio, $tipo_tributo)
    {
        // Esta consulta debería estar en un modelo, pero por simplicidad la ponemos aquí
        // En un entorno real, se recomienda moverla a un modelo Pago
        return DB::table('PAGOS')
            ->where('CONTRIBUYENTE', $codigo_contribuyente)
            ->where('ANIO', 'like', $anio)
            ->where('TIPO', 'like', $tipo_tributo)
            ->orderBy('ANIO', 'desc')
            ->orderBy('FECHA_PAGO', 'desc')
            ->get();
    }

    /**
     * Calcula el total pagado de los pagos
     *
     * @param array $pagos
     * @return float
     */
    private function calcularTotalPagado($pagos)
    {
        $total = 0;
        foreach ($pagos as $pago) {
            $total += floatval($pago->TOTAL);
        }
        return $total;
    }

    //Cabecera de página
    public function Header()
    {
        $imagePath = public_path('assets/media/logos/custom-3-h25-2.png');

        // Insertar la imagen en el encabezado
        $this->Image($imagePath, 10, 16, 30);

        $this->SetY(15);
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 4, "REPORTE DE PAGOS DEL CONTRIBUYENTE", 0, 0, 'C');
        $this->Ln(8);

        $this->SetY(22);
        $this->SetFont('Arial', 'B', 8);
        $filtroTexto = 'TODOS LOS PAGOS';

        if ($this->anioSeleccionado != '%') {
            $filtroTexto = "AÑO: " . $this->anioSeleccionado;
        }

        if ($this->tipoTributo != '%') {
            // Obtener descripción del tributo
            $descripcionTributo = DB::table('TIPO_TRIBUTOS')
                ->where('tipo', $this->tipoTributo)
                ->value('tipo_d');

            if ($this->anioSeleccionado != '%') {
                $filtroTexto .= " - TRIBUTO: " . $descripcionTributo;
            } else {
                $filtroTexto = "TRIBUTO: " . $descripcionTributo;
            }
        }

        $this->Cell(0, 4, $filtroTexto, 0, 0, 'C');
        $this->Ln(8);

        // Datos del contribuyente
        $datosContribuyente = DB::table('CONTRIBUYENTES')
            ->where('codigo', $this->codigo_contribuyente)
            ->first();

        if ($datosContribuyente) {
            $this->SetXY(10, 32);
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(0, 4, "Contribuyente: " . utf8_decode($datosContribuyente->nombre), 0, 0, 'L');
            $this->Ln(6);

            $this->SetXY(10, 38);
            $this->Cell(0, 4, "Código: " . $this->codigo_contribuyente, 0, 0, 'L');
            $this->Ln(6);
        }

        $this->SetXY(10, 44);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(0, 4, "Fecha de generación: " . $this->fechaActual, 0, 0, 'L');
        $this->Ln(10);

        // Mostrar el total pagado
        $this->SetFont('Arial', 'B', 10);
        $this->SetXY(200, 38);
        $this->Cell(0, 4, "Total Pagado: S/. " . number_format($this->totalPagado, 2), 0, 0, 'R');
        $this->Ln(10);

        // Cabecera de la tabla
        $this->SetFont('Arial', 'B', 8);
        $this->SetFillColor(229, 229, 229);
        $this->SetTextColor(0);
        $this->SetDrawColor(0);
        $this->SetLineWidth(.2);

        $this->SetXY(10, 54);
        $header = array('Tributo', 'Año', 'Imp. Insoluto', 'Reajuste', 'Mora', 'Costos', 'Total', 'Fecha', 'N° Recibo');
        $w = array(40, 25, 25, 25, 25, 25, 30, 30, 35);

        for($i = 0; $i < count($header); $i++) {
            $this->Cell($w[$i], 8, utf8_decode($header[$i]), 1, 0, 'C', 1);
        }
        $this->Ln();
    }

    //Pie de página
    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Página ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    public function generarPDF()
    {
        $this->AliasNbPages();
        $this->AddPage();
        $this->SetFont('Arial', '', 8);

        $y = 62;
        $pagosAgrupados = [];
        $totalesPorAnio = [];

        // Agrupar los pagos por año
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

        // Configuración de tabla
        $w = array(40, 25, 25, 25, 25, 25, 30, 30, 35);

        // Dibujar filas de datos agrupadas por año
        foreach ($pagosAgrupados as $anio => $pagosPorAnio) {
            // Verificar si hay suficiente espacio en la página actual
            if ($y > 180) {
                $this->AddPage();
                $y = 62;
            }

            // Cabecera del año
            $this->SetXY(10, $y);
            $this->SetFont('Arial', 'B', 9);
            $this->SetFillColor(241, 250, 255);
            $this->SetTextColor(0, 158, 247);
            $this->Cell(array_sum($w), 8, "Año: " . $anio, 1, 0, 'L', 1);
            $this->Ln();
            $y += 8;

            // Pagos del año
            $this->SetFont('Arial', '', 8);
            $this->SetTextColor(0);

            foreach ($pagosPorAnio as $pago) {
                // Controlar que no se salga de la página
                if ($y > 180) {
                    $this->AddPage();
                    $y = 62;
                }

                $this->SetXY(10, $y);

                // Determinar el estilo del tipo de tributo
                $badgeColor = ($pago->TIPO_D == "IMP.PREDIAL") ?
                    $this->SetTextColor(15, 150, 72) :
                    $this->SetTextColor(220, 53, 69);

                // Imprimir los datos
                $this->Cell($w[0], 8, utf8_decode($pago->TIPO_D), 1, 0, 'L');
                $this->SetTextColor(0); // Restaurar color de texto
                $this->Cell($w[1], 8, $pago->ANIO, 1, 0, 'C');
                $this->Cell($w[2], 8, number_format(floatval($pago->IMP_INSOL), 2), 1, 0, 'R');
                $this->Cell($w[3], 8, '0.00', 1, 0, 'R');
                $this->Cell($w[4], 8, number_format(floatval($pago->MORA), 2), 1, 0, 'R');
                $this->Cell($w[5], 8, number_format(floatval($pago->COSTO_EMIS), 2), 1, 0, 'R');
                $this->Cell($w[6], 8, number_format(floatval($pago->TOTAL), 2), 1, 0, 'R');
                $this->Cell($w[7], 8, $pago->FECHA_PAGO ?? '-', 1, 0, 'C');
                $this->Cell($w[8], 8, $pago->NRO_RECIBO ?? '-', 1, 0, 'C');

                $this->Ln();
                $y += 8;
            }

            // Fila de total por año
            if ($y > 180) {
                $this->AddPage();
                $y = 62;
            }

            $this->SetXY(10, $y);
            $this->SetFont('Arial', 'B', 9);
            $this->SetFillColor(241, 241, 242);

            // Celdas vacías para las primeras columnas
            $this->Cell($w[0] + $w[1] + $w[2] + $w[3] + $w[4], 8, '', 1, 0, 'R', 1);

            // Celda de texto "TOTAL"
            $this->Cell($w[5], 8, 'TOTAL', 1, 0, 'C', 1);

            // Celda del total
            $this->SetFont('Arial', 'B', 10);
            $this->Cell($w[6], 8, number_format($totalesPorAnio[$anio], 2), 1, 0, 'R');

            // Celdas vacías para las últimas columnas
            $this->Cell($w[7] + $w[8], 8, '', 1, 0, 'C', 1);

            $this->Ln();
            $y += 10; // Espacio adicional después de cada grupo
        }

        // Si no hay pagos, mostrar mensaje
        if (count($this->pagos) == 0) {
            $this->SetXY(10, $y);
            $this->SetFont('Arial', 'B', 10);
            $this->SetFillColor(217, 237, 247);
            $this->SetTextColor(49, 112, 143);
            $this->Cell(array_sum($w), 20, 'No se encontraron registros de pagos con los filtros seleccionados.', 1, 0, 'C', 1);
        }

        return $this->Output('Reporte-Pagos.pdf', 'I');
    }
}
