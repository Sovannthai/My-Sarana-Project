<?php

namespace App\Helpers;

use Barryvdh\DomPDF\Facade\Pdf;

class PdfGenerator
{
    public static function generatePdf($view, $data, $filename)
    {
        $pdf = Pdf::loadView($view, $data);
        $pdf->save(public_path("uploads/pdf/{$filename}.pdf"));
        return public_path("uploads/pdf/{$filename}.pdf");
    }
}
