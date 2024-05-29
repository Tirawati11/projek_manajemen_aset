<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class YearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $years = range(2000, 2024);

        foreach ($years as $year) {
            DB::table('years')->insert([
                'tahun' => $year,
            ]);
        }
}
}
