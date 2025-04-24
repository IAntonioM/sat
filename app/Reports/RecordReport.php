<?php

namespace App\Reports;

use App\Models\Contribuyente;
use App\Models\HR;
use App\Models\Predio;
use App\Models\RecordPapeleta;
use Illuminate\Support\Facades\Session;
use FPDF;

class RecordReport extends FPDF
{
    protected $usuario;
    protected $resumenData;
    protected $totalDeuda;
    protected $totalDescuento;
    protected $total;
    protected $termBusq;
    protected $codigo_contribuyente;

    public function __construct( $termBusq = null)
    {
        parent::__construct('L', 'mm', 'A4');

        $this->codigo_contribuyente = Session::get('codigo_contribuyente');
        // Obtener datos del contribuyente
        $this->usuario = Contribuyente::obtenerDatosContri($this->codigo_contribuyente);

        // Obtener datos de papeletas
        $this->resumenData = RecordPapeleta::listarPapeletas($this->codigo_contribuyente, $termBusq);
        $this->termBusq = $termBusq;

        // Calcular totales
        $this->calcularTotales();
    }

    /**
     * Calcula los totales para el reporte
     */
    protected function calcularTotales()
    {
        $this->totalDeuda = 0;
        $this->totalDescuento = 0;

        foreach ($this->resumenData as $item) {
            if ($item->estado != 0) {
                $this->totalDeuda += (float) $item->deuda;
                $this->totalDescuento += (float) $item->deuda_dscto;
            }
        }

        $this->total = $this->totalDeuda - $this->totalDescuento;
    }

    //Cabecera de página
    public function Header()
    {
        // Logo a la izquierda
        $imagePath = public_path('assets/media/logos/custom-3-h25-2.png');
        $this->Image($imagePath, 10, 10, 30);

        // Título en el centro
        $this->SetXY(90, 15);
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(120, 10, utf8_decode('RECORD DE PAPELETAS'), 0, 0, 'C');
        $this->Ln(15);

        // Datos del contribuyente
        // $this->SetFont('Arial', 'B', 10);
        // $this->Cell(0, 8, utf8_decode('DATOS DEL CONTRIBUYENTE:'), 0, 1, 'L');

        // $this->SetFont('Arial', '', 9);
        // $this->Cell(30, 6, utf8_decode('Contribuyente:'), 0, 0, 'L');
        // $this->SetFont('Arial', 'B', 9);
        // $this->Cell(100, 6, utf8_decode($this->usuario->nombre ?? ''), 0, 0, 'L');

        // $this->SetFont('Arial', '', 9);
        // $this->Cell(20, 6, utf8_decode('DNI/RUC:'), 0, 0, 'L');
        // $this->SetFont('Arial', 'B', 9);
        // $this->Cell(40, 6, utf8_decode($this->usuario->nrodoc ?? ''), 0, 1, 'L');

        // $this->SetFont('Arial', '', 9);
        // $this->Cell(30, 6, utf8_decode('Dirección:'), 0, 0, 'L');
        // $this->SetFont('Arial', 'B', 9);
        // $this->Cell(170, 6, utf8_decode($this->usuario->direcc ?? ''), 0, 1, 'L');
        // $this->Ln(5);

        // Encabezados de tabla
        $this->SetFillColor(248, 248, 249);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(22, 8, 'DNI/RUC', 1, 0, 'C', true);
        $this->Cell(30, 8, 'Nro. Papeleta', 1, 0, 'C', true);
        $this->Cell(20, 8, 'Placa', 1, 0, 'C', true);
        $this->Cell(25, 8, utf8_decode('Infracción'), 1, 0, 'C', true);
        $this->Cell(35, 8, utf8_decode('Fecha de Infracción'), 1, 0, 'C', true);
        $this->Cell(60, 8, 'Propietario', 1, 0, 'C', true);
        $this->Cell(20, 8, 'Estado', 1, 0, 'C', true);
        $this->Cell(25, 8, 'Deuda', 1, 0, 'C', true);
        $this->Cell(25, 8, 'Deuda-Dscto', 1, 0, 'C', true);
        $this->Ln();
    }

    //Pie de página
    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C');
        $this->SetX(15);
      //  $this->Cell(0, 10, 'Fecha de emisión: ' . date('d/m/Y'), 0, 0, 'L');
    }

    /**
     * Genera el contenido del reporte
     */
    public function generarContenido()
    {
        $this->SetFont('Arial', '', 8);

        // Si no hay datos, mostrar mensaje
        if (count($this->resumenData) == 0) {
            $this->Cell(0, 10, 'No se encontraron registros de papeletas.', 1, 1, 'C');
            return;
        }

        // Mostrar datos de papeletas
        foreach ($this->resumenData as $item) {
            // Verificar si necesitamos truncar textos largos
            $propietario = utf8_decode($item->nombre_propietario);
            if (strlen($propietario) > 35) {
                $propietario = substr($propietario, 0, 32) . '...';
            }

            // Formato de la fecha
            $fecha = \Carbon\Carbon::parse($item->fecha_infraccion)->format('d/m/Y');

            // Estado formateado
            $estado = $item->estado == 1 ? 'Pendiente' : 'Cancelado';

            // Imprimir fila
            $this->Cell(22, 7, $item->nrodoc, 1, 0, 'C');
            $this->Cell(30, 7, $item->nro_papeleta, 1, 0, 'C');
            $this->Cell(20, 7, $item->placa, 1, 0, 'C');
            $this->Cell(25, 7, $item->infraccion, 1, 0, 'C');
            $this->Cell(35, 7, $fecha, 1, 0, 'C');
            $this->Cell(60, 7, $propietario, 1, 0, 'L');
            $this->Cell(20, 7, $estado, 1, 0, 'C');
            $this->Cell(25, 7, number_format($item->deuda, 2), 1, 0, 'R');
            $this->Cell(25, 7, number_format($item->deuda_dscto, 2), 1, 0, 'R');
            $this->Ln();
        }

        // Fila de totales
        $this->SetFillColor(241, 241, 242);
        $this->Cell(192, 8, '', 1, 0, 'C', true);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(20, 8, 'TOTAL', 1, 0, 'C', true);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(25, 8, number_format($this->totalDeuda, 2), 1, 0, 'R');
        $this->Cell(25, 8, number_format($this->totalDescuento, 2), 1, 0, 'R');
        $this->Ln();

        // Fila de importe total
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(212, 8, 'IMPORTE TOTAL:', 1, 0, 'R');
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(50, 8, number_format($this->total, 2), 1, 0, 'C');
        $this->Ln();
    }

    /**
     * Genera el PDF y lo muestra al usuario
     */
    public function generarPDF()
    {
        $this->AliasNbPages();
        $this->AddPage();
        $this->SetFont('Arial', '', 8);

        $this->generarContenido();

        return $this->Output('Record-Papeletas.pdf', 'I');
    }
}
