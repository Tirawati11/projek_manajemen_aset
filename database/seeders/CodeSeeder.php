<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Daftar nama barang
        $barang = [
            'Komputer',
            'Laptop',
            'Kipas',
            'Alat Tulis Kantor',
        ];

        // Buat array kosong untuk menyimpan data kode barang
        $codes = [];

        // Generate kode untuk setiap nama barang
        foreach ($barang as $nama) {
            // Ambil inisial dari setiap kata dalam nama barang
            $inisial = '';
            $kata = explode(' ', $nama);
            foreach ($kata as $k) {
                $inisial .= strtoupper(substr($k, 0, 1));
            }

            // Gabungkan inisial dengan angka acak antara 100 dan 999
            $angka = rand(100, 999);
            $kode = $inisial . '-' . $angka;

            // Simpan kode barang ke dalam array
            $codes[] = [
                'nama' => $nama,
                'kode' => $kode,
            ];
        }

        // Insert semua data kode barang ke dalam tabel 'codes'
        DB::table('codes')->insert($codes);
    }
}
