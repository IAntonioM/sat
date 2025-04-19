<?php

namespace Reports;

use FPDF;

abstract class BaseReport
{
    protected $pdf;

    public function __construct()
    {
        require_once base_path('vendor/setasign/fpdf/fpdf.php');
        $this->pdf = new \FPDF();
        $this->pdf->AddPage();
    }

    public function output()
    {
        return $this->pdf->Output('S');
    }
}
