<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Aset;
use App\Models\PeminjamanBarang; // Perhatikan perubahan di sini

class Barang extends Model
{
    protected $fillable = ['nama_barang', 'jumlah'];

    public function asets()
    {
        return $this->hasMany(Aset::class);
    }

    public function peminjamanBarang() // Perhatikan perubahan di sini
    {
        return $this->hasMany(PeminjamanBarang::class);
    }
}
