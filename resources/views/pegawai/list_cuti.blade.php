@extends('layouts.pegawai.app')

@section('content')

<!-- ALERT SUCCESS -->
@if(session('success'))

<div
    id="alertSuccess"
    class="fixed top-5 right-5 z-50
    bg-emerald-500 text-white
    px-6 py-4 rounded-2xl shadow-2xl
    flex items-center gap-3">

    <i data-lucide="check-circle" class="w-5 h-5"></i>

    <span>

        {{ session('success') }}

    </span>

</div>

@endif

<!-- ALERT ERROR -->
@if(session('error'))

<div
    id="alertError"
    class="fixed top-5 right-5 z-50
    bg-red-500 text-white
    px-6 py-4 rounded-2xl shadow-2xl
    flex items-center gap-3">

    <i data-lucide="x-circle" class="w-5 h-5"></i>

    <span>

        {{ session('error') }}

    </span>

</div>

@endif

<div class="max-w-7xl mx-auto">

    <!-- HEADER -->
    <div class="flex items-center justify-between mb-8">

        <div>

            <h1 class="text-3xl font-bold text-slate-800">

                List Cuti

            </h1>

            <p class="text-slate-500 mt-2">

                Daftar pengajuan cuti pegawai

            </p>

        </div>

    </div>

    <!-- CARD -->
    <div class="bg-white rounded-3xl border
        border-slate-200 shadow-sm overflow-hidden">

        <!-- TABLE -->
        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-slate-50">

                    <tr>

                        <th class="px-6 py-4 text-left text-xs
                            font-semibold text-slate-500 uppercase">

                            No

                        </th>

                        <th class="px-6 py-4 text-left text-xs
                            font-semibold text-slate-500 uppercase">

                            Pegawai

                        </th>

                        <th class="px-6 py-4 text-left text-xs
                            font-semibold text-slate-500 uppercase">

                            Bagian

                        </th>

                        <th class="px-6 py-4 text-left text-xs
                            font-semibold text-slate-500 uppercase">

                            Jenis Cuti

                        </th>

                        <th class="px-6 py-4 text-left text-xs
                            font-semibold text-slate-500 uppercase">

                            Tanggal

                        </th>

                        <th class="px-6 py-4 text-center text-xs
                            font-semibold text-slate-500 uppercase">

                            Status

                        </th>

                        <th class="px-6 py-4 text-center text-xs
                            font-semibold text-slate-500 uppercase">

                            Aksi

                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($cuti as $index => $item)

                    <tr class="hover:bg-slate-50 transition">

                        <!-- NO -->
                        <td class="px-6 py-5 text-sm text-slate-700">

                            {{ $cuti->firstItem() + $index }}

                        </td>

                        <!-- PEGAWAI -->
                        <td class="px-6 py-5">

                            <div class="flex items-center gap-3">

                                <div class="w-11 h-11 rounded-xl
                                    bg-blue-50 flex items-center
                                    justify-center">

                                    <i data-lucide="user"
                                        class="w-5 h-5 text-blue-600"></i>

                                </div>

                                <div>

                                    <p class="text-sm font-semibold
                                        text-slate-800">

                                        {{ $item->pegawai->nama ?? '-' }}

                                    </p>

                                    <p class="text-xs text-slate-500">

                                        {{ $item->pegawai->jabatanRelasi->nama_jabatan ?? '-' }}

                                    </p>

                                </div>

                            </div>

                        </td>

                        <!-- BAGIAN -->
                        <td class="px-6 py-5 text-sm text-slate-700">

                            {{ $item->pegawai->bagianRelasi->nama_bagian ?? '-' }}

                        </td>

                        <!-- JENIS -->
                        <td class="px-6 py-5">

                            <span class="inline-flex items-center
                                px-3 py-1 rounded-full
                                bg-blue-100 text-blue-700
                                text-xs font-semibold">

                                {{ $item->jenis_cuti }}

                            </span>

                        </td>

                        <!-- TANGGAL -->
                        <td class="px-6 py-5 text-sm text-slate-700">

                            {{ \Carbon\Carbon::parse($item->mulai_cuti)->format('d M Y') }}
                            -
                            {{ \Carbon\Carbon::parse($item->akhir_cuti)->format('d M Y') }}

                        </td>

                        <!-- STATUS -->
                        <td class="px-6 py-5 text-center">

                            @if($item->surat->status == 'disetujui')

                            <span class="inline-flex items-center
                                px-3 py-1 rounded-full
                                bg-emerald-100 text-emerald-700
                                text-xs font-semibold">

                                Disetujui

                            </span>

                            @elseif($item->surat->status == 'ditolak')

                            <span class="inline-flex items-center
                                px-3 py-1 rounded-full
                                bg-red-100 text-red-700
                                text-xs font-semibold">

                                Ditolak

                            </span>

                            @else

                            <span class="inline-flex items-center
                                px-3 py-1 rounded-full
                                bg-yellow-100 text-yellow-700
                                text-xs font-semibold">

                                {{ $item->surat->status }}

                            </span>

                            @endif

                        </td>

                        <!-- AKSI -->
                        <td class="px-6 py-5">

                            <div class="flex items-center
                                justify-center gap-2">

                                <!-- PREVIEW -->
                                <a
                                    href="{{ route('pegawai.preview.cuti', $item->id) }}"
                                    class="w-9 h-9 rounded-xl border
                                    border-slate-300 flex items-center
                                    justify-center text-slate-600
                                    hover:bg-slate-100 transition">

                                    <i data-lucide="eye"
                                        class="w-4 h-4"></i>

                                </a>

                                <!-- PRINT -->
                                <a
                                    href="{{ route('pegawai.print.cuti', $item->id) }}"
                                    target="_blank"
                                    class="w-9 h-9 rounded-xl border
                                    border-slate-300 flex items-center
                                    justify-center text-slate-600
                                    hover:bg-slate-100 transition">

                                    <i data-lucide="printer"
                                        class="w-4 h-4"></i>

                                </a>

                                <!-- Approval -->
                                    <a
                                        href="{{ route('pegawai.cuti.approval', $item->id) }}"
                                        class="w-9 h-9 rounded-xl border
                                        border-slate-300 flex items-center
                                        justify-center text-slate-600
                                        hover:bg-slate-100 transition">

                                        <i data-lucide="badge-check"
                                        class="w-4 h-4"></i>

                                    </a>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="7"
                            class="px-6 py-12 text-center
                            text-sm text-slate-500">

                            Belum ada data cuti

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <!-- PAGINATION -->
        <div class="p-6 border-t border-slate-100">

            {{ $cuti->links() }}

        </div>

    </div>

</div>

<script>

setTimeout(() => {

    const success =
        document.getElementById('alertSuccess');

    if(success){

        success.style.transition = '.4s';
        success.style.opacity = '0';

        setTimeout(() => {

            success.remove();

        }, 400);

    }

}, 3000);

setTimeout(() => {

    const error =
        document.getElementById('alertError');

    if(error){

        error.style.transition = '.4s';
        error.style.opacity = '0';

        setTimeout(() => {

            error.remove();

        }, 400);

    }

}, 3000);

</script>

@endsection