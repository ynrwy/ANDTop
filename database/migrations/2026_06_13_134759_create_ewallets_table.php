<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ewallets', function (Blueprint $table) {
            $table->id('id_ewallet');
            $table->string('nama_ewallet');
            $table->text('deskripsi')->nullable();
            $table->string('photo')->default('images/ewallets/default.png');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ewallets');
    }
};
