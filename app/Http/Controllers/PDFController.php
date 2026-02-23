<?php

namespace App\Http\Controllers;

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
}
