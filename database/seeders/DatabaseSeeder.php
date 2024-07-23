<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Location;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
Revisi/data_user
        \Database\Factories\CategoryFactory::new()->count(1000)->create(); // Panggil factory dengan menggunakan Factory facade

        \Database\Factories\CategoryFactory::new()->count(500)->create(); // Panggil factory dengan menggunakan Factory facade
    }
}
