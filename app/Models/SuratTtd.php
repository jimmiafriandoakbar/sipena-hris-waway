<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratTtd extends Model
{
    protected $table = 'surat_ttd';

    protected $fillable = [

        'surat_id',
        'pegawai_id',
        'urutan',
        'status',
        'tanggal_ttd',
        'catatan'

    ];

    public function surat()
    {
        return $this->belongsTo(Surat::class, 'surat_id');
    }

    public function pegawai()
{
    return $this->belongsTo(
        Pegawai::class,
        'pegawai_id'
    );
}
}