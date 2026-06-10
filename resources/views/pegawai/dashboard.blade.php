@extends('layouts.pegawai.app')

@section('content')

@php

$totalMasuk = $suratMasuk->count();
$totalKeluar = $suratKeluar->count();
$totalApproval = $approval->count();
$totalSemua = $totalMasuk + $totalKeluar;

@endphp

<!-- HEADER -->
<div class="mb-8">

    <h1 class="text-2xl font-bold text-slate-800">
        Dashboard Pegawai
    </h1>

    <p class="text-sm text-slate-500 mt-1">
        Kelola surat masuk dan keluar dengan mudah.
    </p>

</div>

<!-- CARD -->
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">

    <!-- SURAT MASUK -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">

        <div class="flex items-center justify-between">

            <div>

                <p class="text-slate-500 text-sm">
                    Surat Masuk
                </p>

                <h2 class="text-3xl font-bold text-slate-800 mt-2">

                    {{ $totalMasuk }}

                </h2>

            </div>

            <div class="w-14 h-14 rounded-2xl bg-blue-100
                flex items-center justify-center text-blue-600">

                <i data-lucide="inbox" class="w-7 h-7"></i>

            </div>

        </div>

    </div>

    <!-- SURAT KELUAR -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">

        <div class="flex items-center justify-between">

            <div>

                <p class="text-slate-500 text-sm">
                    Surat Keluar
                </p>

                <h2 class="text-3xl font-bold text-slate-800 mt-2">

                    {{ $totalKeluar }}

                </h2>

            </div>

            <div class="w-14 h-14 rounded-2xl bg-emerald-100
                flex items-center justify-center text-emerald-600">

                <i data-lucide="send" class="w-7 h-7"></i>

            </div>

        </div>

    </div>

    <!-- APPROVAL -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">

        <div class="flex items-center justify-between">

            <div>

                <p class="text-slate-500 text-sm">
                    Approval
                </p>

                <h2 class="text-3xl font-bold text-slate-800 mt-2">

                    {{ $totalApproval }}

                </h2>

            </div>

            <div class="w-14 h-14 rounded-2xl bg-yellow-100
                flex items-center justify-center text-yellow-600">

                <i data-lucide="signature" class="w-7 h-7"></i>

            </div>

        </div>

    </div>

    <!-- TOTAL -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">

        <div class="flex items-center justify-between">

            <div>

                <p class="text-slate-500 text-sm">
                    Total Surat
                </p>

                <h2 class="text-3xl font-bold text-slate-800 mt-2">

                    {{ $totalSemua }}

                </h2>

            </div>

            <div class="w-14 h-14 rounded-2xl bg-red-100
                flex items-center justify-center text-red-600">

                <i data-lucide="file-text" class="w-7 h-7"></i>

            </div>

        </div>

    </div>

</div>

