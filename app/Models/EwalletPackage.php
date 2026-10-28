<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EwalletPackage extends Model
{
    protected $primaryKey = 'id_package';

    protected $fillable = [
        'id_ewallet',
        'nama_paket',
        'nominal',
        'harga_coin',
    ];

    // EwalletPackage.php
    public function getRouteKeyName()
    {
        return 'id_package';
    }

    public function ewallet()
    {
        return $this->belongsTo(Ewallet::class, 'id_ewallet', 'id_ewallet');
    }
}
