<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatHukuman extends Model
{
    protected $table = 'riwayat_hukumans';

    protected $guarded = [];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}