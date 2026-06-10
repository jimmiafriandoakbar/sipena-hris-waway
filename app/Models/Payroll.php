<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $fillable = [
        'pegawai_id',
        'gaji_pokok',
        'tunjangan_teller',
        'tunjangan_anak',
        'jumlah_anak',
        'tunjangan_istri',
        'tunjangan_kemahalan',
        'tunjangan_lain_lain',
        'koperasi',
        'koperasi_pinjaman',
        'infaq',
        'bpjs_kesehatan',
        'bpjs_ketenagakerjaan',
        'tabungan_pensiun',
        'pinjaman_pegawai',
        'potongan_lain_lain',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}