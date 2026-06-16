@extends('layouts.pegawai.app')

@section('content')

@php
    $gajiPokok = $payroll->gaji_pokok ?? 0;

    $totalTunjangan =
        ($payroll->tunjangan_teller ?? 0) +
        ($payroll->tunjangan_anak ?? 0) +
        ($payroll->tunjangan_istri ?? 0) +
        ($payroll->tunjangan_kemahalan ?? 0) +
        ($payroll->tunjangan_lain_lain ?? 0);

    $totalPotongan =
        ($payroll->koperasi ?? 0) +
        ($payroll->koperasi_pinjaman ?? 0) +
        ($payroll->infaq ?? 0) +
        ($payroll->bpjs_kesehatan ?? 0) +
        ($payroll->tabungan_pensiun ?? 0) +
        ($payroll->bpjs_ketenagakerjaan ?? 0) +
        ($payroll->pinjaman_pegawai ?? 0) +
        ($payroll->potongan_lain_lain ?? 0);

    $totalDiterima = $gajiPokok + $totalTunjangan - $totalPotongan;

    function rupiah($angka) {
        return 'Rp ' . number_format($angka ?? 0, 0, ',', '.');
    }
@endphp

<div class="p-3">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">
            Detail Gaji Pegawai
        </h1>
        <p class="text-slate-500 mt-1">
            Informasi rincian gaji dan tunjangan pegawai
        </p>
    </div>

    <div class="bg-gradient-to-r from-slate-800 to-slate-900 rounded-3xl p-8 text-white shadow-xl mb-8">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-slate-300 text-sm">
                    Total Gaji Diterima
                </p>

                <h2 class="text-4xl font-bold mt-2">
                    {{ rupiah($totalDiterima) }}
                </h2>
            </div>

            <div class="w-20 h-20 rounded-3xl bg-white/10 flex items-center justify-center">
                <i data-lucide="wallet" class="w-10 h-10"></i>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <div class="bg-white rounded-3xl shadow-sm border p-6">
            <h2 class="text-lg font-bold text-slate-800 mb-5">
                Gaji Pokok
            </h2>

            <div class="space-y-4">

                <div class="flex items-center justify-between border-b pb-3">
                    <span class="text-slate-600">Nama Pegawai</span>
                    <span class="font-semibold">{{ $pegawai->nama ?? '-' }}</span>
                </div>

                <div class="flex items-center justify-between border-b pb-3">
                    <span class="text-slate-600">Gaji Pokok</span>
                    <span class="font-semibold">{{ rupiah($payroll->gaji_pokok ?? 0) }}</span>
                </div>

                <div class="flex items-center justify-between">
                    <span class="text-slate-600">Jumlah Anak</span>
                    <span class="font-semibold">{{ $payroll->jumlah_anak ?? 0 }}</span>
                </div>

            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border p-6">
            <h2 class="text-lg font-bold text-slate-800 mb-5">
                Rincian Tunjangan
            </h2>

            <div class="space-y-4">

                <div class="flex items-center justify-between border-b pb-3">
                    <span>Tunjangan Teller</span>
                    <span class="font-semibold">{{ rupiah($payroll->tunjangan_teller ?? 0) }}</span>
                </div>

                <div class="flex items-center justify-between border-b pb-3">
                    <span>Tunjangan Anak</span>
                    <span class="font-semibold">{{ rupiah($payroll->tunjangan_anak ?? 0) }}</span>
                </div>

                <div class="flex items-center justify-between border-b pb-3">
                    <span>Tunjangan Istri</span>
                    <span class="font-semibold">{{ rupiah($payroll->tunjangan_istri ?? 0) }}</span>
                </div>

                <div class="flex items-center justify-between border-b pb-3">
                    <span>Tunjangan Kemahalan</span>
                    <span class="font-semibold">{{ rupiah($payroll->tunjangan_kemahalan ?? 0) }}</span>
                </div>

                <div class="flex items-center justify-between border-b pb-3">
                    <span>Tunjangan Lain-lain</span>
                    <span class="font-semibold">{{ rupiah($payroll->tunjangan_lain_lain ?? 0) }}</span>
                </div>

                <div class="flex items-center justify-between">
                    <span class="font-semibold">Total Tunjangan</span>
                    <span class="font-bold text-emerald-600">
                        {{ rupiah($totalTunjangan) }}
                    </span>
                </div>

            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border p-6 lg:col-span-2">
            <h2 class="text-lg font-bold text-slate-800 mb-5">
                Rincian Kewajiban Pegawai
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <div class="flex items-center justify-between border rounded-2xl p-4">
                    <span>Koperasi</span>
                    <span class="font-semibold text-red-600">{{ rupiah($payroll->koperasi ?? 0) }}</span>
                </div>

                <div class="flex items-center justify-between border rounded-2xl p-4">
                    <span>Koperasi Pinjaman</span>
                    <span class="font-semibold text-red-600">{{ rupiah($payroll->koperasi_pinjaman ?? 0) }}</span>
                </div>

                <div class="flex items-center justify-between border rounded-2xl p-4">
                    <span>Infaq</span>
                    <span class="font-semibold text-red-600">{{ rupiah($payroll->infaq ?? 0) }}</span>
                </div>

                <div class="flex items-center justify-between border rounded-2xl p-4">
                    <span>BPJS Kesehatan</span>
                    <span class="font-semibold text-red-600">{{ rupiah($payroll->bpjs_kesehatan ?? 0) }}</span>
                </div>

                <div class="flex items-center justify-between border rounded-2xl p-4">
                    <span>Tabungan Pensiun</span>
                    <span class="font-semibold text-red-600">{{ rupiah($payroll->tabungan_pensiun ?? 0) }}</span>
                </div>

                <div class="flex items-center justify-between border rounded-2xl p-4">
                    <span>BPJS Ketenagakerjaan</span>
                    <span class="font-semibold text-red-600">{{ rupiah($payroll->bpjs_ketenagakerjaan ?? 0) }}</span>
                </div>

                <div class="flex items-center justify-between border rounded-2xl p-4">
                    <span>Pinjaman Pegawai</span>
                    <span class="font-semibold text-red-600">{{ rupiah($payroll->pinjaman_pegawai ?? 0) }}</span>
                </div>

                <div class="flex items-center justify-between border rounded-2xl p-4">
                    <span>Potongan Lain-lain</span>
                    <span class="font-semibold text-red-600">{{ rupiah($payroll->potongan_lain_lain ?? 0) }}</span>
                </div>

                <div class="flex items-center justify-between border-2 border-red-200 bg-red-50 rounded-2xl p-4 md:col-span-2">
                    <span class="font-semibold">Total Potongan</span>
                    <span class="font-bold text-red-600">
                        {{ rupiah($totalPotongan) }}
                    </span>
                </div>

            </div>
        </div>

    </div>

</div>

@endsection