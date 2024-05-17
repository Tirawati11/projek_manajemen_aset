<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Year;
use App\Models\Code;

class Aset extends Model
{
    use HasFactory;

    protected $fillable = ['gambar', 'code_id', 'nama_barang', 'merek', 'jumlah', 'status', 'year_id', 'deskripsi', 'lokasi', 'kondisi'];

    // Relasi Many-to-One dengan Year
    public function years()
    {
        return $this->belongsTo(Year::class, 'year_id');
    }

    // Relasi Many-to-One dengan Code
    public function codes()
    {
        return $this->belongsTo(Code::class, 'code_id');
    }
}
