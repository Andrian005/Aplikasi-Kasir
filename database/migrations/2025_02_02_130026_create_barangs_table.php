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
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang');
            $table->string('nama_barang');
            $table->date('tgl_pembelian');
            $table->date('tgl_kadaluarsa');
            $table->decimal('harga_beli', 20, 0);
            $table->integer('stok_minimal');
            $table->integer('stok');
            $table->unsignedBigInteger('kategori_id');
            $table->timestamps();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();

            $table->foreign('kategori_id')
                ->references('id')
                ->on('kategoris')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
