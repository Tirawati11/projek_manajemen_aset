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
        Schema::create('asets', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->string('gambar');
            $table->string('nama barang');
            $table->string('Merek');
            $table->string('tahun');
            $table->string('jumlah');
            $table->string('status')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('deskripsi')->nullable();
            $table->string('kondisi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asets');
    }
};
