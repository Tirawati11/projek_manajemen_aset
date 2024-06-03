<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Code;
use App\Models\Category;
use App\Models\Barang;

class Aset extends Model
{
    protected $fillable = ['gambar', 'kode', 'nama_barang', 'merek', 'jumlah', 'status', 'tanggal_masuk', 'deskripsi', 'lokasi', 'kondisi', 'category_id'];


    // Relasi Many-to-One dengan Code
    // public function codes()
    // {
    //     return $this->belongsTo(Code::class, 'code_id');
    // }
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
            // tambahkan kolom lainnya sesuai kebutuhan
            ]);
        });
    }
}

