<?php

namespace App\Reports;

use App\Models\PR;
use Illuminate\Support\Facades\DB;
use FPDF;

class PRReport extends FPDF
{
    protected $vcodcontr;
    protected $idanexo;
    protected $fechaActual;
    protected $datos_predio;
    protected $year;

    public function __construct($vcodcontr = null, $idanexo = null)
    {
        // Cambio de 'P' a 'L' para orientación horizontal (landscape)
        parent::__construct('L', 'mm', 'A4');

        $this->vcodcontr = $vcodcontr;
        $this->idanexo = $idanexo;
        $this->fechaActual = date('d/m/Y');
        $this->year = date('Y');

        // Obtener los datos del predio
        if ($this->vcodcontr && $this->idanexo) {
            $this->datos_predio = PR::getPredioDatos($this->vcodcontr, $this->idanexo);
        } else {
            $this->datos_predio = [];
        }
    }

    //Cabecera de página
    public function Header()
    {
        $imagePath = public_path('assets/media/logos/custom-3-h25-2.png');

        // Insertar la imagen en el encabezado - ajustada para formato horizontal
        $this->Image($imagePath, 10, 10, 30);

        $this->SetY(10);
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 4, "REPORTE DE PREDIO RUSTICO (PR)", 0, 0, 'C');
        $this->Ln(8);

