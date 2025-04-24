<?php

namespace App\Reports;

use App\Models\Detallado;
use Illuminate\Support\Facades\DB;
use FPDF;

class DetalladoReport extends FPDF
{
    protected $codigoContribuyente;
    protected $anioSeleccionado;
    protected $tipoTributo;
    protected $fechaActual;
    protected $deudas;
    protected $datosContribuyente;
    protected $totalDeuda;

    public function __construct($codigoContribuyente, $anioSeleccionado = '%', $tipoTributo = '%')
    {
        parent::__construct('L', 'mm', 'A4');

        $this->codigoContribuyente = $codigoContribuyente;
        $this->anioSeleccionado = $anioSeleccionado;
        $this->tipoTributo = $tipoTributo;
        $this->fechaActual = date('d/m/Y');

        // Obtener datos del contribuyente
        $this->datosContribuyente = Detallado::obtenerDatosContribuyente($this->codigoContribuyente);

        // Obtener total de deuda
        $this->totalDeuda = Detallado::obtenerTotalDeuda($this->codigoContribuyente);

        // Obtener las deudas detalladas según filtros
        $this->deudas = Detallado::obtenerDetalleDeudas(
            $this->codigoContribuyente,
            $this->anioSeleccionado,
            $this->tipoTributo
        );
    }

    //Cabecera de página
    public function Header()
    {
        $imagePath = public_path('assets/media/logos/custom-3-h25-2.png');

        // Insertar la imagen en el encabezado
        $this->Image($imagePath, 10, 16, 30);

        $this->SetY(15);
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 4, "REPORTE DE DEUDAS DETALLADAS", 0, 0, 'C');
        $this->Ln(8);

        if ($this->datosContribuyente) {
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(0, 6, utf8_decode("Contribuyente: " . $this->datosContribuyente->nombre), 0, 1, 'C');
            $this->Cell(0, 6, utf8_decode("Código: " . $this->codigoContribuyente), 0, 0, 'C');
        }
        $this->Ln(8);

        $this->SetXY(10, 32);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(0, 4, utf8_decode("Fecha de generación: ") . $this->fechaActual, 0, 0, 'L');

        // Mostrar total de deuda
        $this->SetXY(210, 32);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0, 4, utf8_decode("Deuda Total: S/. ") . number_format($this->totalDeuda, 2), 0, 0, 'R');
        $this->Ln(10);

        // Cabecera de la tabla
        $this->SetFont('Arial', 'B', 8);
        $this->SetFillColor(229, 229, 229);
        $this->SetTextColor(0);
        $this->SetDrawColor(0);
        $this->SetLineWidth(.2);

        $this->SetXY(10, 40);
        $header = array('Tributo', 'Año-Periodo', 'Imp. Insoluto', 'Imp. Reajuste', 'Mora', 'Cos. de Emisión', 'Total');
        $w = array(60, 30, 35, 35, 35, 35, 35);

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

    // Función para organizar las deudas por año
    private function organizarPorAnio($deudas)
    {
        $deudasPorAnio = [];

        foreach ($deudas as $deuda) {
            if (!isset($deudasPorAnio[$deuda->ano])) {
                $deudasPorAnio[$deuda->ano] = [];
            }
            $deudasPorAnio[$deuda->ano][] = $deuda;
        }

        // Ordenar por año (descendente)
        krsort($deudasPorAnio);

        return $deudasPorAnio;
    }

    public function generarPDF()
    {
        $this->AliasNbPages();
        $this->AddPage();
        $this->SetFont('Arial', '', 8);

        $y = 48;
        $deudasPorAnio = $this->organizarPorAnio($this->deudas);
        $totalGeneral = 0;

        // Configuración de tabla
        $w = array(60, 30, 35, 35, 35, 35, 35);

        // Dibujar filas de datos agrupadas por año
        foreach ($deudasPorAnio as $anio => $deudasAnio) {
            // Encabezado de año
            $this->SetXY(10, $y);
            $this->SetFont('Arial', 'B', 9);
            $this->SetFillColor(241, 250, 255);
            $this->SetTextColor(0, 158, 247);
            $this->Cell(array_sum($w), 8, utf8_decode("AÑO: " . $anio), 1, 0, 'L', 1);
            $this->Ln();
            $y += 8;

            // Restaurar formato para datos
            $this->SetFont('Arial', '', 8);
            $this->SetTextColor(0);

            $totalAnio = 0;

            foreach ($deudasAnio as $deuda) {
                // Controlar que no se salga de la página
                if ($y > 180) {
                    $this->AddPage();
                    $y = 48;
                }

                $this->SetXY(10, $y);

                // Determinar el tipo de badge (color) basado en el tipo de tributo
                $tipoTributoTexto = $deuda->mtipo;
                $periodoAnio = $deuda->ano . '-' . $deuda->periodo;

                // Imprimir los datos
                $this->Cell($w[0], 8, utf8_decode(substr($tipoTributoTexto, 0, 35)), 1, 0, 'L');
                $this->Cell($w[1], 8, $periodoAnio, 1, 0, 'C');
                $this->Cell($w[2], 8, number_format($deuda->imp_insol, 2), 1, 0, 'R');
                $this->Cell($w[3], 8, number_format($deuda->imp_reaj, 2), 1, 0, 'R');
                $this->Cell($w[4], 8, number_format($deuda->mora, 2), 1, 0, 'R');
                $this->Cell($w[5], 8, number_format($deuda->costo_emis, 2), 1, 0, 'R');
                $this->Cell($w[6], 8, number_format($deuda->total, 2), 1, 0, 'R');

                $this->Ln();
                $y += 8;
                $totalAnio += $deuda->total;
                $totalGeneral += $deuda->total;
            }

            // Subtotal por año
            $this->SetXY(10, $y);
            $this->SetFont('Arial', 'B', 8);
            $this->SetFillColor(241, 241, 242);
            $this->Cell($w[0] + $w[1] + $w[2] + $w[3] + $w[4], 8, '', 1, 0, 'R', 1);
            $this->Cell($w[5], 8, 'SUBTOTAL', 1, 0, 'R', 1);
            $this->Cell($w[6], 8, number_format($totalAnio, 2), 1, 0, 'R');

            $this->Ln();
            $y += 8;
            $this->SetFont('Arial', '', 8);
        }

        // Total general
        if ($totalGeneral > 0) {
            $this->SetXY(10, $y);
            $this->SetFont('Arial', 'B', 10);
            $this->SetFillColor(229, 229, 229);
            $this->Cell($w[0] + $w[1] + $w[2] + $w[3] + $w[4], 8, '', 1, 0, 'R', 1);
            $this->Cell($w[5], 8, 'TOTAL GENERAL', 1, 0, 'R', 1);
            $this->Cell($w[6], 8, number_format($totalGeneral, 2), 1, 0, 'R');

            $this->Ln();
            $y += 8;
        }

        // Resumen al final
        $this->Ln(10);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0, 8, 'Resumen:', 0, 1);
        $this->SetFont('Arial', '', 9);
        $this->Cell(0, 6, 'Total de deudas: ' . count($this->deudas), 0, 1);
        $this->Cell(0, 6, 'Monto total: S/. ' . number_format($totalGeneral, 2), 0, 1);
        $this->Cell(0, 6, utf8_decode('Fecha de emisión: ' . $this->fechaActual), 0, 1);

        return $this->Output('Reporte-Detallado.pdf', 'I');
    }
}
