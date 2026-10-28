<?php

namespace Database\Seeders;

use App\Models\Game;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    public function run(): void
    {
        Game::create([
            'nama_game' => 'Mobile Legends',
            'deskripsi' => 'Top up diamond Mobile Legends dengan harga terjangkau dan proses cepat.',
            'photo' => 'images/games/mobile-legends.jpeg',
            'icon' => 'images/games/icons/diamond-ml.jpg',
        ]);

        Game::create([
            'nama_game' => 'Free Fire',
            'deskripsi' => 'Top up diamond Free Fire untuk membeli skin, karakter, dan item lainnya.',
            'photo' => 'images/games/free-fire.jpeg',
            'icon' => 'images/games/icons/diamond-ff.jpg',
        ]);

        Game::create([
            'nama_game' => 'PUBG Mobile',
            'deskripsi' => 'Top up UC PUBG Mobile dengan berbagai pilihan nominal.',
            'photo' => 'images/games/pubg-mobile.jpg',
            'icon' => 'images/games/icons/diamond-pubg.jpg',
        ]);
    }
}
