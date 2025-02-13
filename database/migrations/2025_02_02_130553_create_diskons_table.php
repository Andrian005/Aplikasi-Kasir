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
        Schema::create('diskons', function (Blueprint $table) {
            $table->id();
            $table->string('kode_diskon');
            $table->string('nama_diskon');
            $table->decimal('min_diskon', 20, 0);
            $table->decimal('max_diskon', 20, 0);
            $table->integer('diskon');
            $table->unsignedBigInteger('type_pelanggan_id')->nullable();
            $table->date('tgl_mulai');
            $table->date('tgl_berakhir');
            $table->timestamps();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();

            $table->foreign('type_pelanggan_id')
                ->references('id')
                ->on('type_pelanggans')
                ->onDelete('set null');
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
