<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       // Buat array kosong untuk menyimpan kode barang
       $codes = [];

       // Generate beberapa kode barang secara acak
       for ($i = 0; $i < 10; $i++) { // Ubah angka 10 sesuai dengan jumlah kode barang yang ingin Anda buat
           $code = 'BRG' . rand(1000, 9999);
           $codes[] = ['kode' => $code];
       }

       // Insert semua kode barang ke dalam database
       DB::table('codes')->insert($codes);
   }
    }