        $this->SetFont('Arial', 'B', 8);
        $this->Cell(0, 4, "IMPUESTO PREDIAL " . $this->year, 0, 0, 'C');
        $this->Ln(4);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(0, 4, utf8_decode("DECLARACIÓN JURADA"), 0, 0, 'C');
        $this->Ln(8);
    }

    //Pie de página
    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo() . '/{nb}'), 0, 0, 'C');
    }

    public function generarPDF()
    {
        if (empty($this->datos_predio)) {
            return redirect()->back()->with('error', 'No se encontraron datos para el predio especificado');
        }

        $this->AliasNbPages();
        $this->AddPage();

        // I. DATOS DEL CONTRIBUYENTE - ajustado para formato horizontal
        $this->SetXY(10, 30);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0, 8, 'I. DATOS DEL CONTRIBUYENTE', 0, 1, 'L');
        $this->Ln(2);

        // Crear un marco para los datos del contribuyente
        $this->SetFont('Arial', '', 9);
        $this->SetFillColor(248, 248, 249);

        // Datos del contribuyente - Primera fila
        $this->SetDrawColor(128, 128, 128);
        $this->SetLineWidth(0.3);

        // Contribuyente - ajustado el ancho para formato horizontal
        $this->Cell(40, 10, 'CONTRIBUYENTE:', 1, 0, 'L', true);
        $this->Cell(150, 10, utf8_decode($this->datos_predio[0]->nombre ?? 'N/A'), 1, 0, 'L');

        // Código de contribuyente
        $this->SetFont('Arial', '', 6);
        $this->Cell(42, 5, 'CODIGO CONTRIBUYENTE', 1, 0, 'C', true);
        $this->SetFont('Arial', '', 9);
        $this->Cell(42, 5, $this->datos_predio[0]->codigo ?? 'N/A', 1, 1, 'C');

        // Segunda parte del código
        $this->SetX(200);
        $this->SetFont('Arial', '', 6);
        $this->Cell(42, 5, 'CODIGO PREDIO', 1, 0, 'C', true);
        $this->SetFont('Arial', '', 9);
        $this->Cell(42, 5, $this->datos_predio[0]->id_anexo ?? 'N/A', 1, 1, 'C');

        // Datos del predio - Segunda fila
        $this->Cell(40, 10, 'DATOS DEL PREDIO:', 1, 0, 'L', true);
        $this->SetFont('Arial', '', 5);
        $this->Cell(70, 10, utf8_decode($this->datos_predio[0]->direccion ?? 'N/A'), 1, 0, 'L');

        // Condición
        $this->SetFont('Arial', '', 6);
        $this->Cell(30, 10, utf8_decode('CONDICIÓN'), 1, 0, 'C', true);
        $this->SetFont('Arial', '', 6);
        $this->Cell(50, 10, $this->datos_predio[0]->condicion ?? 'N/A', 1, 0, 'C');

        // Condición de propiedad
        $this->SetFont('Arial', '', 6);
        $this->Cell(42, 5, 'COND. PROPIEDAD', 1, 0, 'C', true);
        $this->SetFont('Arial', '', 6);
        $this->Cell(42, 5, $this->datos_predio[0]->condicion_prop ?? 'N/A', 1, 1, 'C');

        // Segunda línea de campos
        $this->SetX(200);
        $this->SetFont('Arial', '', 5);
        $this->Cell(12, 5, 'USO', 1, 0, 'C', true);
        $this->SetFont('Arial', '', 6);
        $this->Cell(30, 5, $this->datos_predio[0]->uso ?? 'N/A', 1, 0, 'C');

        // % Propiedad
        $this->SetFont('Arial', '', 6);
        $this->Cell(21, 5, '% PRO.', 1, 0, 'C', true);
        $porcentaje = number_format($this->datos_predio[0]->porcen ?? 0, 2) . '%';
        $this->SetFont('Arial', '', 6);
        $this->Cell(21, 5, $porcentaje, 1, 1, 'C');

        $this->Ln(5);

        // II. DETERMINACIÓN DE AUTOAVALUO
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0, 8, utf8_decode('II. DETERMINACIÓN DE AUTOAVALUO'), 0, 1, 'L');
        $this->Ln(2);

        // Encabezados para la construcción
        $this->SetFont('Arial', 'B', 7);
        $this->SetFillColor(229, 229, 229);

        // Primera fila - Datos de construcción - ajustada para formato horizontal
        $this->Cell(15, 6, 'NIVEL', 1, 0, 'C', true);
        $this->Cell(15, 6, 'TIPO', 1, 0, 'C', true);
        $this->Cell(15, 6, utf8_decode('AÑO'), 1, 0, 'C', true);
        $this->Cell(15, 6, 'CL', 1, 0, 'C', true);
        $this->Cell(15, 6, 'MP', 1, 0, 'C', true);
        $this->Cell(25, 6, 'ESTADO', 1, 0, 'C', true);
        $this->Cell(35, 6, 'CATEGORIA', 1, 0, 'C', true);
        $this->Cell(25, 6, 'V.UNITARIO', 1, 0, 'C', true);
        $this->Cell(25, 6, 'INC.5%', 1, 0, 'C', true);
        $this->Cell(29, 6, 'DEPREC.', 1, 0, 'C', true);
        $this->Cell(30, 6, 'V.U.DEP', 1, 0, 'C', true);
        $this->Cell(30, 6, 'VALOR CONST.', 1, 1, 'C', true);

        // Datos de construcción
        $this->SetFont('Arial', '', 7);
        $this->Cell(15, 6, $this->datos_predio[0]->piso ?? 'N/A', 1, 0, 'C');
        $this->Cell(15, 6, $this->datos_predio[0]->tipo ?? 'N/A', 1, 0, 'C');
        $this->Cell(15, 6, $this->datos_predio[0]->anio ?? 'N/A', 1, 0, 'C');
        $this->Cell(15, 6, $this->datos_predio[0]->cl ?? 'N/A', 1, 0, 'C');
        $this->Cell(15, 6, $this->datos_predio[0]->mp ?? 'N/A', 1, 0, 'C');
        $this->Cell(25, 6, $this->datos_predio[0]->estado ?? 'N/A', 1, 0, 'C');
        $this->Cell(35, 6, $this->datos_predio[0]->categoria ?? 'N/A', 1, 0, 'C');
        $this->Cell(25, 6, number_format($this->datos_predio[0]->val_unit ?? 0, 2), 1, 0, 'C');
        $this->Cell(25, 6, number_format($this->datos_predio[0]->incremento ?? 0, 2), 1, 0, 'C');
        $this->Cell(29, 6, number_format($this->datos_predio[0]->deprec ?? 0, 2), 1, 0, 'C');
        $this->Cell(30, 6, number_format($this->datos_predio[0]->val_un_dep ?? 0, 2), 1, 0, 'C');
        $this->Cell(30, 6, number_format($this->datos_predio[0]->val_const ?? 0, 2), 1, 1, 'C');

        $this->Ln(5);

        // Clases de tierras - ajustado para formato horizontal
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(150, 6, 'CLASES DE TIERRAS', 1, 0, 'C', true);
        $this->Cell(33, 6, 'CATEGORIA', 1, 0, 'C', true);
        $this->Cell(33, 6, 'ARANCEL', 1, 0, 'C', true);
        $this->Cell(33, 6, 'CANT. HA', 1, 0, 'C', true);
        $this->Cell(25, 6, 'AR X H', 1, 1, 'C', true);

        // Datos de tierras
        $this->SetFont('Arial', '', 7);
        $this->Cell(150, 6, 'Urbana o Residencial', 1, 0, 'C');
        $this->Cell(33, 6, $this->datos_predio[0]->categoria ?? 'N/A', 1, 0, 'C');
        $this->Cell(33, 6, $this->datos_predio[0]->arancel ?? 'N/A', 1, 0, 'C');
        $this->Cell(33, 6, $this->datos_predio[0]->area_ha ?? 'N/A', 1, 0, 'C');
        $this->Cell(25, 6, '10', 1, 1, 'C');

        $this->Ln(5);

        // Totales y resumen - diseño de dos columnas para formato horizontal
        $this->SetFont('Arial', 'B', 8);

        // Primera fila
        $this->Cell(100, 8, utf8_decode('TOTAL ÁREA CONST.: ') . number_format($this->datos_predio[0]->area_const ?? 0, 2) . ' M2', 0, 0, 'L');
        $this->Cell(100, 8, utf8_decode('FECHA DE ADQUISICIÓN: ') . ($this->datos_predio[0]->fec_resol ?? '--/--/----'), 0, 0, 'L');

        // Segunda fila
        $this->Ln(8);
        $this->Cell(100, 8, utf8_decode('ÁREA DE TERRENO: ') . number_format($this->datos_predio[0]->area_terr ?? 0, 2) . ' M2', 0, 0, 'L');
        $this->Cell(100, 8, utf8_decode('ÁREA COMUN DE TERRENO: ') . number_format($this->datos_predio[0]->area_comun ?? 0, 2) . ' M2', 0, 0, 'L');
        $this->Cell(75, 8, 'ARANCEL: ' . number_format($this->datos_predio[0]->arancel ?? 0, 2), 0, 1, 'R');

        $this->Ln(5);

        // Resumen de valores - ajustados para formato horizontal
        $this->SetX(140);
        $this->Cell(80, 8, utf8_decode('VALOR TOTAL DE LA CONSTRUCCIÓN:'), 0, 0, 'R');
        $this->Cell(65, 8, number_format($this->datos_predio[0]->tot_constr ?? 0, 2), 0, 1, 'R');

        $this->SetX(140);
        $this->Cell(80, 8, utf8_decode('VALOR DE OTRAS INSTALACIÓNES:'), 0, 0, 'R');
        $this->Cell(65, 8, number_format($this->datos_predio[0]->ot_instal ?? 0, 2), 0, 1, 'R');

        $this->SetX(140);
        $this->Cell(80, 8, 'VALOR TOTAL DEL TERRENO:', 0, 0, 'R');
        $this->Cell(65, 8, number_format($this->datos_predio[0]->tot_terr ?? 0, 2), 0, 1, 'R');

        $this->Ln(5);

        // Notas legales - más ancho para formato horizontal
        $this->SetFont('Arial', '', 6);
        $this->MultiCell(0, 4, "1). APROBADO MEDIANTE R.M. 367-2014 - VIVIENDA DEL MINISTERIO DE VIVIENDA, CONSTRUCCION Y SANEAMIENTO\n".
                               "2). APROBADO MEDIANTE R.M. 126-2007 - VIVIENDA DEL MINISTERIO DE VIVIENDA, CONSTRUCCION Y SANEAMIENTO\n".
                               "3). APROBADO MEDIANTE R.M. 369-2014 - VIVIENDA DEL MINISTERIO DE VIVIENDA, CONSTRUCCION Y SANEAMIENTO", 0, 'L');

        $this->Ln(5);

        // Valor total del predio
        $valor_total = ($this->datos_predio[0]->ot_instal ?? 0) +
                      ($this->datos_predio[0]->tot_constr ?? 0) +
                      ($this->datos_predio[0]->tot_terr ?? 0);

        $this->SetFont('Arial', 'B', 10);
        $this->SetX(140);
        $this->Cell(80, 8, 'VALOR TOTAL DEL PREDIO:', 0, 0, 'R');
        $this->Cell(65, 8, number_format($valor_total, 2), 0, 1, 'R');

        return $this->Output('PR-Report.pdf', 'I');
    }
}
