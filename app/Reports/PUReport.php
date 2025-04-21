<?php

namespace App\Reports;

use App\Models\PUModel;
use Illuminate\Support\Facades\Session;
use FPDF;

class PUReport extends FPDF
{
    protected $codigos;
    protected $xid_anexo;
    protected $year;
    /** @var object|null $datosPredio */
    protected $datosPredio;

    public function __construct($xid_anexo = null)
    {
        parent::__construct('L', 'mm', 'A5');

        // Obtener datos de sesión
        $this->codigos = Session::get('codigo_contribuyente');
        $this->xid_anexo = $xid_anexo;
        $this->year = date('Y');

        // Obtener datos del predio
        $this->datosPredio = PUModel::getPredioDatos($this->codigos, $this->xid_anexo);
    }

    //Cabecera de página
    public function Header()
    {
        $imagePath = public_path('assets/media/logos/custom-3-h25-2.png');

        // Usar el método Image para insertar la imagen en el encabezado
        $this->Image($imagePath, 10, 10, 15); // 10, 10 es la posición y 15 es el ancho de la imagen

        $this->SetFont('Arial', 'B', 7);
        $this->SetXY(25, 16);
        $this->Cell(0, 4, "MUNICIPALIDAD DISTRITAL");
        $this->Ln();

        $this->SetFont('Arial', 'B', 7);
        $this->SetXY(25, 19);
        $this->Cell(0, 4, "DE HUMAY");
        $this->Ln();

        $this->SetXY(190, 15);
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 4, "PU");
        $this->Ln(3);

        $this->SetXY(183, 20);
        $this->SetFont('Arial', 'B', 6);
        $this->Cell(0, 4, "(PREDIO URBANO)");
        $this->Ln(3);

        $this->SetXY(70, 15);
        $this->SetFont('Arial', 'B', 13);
        $this->Cell(0, 4, 'IMPUESTO PREDIAL - ' . $this->year);
        $this->Ln(3);

        $this->SetXY(87, 19);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(0, 4, "DECLARACION JURADA");
        $this->Ln(3);

