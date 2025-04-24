<?php

namespace App\Reports;

use App\Models\UsuariosAdmins;
use Illuminate\Support\Facades\DB;
use FPDF;

class UsuariosAdminReport extends FPDF
{
    protected $tipoAdministrador;
    protected $estado;
    protected $usuarios;

    public function __construct($tipoAdministrador, $estado)
    {
        parent::__construct('L', 'mm', 'A4');

        $this->tipoAdministrador = $tipoAdministrador;
        $this->estado = $estado;

        // Obtener los usuarios según los filtros
        $this->usuarios = UsuariosAdmins::obtenerUsuarios($this->tipoAdministrador, $this->estado);
    }

    //Cabecera de página
    public function Header()
    {
        $imagePath = public_path('assets/media/logos/custom-3-h25-2.png');
        $this->Image($imagePath, 10, 15, 30);

        $this->SetXY(240, 15);
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 4, "UA");
        $this->Ln(3);

        $this->SetXY(230, 20);
        $this->SetFont('Arial', 'B', 6);
        $this->Cell(0, 4, "(USUARIOS ADMINISTRATIVOS)");
        $this->Ln(3);

        $this->SetY(15);
        $this->SetFont('Arial', 'B', 13);
        $this->Cell(0, 4, 'REPORTE DE USUARIOS ADMINISTRATIVOS', 0, 0, 'C');
        $this->Ln(3);

        $this->SetY(19);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(0, 4, utf8_decode("SISTEMA DE GESTIÓN MUNICIPAL"), 0, 0, 'C');
        $this->Ln(10);

        // Filtros aplicados
        $this->SetXY(10, 30);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(40, 6, 'Filtros aplicados:', 0, 0, 'L');

        // Mostrar tipo de administrador seleccionado
        $tipoAdminTexto = "Todos";
        if ($this->tipoAdministrador != '%') {
            if ($this->tipoAdministrador == '002') {
                $tipoAdminTexto = "Moderador";
            } elseif ($this->tipoAdministrador == '003') {
                $tipoAdminTexto = "Administrador";
            }
        }

        // Mostrar estado seleccionado
        $estadoTexto = "Todos";
        if ($this->estado != '%') {
            if ($this->estado == '1') {
                $estadoTexto = "Activo";
            } elseif ($this->estado == '0') {
                $estadoTexto = "Desactivado";
            }
        }

        $this->SetXY(50, 30);
        $this->SetFont('Arial', '', 8);
        $this->Cell(80, 6, 'Tipo Admin: ' . $tipoAdminTexto . ' | Estado: ' . $estadoTexto, 0, 0, 'L');

        $this->SetXY(200, 30);
        $this->SetFont('Arial', '', 8);
        $this->Cell(80, 6, 'Fecha: ' . date('d/m/Y'), 0, 0, 'R');
        $this->Ln(10);

        // Cabecera de la tabla
        $this->SetFillColor(229, 229, 229);
        $this->SetFont('Arial', 'B', 8);
        $this->SetXY(10, 40);

        $this->Cell(43, 8, 'Usuario', 1, 0, 'C', 1);
        $this->Cell(93, 8, 'Apellidos y Nombres', 1, 0, 'C', 1);
        $this->Cell(38, 8, 'Fecha Registro', 1, 0, 'C', 1);
        $this->Cell(53, 8, 'Tipo Administrador', 1, 0, 'C', 1);
        $this->Cell(38, 8, 'Estado', 1, 0, 'C', 1);
        $this->Ln();
    }

    //Pie de página
    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Página ' . $this->PageNo() . '/{nb}', 0, 0, 'C');

        $this->SetY(-10);
        $this->SetFont('Arial', '', 6);
        $this->Cell(0, 10, 'Generado el ' . date('d/m/Y H:i:s'), 0, 0, 'C');
    }

    public function generarPDF()
    {
        $this->AliasNbPages();
        $this->AddPage();
        $this->SetFont('Arial', '', 8);

        $this->SetFillColor(255, 255, 255);
        $altura = 48;

        $contadorFilas = 0;

        if (count($this->usuarios) > 0) {
            foreach ($this->usuarios as $usuario) {
                $this->SetXY(10, $altura);

                // Determinar el tipo de administrador
                $tipoAdmin = "Desconocido";
                if ($usuario->vestado == '002') {
                    $tipoAdmin = "Moderador";
                } elseif ($usuario->vestado == '003') {
                    $tipoAdmin = "Administrador";
                }

                // Determinar el estado
                $estado = "Desconocido";
                if ($usuario->vestado_cuenta == '1') {
                    $estado = "Activo";
                } elseif ($usuario->vestado_cuenta == '0') {
                    $estado = "Desactivado";
                }

                // Formato para el nombre completo
                $nombreCompleto = trim($usuario->vpater . ' ' . $usuario->vmater . ' ' . $usuario->vnombre);

                // Formatear fecha de registro
                $fechaRegistro = $usuario->dfecregist ? date('d/m/Y', strtotime($usuario->dfecregist)) : 'N/A';

                // Imprimir datos
                $this->Cell(43, 8, $usuario->cidusu, 1, 0, 'L');
                $this->Cell(93, 8, utf8_decode($nombreCompleto), 1, 0, 'L');
                $this->Cell(38, 8, $fechaRegistro, 1, 0, 'C');
                $this->Cell(53, 8, $tipoAdmin, 1, 0, 'C');
                $this->Cell(38, 8, $estado, 1, 0, 'C');

                $this->Ln();
                $altura += 8;
                $contadorFilas++;

                // Si se llega al final de la página, crear una nueva
                if ($altura > 260) {
                    $this->AddPage();
                    $altura = 48;
                }
            }
        } else {
            $this->SetXY(10, $altura);
            $this->Cell(265, 8, 'No se encontraron usuarios con los filtros seleccionados', 1, 0, 'C');
        }

        // Agregar resumen al final
        $this->Ln(15);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(100, 8, 'Resumen:', 0, 0, 'L');
        $this->Ln();

        $this->SetFont('Arial', '', 8);
        $this->Cell(100, 6, 'Total de usuarios encontrados: ' . count($this->usuarios), 0, 0, 'L');

        return $this->Output('Usuarios-Admin-Report.pdf', 'I');
    }
}
