<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customer';
    protected $primaryKey = 'id_customer';
    protected $fillable = ['nama', 'alamat', 'id_provinsi', 'id_kota', 'id_kecamatan', 'id_kelurahan', 'foto_blob', 'foto_path'];
    public $timestamps = false;
}
