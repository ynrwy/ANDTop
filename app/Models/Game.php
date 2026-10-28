<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $primaryKey = 'id_game';

    protected $fillable = [
        'nama_game',
        'deskripsi',
        'photo',
        'icon',
    ];

    public function getRouteKeyName()
    {
        return 'id_game';
    }

    public function packages()
    {
        return $this->hasMany(GamePackage::class, 'id_game', 'id_game');
    }
}
