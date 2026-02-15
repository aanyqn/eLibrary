<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    public function data()
    {
        $category = DB::table('kategori')->select('idkategori', 'nama_kategori')->get();
        return $category;
    }
}
