<?php

namespace App\Reports;

use App\Models\SolicitudAcceso;
use Illuminate\Support\Facades\DB;
use FPDF;

class PendientesReport extends FPDF
{
    protected $estadoSeleccionado;
    protected $fechaActual;
    protected $solicitudes;

    public function __construct($estadoSeleccionado = '%')
    {
        parent::__construct('L', 'mm', 'A4');

        $this->estadoSeleccionado = $estadoSeleccionado;
        $this->fechaActual = date('d/m/Y');

        // Obtener las solicitudes según el filtro de estado
        $this->solicitudes = SolicitudAcceso::obtenerSolicitudes($this->estadoSeleccionado);
    }

    //Cabecera de página
    public function Header()
    {
        $imagePath = public_path('assets/media/logos/custom-3-h25-2.png');

        // Insertar la imagen en el encabezado
        $this->Image($imagePath, 10, 16, 30);

        $this->SetY(15);
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 4, "REPORTE DE SOLICITUDES DE ACCESO", 0, 0, 'C');
        $this->Ln(8);

        $this->SetY(22);
        $this->SetFont('Arial', 'B', 8);
        $fechaEstado = '';
        switch ($this->estadoSeleccionado) {
            case '0':
                $fechaEstado = 'DENEGADAS';
                break;
            case '1':
                $fechaEstado = 'ACEPTADAS';
                break;
            case '2':
                $fechaEstado = 'EN ESPERA';
                break;
            default:
                $fechaEstado = 'TODAS';
                break;
        }
        $this->Cell(0, 4, "SOLICITUDES " . $fechaEstado, 0, 0, 'C');
        $this->Ln(8);

        $this->SetXY(10, 32);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(0, 4, utf8_decode("Fecha de generación: ") . $this->fechaActual, 0, 0, 'L');
        $this->Ln(10);

        // Cabecera de la tabla
        $this->SetFont('Arial', 'B', 8);
        $this->SetFillColor(229, 229, 229);
        $this->SetTextColor(0);
        $this->SetDrawColor(0);
        $this->SetLineWidth(.2);

        $this->SetXY(10, 40);
        $header = array('#', 'Nombre/Razón Social', 'Asunto', 'Fecha de Registro', 'Fecha de Actualización', 'Usuario', 'Estado');
        $w = array(10, 65, 65, 35, 35, 30, 30);

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

        $counter = 1;
        $y = 48;

        // Configuración de tabla
        $w = array(10, 65, 65, 35, 35, 30, 30);

        // Dibujar filas de datos
        foreach ($this->solicitudes as $solicitud) {
            // Controlar que no se salga de la página
            if ($y > 180) {
                $this->AddPage();
                $y = 48;
            }

            $this->SetXY(10, $y);

            // Formatear los nombres completos si no hay razón social
            $nombreCompleto = $solicitud->cRazonSocial ?? $solicitud->cNombres . ' ' . $solicitud->cApePate . ' ' . $solicitud->cApeMate;

            // Formatear fechas
            $fechaRegistro = \Carbon\Carbon::parse($solicitud->dFechaSolicitud)->format('d/m/Y');
            $fechaActualizacion = $solicitud->dFechaActualizacion ? \Carbon\Carbon::parse($solicitud->dFechaActualizacion)->format('d/m/Y') : '-';

            // Formatear estado
            $estado = '';
            switch ($solicitud->nFlgEstado) {
                case 0:
                    $estado = 'Denegado';
                    break;
                case 1:
                    $estado = 'Aceptado';
                    break;
                case 2:
                    $estado = 'En espera';
                    break;
                default:
                    $estado = 'No especificado';
                    break;
            }

            // Imprimir los datos
            $this->Cell($w[0], 8, $counter, 1, 0, 'C');
            $this->Cell($w[1], 8, utf8_decode(substr($nombreCompleto, 0, 35)), 1, 0, 'L');
            $this->Cell($w[2], 8, utf8_decode(substr($solicitud->cAsunto, 0, 35)), 1, 0, 'L');
            $this->Cell($w[3], 8, $fechaRegistro, 1, 0, 'C');
            $this->Cell($w[4], 8, $fechaActualizacion, 1, 0, 'C');
            $this->Cell($w[5], 8, $solicitud->cUsuarioActualizacion ?? '-', 1, 0, 'C');
            $this->Cell($w[6], 8, $estado, 1, 0, 'C');

            $this->Ln();
            $counter++;
            $y += 8;
        }

        // Estadísticas al final
        $totalAceptadas = array_filter($this->solicitudes, function($s) { return $s->nFlgEstado == 1; });
        $totalDenegadas = array_filter($this->solicitudes, function($s) { return $s->nFlgEstado == 0; });
        $totalEspera = array_filter($this->solicitudes, function($s) { return $s->nFlgEstado == 2; });

        $this->Ln(10);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0, 8, 'Resumen:', 0, 1);
        $this->SetFont('Arial', '', 9);
        $this->Cell(0, 6, 'Total de solicitudes: ' . count($this->solicitudes), 0, 1);
        $this->Cell(0, 6, 'Solicitudes aceptadas: ' . count($totalAceptadas), 0, 1);
        $this->Cell(0, 6, 'Solicitudes denegadas: ' . count($totalDenegadas), 0, 1);
        $this->Cell(0, 6, 'Solicitudes en espera: ' . count($totalEspera), 0, 1);

        return $this->Output('Reporte-Pendientes.pdf', 'I');
    }
}
