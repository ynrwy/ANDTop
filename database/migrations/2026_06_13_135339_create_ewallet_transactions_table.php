<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ewallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('id_ewallet');
            $table->unsignedBigInteger('id_package');
            $table->string('target_id'); // no HP / akun e-wallet
            $table->decimal('harga_coin', 15, 2);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_ewallet')->references('id_ewallet')->on('ewallets')->onDelete('cascade');
            $table->foreign('id_package')->references('id_package')->on('ewallet_packages')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ewallet_transactions');
    }
};
