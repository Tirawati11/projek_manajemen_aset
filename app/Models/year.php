<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasMany;
use app\Models\Aset;

class year extends Model
{
    protected $fillable = ['tahun'];

    // Relasi One To Many
    public function aset()
    {
        return $this->hasMany(Aset::class);
    }

}
