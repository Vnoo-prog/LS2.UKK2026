<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    // 1. INI KUNCI FIX-NYA: Beri tahu Laravel nama tabel yang benar
    protected $table = 'peminjamans';

    // 2. Mengizinkan semua kolom diisi (mass assignment)
    protected $guarded = [];

    // 3. Relasi ke tabel User (Setiap peminjaman milik 1 User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 4. Relasi ke tabel Buku (Setiap peminjaman meminjam 1 Buku)
    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }
}