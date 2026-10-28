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
        Schema::table('topup_orders', function (Blueprint $table) {
            $table->string('payment_detail')->nullable()->after('payment_type');
        });
    }

    public function down(): void
    {
        Schema::table('topup_orders', function (Blueprint $table) {
            $table->dropColumn('payment_detail');
        });
    }
};
