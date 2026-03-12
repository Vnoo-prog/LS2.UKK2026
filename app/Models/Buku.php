<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $guarded = [];
    public function kategoris() { return $this->belongsToMany(KategoriBuku::class, 'kategoribuku_relasis', 'buku_id', 'kategori_id'); }
    public function peminjamans() { return $this->hasMany(Peminjaman::class); }
    public function ulasans() { return $this->hasMany(UlasanBuku::class); }
}
