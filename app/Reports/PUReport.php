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
        $this->SetAutoPageBreak(true, 20);

        // Configuración para caracteres acentuados
        $this->SetFont('Arial', '', 10);

        // Obtener datos de sesión
        $this->codigos = Session::get('codigo_contribuyente');
        $this->xid_anexo = $xid_anexo;
        $this->year = date('Y');

        // Obtener datos del predio
        $this->datosPredio = PUModel::getPredioDatos($this->codigos, $this->xid_anexo);
    }

    //Cabecera de página - simplificada
    public function Header()
    {
        $imagePath = public_path('assets/media/logos/custom-3-h25-2.png');

        // Usar el método Image para insertar la imagen en el encabezado
        $this->Image($imagePath, 11, 16, 25); // 10, 10 es la posición y 15 es el ancho de la imagen

        $this->SetXY(190, 15);
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 4, "PU");
        $this->Ln(3);

        $this->SetXY(183, 20);
        $this->SetFont('Arial', 'B', 6);
        $this->Cell(0, 4, "(PREDIO URBANO)");
        $this->Ln(3);

        $this->SetY(15);
        $this->SetFont('Arial', 'B', 13);
        $this->Cell(0, 4, 'IMPUESTO PREDIAL - ' . $this->year, 0, 1, 'C');
        $this->Ln(3);

        $this->SetY(19);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(0, 4, utf8_decode("DECLARACIÓN JURADA"), 0, 1, 'C');
        $this->Ln(3);

        $this->SetY(23);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(0, 4, utf8_decode("T.U.O. DE LA LEY DE TRIBUTACIÓN MUNICIPAL (D.S.N°156-2004-EF)"), 0, 1, 'C');
        $this->Ln(10); // Espacio después del encabezado
    }

    // Sección de datos del contribuyente - ahora como método separado
    public function DatosContribuyente()
    {
        // Sección I - DATOS DEL CONTRIBUYENTE
        $this->SetXY(5, 30);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(200, 4, 'I. DATOS DEL CONTRIBUYENTE', 0, 1, 'L');

        // Primera fila
        $this->SetFillColor(229, 229, 229);
        $this->Cell(28, 5, 'CONTRIBUYENTE', 1, 0, 'C', 1);

        $this->SetFont('Arial', 'B', 6);
        $this->SetFillColor(255, 255, 255);
        $nombre = isset($this->datosPredio[0]->nombre) ? utf8_decode($this->datosPredio[0]->nombre) : 'N/A';
        $this->Cell(85, 5, $nombre, 1, 0, 'L', 1);

        $this->SetFillColor(229, 229, 229);
        $this->Cell(35, 5, 'CODIGO DE CONTRIBUYENTE', 1, 0, 'C', 1);

        $this->SetFont('Arial', 'B', 8);
        $this->SetFillColor(255, 255, 255);
        $codigo = isset($this->datosPredio[0]->codigo) ? $this->datosPredio[0]->codigo : 'N/A';
        $this->Cell(37, 5, $codigo, 1, 0, 'C', 1);

        $this->Ln();

        // Segunda fila
        $this->SetFont('Arial', 'B', 6);
        $this->SetFillColor(229, 229, 229);
        $this->Cell(28, 5, 'DATOS DEL PREDIO', 1, 0, 'C', 1);

        $this->SetFont('Arial', 'B', 5);
        $this->SetFillColor(255, 255, 255);
        $direccion = isset($this->datosPredio[0]->direccion) ? utf8_decode($this->datosPredio[0]->direccion) : 'UBICACIÓN: N/A';
        $this->Cell(85, 5, $direccion, 1, 0, 'L', 1);

        $this->SetFont('Arial', 'B', 6);
        $this->SetFillColor(229, 229, 229);
        $this->Cell(35, 5, 'CODIGO PREDIO', 1, 0, 'C', 1);

        $this->SetFont('Arial', 'B', 8);
        $this->SetFillColor(255, 255, 255);
        $idAnexo = isset($this->datosPredio[0]->id_anexo) ? $this->datosPredio[0]->id_anexo : 'N/A';
        $this->Cell(37, 5, $idAnexo, 1, 0, 'C', 1);

        $this->Ln();

        // Tercera fila
        $this->SetFont('Arial', 'B', 6);
        $this->SetFillColor(229, 229, 229);
        $this->Cell(15, 5, utf8_decode('CONDICIÓN'), 1, 0, 'C', 1);

        $this->SetFont('Arial', 'B', 7);
        $this->SetFillColor(255, 255, 255);
        $idCondi = isset($this->datosPredio[0]->id_condi) ? $this->datosPredio[0]->id_condi : 'N/A';
        $this->Cell(5, 5, $idCondi, 1, 0, 'C', 1);

        $this->SetFont('Arial', 'B', 6);
        $this->SetFillColor(229, 229, 229);
        $this->Cell(32, 5, utf8_decode('CONDICIÓN DE PROPIEDAD'), 1, 0, 'C', 1);

        $this->SetFont('Arial', 'B', 7);
        $this->SetFillColor(255, 255, 255);
        $condiRaw = isset($this->datosPredio[0]->condi) ? utf8_decode($this->datosPredio[0]->condi) : '';
        $condi = trim($condiRaw) !== '' ? trim($condiRaw) : 'N/A';
        $this->Cell(32, 5, $condi, 1, 0, 'C', 1);

        $this->SetFont('Arial', 'B', 6);
        $this->SetFillColor(229, 229, 229);
        $this->Cell(25, 5, 'USO DE PREDIO', 1, 0, 'C', 1);

        $this->SetFont('Arial', 'B', 7);
        $this->SetFillColor(255, 255, 255);
        $uso = isset($this->datosPredio[0]->uso) ? utf8_decode($this->datosPredio[0]->uso) : 'N/A';
        $this->Cell(27, 5, $uso, 1, 0, 'C', 1);

        $this->SetFont('Arial', 'B', 6);
        $this->SetFillColor(229, 229, 229);
        $this->Cell(27, 5, '% DE PROPIEDAD', 1, 0, 'C', 1);

        $this->SetFont('Arial', 'B', 7);
        $this->SetFillColor(255, 255, 255);
        $porcen = isset($this->datosPredio[0]->porcen) ? number_format($this->datosPredio[0]->porcen, 2) . '%' : '0.00%';
        $this->Cell(22, 5, $porcen, 1, 0, 'C', 1);

        $this->Ln(8);
    }

    //Pie de página
    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 5);
        $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo() . '/{nb}'), 0, 0, 'C');
    }

    public function generarPDF()
    {
        $this->AliasNbPages();
        $this->AddPage();
        $this->SetFont('Arial', '', 7);

        // Llamar a la función para mostrar los datos del contribuyente
        $this->DatosContribuyente();

        // Sección II - DETERMINACIÓN DE AUTOAVALUO
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(200, 4, utf8_decode('II. DETERMINACIÓN DE AUTOAVALUO'), 0, 1, 'L');
        $this->Ln(1);

        // Encabezado tabla de construcciones - con alineación mejorada
        $headers = [
            'NIVEL' => 7,
            'T CONST.' => 20,
            'AÑO' => 10,
            'CL' => 8,
            'MP' => 8,
            'ESTADO' => 23,
            'CATEGORIA' => 15,
            'V.UNI' => 10   ,
            'INC.5%' => 12,
            'DEPREC.' => 15,
            'V.U.DEPREC.' => 16,
            'A CONST.' => 15,
            'ÁREA COM.' => 14,
            'V CONST.' => 12
        ];

        // Encabezados
        $this->SetFillColor(229, 229, 229);
        $this->SetFont('Arial', 'B', 6);
        $startX = 10; // Posición inicial en X
        $currentX = $startX;

        foreach ($headers as $title => $width) {
            $this->SetXY($currentX, $this->GetY());
            $this->Cell($width, 6, utf8_decode($title), 1, 0, 'C', 1);
            $currentX += $width;
        }
        $this->Ln();

        // Datos de construcciones
        $this->SetFillColor(255, 255, 255);
        $this->SetFont('Arial', '', 6);
        $currentX = $startX;

        // Datos de construcción (una sola fila)
        $piso = isset($this->datosPredio[0]->piso) ? $this->datosPredio[0]->piso : 'N/A';
        $this->SetXY($currentX, $this->GetY());
        $this->Cell($headers['NIVEL'], 6, $piso, 1, 0, 'C', 1);
        $currentX += $headers['NIVEL'];

        $tipo = isset($this->datosPredio[0]->tipo) ? utf8_decode($this->datosPredio[0]->tipo) : 'N/A';
        $this->SetXY($currentX, $this->GetY());
        $this->Cell($headers['T CONST.'], 6, $tipo, 1, 0, 'C', 1);
        $currentX += $headers['T CONST.'];

        $anio = isset($this->datosPredio[0]->anio) ? $this->datosPredio[0]->anio : 'N/A';
        $this->SetXY($currentX, $this->GetY());
        $this->Cell($headers['AÑO'], 6, $anio, 1, 0, 'C', 1);
        $currentX += $headers['AÑO'];

        $cl = isset($this->datosPredio[0]->cl) ? $this->datosPredio[0]->cl : 'N/A';
        $this->SetXY($currentX, $this->GetY());
        $this->Cell($headers['CL'], 6, $cl, 1, 0, 'C', 1);
        $currentX += $headers['CL'];

        $mp = isset($this->datosPredio[0]->mp) ? $this->datosPredio[0]->mp : 'N/A';
        $this->SetXY($currentX, $this->GetY());
        $this->Cell($headers['MP'], 6, $mp, 1, 0, 'C', 1);
        $currentX += $headers['MP'];

        $estado = isset($this->datosPredio[0]->estado) ? utf8_decode($this->datosPredio[0]->estado) : 'N/A';
        $this->SetXY($currentX, $this->GetY());
        $this->Cell($headers['ESTADO'], 6, $estado, 1, 0, 'C', 1);
        $currentX += $headers['ESTADO'];

        $categoria = isset($this->datosPredio[0]->categoria) ? utf8_decode($this->datosPredio[0]->categoria) : 'N/A';
        $this->SetXY($currentX, $this->GetY());
        $this->Cell($headers['CATEGORIA'], 6, $categoria, 1, 0, 'C', 1);
        $currentX += $headers['CATEGORIA'];

        $val_unit = isset($this->datosPredio[0]->val_unit) ? number_format($this->datosPredio[0]->val_unit, 2) : '0.00';
        $this->SetXY($currentX, $this->GetY());
        $this->Cell($headers['V.UNI'], 6, $val_unit, 1, 0, 'C', 1);
        $currentX += $headers['V.UNI'];

        $incremento = isset($this->datosPredio[0]->incremento) ? number_format($this->datosPredio[0]->incremento, 2) : '0.00';
        $this->SetXY($currentX, $this->GetY());
        $this->Cell($headers['INC.5%'], 6, $incremento, 1, 0, 'C', 1);
        $currentX += $headers['INC.5%'];

        $deprec = isset($this->datosPredio[0]->deprec) ? number_format($this->datosPredio[0]->deprec, 2) : '0.00';
        $this->SetXY($currentX, $this->GetY());
        $this->Cell($headers['DEPREC.'], 6, $deprec, 1, 0, 'C', 1);
        $currentX += $headers['DEPREC.'];

        $val_un_dep = isset($this->datosPredio[0]->val_un_dep) ? number_format($this->datosPredio[0]->val_un_dep, 2) : '0.00';
        $this->SetXY($currentX, $this->GetY());
        $this->Cell($headers['V.U.DEPREC.'], 6, $val_un_dep, 1, 0, 'C', 1);
        $currentX += $headers['V.U.DEPREC.'];

        $area_const = isset($this->datosPredio[0]->area_const) ? number_format($this->datosPredio[0]->area_const, 2) : '0.00';
        $this->SetXY($currentX, $this->GetY());
        $this->Cell($headers['A CONST.'], 6, $area_const, 1, 0, 'C', 1);
        $currentX += $headers['A CONST.'];

        $area_comun = isset($this->datosPredio[0]->area_comun) ? number_format($this->datosPredio[0]->area_comun, 2) : '0.00';
        $this->SetXY($currentX, $this->GetY());
        $this->Cell($headers['ÁREA COM.'], 6, $area_comun, 1, 0, 'C', 1);
        $currentX += $headers['ÁREA COM.'];

        $val_const = isset($this->datosPredio[0]->val_const) ? number_format($this->datosPredio[0]->val_const, 2) : '0.00';
        $this->SetXY($currentX, $this->GetY());
        $this->Cell($headers['V CONST.'], 6, $val_const, 1, 0, 'C', 1);

        $this->Ln(8);

        // Sección de resumen
        $this->SetFont('Arial', 'B', 7);
        $area_const_total = isset($this->datosPredio[0]->area_const) ? number_format($this->datosPredio[0]->area_const, 2) : '0.00';
        $this->Cell(80, 6, utf8_decode('TOTAL A CONST.: ' . $area_const_total . ' M2'), 'LTB', 0, 'L', 0);

        $fec_resol = isset($this->datosPredio[0]->fec_resol) ? $this->datosPredio[0]->fec_resol : '--/--/----';
        $this->Cell(70, 6, utf8_decode('FECHA DE ADQUISICIÓN: ' . $fec_resol), 'TB', 0, 'L', 0);
        $this->Cell(35, 6, '', 'RTB', 0, 'L', 0);
        $this->Ln();

        $area_terr = isset($this->datosPredio[0]->area_terr) ? number_format($this->datosPredio[0]->area_terr, 2) : '0.00';
        $this->Cell(80, 6, utf8_decode('ÁREA DE TERRENO: ' . $area_terr . ' M2'), 'LTB', 0, 'L', 0);

        $area_comun_terr = isset($this->datosPredio[0]->area_comun) ? number_format($this->datosPredio[0]->area_comun, 2) : '0.00';
        $this->Cell(70, 6, utf8_decode('ÁREA COMÚN DE TERRENO: ' . $area_comun_terr . ' M2'), 'TB', 0, 'L', 0);

        $arancel = isset($this->datosPredio[0]->arancel) ? number_format($this->datosPredio[0]->arancel, 2) : '0.00';
        $this->Cell(35, 6, 'ARANCEL: ' . $arancel, 'RTB', 0, 'R', 0);
        $this->Ln(10);

        // Sección de valores totales
        $this->SetFont('Arial', 'B', 7);
        $tot_constr = isset($this->datosPredio[0]->tot_constr) ? number_format($this->datosPredio[0]->tot_constr, 2) : '0.00';
        $this->Cell(130, 6, utf8_decode('VALOR TOTAL DE LA CONSTRUCCIÓN:'), 0, 0, 'R', 0);
        $this->Cell(40, 6, $tot_constr, 0, 0, 'R', 0);
        $this->Ln();

        $ot_instal = isset($this->datosPredio[0]->ot_instal) ? number_format($this->datosPredio[0]->ot_instal, 2) : '0.00';
        $this->Cell(130, 6, 'VALOR DE OTRAS INSTALACIONES:', 0, 0, 'R', 0);
        $this->Cell(40, 6, $ot_instal, 0, 0, 'R', 0);
        $this->Ln();

        $tot_terr = isset($this->datosPredio[0]->tot_terr) ? number_format($this->datosPredio[0]->tot_terr, 2) : '0.00';
        $this->Cell(130, 6, 'VALOR TOTAL DEL TERRENO:', 0, 0, 'R', 0);
        $this->Cell(40, 6, $tot_terr, 0, 0, 'R', 0);
        $this->Ln(5);

        $totalValor = (isset($this->datosPredio[0]->ot_instal) ? $this->datosPredio[0]->ot_instal : 0) +
            (isset($this->datosPredio[0]->tot_constr) ? $this->datosPredio[0]->tot_constr : 0) +
            (isset($this->datosPredio[0]->tot_terr) ? $this->datosPredio[0]->tot_terr : 0);

        $this->SetFont('Arial', 'B', 8);
        $this->Cell(130, 6, 'VALOR TOTAL DEL PREDIO:', 0, 0, 'R', 0);
        $this->Cell(40, 6, number_format($totalValor, 2), 0, 0, 'R', 0);
        $this->Ln(10);

        // Notas legales
        $this->SetFont('Arial', '', 6);
        $this->Cell(200, 4, utf8_decode('1). APROBADO MEDIANTE R.M. 367-2014 - VIVIENDA DEL MINISTERIO DE VIVIENDA, CONSTRUCCIÓN Y SANEAMIENTO'), 0, 0, 'L', 0);
        $this->Ln();
        $this->Cell(200, 4, utf8_decode('2). APROBADO MEDIANTE R.M. 126-2007 - VIVIENDA DEL MINISTERIO DE VIVIENDA, CONSTRUCCIÓN Y SANEAMIENTO'), 0, 0, 'L', 0);
        $this->Ln();
        $this->Cell(200, 4, utf8_decode('3). APROBADO MEDIANTE R.M. 369-2014 - VIVIENDA DEL MINISTERIO DE VIVIENDA, CONSTRUCCIÓN Y SANEAMIENTO'), 0, 0, 'L', 0);
        $this->Ln(15);

        return $this->Output('PU-Report.pdf', 'I');
    }
}
