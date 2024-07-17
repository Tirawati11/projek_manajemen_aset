<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class PengajuanBarang extends Model
{
    use HasFactory;

    protected $fillable = ['nama_barang', 'nama_pemohon', 'jumlah', 'deskripsi', 'status', 'stok'];

    // Definisikan relasi dengan model User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // Sesuaikan dengan nama field yang tepat
    }
}
