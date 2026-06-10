<?php

namespace App\Exports;

use App\Models\Pegawai;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GajiExport implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return [
            'No',
            'Nama Pegawai',
            'Jabatan',
            'Nomor Rekening',
            'Gaji Pokok',
            'Tunjangan Teller',
            'Tunjangan Anak',
            'Jumlah Anak',
            'Tunjangan Istri',
            'Tunjangan Kemahalan',
            'Tunjangan Lain-lain',
            'Koperasi',
            'Koperasi Pinjaman',
            'Infaq',
            'BPJS Kesehatan',
            'Tabungan Pensiun',
            'BPJS Ketenagakerjaan',
            'Pinjaman Pegawai',
            'Potongan Lain-lain',
        ];
    }

    public function collection()
    {
        $pegawai = Pegawai::with([
            'jabatanRelasi',
            'payroll'
        ])->get();

        $rows = collect();

        foreach ($pegawai as $index => $item) {

            $payroll = $item->payroll;

            $rows->push([

                $index + 1,

                $item->nama,

                $item->jabatanRelasi->nama_jabatan ?? '-',

                $item->nomor_rekening,

                $payroll->gaji_pokok ?? 0,

                $payroll->tunjangan_teller ?? 0,

                $payroll->tunjangan_anak ?? 0,

                $payroll->jumlah_anak ?? 0,

                $payroll->tunjangan_istri ?? 0,

                $payroll->tunjangan_kemahalan ?? 0,

                $payroll->tunjangan_lain_lain ?? 0,

                $payroll->koperasi ?? 0,

                $payroll->koperasi_pinjaman ?? 0,

                $payroll->infaq ?? 0,

                $payroll->bpjs_kesehatan ?? 0,

                $payroll->tabungan_pensiun ?? 0,

                $payroll->bpjs_ketenagakerjaan ?? 0,

                $payroll->pinjaman_pegawai ?? 0,

                $payroll->potongan_lain_lain ?? 0,

            ]);
        }

        $rows->push([
            '',
            'TOTAL KESELURUHAN',
            '',
            '',

            $pegawai->sum(fn($p) => $p->payroll->gaji_pokok ?? 0),

            $pegawai->sum(fn($p) => $p->payroll->tunjangan_teller ?? 0),

            $pegawai->sum(fn($p) => $p->payroll->tunjangan_anak ?? 0),

            $pegawai->sum(fn($p) => $p->payroll->jumlah_anak ?? 0),

            $pegawai->sum(fn($p) => $p->payroll->tunjangan_istri ?? 0),

            $pegawai->sum(fn($p) => $p->payroll->tunjangan_kemahalan ?? 0),

            $pegawai->sum(fn($p) => $p->payroll->tunjangan_lain_lain ?? 0),

            $pegawai->sum(fn($p) => $p->payroll->koperasi ?? 0),

            $pegawai->sum(fn($p) => $p->payroll->koperasi_pinjaman ?? 0),

            $pegawai->sum(fn($p) => $p->payroll->infaq ?? 0),

            $pegawai->sum(fn($p) => $p->payroll->bpjs_kesehatan ?? 0),

            $pegawai->sum(fn($p) => $p->payroll->tabungan_pensiun ?? 0),

            $pegawai->sum(fn($p) => $p->payroll->bpjs_ketenagakerjaan ?? 0),

            $pegawai->sum(fn($p) => $p->payroll->pinjaman_pegawai ?? 0),

            $pegawai->sum(fn($p) => $p->payroll->potongan_lain_lain ?? 0),
        ]);

        return $rows;
    }
}