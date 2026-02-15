<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Book extends Model
{
    public function data()
    {
        $book = DB::table('buku')->leftJoin('kategori', 'buku.idkategori', '=', 'kategori.idkategori')->select('buku.idbuku', 'buku.kode', 'buku.judul', 'buku.pengarang', 'buku.idkategori', 'kategori.nama_kategori')->get();
        return $book;
    }
}
