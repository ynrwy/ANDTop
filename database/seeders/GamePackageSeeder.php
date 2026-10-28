<?php

namespace Database\Seeders;

use App\Models\GamePackage;
use Illuminate\Database\Seeder;

class GamePackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            // Mobile Legends (id_game 1)
            ['id_game' => 1, 'nama_paket' => '86 Diamond', 'jumlah' => 86, 'harga_coin' => 20],
            ['id_game' => 1, 'nama_paket' => '172 Diamond', 'jumlah' => 172, 'harga_coin' => 38],
            ['id_game' => 1, 'nama_paket' => '344 Diamond', 'jumlah' => 344, 'harga_coin' => 75],

            // Free Fire (id_game 2)
            ['id_game' => 2, 'nama_paket' => '70 Diamond', 'jumlah' => 70, 'harga_coin' => 15],
            ['id_game' => 2, 'nama_paket' => '140 Diamond', 'jumlah' => 140, 'harga_coin' => 29],
            ['id_game' => 2, 'nama_paket' => '355 Diamond', 'jumlah' => 355, 'harga_coin' => 70],

            // PUBG Mobile (id_game 3)
            ['id_game' => 3, 'nama_paket' => '60 UC', 'jumlah' => 60, 'harga_coin' => 17],
            ['id_game' => 3, 'nama_paket' => '325 UC', 'jumlah' => 325, 'harga_coin' => 85],
            ['id_game' => 3, 'nama_paket' => '660 UC', 'jumlah' => 660, 'harga_coin' => 165],
        ];

        foreach ($packages as $package) {
            GamePackage::create($package);
        }
    }
}
