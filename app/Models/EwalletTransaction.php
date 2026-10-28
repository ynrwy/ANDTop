<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EwalletTransaction extends Model
{
    protected $fillable = [
        'user_id',
        'id_ewallet',
        'id_package',
        'target_id',
        'harga_coin',
    ];

    public function ewallet()
    {
        return $this->belongsTo(Ewallet::class, 'id_ewallet', 'id_ewallet');
    }

    public function package()
    {
        return $this->belongsTo(EwalletPackage::class, 'id_package', 'id_package');
    }
}
