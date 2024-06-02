<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Location;
use App\Models\Barang;

class PeminjamanBarang extends Model
{
   protected $fillable = ['nama_barang_id', 'nama', 'location_id', 'jumlah', 'tanggal_peminjaman', 'tanggal_pengembalian', 'status'];

   public function location()
    {
        return $this->belongsTo(Location::class);
    }
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'nama_barang_id');
    }
}
