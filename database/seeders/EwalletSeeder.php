<?php

namespace Database\Seeders;

use App\Models\Ewallet;
use Illuminate\Database\Seeder;

class EwalletSeeder extends Seeder
{
    public function run(): void
    {
        Ewallet::create([
            'nama_ewallet' => 'DANA',
            'deskripsi' => 'Top up saldo DANA dengan proses cepat dan aman.',
            'photo' => 'images/ewallets/dana.png',
        ]);

        Ewallet::create([
            'nama_ewallet' => 'OVO',
            'deskripsi' => 'Top up saldo OVO untuk kebutuhan transaksi sehari-hari.',
            'photo' => 'images/ewallets/ovo.png',
        ]);

        Ewallet::create([
            'nama_ewallet' => 'GoPay',
            'deskripsi' => 'Top up saldo GoPay langsung masuk ke akun Anda.',
            'photo' => 'images/ewallets/gopay.png',
        ]);
    }
}
