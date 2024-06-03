<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            ['name' => 'Ruang 1'],
            ['name' => 'Ruang 2'],
            ['name' => 'Ruang 3'],
            ['name' => 'Ruang 4'],
        ];

        foreach ($locations as $location) {
            Location::create($location);
        }
    }
}
