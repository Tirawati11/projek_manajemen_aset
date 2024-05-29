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
        Schema::create('peminjaman_barangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('jumlah');
            $table->string('nama_barang');
            // $table->unsignedBigInteger('location_id'); // Gunakan unsignedBigInteger untuk foreign key
            // $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
            $table->date('tanggal_peminjaman');
            $table->date('tanggal_pengembalian')->nullable();
            $table->string('status')->default('dipinjam'); // 'dipinjam' or 'dikembalikan'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman_barangs');
    }
};
