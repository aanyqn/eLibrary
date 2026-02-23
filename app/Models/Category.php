<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    protected $table = 'kategori';
    protected $primaryKey = 'idkategori';
    protected $fillable = ['nama_kategori'];
    public $timestamps = false;
    public function buku()
    {
        return $this->hasMany(Book::class, 'idkategori', 'idkategori');

    }
}
