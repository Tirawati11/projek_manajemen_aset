<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLocationIdToPeminjamanBarangsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('peminjaman_barangs', function (Blueprint $table) {
            $table->unsignedBigInteger('location_id')->after('jumlah'); // Tambahkan kolom setelah kolom 'jumlah'
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peminjaman_barangs', function (Blueprint $table) {
            $table->dropForeign(['location_id']); // Hapus foreign key constraint
            $table->dropColumn('location_id'); // Hapus kolom 'location_id'
        });
    }
}
