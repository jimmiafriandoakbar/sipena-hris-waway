<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    protected $table = 'surat_masuk';

    protected $fillable = [

        'surat_id',
        'bagian_id',
        'dibaca',
        'catatan',
        'dari_pegawai_id',
        'is_disposisi'

    ];

    public function surat()
    {
        return $this->belongsTo(
            Surat::class,
            'surat_id'
        );
    }

    public function bagian()
    {
        return $this->belongsTo(
            Bagian::class,
            'bagian_id'
        );
    }

    public function dariPegawai()
{
    return $this->belongsTo(
        Pegawai::class,
        'dari_pegawai_id'
    );
}
}