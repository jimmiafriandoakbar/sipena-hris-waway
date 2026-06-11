<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbsensiSetting extends Model
{
   protected $fillable = [
        'jam_masuk',
        'jam_pulang',
        'jam_mulai_lembur',
        'toleransi_terlambat',
        'radius_absensi',
        'latitude_kantor',
        'longitude_kantor',
        'hari_kerja',
        'wajib_foto',
        'wajib_lokasi',
    ];

    protected $casts = [
        'hari_kerja' => 'array',
        'wajib_foto' => 'boolean',
        'wajib_lokasi' => 'boolean',
    ];
}