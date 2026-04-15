<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanan';
    protected $primaryKey = 'id_pesanan';
    public $timestamps = false;
    protected $fillable = ['nama', 'total', 'metode_bayar', 'status_bayar', 'order_id', 'snap_token'];
    public function detail_pesanan() 
    {
        return $this->hasMany(Detail_Pesanan::class, 'id_pesanan', 'id_pesanan');
    }
}
