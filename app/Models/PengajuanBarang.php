<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanBarang extends Model
{
    protected $fillable = ['nama_barang', 'user_id', 'jumlah', 'deskripsi', 'status', 'stok'];
}
