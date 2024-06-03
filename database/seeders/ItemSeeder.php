<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $codes = DB::table('codes')->pluck('id')->toArray();

        $items = [
            ['nama_barang' => 'Meja Kantor', 'code_id' => $codes[0]], // Menggunakan kode pertama
            ['nama_barang' => 'Kursi Kantor', 'code_id' => $codes[1]], // Menggunakan kode kedua
            ['nama_barang' => 'Lemari Arsip', 'code_id' => $codes[2]], // Menggunakan kode ketiga
            // Tambahkan data barang aset kantor lainnya di sini...
        ];

        // Masukkan data barang ke dalam tabel 'items'
        DB::table('items')->insert($items);
    }
}