<!-- TABEL -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

    <!-- HEADER -->
    <div class="p-6 border-b border-slate-200
        flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

        <div>

            <h2 class="text-xl font-bold text-slate-800">
                Surat Terbaru
            </h2>

            <p class="text-sm text-slate-500 mt-1">
                Daftar surat terbaru SIPENA
            </p>

        </div>

        <!-- SEARCH -->
        <div class="relative w-full lg:w-80">

            <input type="text" id="searchInput" placeholder="Cari surat..." class="w-full h-12 pl-11 pr-4 rounded-2xl
                border border-slate-300 bg-white text-sm
                shadow-sm focus:ring-4 focus:ring-blue-100
                focus:border-blue-500 transition">

            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">

                <i data-lucide="search" class="w-4 h-4"></i>

            </div>

        </div>

    </div>

    <!-- TABLE -->
    <div class="overflow-x-auto">

        <table class="w-full text-sm">

            <thead class="bg-slate-100 text-slate-600">

                <tr>

                    <th class="px-6 py-4 text-left font-semibold">
                        Nomor Surat
                    </th>

                    <th class="px-6 py-4 text-left font-semibold">
                        Tujuan
                    </th>

                    <th class="px-6 py-4 text-left font-semibold">
                        Perihal
                    </th>

                    <th class="px-6 py-4 text-left font-semibold">
                        Tanggal
                    </th>

                    <th class="px-6 py-4 text-left font-semibold">
                        Jenis
                    </th>

                    <th class="px-6 py-4 text-left font-semibold">
                        Status
                    </th>

                    <th class="px-6 py-4 text-center font-semibold">
                        Aksi
                    </th>

                </tr>

            </thead>

            <tbody id="tableBody">

                @forelse($suratTerbaru as $item)

                <tr class="border-b border-slate-100 hover:bg-slate-50 transition">

                    <!-- NOMOR -->
                    <td class="px-6 py-5 font-medium text-slate-700">

                        {{ $item->nomor_surat }}

                    </td>

                    <!-- Tujuan -->
                    <td class="px-6 py-5 text-slate-700">

                        <div class="flex flex-wrap gap-2">

                            @foreach($item->tujuan as $tujuan)

                            <span class="px-3 py-1 rounded-xl
                                        bg-blue-50 text-blue-700
                                        text-xs font-semibold">

                                {{ $tujuan->bagian->nama_bagian ?? '-' }}

                            </span>

                            @endforeach

                        </div>

                    </td>

                    <!-- PERIHAL -->
                    <td class="px-6 py-5 text-slate-700">

                        {{ $item->perihal }}

                    </td>

                    <!-- TANGGAL -->
                    <td class="px-6 py-5 text-slate-500">

                        {{ \Carbon\Carbon::parse($item->tanggal_surat)->format('d M Y') }}

                    </td>

                    <!-- JENIS -->
                    <td class="px-6 py-5">

                        <span class="px-3 py-1 rounded-xl
                                bg-blue-50 text-blue-700 text-xs font-semibold">

                            {{ ucwords(str_replace('_', ' ', $item->jenis_surat)) }}

                        </span>

                    </td>

                    <!-- STATUS -->
                    <td class="px-6 py-5">

                        @if($item->status == 'disetujui')

                        <span class="px-3 py-1 rounded-xl
                                    bg-emerald-50 text-emerald-700
                                    text-xs font-semibold">

                            Disetujui

                        </span>

                        @elseif($item->status == 'pending')

                        <span class="px-3 py-1 rounded-xl
                                    bg-yellow-50 text-yellow-700
                                    text-xs font-semibold">

                            Pending

                        </span>

                        @else

                        <span class="px-3 py-1 rounded-xl
                                    bg-red-50 text-red-700
                                    text-xs font-semibold">

                            Ditolak

                        </span>

                        @endif

                    </td>

                    <!-- AKSI -->
                    <td class="px-6 py-5">

                        <div class="flex items-center justify-center gap-2">

                            {{-- JIKA FORM CUTI --}}
                            @if($item->jenis_surat == 'Form Cuti')

                            <!-- PREVIEW CUTI -->
                            <a href="{{ route('pegawai.preview.cuti', $item->cuti->id) }}" class="w-9 h-9 rounded-xl border border-slate-300
        flex items-center justify-center
        text-slate-600 hover:bg-slate-100 transition">

                                <i data-lucide="eye" class="w-4 h-4"></i>

                            </a>

                            <!-- PRINT CUTI -->
                            <a href="{{ route('pegawai.print.cuti', $item->cuti->id) }}" target="_blank" class="w-9 h-9 rounded-xl border border-slate-300
        flex items-center justify-center
        text-slate-600 hover:bg-slate-100 transition">

                                <i data-lucide="printer" class="w-4 h-4"></i>

                            </a>

                            @else

                            <!-- PREVIEW SURAT -->
                            <a href="{{ route('pegawai.surat.preview', $item->id) }}" class="w-9 h-9 rounded-xl border border-slate-300
        flex items-center justify-center
        text-slate-600 hover:bg-slate-100 transition">

                                <i data-lucide="eye" class="w-4 h-4"></i>

                            </a>

                            <!-- PRINT SURAT -->
                            <a href="{{ route('pegawai.surat.print', $item->id) }}" target="_blank" class="w-9 h-9 rounded-xl border border-slate-300
        flex items-center justify-center
        text-slate-600 hover:bg-slate-100 transition">

                                <i data-lucide="printer" class="w-4 h-4"></i>

                            </a>

                            @endif

                        </div>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="6" class="px-6 py-12 text-center text-slate-400">

                        Belum ada data surat

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

        <!-- PAGINATION -->
        <div class="p-6 border-t border-slate-200">

            <div class="flex items-center justify-end">

                {{ $suratTerbaru->links() }}

            </div>

        </div>

    </div>

</div>

<script>
    const searchInput =
        document.getElementById('searchInput');

    const rows =
        document.querySelectorAll('#tableBody tr');

    searchInput.addEventListener('keyup', function () {

        let keyword =
            this.value.toLowerCase();

        rows.forEach(row => {

            row.style.display =
                row.innerText.toLowerCase().includes(keyword) ?
                '' :
                'none';

        });

    });
</script>

@endsection