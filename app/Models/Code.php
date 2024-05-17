<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use app\Models\Aset;

class Code extends Model
{
   protected $fillable = ['kode'];

    // Relasi One To Many
    public function aset()
    {
        return $this->hasMany(Aset::class);
    }
}
