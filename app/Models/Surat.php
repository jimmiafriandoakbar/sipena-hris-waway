<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    protected $table = 'surat';

    protected $fillable = [

        'user_id',
        'jenis_surat',
        'nomor_surat',
        'tanggal_surat',
        'perihal',
        'isi_surat',
        'dari',
        'file_pdf',
        'status',
    ];

    public function tujuan()
{
    return $this->hasMany(SuratTujuan::class);
}

public function ttd()
{
    return $this->hasMany(SuratTtd::class);
}

public function pegawai()
{
    return $this->belongsTo(
        Pegawai::class,
        'user_id',
        'user_id'
    );
}

public function lembur()
{
    return $this->hasOne(
        Lembur::class,
        'surat_id'
    );
}

public function cuti()
{
    return $this->hasOne(
        Cuti::class,
        'surat_id'
    );
}
}