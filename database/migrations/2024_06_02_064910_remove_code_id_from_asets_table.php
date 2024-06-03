<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asets', function (Blueprint $table) {
            // Hapus foreign key constraint terlebih dahulu
            $table->dropForeign(['code_id']); // Gunakan array jika foreign key menggunakan nama kolom secara default

            // Hapus kolom kode_id
            $table->dropColumn('code_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('asets', function (Blueprint $table) {
            // Tambahkan kembali kolom kode_id
            $table->unsignedBigInteger('code_id');

            // Tambahkan kembali foreign key constraint
            $table->foreign('code_id')->references('id')->on('codes')->onDelete('cascade');
        });
    }
};
