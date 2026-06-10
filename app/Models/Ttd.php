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
}