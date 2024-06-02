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
        Schema::table('peminjaman_barangs', function (Blueprint $table) {
            $table->unsignedBigInteger('nama_barang_id')->nullable()->after('nama');
            $table->foreign('nama_barang_id')->references('id')->on('barangs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peminjaman_barangs', function (Blueprint $table) {
            $table->dropForeign(['nama_barang_id']);
            $table->dropColumn('nama_barang_id');
        });
    }
};
