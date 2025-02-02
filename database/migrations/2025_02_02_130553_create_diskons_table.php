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
        Schema::create('diskons', function (Blueprint $table) {
            $table->id();
            $table->string('kode_diskon');
            $table->string('nama_diskon');
            $table->integer('diskon');
            $table->integer('minimal');
            $table->integer('maksimal');
            $table->date('tanggal_mulai');
            $table->date('tanggal_berakhir');
            $table->integer('type_pelanggan');
            $table->integer('active');
            $table->timestamps();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diskons');
    }
};
