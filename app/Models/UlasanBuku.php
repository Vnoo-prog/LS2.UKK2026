<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UlasanBuku extends Model
{
    protected $table = 'ulasanbukus';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }
}
