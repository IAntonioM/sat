<?php

namespace App\Reports;

require_once base_path('vendor/setasign/fpdf/fpdf.php');

use FPDF;

class HRReport
{
    public static function generarPDFRecibo()
    {
        $pdf = new FPDF();

        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Recibo tipo 2 - Términos y Condiciones', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->MultiCell(0, 10, 'Aquí va el contenido del recibo con los términos y condiciones.');

        return $pdf->Output('S');
    }
}
