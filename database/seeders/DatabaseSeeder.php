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
        \Database\Factories\LocationFactory::new()->count(500)->create(); // Panggil factory dengan menggunakan Factory facade
    }
}
