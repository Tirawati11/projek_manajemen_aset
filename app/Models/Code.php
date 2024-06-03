<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Aset;
use App\Models\Item;

class Code extends Model
{
   protected $fillable = ['kode', 'nama'];

    // Relasi One To Many
    public function aset()
    {
        return $this->hasMany(Aset::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
