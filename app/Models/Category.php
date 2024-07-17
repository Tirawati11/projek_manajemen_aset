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
        return $this->hasMany(Aset::class, 'category_id');
    }
    // Konfigurasi relasi
    public function delete()
    {
        // Check if the category has any related Aset records
        if ($this->aset()->count() > 0) {
            // Optionally, you can throw an exception or return a response here
            throw new \Exception('Category cannot be deleted because it is still related to assets.');
        }

        // If no related Aset records, proceed with deletion
        return parent::delete();
    }
}
