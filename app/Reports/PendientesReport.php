<?php

namespace App\Reports;

use FPDF;

class PendientesReport extends FPDF
{
    protected $pendientes;
    protected $fechaActual;

    public function __construct($pendientes, $fechaActual)
    {
        parent::__construct('L', 'mm', 'A4');
        $this->SetAutoPageBreak(true, 20);
        $this->pendientes = $pendientes;
        $this->fechaActual = $fechaActual;
    }

    public function Header()
    {
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, 'Pendientes por Aprobar', 0, 1, 'C');
        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 10, 'Actualizados al: ' . $this->fechaActual, 0, 1, 'C');
        $this->Ln(10);
    }

    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Página ' . $this->PageNo(), 0, 0, 'C');
    }

    public function generarPDF()
    {
        $this->AddPage();
        $this->SetFont('Arial', 'B', 10);

        // Encabezado de la tabla
        $this->Cell(50, 10, 'Nombre/Razón Social', 1);
        $this->Cell(30, 10, 'Asunto', 1);
        $this->Cell(30, 10, 'Fecha de Registro', 1);
        $this->Cell(30, 10, 'Fecha de Actualización', 1);
        $this->Cell(30, 10, 'Usuario', 1);
        $this->Cell(30, 10, 'Estado', 1);
        $this->Ln();

        // Datos de las solicitudes
        $this->SetFont('Arial', '', 10);
        foreach ($this->pendientes as $solicitud) {
            $this->Cell(50, 10, $solicitud->cRazonSocial ?? $solicitud->cNombres . ' ' . $solicitud->cApePate . ' ' . $solicitud->cApeMate, 1);
            $this->Cell(30, 10, $solicitud->cAsunto, 1);
            $this->Cell(30, 10, \Carbon\Carbon::parse($solicitud->dFechaSolicitud)->format('d/m/Y'), 1);
            $this->Cell(30, 10, $solicitud->dFechaActualizacion ? \Carbon\Carbon::parse($solicitud->dFechaActualizacion)->format('d/m/Y') : '-', 1);
            $this->Cell(30, 10, $solicitud->cUsuarioActualizacion ?? '-', 1);
            $this->Cell(30, 10, $this->getEstadoLabel($solicitud->nFlgEstado), 1);
            $this->Ln();
        }

        $this->Output('Pendientes_Report.pdf', 'I');
    }

    private function getEstadoLabel($estado)
    {
        switch ($estado) {
            case 1:
                return 'Aceptado';
            case 0:
                return 'Denegado';
            case 2:
                return 'En espera';
            default:
                return 'No especificado';
        }
    }
}
