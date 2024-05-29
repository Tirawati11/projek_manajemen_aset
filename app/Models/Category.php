<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Aset;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function aset()
    {
        return $this->hasMany(Aset::class);
    }
}
