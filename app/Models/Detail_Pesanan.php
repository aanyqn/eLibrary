<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detail_Pesanan extends Model
{
    protected $table = 'detail_pesanan';
    protected $primaryKey = 'id_detail_pesanan';
    public $timestamps = false;
    protected $fillable = ['id_menu', 'id_pesanan', 'jumlah', 'harga', 'subtotal', 'catatan'];
    public function pesanan() 
    {
        return $this->belongsToMany(Pesanan::class, 'id_pesanan', 'id_pesanan');
    }
    public function menu() 
    {
        return $this->belongsToMany(Menu::class, 'id_menu', 'id_menu');
    }
}
