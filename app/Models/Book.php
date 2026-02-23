<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Book extends Model
{
    protected $table = 'buku';
    protected $primaryKey = 'idbuku';
    protected $fillable = ['kode', 'judul', 'pengarang', 'idkategori'];
    public $timestamps = false;
    public function category()
    {
        return $this->belongsTo(Category::class, 'idkategori', 'idkategori');
    }
}
