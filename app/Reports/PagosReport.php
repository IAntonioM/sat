<?php

namespace App\Reports;

use App\Models\PagosModel;
use Illuminate\Support\Facades\Session;
use FPDF;

class PagosReport extends FPDF
{

    public function generarPDF()
    {

        return $this->Output('Reporte-Pagos.pdf', 'I');
    }
}
