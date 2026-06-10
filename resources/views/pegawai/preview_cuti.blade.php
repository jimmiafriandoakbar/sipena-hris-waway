@extends('layouts.pegawai.app')

@section('content')

<div class="max-w-6xl mx-auto">

    <!-- HEADER -->
    <div class="flex items-center justify-between mb-8">

        <div>

            <h1 class="text-3xl font-bold text-slate-800">

                Preview Cuti

            </h1>

            <p class="text-slate-500 mt-2">

                Detail pengajuan cuti pegawai

            </p>

        </div>

        <div class="flex gap-3">

            <a href="{{ route('pegawai.print.cuti', $cuti->id) }}" target="_blank" class="px-5 py-3 rounded-2xl
                bg-blue-600 text-white
                hover:bg-blue-700 transition">

                Print

            </a>

            <a href="{{ route('pegawai.list.cuti') }}" class="px-5 py-3 rounded-2xl
                border border-slate-300
                hover:bg-slate-100 transition">

                Kembali

            </a>

        </div>

    </div>

    <!-- CARD -->
    <div class="bg-white rounded-3xl border
        border-slate-200 shadow-sm overflow-hidden">

        <!-- HEADER SURAT -->
        <div class="p-8 border-b border-slate-100">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div>

                    <p class="text-sm text-slate-500">
                        Nomor Surat
                    </p>

                    <h3 class="font-semibold text-slate-800 mt-1">

                        {{ $cuti->surat->nomor_surat ?? '-' }}

                    </h3>

                </div>

                <div>

                    <p class="text-sm text-slate-500">
                        Tanggal Surat
                    </p>

                    <h3 class="font-semibold text-slate-800 mt-1">

                        {{ $cuti->surat->tanggal_surat ?? '-' }}

                    </h3>

                </div>

                <div>

                    <p class="text-sm text-slate-500">
                        Status
                    </p>

                    <h3 class="mt-1">

                        @if($cuti->surat->status == 'disetujui')

                        <span class="px-3 py-1 rounded-full
                            bg-emerald-100 text-emerald-700
                            text-xs font-semibold">

                            Disetujui

                        </span>

                        @elseif($cuti->surat->status == 'ditolak')

                        <span class="px-3 py-1 rounded-full
                            bg-red-100 text-red-700
                            text-xs font-semibold">

                            Ditolak

                        </span>

                        @else

                        <span class="px-3 py-1 rounded-full
                            bg-yellow-100 text-yellow-700
                            text-xs font-semibold">

                            {{ $cuti->surat->status }}

                        </span>

                        @endif

                    </h3>

                </div>

            </div>

        </div>

        <!-- DATA PEGAWAI -->
        <div class="p-8 border-b border-slate-100">

            <h2 class="text-xl font-bold text-slate-800 mb-6">

                Informasi Pegawai

            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>

                    <label class="text-sm text-slate-500">

                        Nama Pegawai

                    </label>

                    <div class="mt-2 p-4 rounded-2xl
                        bg-slate-50 border">

                        {{ $cuti->pegawai->nama ?? '-' }}

                    </div>

                </div>

                <div>

                    <label class="text-sm text-slate-500">

                        Jabatan

                    </label>

                    <div class="mt-2 p-4 rounded-2xl
                        bg-slate-50 border">

                        {{ $cuti->pegawai->jabatanRelasi->nama_jabatan ?? '-' }}

                    </div>

                </div>

                <div>

                    <label class="text-sm text-slate-500">

                        Bagian

                    </label>

                    <div class="mt-2 p-4 rounded-2xl
                        bg-slate-50 border">

                        {{ $cuti->pegawai->bagianRelasi->nama_bagian ?? '-' }}

                    </div>

                </div>

                <div>

                    <label class="text-sm text-slate-500">

                        Jenis Cuti

                    </label>

                    <div class="mt-2 p-4 rounded-2xl
                        bg-slate-50 border">

                        {{ $cuti->jenis_cuti ?? '-' }}

                    </div>

                </div>

            </div>

        </div>

        <!-- DATA CUTI -->
        <div class="p-8 border-b border-slate-100">

            <h2 class="text-xl font-bold text-slate-800 mb-6">
                Detail Cuti
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div>
                    <label class="text-sm text-slate-500">
                        Mulai Cuti
                    </label>

                    <div class="mt-2 p-4 rounded-2xl bg-slate-50 border">
                        {{ $cuti->mulai_cuti 
                        ? \Carbon\Carbon::parse($cuti->mulai_cuti)->translatedFormat('l, d F Y'): '-' }}
                    </div>
                </div>

                <div>
                    <label class="text-sm text-slate-500">
                        Akhir Cuti
                    </label>

                    <div class="mt-2 p-4 rounded-2xl bg-slate-50 border">
                        {{ $cuti->akhir_cuti
                        ? \Carbon\Carbon::parse($cuti->akhir_cuti)->translatedFormat('l, d F Y'): '-'}}
                    </div>
                </div>

                <div>
                    <label class="text-sm text-slate-500">
                        Tanggal Masuk
                    </label>

                    <div class="mt-2 p-4 rounded-2xl bg-slate-50 border">
                        {{ $cuti->tgl_masuk
                        ? \Carbon\Carbon::parse($cuti->tgl_masuk)->translatedFormat('l, d F Y'): '-'}}
                    </div>
                </div>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">

                <div>
                    <label class="text-sm text-slate-500">
                        Total Hari
                    </label>

                    <div class="mt-2 p-4 rounded-2xl bg-slate-50 border">
                        {{ $cuti->total_hari ?? '-' }} Hari
                    </div>
                </div>

                <div>
                    <label class="text-sm text-slate-500">
                        Nomor HP
                    </label>

                    <div class="mt-2 p-4 rounded-2xl bg-slate-50 border">
                        {{ $cuti->nomor_hp ?? '-' }}
                    </div>
                </div>

            </div>

            <div class="mt-6">

                <label class="text-sm text-slate-500">
                    Alamat Selama Cuti
                </label>

                <div class="mt-2 p-4 rounded-2xl bg-slate-50 border min-h-[100px]">
                    {{ $cuti->alamat ?? '-' }}
                </div>

            </div>

            <div class="mt-6">

                <label class="text-sm text-slate-500">
                    Keterangan
                </label>

                <div class="mt-2 p-4 rounded-2xl bg-slate-50 border min-h-[100px]">
                    {{ $cuti->keterangan ?? '-' }}
                </div>

            </div>

        </div>

        <!-- HISTORI APPROVAL -->
        <div class="p-8">

            <h2 class="text-xl font-bold text-slate-800 mb-6">

                Histori Approval

            </h2>

            <div class="space-y-5">

                @foreach($cuti->approval as $item)

                <div class="border rounded-2xl p-6">

                    <div class="flex items-center justify-between">

                        <div>

                            <h3 class="font-semibold text-slate-800">

                                {{ $item->pegawai->nama ?? '-' }}

                            </h3>

                            <p class="text-sm text-slate-500 mt-1">

                                {{ ucwords(str_replace('_',' ', $item->role_approval)) }}

                            </p>

                        </div>

                        <div>

                            @if($item->status == 'pending')

                            <span class="px-3 py-1 rounded-full
                                bg-yellow-100 text-yellow-700
                                text-xs font-semibold">

                                Pending

                            </span>

                            @elseif($item->status == 'disetujui')

                            <span class="px-3 py-1 rounded-full
                                bg-emerald-100 text-emerald-700
                                text-xs font-semibold">

                                Disetujui

                            </span>

                            @else

                            <span class="px-3 py-1 rounded-full
                                bg-red-100 text-red-700
                                text-xs font-semibold">

                                Ditolak

                            </span>

                            @endif

                        </div>

                    </div>

                    <div class="mt-5 grid grid-cols-1
                        md:grid-cols-2 gap-4 text-sm">

                        @if($item->cuti_efektif)

                        <div>

                            <span class="text-slate-500">
                                Cuti Efektif :
                            </span>

                            <b>
                                {{ $item->cuti_efektif }}
                            </b>

                        </div>

                        @endif

                        @if($item->sampai_dengan)

                        <div>

                            <span class="text-slate-500">
                                Sampai Dengan :
                            </span>

                            <b>
                                {{ $item->sampai_dengan }}
                            </b>

                        </div>

                        @endif

                        @if($item->petugas_pengganti)

                        <div>

                            <span class="text-slate-500">
                                Petugas Pengganti :
                            </span>

                            <b>
                                {{ $item->petugas_pengganti }}
                            </b>

                        </div>

                        @endif

                        @if($item->jumlah_hari)

                        <div>

                            <span class="text-slate-500">
                                Jumlah Hari :
                            </span>

                            <b>
                                {{ $item->jumlah_hari }} Hari
                            </b>

                        </div>

                        @endif

                        @if($item->hak_hari_cuti)

                        <div>
                            <span class="text-slate-500">
                                Hak Hari Cuti :
                            </span>

                            <b>
                                {{ $item->hak_hari_cuti }} Hari
                            </b>
                        </div>

                        @endif


                        @if($item->telah_dijalani)

                        <div>
                            <span class="text-slate-500">
                                Telah Dijalani :
                            </span>

                            <b>
                                {{ $item->telah_dijalani }} Hari
                            </b>
                        </div>

                        @endif


                        @if($item->izin_potong_cuti)

                        <div>
                            <span class="text-slate-500">
                                Izin Potong Cuti :
                            </span>

                            <b>
                                {{ $item->izin_potong_cuti }} Hari
                            </b>
                        </div>

                        @endif


                        @if($item->sisa_hari_cuti)

                        <div>
                            <span class="text-slate-500">
                                Sisa Hari Cuti :
                            </span>

                            <b>
                                {{ $item->sisa_hari_cuti }} Hari
                            </b>
                        </div>

                        @endif


                        @if($item->sisa_setelah_cuti)

                        <div>
                            <span class="text-slate-500">
                                Sisa Setelah Cuti :
                            </span>

                            <b>
                                {{ $item->sisa_setelah_cuti }} Hari
                            </b>
                        </div>

                        @endif

                        @if($item->jumlah_hari)

                        <div>

                            <span class="text-slate-500">
                                Jumlah Hari :
                            </span>

                            <b>
                                {{ $item->jumlah_hari }} Hari
                            </b>

                        </div>

                        @endif

                        @if($item->catatan)

                        <div class="md:col-span-2">

                            <span class="text-slate-500">
                                Catatan :
                            </span>

                            <div class="mt-2 p-4 rounded-xl
                                bg-slate-50 border">

                                {{ $item->catatan }}

                            </div>

                        </div>

                        @endif

                    </div>

                </div>

                @endforeach

            </div>

        </div>

    </div>

</div>

@endsection