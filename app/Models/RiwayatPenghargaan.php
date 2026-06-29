<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatPenghargaan extends Model
{
    protected $guarded = [];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}
