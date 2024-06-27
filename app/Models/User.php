<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\PengajuanBarang;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_user',
        'email',
        'password',
        'jabatan',
        'approved',
        'last_login_at'
    ];
    protected $dates = [
        'last_login_at',
    ];
// Relasi Pengajuan Barang
    public function pengajuanBarang()
    {
        return $this->hasMany(PengajuanBarang::class, 'user_id');
    }
    // Relasi Peminjaman Barang
    public function peminjamanBarang()
    {
        return $this->hasMany(PeminjamanBarang::class, 'user_id');
    }
    }

