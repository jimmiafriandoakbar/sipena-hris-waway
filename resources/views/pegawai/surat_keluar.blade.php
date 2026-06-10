@extends('layouts.pegawai.app')

@section('content')

<div class="mb-6">

    <h1 class="text-2xl font-bold text-slate-800">
        Surat Keluar
    </h1>

    <p class="text-sm text-slate-500 mt-1">
        Daftar surat yang telah dibuat dan dikirim
    </p>

</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

    <!-- FILTER -->
    <div class="p-5 border-b border-slate-100">

        <form method="GET"
            class="flex flex-col xl:flex-row xl:items-center
            xl:justify-between gap-4">

            <!-- LEFT -->
            <div class="flex flex-col lg:flex-row gap-3 w-full">

                <!-- SEARCH -->
                <div class="relative w-full lg:w-80">

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nomor atau perihal..."
                        class="w-full h-11 pl-10 pr-4 rounded-xl
                        border border-slate-300 bg-white
                        text-sm focus:ring-4 focus:ring-blue-100
                        focus:border-blue-500 transition outline-none">

                    <div class="absolute left-3 top-1/2 -translate-y-1/2
                        text-slate-400">

                        <i data-lucide="search" class="w-4 h-4"></i>

                    </div>

                </div>

                <!-- START DATE -->
                <input
                    type="date"
                    name="start_date"
                    value="{{ request('start_date') }}"
                    class="h-11 px-4 rounded-xl border
                    border-slate-300 text-sm
                    focus:ring-4 focus:ring-blue-100
                    focus:border-blue-500 transition outline-none">

                <!-- END DATE -->
                <input
                    type="date"
                    name="end_date"
                    value="{{ request('end_date') }}"
                    class="h-11 px-4 rounded-xl border
                    border-slate-300 text-sm
                    focus:ring-4 focus:ring-blue-100
                    focus:border-blue-500 transition outline-none">

                <!-- FILTER JENIS -->
                <select
                    name="jenis"
                    class="h-11 px-4 rounded-xl border
                    border-slate-300 bg-white text-sm
                    focus:ring-4 focus:ring-blue-100
                    focus:border-blue-500 transition outline-none">

                    <option value="">
                        Semua Jenis
                    </option>

                    <option value="nota_dinas"
                        {{ request('jenis') == 'nota_dinas' ? 'selected' : '' }}>

                        Nota Dinas

                    </option>

                    <option value="berita_acara"
                        {{ request('jenis') == 'berita_acara' ? 'selected' : '' }}>

                        Berita Acara

                    </option>

                    <option value="risalah_rapat"
                        {{ request('jenis') == 'risalah_rapat' ? 'selected' : '' }}>

                        Risalah Rapat

                    </option>

                </select>

                <!-- BUTTON -->
                <button
                    type="submit"
                    class="h-11 px-5 rounded-xl bg-blue-600
                    hover:bg-blue-700 transition text-sm
                    font-medium text-white whitespace-nowrap">

                    Cari

                </button>

                <!-- RESET -->
                <a href="{{ route('pegawai.surat.keluar') }}"
                    class="h-11 px-5 rounded-xl border
                    border-slate-300 bg-white hover:bg-slate-50
                    transition text-sm font-medium text-slate-700
                    inline-flex items-center justify-center
                    whitespace-nowrap">

                    Reset

                </a>

            </div>

            <!-- RIGHT -->
            <div class="text-sm text-slate-500 whitespace-nowrap">

                Total

                <span class="font-semibold text-slate-700">

                    {{ $suratKeluar->total() }}

                </span>

                data

            </div>

        </form>

    </div>

    <!-- TABLE -->
    <div class="overflow-x-auto">

        <table class="w-full text-sm">

            <thead class="bg-slate-50 text-slate-500 text-xs uppercase">

                <tr>

                    <th class="px-5 py-4 text-left">
                        No
                    </th>

                    <th class="px-5 py-4 text-left">
                        Nomor
                    </th>

                    <th class="px-5 py-4 text-left">
                        Perihal
                    </th>

                    <th class="px-5 py-4 text-left">
                        Jenis
                    </th>

                    <th class="px-5 py-4 text-left">
                        Tanggal
                    </th>

                    <th class="px-5 py-4 text-left">
                        Tujuan
                    </th>

                    <th class="px-5 py-4 text-left">
                        Status
                    </th>

                    <th class="px-5 py-4 text-right">
                        Aksi
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($suratKeluar as $index => $item)

                <tr class="border-t border-slate-100
                    hover:bg-slate-50 transition">

                    <!-- NO -->
                    <td class="px-5 py-4">

                        {{ $suratKeluar->firstItem() + $index }}

                    </td>

                    <!-- NOMOR -->
                    <td class="px-5 py-4 text-slate-700">

                        {{ $item->nomor_surat }}

                    </td>

                    <!-- PERIHAL -->
                    <td class="px-5 py-4 text-slate-700">

                        {{ $item->perihal }}

                    </td>

                    <!-- JENIS -->
                    <td class="px-5 py-4">

                        <span class="bg-blue-50 text-blue-700
                            px-3 py-1 rounded-lg text-xs font-medium">

                            {{ ucwords(str_replace('_', ' ', $item->jenis_surat)) }}

                        </span>

                    </td>

                    <!-- TANGGAL -->
                    <td class="px-5 py-4 text-slate-700">

                        {{ \Carbon\Carbon::parse($item->tanggal_surat)->format('d M Y') }}

                    </td>

                    <!-- TUJUAN -->
                    <td class="px-5 py-4 text-slate-700">

                        @foreach($item->tujuan as $tujuan)

                            <span class="inline-block bg-slate-100
                                text-slate-700 px-2 py-1 rounded-md
                                text-xs mr-1 mb-1">

                                {{ $tujuan->bagian->kode_bagian ?? '-' }}

                            </span>

                        @endforeach

                    </td>

                    <!-- STATUS -->
                    <td class="px-5 py-4">

                        @if($item->status == 'disetujui')

                            <span class="bg-emerald-50 text-emerald-700
                                px-3 py-1 rounded-lg text-xs font-medium">

                                Terkirim

                            </span>

                        @elseif($item->status == 'pending')

                            <span class="bg-yellow-50 text-yellow-700
                                px-3 py-1 rounded-lg text-xs font-medium">

                                Menunggu TTD

                            </span>

                        @else

                            <span class="bg-red-50 text-red-700
                                px-3 py-1 rounded-lg text-xs font-medium">

                                Ditolak

                            </span>

                        @endif

                    </td>

                    <!-- AKSI -->
                    <td class="px-5 py-4">

                        <div class="flex justify-end gap-2">

                            <!-- PREVIEW -->
                            <a href="{{ route('pegawai.surat.preview', $item->id) }}"
                                class="h-9 px-4 rounded-lg border border-slate-300
                                hover:bg-slate-50 transition text-xs
                                font-medium inline-flex items-center">

                                Preview

                            </a>

                            <!-- PRINT -->
                            <a href="{{ route('pegawai.surat.print', $item->id) }}"
                                target="_blank"
                                class="h-9 px-4 rounded-lg border border-slate-300
                                hover:bg-slate-50 transition text-xs
                                font-medium inline-flex items-center">

                                Print

                            </a>

                        </div>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="8"
                        class="px-5 py-10 text-center
                        text-sm text-slate-500">

                        Belum ada surat keluar

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <!-- PAGINATION -->
    <div class="flex flex-col md:flex-row
        items-center justify-between gap-4
        p-5 border-t border-slate-100">

        <p class="text-sm text-slate-500">

            Menampilkan

            <span class="font-semibold text-slate-700">
                {{ $suratKeluar->firstItem() ?? 0 }}
            </span>

            -

            <span class="font-semibold text-slate-700">
                {{ $suratKeluar->lastItem() ?? 0 }}
            </span>

            dari

            <span class="font-semibold text-slate-700">
                {{ $suratKeluar->total() }}
            </span>

            data

        </p>

        <div class="flex items-center gap-2">

            {{ $suratKeluar->links() }}

        </div>

    </div>

</div>

@endsection