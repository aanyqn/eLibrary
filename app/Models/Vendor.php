<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $table = 'vendor';
    protected $primaryKey = 'id_vendor';
    protected $fillable = ['nama', 'deskripsi', 'id_user'];
    public $timestamps = false;
    public function menu() 
    {
        return $this->hasMany(Menu::class, 'id_vendor', 'id_vendor');
    }
    public function user()
    {
        return $this->belongsTo('user', 'id', 'id_user');
    }
}
