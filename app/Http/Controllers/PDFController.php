<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF; // Pastikan Anda sudah menginstal package PDF

class PDFController extends Controller
{
    public function generatePDF(Request $request)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        $pdf = PDF::loadView('pdf_view', $data);
        return $pdf->download('data.pdf');
    }
}