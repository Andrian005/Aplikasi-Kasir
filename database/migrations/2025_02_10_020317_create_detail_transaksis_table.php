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
        Schema::create('detail_transaksis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaksi_id')->nullable();
            $table->unsignedBigInteger('barang_id')->nullable();
            $table->integer('jumlah_barang');
            $table->decimal('harga_satuan', 20, 0)->default(0);
            $table->decimal('sub_total', 20, 0)->default(0);
            $table->timestamps();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();

            // Tambahkan constraint foreign key
            $table->foreign('transaksi_id')
                ->references('id')
                ->on('transaksis') // Pastikan nama tabel sesuai dengan yang ada
                ->onDelete('set null');

            $table->foreign('barang_id')
                ->references('id')
                ->on('barangs') // Pastikan nama tabel sesuai dengan yang ada
                ->onDelete('set null');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_transaksis');
    }
};
