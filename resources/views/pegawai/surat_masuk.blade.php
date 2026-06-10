@extends('layouts.pegawai.app')

@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Surat Masuk</h1>
    <p class="text-sm text-slate-500 mt-1">Daftar surat yang masuk dan perlu diproses</p>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

    <!-- FILTER -->
    <div class="p-5 border-b border-slate-100">

        <form method="GET" class="flex flex-col lg:flex-row lg:items-center
            lg:justify-between gap-4">

            <!-- LEFT -->
            <div class="flex flex-col md:flex-row gap-3 w-full">

                <!-- SEARCH -->
                <div class="relative w-full md:w-80">

                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari nomor atau perihal..." class="w-full h-11 pl-10 pr-4 rounded-xl
                        border border-slate-300 bg-white
                        text-sm focus:ring-4 focus:ring-blue-100
                        focus:border-blue-500 transition outline-none">

                    <div class="absolute left-3 top-1/2 -translate-y-1/2
                        text-slate-400">

                        <i data-lucide="search" class="w-4 h-4"></i>

                    </div>

                </div>

                <!-- FILTER JENIS -->
                <select name="jenis" class="h-11 px-4 rounded-xl border
                    border-slate-300 bg-white text-sm
                    focus:ring-4 focus:ring-blue-100
                    focus:border-blue-500 transition outline-none">

                    <option value="">
                        Semua Jenis
                    </option>

                    <option value="nota_dinas" {{ request('jenis') == 'nota_dinas' ? 'selected' : '' }}>

                        Nota Dinas

                    </option>

                    <option value="berita_acara" {{ request('jenis') == 'berita_acara' ? 'selected' : '' }}>

                        Berita Acara

                    </option>

                    <option value="risalah_rapat" {{ request('jenis') == 'risalah_rapat' ? 'selected' : '' }}>

                        Risalah Rapat

                    </option>

                </select>

                <!-- BUTTON CARI -->
                <button type="submit" class="h-11 px-5 rounded-xl bg-blue-600
                    hover:bg-blue-700 transition text-sm
                    font-medium text-white whitespace-nowrap">

                    Cari

                </button>

                <!-- RESET -->
                <a href="{{ route('pegawai.surat.masuk') }}" class="h-11 px-5 rounded-xl border
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

                    {{ $suratMasuk->total() }}

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
                    <th class="px-5 py-3 text-left">No</th>
                    <th>Nomor</th>
                    <th>Perihal</th>
                    <th>Jenis</th>
                    <th>Tanggal</th>
                    <th>Bagian</th>
                    <th>Status</th>
                    <th class="text-right pr-5">Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($suratMasuk as $index => $item)

                <tr class="border-t border-slate-100
    hover:bg-slate-50 transition">

                    <!-- NO -->
                    <td class="px-5 py-4">

                        {{ $suratMasuk->firstItem() + $index }}

                    </td>

                    <!-- NOMOR -->
                    <td class="px-5 py-4 text-sm text-slate-700">

                        {{ $item->surat->nomor_surat }}

                    </td>

                    <!-- PERIHAL -->
                    <td class="px-5 py-4 text-sm text-slate-700">

                        {{ $item->surat->perihal }}

                    </td>

                    <!-- JENIS -->
                    <td class="px-5 py-4">

                        <span class="bg-blue-50 text-blue-700
                px-3 py-1 rounded-lg text-xs font-medium">

                            {{ ucwords(str_replace('_', ' ', $item->surat->jenis_surat)) }}

                        </span>

                    </td>

                    <!-- TANGGAL -->
                    <td class="px-5 py-4 text-sm text-slate-700">

                        {{ \Carbon\Carbon::parse($item->surat->tanggal_surat)->format('d M Y') }}

                    </td>

                    <!-- BAGIAN -->
                    <td class="px-5 py-4">

                        <span class="bg-slate-100 text-slate-700
                px-3 py-1 rounded-lg text-xs font-medium">

                            {{ $item->bagian->nama_bagian ?? '-' }}

                        </span>

                    </td>

                    <!-- STATUS -->
                    <td class="px-5 py-4">

                        @if($item->dibaca)

                        <span class="bg-emerald-50 text-emerald-700
                    px-3 py-1 rounded-lg text-xs font-medium">

                            Dibaca

                        </span>

                        @else

                        <span class="bg-yellow-50 text-yellow-700
                    px-3 py-1 rounded-lg text-xs font-medium">

                            Belum Dibaca

                        </span>

                        @endif

                    </td>

                    <!-- AKSI -->
                    <td class="px-5 py-4">

                        <div class="flex justify-end gap-2">

                            <!-- PREVIEW -->
                            <a href="{{ route('pegawai.surat.preview', $item->surat->id) }}" class="h-9 px-4 rounded-lg border border-slate-300
hover:bg-slate-50 transition text-xs
font-medium inline-flex items-center">

                                Preview

                            </a>

                            <!-- PRINT -->
                            <a href="{{ route('pegawai.surat.print', $item->surat->id) }}" target="_blank" class="h-9 px-4 rounded-lg border border-slate-300
hover:bg-slate-50 transition text-xs
font-medium inline-flex items-center">

                                Print

                            </a>

                        </div>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="8" class="px-5 py-10 text-center text-sm text-slate-500">

                        Belum ada surat masuk

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>
    </div>

    <!-- PAGINATION -->
    <div class="flex flex-col md:flex-row
    items-center justify-between gap-4
    p-5 border-t">

        <p class="text-sm text-slate-500">

            Menampilkan

            <span class="font-semibold text-slate-700">
                {{ $suratMasuk->firstItem() ?? 0 }}
            </span>

            -

            <span class="font-semibold text-slate-700">
                {{ $suratMasuk->lastItem() ?? 0 }}
            </span>

            dari

            <span class="font-semibold text-slate-700">
                {{ $suratMasuk->total() }}
            </span>

            data

        </p>

        <div class="flex items-center gap-2">

            {{ $suratMasuk->links() }}

        </div>

    </div>

</div>

@endsection
