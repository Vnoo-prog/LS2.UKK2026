<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Kolom-kolom yang diizinkan untuk diisi secara massal (Mass Assignment)
     */
    protected $fillable = [
        'username',
        'password',
        'email',
        'nama_lengkap',
        'alamat',
        'role',
    ];

    /**
     * Kolom yang disembunyikan saat data dijadikan array/JSON
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Tipe data khusus untuk kolom tertentu
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            // 'password' => 'hashed', // <-- Sengaja dimatikan karena kita pakai Plain Text
        ];
    }
}