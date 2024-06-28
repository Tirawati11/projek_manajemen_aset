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
//    lokasi tidak terhapus ketika berelasi
public static function boot(){
    parent::boot();

        static::deleting(function ($location) {
            if ($location->peminjamanBarangs()->count() > 0) {
                throw new \Exception('Location cannot be deleted because it is being used in peminjaman barangs.');
            }
        });
}
}
