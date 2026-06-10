<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lembur extends Model
{
    protected $table = 'lembur';

    protected $fillable = [

        'surat_id',
        'pegawai_id',
        'pekerjaan',
        'area',
        'tanggal_lembur',
        'jam_lembur',
        'jumlah_tenaga',
        'pegawai_lembur'

    ];

    public function surat()
    {
        return $this->belongsTo(
            Surat::class,
            'surat_id'
        );
    }

    public function pengaju()
    {
        return $this->belongsTo(
            Pegawai::class,
            'pegawai_id'
        );
    }
}