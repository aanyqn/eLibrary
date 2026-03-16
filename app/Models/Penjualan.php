<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $table = 'penjualan';
    protected $primaryKey = 'id_penjualan';
    protected $fillable = ['total'];
    const UPDATED_AT = null;
    public function barang() {
        return $this->belongsToMany(Barang::class);
    }
}
