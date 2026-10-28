<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GamePackage extends Model
{
    protected $primaryKey = 'id_package';

    protected $fillable = [
        'id_game',
        'nama_paket',
        'jumlah',
        'harga_coin',
    ];

    public function getRouteKeyName()
    {
        return 'id_package';
    }

    public function game()
    {
        return $this->belongsTo(Game::class, 'id_game', 'id_game');
    }
}
