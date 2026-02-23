<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'id';
    protected $fillable = ['name'];
    public function User()
    {
        return $this->belongsToMany(User::class)
                    ->withPivot('status');
    }
}
