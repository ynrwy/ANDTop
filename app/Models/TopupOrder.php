<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TopupOrder extends Model
{
    protected $fillable = ['order_id', 'user_id', 'coin', 'amount', 'status', 'payment_type', 'payment_detail', 'paid_at'];

    protected $casts = ['paid_at' => 'datetime'];
}
