<?php

namespace App\Reports;

use App\Models\Contribuyente;
use App\Models\HR;
use App\Models\Predio;
use Illuminate\Support\Facades\Session;
use FPDF;

class HRReport extends FPDF
{
    protected $codigos;
    protected $nombre;
    protected $vdirecc;
    protected $year;
    /** @var object|null $datosContribuyente */ // ✅ tipo correcto
    protected $datosContribuyente;


    public function __construct()
    {
        parent::__construct('L', 'mm', 'a5');

        // Obtener datos de sesión
        $this->codigos = Session::get('codigo_contribuyente');
        $this->nombre = Session::get('nombr');
        $this->vdirecc = Session::get('vdirecc');
        $this->year = date('Y');

        // Obtener datos del contribuyente
        $this->datosContribuyente = HR::obtenerDatosContribuyente($this->codigos);
    }

    //Cabecera de página
    public function Header()
    {
       $imagePath = public_path('assets/media/logos/custom-3-h25-2.png');

    // Usar el método Image para insertar la imagen en el encabezado
    // $this->Image( ruta, x, y, width, height);
    // Puedes ajustar la posición (x, y) y el tamaño de la imagen (width, height)
        $this->Image($imagePath, 10, 15, 25); // 10, 10 es la posición y 40 es el ancho de la imagen

        $this->SetXY(190, 15);
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 4, "HR");
        $this->Ln(3);

        $this->SetXY(183, 20);
        $this->SetFont('Arial', 'B', 6);
        $this->Cell(0, 4, "(HOJA DE RESUMEN)");
        $this->Ln(3);

        $this->SetXY(70, 15);
        $this->SetFont('Arial', 'B', 13);
        $this->Cell(0, 4, 'IMPUESTO PREDIAL - ' . $this->datosContribuyente->cperiod    );
        $this->Ln(3);

        $this->SetXY(87, 19);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(0, 4, "DECLARACION JURADA");
        $this->Ln(3);

        $this->SetXY(62, 23);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(0, 4, utf8_decode("T.U.O. DE LA LEY DE TRIBUTACION MUNICIPAL (D.S.N°156-2004-EF)"), 'C');
        $this->Ln(3);

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
        $this->SetTextColor(0);
        $this->SetDrawColor(0);
        $this->SetLineWidth(.2);

        $w = array(28);
        for($i = 0; $i < count($header); $i++)
            $this->Cell($w[$i], 5, $header[$i], 1, 0, 'C', 1);
        $this->Ln();

        $this->SetXY(33, 42);
        $header = array($this->datosContribuyente->nombre);
        $this->SetFont('Arial', 'B', 6);
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetDrawColor(0);
        $this->SetLineWidth(.2);

        $w = array(102);
        for($i = 0; $i < count($header); $i++)
            $this->Cell($w[$i], 5, $header[$i], 1, 0, 'L', 1);
        $this->Ln();

        $this->SetXY(135, 42);
        $header = array('CODIGO DE CONTRIBUYENTE');
        $this->SetFillColor(229, 229, 229);
        $this->SetTextColor(0);
        $this->SetDrawColor(0);
        $this->SetLineWidth(.2);

        $w = array(35);
        for($i = 0; $i < count($header); $i++)
            $this->Cell($w[$i], 5, $header[$i], 1, 0, 'C', 1);
        $this->Ln();

        $this->SetXY(135, 47);
        $header = array($this->datosContribuyente->codigo1);
        $this->SetFont('Arial', 'B', 8);
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetDrawColor(0);
        $this->SetLineWidth(.2);

        $w = array(35);
        for($i = 0; $i < count($header); $i++)
            $this->Cell($w[$i], 5, $header[$i], 1, 0, 'C', 1);
        $this->Ln();

        $this->SetXY(170, 42);
        $header = array('DOCUMENTO');
        $this->SetFillColor(229, 229, 229);
        $this->SetTextColor(0);
        $this->SetDrawColor(0);
        $this->SetLineWidth(.2);
        $this->SetFont('Arial', 'B', 6);

        $w = array(35);
        for($i = 0; $i < count($header); $i++)
            $this->Cell($w[$i], 5, $header[$i], 1, 0, 'C', 1);
        $this->Ln();

        $this->SetXY(170, 47);
        $header = array('');
        $this->SetFont('Arial', 'B', 6);
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetDrawColor(0);
        $this->SetLineWidth(.2);

        $w = array(35);
        for($i = 0; $i < count($header); $i++)
            $this->Cell($w[$i], 5, $header[$i], 1, 0, 'C', 1);
        $this->Ln();

