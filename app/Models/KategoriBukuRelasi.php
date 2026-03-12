<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriBukuRelasi extends Model
{
    protected $table = 'kategoribuku_relasis';
    protected $guarded = [];

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }
    public function kategori()
    {
        return $this->belongsTo(KategoriBuku::class, 'kategori_id');
    }
}
