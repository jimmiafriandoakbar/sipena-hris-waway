<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cuti extends Model
{
    protected $table = 'cuti';

    protected $fillable = [

        'surat_id',
        'pegawai_id',
        'jenis_cuti',
        'mulai_cuti',
        'akhir_cuti',
        'tgl_masuk',
        'total_hari',
        'keterangan',
        'alamat',
        'nomor_hp',
        'user_cbs'

    ];

    public function surat()
    {
        return $this->belongsTo(
            Surat::class,
            'surat_id'
        );
    }

    public function approval()
    {
        return $this->hasMany(
            CutiApproval::class,
            'cuti_id'
        )->orderBy('urutan');
    }

    public function pegawai()
    {
        return $this->belongsTo(
            Pegawai::class,
            'pegawai_id'
        );
    }
}