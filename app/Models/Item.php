<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Code;

class Item extends Model
{
    protected $fillable= ['nama_barang'];

    public function code()
    {
        return $this->belongsTo(Code::class);
    }
}
