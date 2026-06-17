<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $fillable = [
        'pegawai_id',
        'tanggal',
        'nama_hari',

        'jam_masuk',
        'latitude_masuk',
        'longitude_masuk',
        'jarak_masuk',
        'valid_lokasi_masuk',
        'foto_masuk',

        'jam_pulang',
        'latitude_pulang',
        'longitude_pulang',
        'jarak_pulang',
        'valid_lokasi_pulang',
        'foto_pulang',

        'status_masuk',
        'status_pulang',

        'menit_terlambat',
        'menit_pulang_cepat',
        'total_menit_lembur',

        'ip_address',
        'device',
    ];
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

    public function absensis()
    {
        return $this->hasMany(Absensi::class);
    }
}