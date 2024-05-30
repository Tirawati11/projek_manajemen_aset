<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Code;
use App\Models\Category;

class Aset extends Model
{
    use HasFactory;

    protected $fillable = ['gambar', 'code_id', 'nama_barang', 'merek', 'jumlah', 'status', 'tanggal_masuk', 'deskripsi', 'lokasi', 'kondisi', 'category_id'];


    // Relasi Many-to-One dengan Code
    public function codes()
    {
        return $this->belongsTo(Code::class, 'code_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
