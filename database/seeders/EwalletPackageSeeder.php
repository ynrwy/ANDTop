<?php

namespace Database\Seeders;

use App\Models\EwalletPackage;
use Illuminate\Database\Seeder;

class EwalletPackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            // DANA (id_ewallet 1)
            ['id_ewallet' => 1, 'nama_paket' => 'Saldo Rp 25.000', 'nominal' => 25000, 'harga_coin' => 27],
            ['id_ewallet' => 1, 'nama_paket' => 'Saldo Rp 50.000', 'nominal' => 50000, 'harga_coin' => 53],
            ['id_ewallet' => 1, 'nama_paket' => 'Saldo Rp 100.000', 'nominal' => 100000, 'harga_coin' => 104],

            // OVO (id_ewallet 2)
            ['id_ewallet' => 2, 'nama_paket' => 'Saldo Rp 25.000', 'nominal' => 25000, 'harga_coin' => 27],
            ['id_ewallet' => 2, 'nama_paket' => 'Saldo Rp 50.000', 'nominal' => 50000, 'harga_coin' => 53],
            ['id_ewallet' => 2, 'nama_paket' => 'Saldo Rp 100.000', 'nominal' => 100000, 'harga_coin' => 104],

            // GoPay (id_ewallet 3)
            ['id_ewallet' => 3, 'nama_paket' => 'Saldo Rp 25.000', 'nominal' => 25000, 'harga_coin' => 27],
            ['id_ewallet' => 3, 'nama_paket' => 'Saldo Rp 50.000', 'nominal' => 50000, 'harga_coin' => 53],
            ['id_ewallet' => 3, 'nama_paket' => 'Saldo Rp 100.000', 'nominal' => 100000, 'harga_coin' => 104],
        ];

        foreach ($packages as $package) {
            EwalletPackage::create($package);
        }
    }
}
