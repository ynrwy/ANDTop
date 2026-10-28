<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->enum('jenis', ['saldo', 'game', 'ewallet']);
            $table->string('nama_item'); // nama game/ewallet/atau "Topup Saldo"
            $table->string('nama_paket')->nullable(); // nama paket (kosong utk topup saldo)
            $table->string('target_id')->nullable(); // id game / no hp
            $table->decimal('jumlah_coin', 15, 2); // + untuk topup saldo, - untuk pembelian
            $table->enum('tipe', ['masuk', 'keluar']); // masuk = topup saldo, keluar = pembelian
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
