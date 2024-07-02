<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Code;
use App\Models\Category;
use App\Models\Barang;

class Aset extends Model
{
    protected $fillable = ['gambar', 'kode', 'nama_barang', 'merek', 'jumlah', 'status', 'tanggal_masuk', 'deskripsi', 'lokasi', 'kondisi', 'category_id', 'harga'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function Barang()
    {
        return $this->belongsTo(Code::class);
    }
    public static function boot()
    {
        parent::boot();

        static::created(function ($aset) {
            // Simpan data ke tabel barang
            Barang::create([
                'nama_barang' => $aset->nama_barang,
                'jumlah' => $aset->jumlah
            ]);
        });

        static::deleted(function ($aset) {
            // Hapus data barang terkait
            Barang::where('nama_barang', $aset->nama_barang)->delete();
        });
    }
}
