<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Jabatan;
use App\Models\Bagian;
use App\Models\Payroll;

class Pegawai extends Model
{
    protected $table = 'pegawai';

    protected $fillable = [
    'user_id',
    'nama',
    'nip',
    'bagian_id',
    'jabatan_id',
    'no_hp',
    'email',
    'gaji_pokok',
    'tunjangan',
    'bonus',
    'potongan',
    'ttd',
    'pendidikan',
    'jurusan',
    'mulai_bekerja',
    'nomor_rekening'
];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bagianRelasi()
{
    return $this->belongsTo(
        Bagian::class,
        'bagian_id'
    );
}

public function jabatanRelasi()
{
    return $this->belongsTo(
        Jabatan::class,
        'jabatan_id'
    );
}

public function payroll()
{
    return $this->hasOne(Payroll::class);
}

public function absensis()
{
    return $this->hasMany(Absensi::class);
}

}