        $this->SetXY(62, 23);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(0, 4, utf8_decode("T.U.O. DE LA LEY DE TRIBUTACION MUNICIPAL (D.S.N°156-2004-EF)"), 'C');
        $this->Ln(3);
    }

    // Sección de datos del contribuyente
    public function DatosContribuyente()
    {
        // Sección I - DATOS DEL CONTRIBUYENTE
        $this->SetXY(5, 38);
        $header = array('I. DATOS DEL CONTRIBUYENTE');
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetDrawColor(0);
        $this->SetLineWidth(.2);

        $w = array(200);
        for($i = 0; $i < count($header); $i++)
            $this->Cell($w[$i], 4, $header[$i], 0, 0, 'L', 1);
        $this->Ln();

        $this->SetXY(5, 42);
        $header = array('CONTRIBUYENTE');
        $this->SetFillColor(229, 229, 229);
        $this->SetTextColor (0);
        $this->SetDrawColor(0);
        $this->SetLineWidth(.2);

        $w = array(28);
        for($i = 0; $i < count($header); $i++)
            $this->Cell($w[$i], 5, $header[$i], 1, 0, 'C', 1);
        $this->Ln();

        $this->SetXY(33, 42);
        $header = array($this->datosPredio[0]->nombre ?? 'N/A');
        $this->SetFont('Arial', 'B', 6);
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetDrawColor(0);
        $this->SetLineWidth(.2);

        $w = array(85);
        for($i = 0; $i < count($header); $i++)
            $this->Cell($w[$i], 5, $header[$i], 1, 0, 'L', 1);
        $this->Ln();

        $this->SetXY(118, 42);
        $header = array('CODIGO DE CONTRIBUYENTE');
        $this->SetFillColor(229, 229, 229);
        $this->SetTextColor(0);
        $this->SetDrawColor(0);
        $this->SetLineWidth(.2);

        $w = array(35);
        for($i = 0; $i < count($header); $i++)
            $this->Cell($w[$i], 5, $header[$i], 1, 0, 'C', 1);
        $this->Ln();

        $this->SetXY(118, 47);
        $header = array($this->datosPredio[0]->codigo ?? 'N/A');
        $this->SetFont('Arial', 'B', 8);
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetDrawColor(0);
        $this->SetLineWidth(.2);

        $w = array(35);
        for($i = 0; $i < count($header); $i++)
            $this->Cell($w[$i], 5, $header[$i], 1, 0, 'C', 1);
        $this->Ln();

        $this->SetXY(153, 42);
        $header = array('CODIGO PREDIO');
        $this->SetFillColor(229, 229, 229);
        $this->SetTextColor(0);
        $this->SetDrawColor(0);
        $this->SetLineWidth(.2);
        $this->SetFont('Arial', 'B', 6);

        $w = array(35);
        for($i = 0; $i < count($header); $i++)
            $this->Cell($w[$i], 5, $header[$i], 1, 0, 'C', 1);
        $this->Ln();

        $this->SetXY(153, 47);
        $header = array($this->datosPredio[0]->id_anexo ?? 'N/A');
        $this->SetFont('Arial', 'B', 8);
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetDrawColor(0);
        $this->SetLineWidth(.2);

        $w = array(35);
        for($i = 0; $i < count($header); $i++)
            $this->Cell($w[$i], 5, $header[$i], 1, 0, 'C', 1);
        $this->Ln();

        $this->SetXY(5, 47);
        $header = array('DATOS DEL PREDIO');
        $this->SetFillColor(229, 229, 229);
        $this->SetTextColor(0);
        $this->SetDrawColor(0);
        $this->SetLineWidth(.2);
        $this->SetFont('Arial', 'B', 7);

        $w = array(28);
        for($i = 0; $i < count($header); $i++)
            $this->Cell($w[$i], 5, $header[$i], 1, 0, 'C', 1);
        $this->Ln();

        $this->SetXY(33, 47);
        $header = array('UBICACIÓN: ' . ($this->datosPredio[0]->direccion ?? 'N/A'));
        $this-> SetFont('Arial', 'B', 6);
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetDrawColor(0);
        $this->SetLineWidth(.2);

        $w = array(85);
        for($i = 0; $i < count($header); $i++)
            $this->Cell($w[$i], 5, $header[$i], 1, 0, 'L', 1);
        $this->Ln();

        // Segunda fila con información adicional
        $this->SetXY(5, 52);
        $this->SetFont('Arial', 'B', 6);
        $this->SetFillColor(229, 229, 229);
        $this->Cell(28, 5, 'CONDICIÓN', 1, 0, 'C', 1);
        $this->SetFont('Arial', 'B', 7);
        $this->SetFillColor(255, 255, 255);
        $this->Cell(20, 5, $this->datosPredio[0]->id_condi ?? 'N/A', 1, 0, 'C', 1);

        $this->SetFont('Arial', 'B', 6);
        $this->SetFillColor(229, 229, 229);
        $this->Cell(30, 5, 'CONDICIÓN DE PROPIEDAD', 1, 0, 'C', 1);
        $this->SetFont('Arial', 'B', 7);
        $this->SetFillColor(255, 255, 255);
        $this->Cell(35, 5, $this->datosPredio[0]->condi ?? 'N/A', 1, 0, 'C', 1);

        $this->SetFont('Arial', 'B', 6);
        $this->SetFillColor(229, 229, 229);
        $this->Cell(25, 5, 'USO DE PREDIO', 1, 0, 'C', 1);
        $this->SetFont('Arial', 'B', 7);
        $this->SetFillColor(255, 255, 255);
        $this->Cell(25, 5, $this->datosPredio[0]->uso ?? 'N/A', 1, 0, 'C', 1);

        $this->SetFont('Arial', 'B', 6);
        $this->SetFillColor(229, 229, 229);
        $this->Cell(25, 5, '% DE PROPIEDAD', 1, 0, 'C', 1);
        $this->SetFont('Arial', 'B', 7);
        $this->SetFillColor(255, 255, 255);
        $this->Cell(20, 5, number_format($this->datosPredio[0]->porcen ?? 0, 2) . '%', 1, 0, 'C', 1);
        $this->Ln();
    }

    //Pie de página
    public function Footer()
    {
        $this->SetY(-20);
        $this->SetX(5);
        $this->SetFont('Arial', 'B', 5);
        $this->Cell(0, 3, "NOTA IMPORTANTE :");
        $this->Ln(3);

        $this->SetX(5);
        $this->SetFont('Arial', '', 4.7);
        $this->Cell(200, 3, utf8_decode("BASE LEGAL: ULTIMO PARRAFO DEL ART. 14 DEL TUO DE LA LEY DE TRIBUTACION MUNICIPAL, APROBADA MEDIANTE EL D.S. 156-2004-EF"), 'C');
        $this->Ln(3);

        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 5);
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    public function generarPDF()
    {
        $this->AliasNbPages();
        $this->AddPage();
        $this->SetFont('Times', '', 7);

        // Llamar a la función para mostrar los datos del contribuyente
        $this->DatosContribuyente();

        // Sección II - DETERMINACIÓN DE AUTOAVALUO
        $this->SetXY(5, 60);
        $header = array('II. DETERMINACION DE AUTOAVALUO');
        $this-> SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetDrawColor(0);
        $this->SetLineWidth(.2);
        $this->SetFont('Arial', 'B', 7);

        $w = array(200);
        for($i = 0; $i < count($header); $i++)
            $this->Cell($w[$i], 4, $header[$i], 0, 0, 'L', 1);
        $this->Ln();

        // Encabezado tabla de construcciones
        $this->SetXY(5, 65);
        $headers = [
            'NIVEL' => 10,
            'TIPO CONST.' => 12,
            'AÑO' => 10,
            'CL' => 8,
            'MP' => 8,
            'ESTADO' => 12,
            'CATEGORIA' => 25,
            'V.UNITARIO' => 15,
            'INC.5%' => 12,
            'DEPREC.' => 15,
            'V.U.DEPREC.' => 17,
            'ÁREA CONST.' => 15,
            'ÁREA COM.' => 15,
            'VALOR CONST.' => 16
        ];

        // Encabezados
        $this->SetFillColor(229, 229, 229);
        $this->SetFont('Arial', 'B', 6);
        foreach($headers as $title => $width) {
            $this->Cell($width, 6, $title, 1, 0, 'C', 1);
        }
        $this->Ln();

        // Datos de construcciones
        $this->SetFillColor(255, 255, 255);
        $this->SetFont('Arial', '', 7);

        // Datos de construcción (una sola fila)
        $this->Cell($headers['NIVEL'], 6, $this->datosPredio[0]->piso ?? 'N/A', 1, 0, 'C', 1);
        $this->Cell($headers['TIPO CONST.'], 6, $this->datosPredio[0]->tipo ?? 'N/A', 1, 0, 'C', 1);
        $this->Cell($headers['AÑO'], 6, $this->datosPredio[0]->anio ?? 'N/A', 1, 0, 'C', 1);
        $this->Cell($headers['CL'], 6, $this->datosPredio[0]->cl ?? 'N/A', 1, 0, 'C', 1);
        $this->Cell($headers['MP'], 6, $this->datosPredio[0]->mp ?? 'N/A', 1, 0, 'C', 1);
        $this->Cell($headers['ESTADO'], 6, $this->datosPredio[0]->estado ?? 'N/A', 1, 0, 'C', 1);
        $this->Cell($headers['CATEGORIA'], 6, $this->datosPredio[0]->categoria ?? 'N/A', 1, 0, 'C', 1);
        $this->Cell($headers['V.UNITARIO'], 6, number_format($this->datosPredio[0]->val_unit ?? 0, 2), 1, 0, 'C', 1);
        $this->Cell($headers['INC.5%'], 6, number_format($this->datosPredio[0]->incremento ?? 0, 2), 1, 0, 'C', 1);
        $this->Cell($headers['DEPREC.'], 6, number_format($this->datosPredio[0]->deprec ?? 0, 2), 1, 0, 'C', 1);
        $this->Cell($headers['V.U.DEPREC.'], 6, number_format($this->datosPredio[0]->val_un_dep ?? 0, 2), 1, 0, 'C', 1);
        $this->Cell($headers['ÁREA CONST.'], 6, number_format($this->datosPredio[0]->area_const ?? 0, 2), 1, 0, 'C', 1);
        $this->Cell($headers['ÁREA COM.'], 6, number_format($this->datosPredio[0]->area_comun ?? 0, 2), 1, 0, 'C', 1);
        $this->Cell($headers['VALOR CONST.'], 6, number_format($this->datosPredio[0]->val_const ?? 0, 2), 1, 0, 'C', 1);

        $this->Ln(8);

        // Sección de resumen
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(80, 6, 'TOTAL ÁREA CONST.: ' . number_format($this->datosPredio[0]->area_const ?? 0, 2) . ' M2', 'LTB', 0, 'L', 0);
        $this->Cell(70, 6, 'FECHA DE ADQUISICIÓN: ' . ($this->datosPredio[0]->fec_resol ?? '--/--/----'), 'TB', 0, 'L', 0);
        $this->Cell(50, 6, '', 'RTB', 0, 'L', 0);
        $this->Ln();

        $this->Cell(80, 6, 'ÁREA DE TERRENO: ' . number_format($this->datosPredio[0]->area_terr ?? 0, 2) . ' M2', 'LTB', 0, 'L', 0);
        $this->Cell(70, 6, 'ÁREA COMUN DE TERRENO: ' . number_format($this->datosPredio[0]->area_comun ?? 0, 2) . ' M2', 'TB', 0, 'L', 0);
        $this->Cell(50, 6, 'ARANCEL: ' . number_format($this->datosPredio[0]->arancel ?? 0, 2), 'RTB', 0, 'R', 0);
        $this->Ln(10);

        // Sección de valores totales
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(130, 6, 'VALOR TOTAL DE LA CONSTRUCCIÓN:', 0, 0, 'R', 0);
        $this->Cell(40, 6, number_format($this->datosPredio[0]->tot_constr ?? 0, 2), 0, 0, 'R', 0);
        $this->Ln();

        $this->Cell(130, 6, 'VALOR DE OTRAS INSTALACIÓNES:', 0, 0, 'R', 0);
        $this->Cell(40, 6, number_format($this->datosPredio[0]->ot_instal ?? 0, 2), 0, 0, 'R', 0);
        $this->Ln();

        $this->Cell(130, 6, 'VALOR TOTAL DEL TERRENO:', 0, 0, 'R', 0);
        $this->Cell(40, 6, number_format($this->datosPredio[0]->tot_terr ?? 0, 2), 0, 0, 'R', 0);
        $this->Ln(5);

        $totalValor = ($this->datosPredio[0]->ot_instal ?? 0) +
                     ($this->datosPredio[0]->tot_constr ?? 0) +
                     ($this->datosPredio[0]->tot_terr ?? 0);

        $this->SetFont('Arial', 'B', 8);
        $this->Cell(130, 6, 'VALOR TOTAL DEL PREDIO:', 0, 0, 'R', 0);
        $this->Cell(40, 6, number_format($totalValor, 2), 0, 0, 'R', 0);
        $this->Ln(10);

        // Notas legales
        $this->SetFont('Arial', '', 6);
        $this->Cell(200, 4, '1). APROBADO MEDIANTE R.M. 367-2014 - VIVIENDA DEL MINISTERIO DE VIVIENDA, CONSTRUCCION Y SANEAMIENTO', 0, 0, 'L', 0);
        $this->Ln();
        $this->Cell(200, 4, '2). APROBADO MEDIANTE R.M. 126-2007 - VIVIENDA DEL MINISTERIO DE VIVIENDA, CONSTRUCCION Y SANEAMIENTO', 0, 0, 'L', 0);
        $this->Ln();
        $this->Cell(200, 4, '3). APROBADO MEDIANTE R.M. 369-2014 - VIVIENDA DEL MINISTERIO DE VIVIENDA, CONSTRUCCION Y SANEAMIENTO', 0, 0, 'L', 0);
        $this->Ln(15);

        // Sección de firmas
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(95, 6, 'FIRMA DEL CONTRIBUYENTE', 'T', 0, 'C', 0);
        $this->Cell(10, 6, '', 0, 0, 'C', 0);
        $this->Cell(95, 6, 'FIRMA Y SELLO DEL FUNCIONARIO', 'T', 0, 'C', 0);

        return $this->Output('PU-Report.pdf', 'I');
    }
}