        $this->SetXY(5, 47);
        $header = array('DOMICILIO FISCAL');
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
        $header = array($this->datosContribuyente->direcc);
        $this->SetFont('Arial', 'B', 6);
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetDrawColor(0);
        $this->SetLineWidth(.2);

        $w = array(102);
        for($i = 0; $i < count($header); $i++)
            $this->Cell($w[$i], 5, $header[$i], 1, 0, 'L', 1);
        $this->Ln();

        $this->SetXY(5, 55);
        $header = array('II. RELACION DE PREDIOS');
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetDrawColor(0);
        $this->SetLineWidth(.2);
        $this->SetFont('Arial', 'B', 7);

        $w = array(200);
        for($i = 0; $i < count($header); $i++)
            $this->Cell($w[$i], 4, $header[$i], 0, 0, 'L', 1);
        $this->Ln();

        $this->SetXY(5, 60);
        $header = array('CODIGO', 'DIRECCION DEL PREDIO', 'VALOR DEL PREDIO', '% PROPIEDAD.', 'MONTO INAFECTO', 'VALOR AFECTO');
        $this->SetFillColor(229, 229, 229);
        $this->SetTextColor(0);
        $this->SetDrawColor(0);
        $this->SetLineWidth(.2);
        $this->SetFont('Arial', 'B', 5);

        $w = array(14, 120, 18, 16, 17, 17);
        for($i = 0; $i < count($header); $i++)
            $this->Cell($w[$i], 8, $header[$i], 1, 0, 'C', 1);
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

        $predios = HR::obtenerRelacionPredios($this->codigos, $this->year);
        $valuo = 0;

        foreach ($predios as $predio) {
            $this->SetFont('Arial', 'B', 6);
            $this->SetX(5);

            $this->SetFillColor(255, 255, 255);
            $this->SetTextColor(0, 0, 0);

            $this->Cell(14, 6, $predio->cod_pred, 1, 0, 'C');

            $this->SetFont('Arial', 'B', 5);
            $this->Cell(120, 6, utf8_decode($predio->direccion), 1, 0, 'L'); // era {'8'}
            $this->Cell(18, 6, $predio->val_autoavaluo, 1, 0, 'C');      // era {'11'}
            $this->Cell(16, 6, $predio->porcen_propiedad, 1, 0, 'C');    // era {'9'}
            $this->Cell(17, 6, $predio->total, 1, 0, 'C');               // era {'19'}
            $this->Cell(17, 6, $predio->Valor_Afecto, 1, 0, 'C');        // era {'12'}

            $this->Ln(6);

            $valuo += $predio->val_autoavaluo;
        }

        $resumen = HR::obtenerTotales($this->codigos, $this->year);

        $this->SetXY(5, 110);
        $header = array('TOTAL PREDIOS', 'PREDIO AFECTO', 'BASE IMPONIBLE', 'BASE EXONERADA', 'IMPUESTO ANUAL', 'CUOTA TRIMESTRAL', 'EMISION Y DISTRIBUCION', 'TOTAL A PAGAR');
        $this->SetFillColor(229, 229, 229);
        $this->SetFont('Arial', 'B', 6);
        $this->SetTextColor(0);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(.1);

        $w = array(22, 22, 22, 25, 26, 27, 29, 27);
        for($i = 0; $i < count($header); $i++)
            $this->Cell($w[$i], 6, $header[$i], 1, 0, 'C', 1);
        $this->Ln();

        $this->SetFont('Arial', 'B', 6);
        $this->SetXY(5, 116);

        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0, 0, 0);

        $this->Cell(22, 6, $resumen['total_predios'], 1, 0, 'C');            // TOTAL PREDIOS
        $this->Cell(22, 6, $resumen['total_afecto'], 1, 0, 'C');             // PREDIO AFECTO
        $this->Cell(22, 6, $resumen['base_imponible'], 1, 0, 'C');           // BASE IMPONIBLE
        $this->Cell(25, 6, $resumen['base_exonerada'], 1, 0, 'C');           // BASE EXONERADA
        $this->Cell(26, 6, $resumen['imp_anual'], 1, 0, 'C');                // IMPUESTO ANUAL
        $this->Cell(27, 6, $resumen['imp_trime'], 1, 0, 'C');                // CUOTA TRIMESTRAL
        $this->Cell(29, 6, $resumen['costo_emi'], 1, 0, 'C');                // EMISION Y DISTRIBUCION
        $this->Cell(27, 6, $resumen['total'], 1, 0, 'C');                    // TOTAL A PAGAR

        return $this->Output('HR-Report.pdf', 'I');
    }
}
