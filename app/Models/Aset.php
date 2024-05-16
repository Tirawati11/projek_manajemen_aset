<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aset extends Model
{
    protected $fillable =['gambar' ,'kode', 'nama barang', 'merek', 'jumlah', 'status', 'tahun', 'deskripsi', 'lokasi', 'kondisi'];
}
