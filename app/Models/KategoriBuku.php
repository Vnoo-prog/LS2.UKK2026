<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriBuku extends Model
{
    protected $table = 'kategoribukus';
    protected $guarded = [];

    public function relasis()
    {
        return $this->hasMany(KategoriBukuRelasi::class, 'kategori_id');
    }
}
