<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ewallet_packages', function (Blueprint $table) {
            $table->id('id_package');
            $table->unsignedBigInteger('id_ewallet');
            $table->string('nama_paket'); // misal "Saldo Rp 50.000"
            $table->integer('nominal'); // nominal rupiah yang diterima
            $table->decimal('harga_coin', 15, 2);
            $table->timestamps();

            $table->foreign('id_ewallet')->references('id_ewallet')->on('ewallets')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ewallet_packages');
    }
};
