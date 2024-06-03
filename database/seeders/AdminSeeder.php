<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'nama_user' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'jabatan' => 'admin',
            'approved' => true,
           ]);
    }
}
