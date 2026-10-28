<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('game_packages', function (Blueprint $table) {
            $table->id('id_package');
            $table->unsignedBigInteger('id_game');
            $table->string('nama_paket'); // misal "86 Diamond"
            $table->integer('jumlah'); // jumlah diamond/item
            $table->decimal('harga_coin', 15, 2); // harga dalam coin
            $table->timestamps();

            $table->foreign('id_game')->references('id_game')->on('games')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('game_packages');
    }
};
