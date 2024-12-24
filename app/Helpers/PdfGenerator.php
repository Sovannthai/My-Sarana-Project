<?php

namespace App\Helpers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class PdfGenerator
{
    public static function generatePdf($view, $data, $filename)
    {
        // $pdf = Pdf::loadView($view, $data);
        // $pdf->save(public_path("uploads/pdf/{$filename}.pdf"));
        // return public_path("uploads/pdf/{$filename}.pdf");
        $dataArray = is_array($data) ? $data : ['data' => $data];

        $pdf = PDF::loadView($view, $dataArray);

        $directory = public_path('uploads/pdf');

        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }
        $filePath = $directory . "/{$filename}.pdf";

        $pdf->save($filePath);

        return $filePath;
    }
}
