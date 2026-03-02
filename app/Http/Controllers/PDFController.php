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

        $pdf = Pdf::loadView('pdf.label-barang', compact('barang','startRow', 'startCol'))
                ->setPaper([0, 0, 561.26, 447.87], 'landscape');

        return $pdf->stream('label-barang.pdf');
    }
}
