@extends('layouts.pegawai.app')

@section('content')

<div class="p-6">

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

        <!-- HEADER -->
        <div class="px-8 py-6 border-b border-slate-100">

            <div class="flex items-start justify-between gap-4">

                <div>

                    <h1 class="text-2xl font-bold text-slate-800">
                        Preview Surat
                    </h1>

                    <p class="text-sm text-slate-500 mt-1">
                        Detail surat dan riwayat disposisi
                    </p>

                </div>

                <div class="flex items-center gap-3">

                    <a href="{{ url()->previous() }}" class="h-11 px-5 rounded-xl border border-slate-300
                        hover:bg-slate-50 transition
                        text-sm font-medium text-slate-700
                        inline-flex items-center">

                        Kembali

                    </a>

                </div>

            </div>

        </div>

        <!-- BODY -->
        <div class="p-8 space-y-8">

            <!-- INFO -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>

                    <label class="text-sm text-slate-500">
                        Nomor Surat
                    </label>

                    <div class="mt-2 p-4 rounded-2xl bg-slate-50 border border-slate-200">

                        <p class="text-sm font-semibold text-slate-800">

                            {{ $surat->nomor_surat }}

                        </p>

                    </div>

                </div>

                <div>

                    <label class="text-sm text-slate-500">
                        Jenis Surat
                    </label>

                    <div class="mt-2 p-4 rounded-2xl bg-slate-50 border border-slate-200">

                        <p class="text-sm font-semibold text-slate-800">

                            {{ ucwords(str_replace('_', ' ', $surat->jenis_surat)) }}

                        </p>

                    </div>

                </div>

                <div>

                    <label class="text-sm text-slate-500">
                        Tanggal Surat
                    </label>

                    <div class="mt-2 p-4 rounded-2xl bg-slate-50 border border-slate-200">

                        <p class="text-sm font-semibold text-slate-800">

                            {{ \Carbon\Carbon::parse($surat->tanggal_surat)->format('d M Y') }}

                        </p>

                    </div>

                </div>

                <div>

                    <label class="text-sm text-slate-500">
                        Dibuat Oleh
                    </label>

                    <div class="mt-2 p-4 rounded-2xl bg-slate-50 border border-slate-200">

                        <p class="text-sm font-semibold text-slate-800">

                            {{ $surat->pegawai->nama ?? '-' }}

                        </p>

                    </div>

                </div>

            </div>

            <!-- DARI -->
            @if($surat->jenis_surat == 'disposisi')

            <div>

                <label class="text-sm text-slate-500">
                    Surat Masuk Dari
                </label>

                <div class="mt-2 p-5 rounded-2xl border border-slate-200 bg-slate-50">

                    <p class="text-sm text-slate-700">

                        {{ $surat->dari ?? '-' }}

                    </p>

                </div>

            </div>

            @endif

            <!-- PERIHAL -->
            <div>

                <label class="text-sm text-slate-500">
                    Perihal
                </label>

                <div class="mt-2 p-5 rounded-2xl border border-slate-200 bg-slate-50">

                    <p class="text-sm text-slate-700 leading-relaxed">

                        {{ $surat->perihal }}

                    </p>

                </div>

            </div>

            <!-- ISI -->
            <div>

                <label class="text-sm text-slate-500">
                    Isi Surat
                </label>

                <div class="mt-2 p-5 rounded-2xl border border-slate-200 bg-slate-50">

                    <p class="text-sm text-slate-700 whitespace-pre-line leading-loose">

                        {{ $surat->isi_surat }}

                    </p>

                </div>

            </div>

            <!-- TUJUAN -->
            <div>

                <label class="text-sm text-slate-500">
                    Tujuan Bagian
                </label>

                <div class="flex flex-wrap gap-3 mt-3">

                    @foreach($surat->tujuan as $item)

                    <div class="px-4 py-2 rounded-xl
                        bg-blue-100 text-blue-700
                        text-sm font-medium">

                        {{ $item->bagian->nama_bagian ?? '-' }}

                    </div>

                    @endforeach

                </div>

            </div>

            <!-- TTD -->
            <div>

                <label class="text-sm text-slate-500">
                    Penandatangan
                </label>

                <div class="flex flex-wrap gap-3 mt-3">

                    @foreach($surat->ttd as $item)

                    <div class="px-4 py-2 rounded-xl
                        bg-emerald-100 text-emerald-700
                        text-sm font-medium">

                        {{ $item->pegawai->nama ?? '-' }}

                    </div>

                    @endforeach

                </div>

            </div>

            <!-- FILE -->
            @if($surat->file_pdf)

            <div>

                <label class="text-sm text-slate-500">
                    Lampiran Surat
                </label>

                <div class="flex flex-wrap gap-3 mt-3">

                    <!-- LIHAT -->
                    <a href="{{ asset('storage/' . $surat->file_pdf) }}" target="_blank" class="h-11 px-5 rounded-xl border border-slate-300
            bg-white hover:bg-slate-50 transition
            text-sm font-medium text-slate-700
            inline-flex items-center gap-2">

                        Lihat Lampiran

                    </a>

                    <!-- PRINT -->
                    <a href="{{ route('pegawai.surat.print', $surat->id) }}" target="_blank" class="h-11 px-5 rounded-xl
            bg-blue-600 hover:bg-blue-700
            transition text-sm font-medium
            text-white inline-flex items-center">

                        Print Surat

                    </a>

                </div>

            </div>

            @endif

            <!-- RIWAYAT DISPOSISI -->
            @if($surat->jenis_surat == 'disposisi')

            <div>

                <div class="flex items-center justify-between mb-4">

                    <div>

                        <h2 class="text-lg font-bold text-slate-800">
                            Riwayat Disposisi
                        </h2>

                        <p class="text-sm text-slate-500 mt-1">
                            Riwayat disposisi dari setiap approver
                        </p>

                    </div>

                    <a href="{{ route('pegawai.disposisi.form', $surat->id) }}" class="h-11 px-5 rounded-xl
                        bg-amber-500 hover:bg-amber-600
                        transition text-sm font-medium
                        text-white inline-flex items-center">

                        Edit Disposisi

                    </a>

                </div>

                @if($riwayatDisposisi->count())

                <div class="space-y-5">

                    @foreach($riwayatDisposisi->groupBy('dari_pegawai_id') as $pegawaiId => $items)

                    <div class="rounded-3xl border border-slate-200 overflow-hidden">

                        <!-- HEADER -->
                        <div class="px-6 py-5 bg-slate-50 border-b border-slate-100">

                            <div class="flex items-center justify-between">

                                <div>

                                    <h3 class="font-bold text-slate-800">

                                        {{ $items->first()->dariPegawai->nama ?? '-' }}

                                    </h3>

                                    <p class="text-sm text-emerald-600 mt-1">

                                        ✔ Menyetujui Surat

                                    </p>

                                </div>

                            </div>

                        </div>

                        <!-- BODY -->
                        <div class="p-6 space-y-5">

                            <div>

                                <label class="text-xs text-slate-400">
                                    Disposisi Ke Bagian
                                </label>

                                <div class="flex flex-wrap gap-3 mt-3">

                                    @foreach($items as $item)

                                    <div class="px-4 py-2 rounded-xl
                                        bg-amber-100 text-amber-700
                                        text-sm font-medium">

                                        {{ $item->bagian->nama_bagian ?? '-' }}

                                    </div>

                                    @endforeach

                                </div>

                            </div>

                            <div>

                                <label class="text-xs text-slate-400">
                                    Catatan Disposisi
                                </label>

                                <div class="mt-3 p-5 rounded-2xl
                                    border border-amber-200
                                    bg-amber-50">

                                    <p class="text-sm text-slate-700 leading-relaxed">

                                        {{ $items->first()->catatan ?? '-' }}

                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                    @endforeach

                </div>

                @else

                <div class="p-8 rounded-3xl border border-dashed border-slate-300 text-center">

                    <p class="text-sm text-slate-500">

                        Belum ada disposisi.

                    </p>

                </div>

                @endif

            </div>

            @endif

        </div>


    </div>

</div>

@endsection