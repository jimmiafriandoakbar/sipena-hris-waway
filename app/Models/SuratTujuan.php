<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratTujuan extends Model
{
    protected $table = 'surat_tujuan';

    protected $fillable = [
        'surat_id',
        'bagian_id'
    ];

    public function bagian()
{
    return $this->belongsTo(
        Bagian::class,
        'bagian_id'
    );
}
}