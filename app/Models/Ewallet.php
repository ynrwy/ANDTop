<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ewallet extends Model
{
    protected $primaryKey = 'id_ewallet';

    protected $fillable = [
        'nama_ewallet',
        'deskripsi',
        'photo',
    ];

    public function getRouteKeyName()
    {
        return 'id_ewallet';
    }

    public function packages()
    {
        return $this->hasMany(EwalletPackage::class, 'id_ewallet', 'id_ewallet');
    }
}
