<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CutiApproval extends Model
{
    protected $table = 'cuti_approval';

    protected $fillable = [

        'cuti_id',
        'pegawai_id',
        'urutan',
        'role_approval',
        'status',
        'catatan',
        'tanggal_approval',

        'cuti_efektif',
        'sampai_dengan',
        'petugas_pengganti',

        'hak_hari_cuti',
        'telah_dijalani',
        'izin_potong_cuti',
        'sisa_hari_cuti',
        'sisa_setelah_cuti',

        'jumlah_hari'
    ];

    public function pegawai()
    {
        return $this->belongsTo(
            Pegawai::class,
            'pegawai_id'
        );
    }

    public function cuti()
    {
        return $this->belongsTo(
            Cuti::class,
            'cuti_id'
        );
    }
}