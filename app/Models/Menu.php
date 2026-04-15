<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menu';
    protected $primaryKey = 'id_menu';
    protected $fillable = ['nama', 'deskripsi', 'path_gambar', 'harga', 'id_vendor'];
    public $timestamps = false;
    public function vendor() {
        return $this->belongsToMany(Vendor::class. 'id_vendor', 'id_vendor');
    }
}
