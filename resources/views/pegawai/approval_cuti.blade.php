@extends('layouts.pegawai.app')

@section('content')

<div class="max-w-7xl mx-auto">

    {{-- HEADER --}}
    <div class="mb-8">

        <h1 class="text-3xl font-bold text-slate-800">

            Approval Cuti

        </h1>

        <p class="text-slate-500 mt-2">

            Approval pengajuan cuti pegawai

        </p>

    </div>

    @forelse($approvalAktif as $approval)

    <div class="bg-white rounded-2xl shadow-sm
        border border-slate-200 p-8 mb-8">

        {{-- DATA PEGAWAI --}}
        <div class="mb-8">

            <h2 class="text-xl font-bold text-slate-800 mb-6">

                Informasi Pegawai

            </h2>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-5">

                <div>

                    <div class="text-sm text-slate-500">
                        Nama
                    </div>

                    <div class="font-semibold">

                        {{ $approval->cuti->pegawai->nama ?? '-' }}

                    </div>

                </div>

                <div>

                    <div class="text-sm text-slate-500">
                        Jenis Cuti
                    </div>

                    <div class="font-semibold">

                        {{ $approval->cuti->jenis_cuti ?? '-' }}

                    </div>

                </div>

                <div>

                    <div class="text-sm text-slate-500">
                        Mulai Cuti
                    </div>

                    <div class="font-semibold">

                        {{ $approval->cuti->mulai_cuti ?? '-' }}

                    </div>

                </div>

                <div>

                    <div class="text-sm text-slate-500">
                        Sampai
                    </div>

                    <div class="font-semibold">

                        {{ $approval->cuti->akhir_cuti ?? '-' }}

                    </div>

                </div>

            </div>

        </div>

        {{-- HISTORI APPROVAL --}}
        <div class="mb-8">

            <h2 class="text-xl font-bold text-slate-800 mb-5">

                Histori Approval

            </h2>

            <div class="space-y-4">

                @foreach($approval->cuti->approval as $item)

                <div class="border rounded-2xl p-5">

                    <div class="flex items-center justify-between">

                        <div>

                            <div class="font-semibold text-slate-800">

                                {{ $item->pegawai->nama ?? '-' }}

                            </div>

                            <div class="text-sm text-slate-500">

                                {{ ucwords(str_replace('_',' ', $item->role_approval)) }}

                            </div>

                        </div>

                        <div>

                            @if($item->status == 'pending')

                            <span class="px-3 py-1 rounded-full
                                bg-yellow-100 text-yellow-700 text-xs">

                                Pending

                            </span>

                            @elseif($item->status == 'disetujui')

                            <span class="px-3 py-1 rounded-full
                                bg-green-100 text-green-700 text-xs">

                                Disetujui

                            </span>

                            @else

                            <span class="px-3 py-1 rounded-full
                                bg-red-100 text-red-700 text-xs">

                                Ditolak

                            </span>

                            @endif

                        </div>

                    </div>

                    {{-- DATA FORM APPROVAL --}}
                    <div class="mt-4 text-sm text-slate-700 space-y-1">

                        @if($item->cuti_efektif)

                        <div>

                            Cuti Efektif :
                            <b>{{ $item->cuti_efektif }}</b>

                        </div>

                        @endif

                        @if($item->sampai_dengan)

                        <div>

                            Sampai Dengan :
                            <b>{{ $item->sampai_dengan }}</b>

                        </div>

                        @endif

                        @if($item->petugas_pengganti)

                        <div>

                            Petugas Pengganti :
                            <b>{{ $item->petugas_pengganti }}</b>

                        </div>

                        @endif

                        @if($item->hak_hari_cuti)

                        <div>

                            Hak Hari Cuti :
                            <b>{{ $item->hak_hari_cuti }}</b>

                        </div>

                        @endif

                        @if($item->sisa_hari_cuti)

                        <div>

                            Sisa Hari Cuti :
                            <b>{{ $item->sisa_hari_cuti }}</b>

                        </div>

                        @endif

                        @if($item->catatan)

                        <div>

                            Catatan :
                            <b>{{ $item->catatan }}</b>

                        </div>

                        @endif

                    </div>

                </div>

                @endforeach

            </div>

        </div>

        {{-- FORM APPROVAL --}}
        <form
            action="{{ route('pegawai.cuti.approve', $approval->id) }}"
            method="POST">

            @csrf

            {{-- KEPALA BAGIAN --}}
            @if($approval->role_approval == 'kepala_bagian')

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <div>
                    
                    <label class="text-sm font-medium">
                        Cuti Efektif
                    </label>

                    <input
                        type="date"
                        name="cuti_efektif"
                        class="input">

                </div>

                <div>

                    <label class="text-sm font-medium">
                        Sampai Dengan
                    </label>

                    <input
                        type="date"
                        name="sampai_dengan"
                        class="input">

                </div>

                <div>

                    <label class="text-sm font-medium">
                        Jumlah Hari
                    </label>

                    <input
                        type="text"
                        name="jumlah_hari"
                        class="input">

                </div>

                <div>

                    <label class="text-sm font-medium">
                        Petugas Pengganti
                    </label>

                    <input
                        type="text"
                        name="petugas_pengganti"
                        class="input">

                </div>

            </div>

            @endif

            {{-- SDM --}}
            @if($approval->role_approval == 'sdm')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="font-semibold mb-2 block">
                        Hak Hari Cuti
                    </label>

                    <input
                        type="text"
                        name="hak_hari_cuti"
                        placeholder="# Hari"
                        class="input">
                </div>

                <div>
                    <label class="font-semibold mb-2 block">
                        Telah Dijalani
                    </label>

                    <input
                        type="text"
                        name="telah_dijalani"
                        placeholder="# Hari"
                        class="input">
                </div>

                <div>
                    <label class="font-semibold mb-2 block">
                        Izin Potong Cuti
                    </label>

                    <input
                        type="text"
                        name="izin_potong_cuti"
                        placeholder="# Hari"
                        class="input">
                </div>

                <div>
                    <label class="font-semibold mb-2 block">
                        Sisa Hari Cuti
                    </label>

                    <input
                        type="text"
                        name="sisa_hari_cuti"
                        placeholder="# Hari"
                        class="input">
                </div>

                <div>
                    <label class="font-semibold mb-2 block">
                        Sisa Setelah Cuti
                    </label>

                    <input
                        type="text"
                        name="sisa_setelah_cuti"
                        placeholder="# Hari"
                        class="input">
                </div>

            </div>

            @endif

            {{-- DIREKTUR OPERASIONAL --}}
            @if($approval->role_approval == 'direktur_operasional')

            <div>

                <textarea
                    name="catatan"
                    rows="5"
                    class="input"
                    placeholder="Catatan Direktur Operasional"></textarea>

            </div>

            @endif

            {{-- DIREKTUR UTAMA --}}
            @if($approval->role_approval == 'direktur_utama')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                
                <div>
                    <label class="font-semibold mb-2 block">
                        Cuti Efektif
                    </label>

                    <input
                        type="date"
                        name="cuti_efektif"
                        class="input">
                </div>

                <div>
                    <label class="font-semibold mb-2 block">
                        Sampai Dengan
                    </label>

                    <input
                        type="date"
                        name="sampai_dengan"
                        class="input">
                </div>

            </div>

                <div>
                    <label class="font-semibold mb-2 block">
                        Jumlah Hari
                    </label>

                    <input
                        type="text"
                        name="jumlah_hari"
                        class="input">
                </div>

            <div class="mt-4">

                <input
                    type="text"
                    name="petugas_pengganti"
                    placeholder="Petugas Pengganti"
                    class="input">

            </div>

            <div class="mt-4">

                <textarea
                    name="catatan"
                    rows="5"
                    class="input"
                    placeholder="Catatan Direktur Utama"></textarea>

            </div>

            @endif

            {{-- BUTTON --}}
            <div class="flex gap-3 mt-6">

                <button
                    type="submit"
                    name="status"
                    value="disetujui"
                    class="bg-green-600 hover:bg-green-700
                    text-white px-6 py-3 rounded-xl">

                    Setujui

                </button>

                <button
                    type="submit"
                    name="status"
                    value="ditolak"
                    class="bg-red-600 hover:bg-red-700
                    text-white px-6 py-3 rounded-xl">

                    Tolak

                </button>

            </div>

        </form>

    </div>

    @empty

    <div class="bg-white rounded-2xl shadow-sm
        border border-slate-200 p-10 text-center">

        <div class="text-slate-400">

            Sudah Di Approve

        </div>

    </div>

    @endforelse

</div>

@endsection

<style>

.input{
    width:100%;
    border:1px solid #d1d5db;
    padding:12px 14px;
    border-radius:14px;
    margin-top:6px;
}

.input:focus{
    outline:none;
    border-color:#2563eb;
    box-shadow:0 0 0 3px rgba(37,99,235,.1);
}

</style>