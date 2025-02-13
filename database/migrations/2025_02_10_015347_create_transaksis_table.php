<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('invoice')->unique();
            $table->unsignedBigInteger('pelanggan_id')->nullable();
            $table->decimal('total_belanja', 20, 0);
            $table->decimal('diskon', 20, 0)->default(0);
            $table->decimal('ppn', 20, 0)->default(0);
            $table->decimal('total_akhir', 20, 0);
            $table->integer('poin_member_didapat')->default(0);
            $table->integer('poin_member_digunakan')->default(0);
            $table->decimal('pembayaran', 20, 0);
            $table->decimal('kembalian', 20, 0);
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('pelanggan_id')
                ->references('id')
                ->on('pelanggans')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
