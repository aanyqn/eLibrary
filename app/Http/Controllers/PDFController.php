<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Book;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PDFController extends Controller
{
    public function generate(Request $request)
    {
        $books = Book::all();

        if ($request->rotation == 'landscape') {
            $pdf = Pdf::loadView('pdf.book-pdf', [
            'data' => $books
            ])
            ->setPaper('a4', 'landscape');
        } else {
            $pdf = Pdf::loadView('pdf.book-pdf', [
            'data' => $books
            ])
            ->setPaper('a4', 'portrait');
        }

        return $pdf->stream('book.pdf');
    }

    public function generateLabel(Request $request)
    {
        $barang = Barang::whereIn('id_barang', $request->id_barang)->get();
        $startRow = $request->row ?? 1;
        $startCol = $request->column ?? 1;
        // return view('pdf.label-barang', compact('startCol','startRow', 'barang'));

        $pdf = Pdf::loadView('pdf.label-barang', compact('barang', 'startRow', 'startCol'))
        ->setPaper([0, 0, 595.28, 467.72]); 

        return $pdf->stream('label-barang.pdf');
    }
}
