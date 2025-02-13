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
        Schema::table('barangs', function (Blueprint $table) {
            $table->decimal('harga_jual_1', 10, 0)->after('harga_beli');
            $table->decimal('harga_jual_2', 10, 0)->after('harga_jual_1');
            $table->decimal('harga_jual_3', 10, 0)->after('harga_jual_2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->dropColumn(['harga_jual_1', 'harga_jual_2', 'harga_jual_3']);
        });
    }
};
