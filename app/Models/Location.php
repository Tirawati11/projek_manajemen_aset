<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PeminjamanBarang;

class Location extends Model
{
   protected $fillable = ['name'];

   public function peminjamanBarangs()
   {
       return $this->hasMany(PeminjamanBarang::class);
   }
}
