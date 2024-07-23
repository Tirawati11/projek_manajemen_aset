<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Tambahkan debug log untuk melihat data yang diimpor
        \Log::info('Importing row:', $row);

        // Cek apakah kunci 'nama_user' ada dan tidak kosong
        if (isset($row['nama_user']) && !empty($row['nama_user'])) {
            \Log::info('Valid row detected, creating user', $row);
            return new User([
                'nama_user' => $row['nama_user'],
                'email' => $row['email'],
                'password' => bcrypt($row['password']), // Ganti dengan hash password sesuai kebutuhan Anda
                'jabatan' => $row['jabatan'],
            ]);
        }

        // Kembalikan null jika kunci 'nama_user' tidak ada atau kosong
        \Log::info('Invalid row, skipping', $row);
        return null;
    }

}
