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
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">

        <div>

            <h1 class="text-3xl font-bold text-slate-800">
                Tanda Tangan
            </h1>

            <p class="text-slate-500 text-sm mt-1">
                Persetujuan dan validasi dokumen tanda tangan pegawai SIPENA
            </p>

        </div>

    </div>

    <!-- CARD -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

        <!-- TOP -->
        <div class="p-8 border-b border-slate-100">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- FILTER -->
                <div class="lg:col-span-2">

                    <form method="GET"
                        class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">

                        <!-- SEARCH -->
                        <div class="relative flex-1">

                            <input
                                type="text"
                                name="search"
                                placeholder="Cari nama pegawai..."
                                class="w-full h-12 pl-11 pr-4 rounded-xl border border-slate-300 bg-white
                                focus:ring-4 focus:ring-blue-100 focus:border-blue-500
                                transition duration-200 text-sm outline-none shadow-sm">

                            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">

                                <i data-lucide="search" class="w-4 h-4"></i>

                            </div>

                        </div>

                        <!-- STATUS -->
                        <select
                            class="h-12 px-4 rounded-xl border border-slate-300 bg-white
                            focus:ring-4 focus:ring-blue-100 focus:border-blue-500
                            transition duration-200 text-sm outline-none shadow-sm">

                            <option>
                                Semua Status
                            </option>

                            <option>
                                Pending
                            </option>

                            <option>
                                Disetujui
                            </option>

                            <option>
                                Ditolak
                            </option>

                        </select>

                        <!-- BUTTON -->
                        <button
                            class="h-12 px-5 rounded-xl bg-blue-600 hover:bg-blue-700
                            transition text-sm font-medium text-white shadow-sm whitespace-nowrap">

                            Cari

                        </button>

                    </form>

                </div>
            </div>

        </div>

        <!-- TABLE -->
        <div class="p-8">

            <div class="overflow-x-auto border border-slate-200 rounded-2xl">

                <table class="w-full">

    <thead class="bg-slate-50">

        <tr>

            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase">
                No
            </th>

            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase">
                Pegawai
            </th>

            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase">
                Bagian
            </th>

            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase">
                Perihal
            </th>

            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase">
                Jenis
            </th>

            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase">
                Tanggal
            </th>

            <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase">
                Status
            </th>

            <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase">
                Aksi
            </th>

        </tr>

    </thead>

    <tbody class="divide-y divide-slate-100">

        @forelse($ttd as $index => $item)

<tr class="hover:bg-slate-50 transition">

    <!-- NO -->
    <td class="px-6 py-5 text-sm text-slate-700">

        {{ $ttd->firstItem() + $index }}

    </td>

    <!-- PEGAWAI -->
    <td class="px-6 py-5">

        <div class="flex items-center gap-3">

            <div class="w-11 h-11 rounded-xl bg-blue-50
                flex items-center justify-center">

                <i data-lucide="signature"
                    class="w-5 h-5 text-blue-600"></i>

            </div>

            <div>

                <p class="text-sm font-semibold text-slate-800">

                    {{ $item->surat->pegawai->nama ?? '-' }}

                </p>

                <p class="text-xs text-slate-500">

                    {{ $item->surat->pegawai->email ?? '-' }}

                </p>

            </div>

        </div>

    </td>

    <!-- BAGIAN -->
    <td class="px-6 py-5 text-sm text-slate-700">

        {{ $item->surat->pegawai->bagianRelasi->nama_bagian ?? '-' }}

    </td>

    <!-- PERIHAL -->
    <td class="px-6 py-5 text-sm text-slate-700">

        {{ $item->surat->perihal }}

    </td>

    <!-- JENIS -->
    <td class="px-6 py-5">

        <span class="inline-flex items-center px-3 py-1 rounded-full
            bg-blue-100 text-blue-700 text-xs font-semibold">

            {{ ucwords(str_replace('_', ' ', $item->surat->jenis_surat)) }}

        </span>

    </td>

    <!-- TANGGAL -->
    <td class="px-6 py-5 text-sm text-slate-700">

        {{ \Carbon\Carbon::parse($item->surat->tanggal_surat)->format('d M Y') }}

    </td>

    <!-- STATUS -->
    <td class="px-6 py-5 text-center">

        @if($item->status == 'pending')

            <span class="inline-flex items-center px-3 py-1 rounded-full
                bg-yellow-100 text-yellow-700 text-xs font-semibold">

                Pending

            </span>

        @elseif($item->status == 'disetujui')

            <span class="inline-flex items-center px-3 py-1 rounded-full
                bg-emerald-100 text-emerald-700 text-xs font-semibold">

                Disetujui

            </span>

        @else

            <span class="inline-flex items-center px-3 py-1 rounded-full
                bg-red-100 text-red-700 text-xs font-semibold">

                Ditolak

            </span>

        @endif

    </td>

    <!-- AKSI -->
    <td class="px-6 py-5">

        <div class="flex items-center justify-center gap-2">

            <!-- PREVIEW -->
            <a href="{{ route('pegawai.surat.preview', $item->surat->id) }}"
                class="h-10 px-4 rounded-xl border border-slate-300
                text-slate-700 hover:bg-slate-50 transition
                text-sm font-medium inline-flex items-center">

                Preview

            </a>

            @if($item->status == 'pending')

            <!-- SETUJUI -->
            <form action="{{ route('pegawai.surat.setujui', $item->id) }}"
                method="POST">

                @csrf

                <button
                    class="h-10 px-4 rounded-xl border border-emerald-500
                    text-emerald-600 hover:bg-emerald-50 transition
                    text-sm font-medium">

                    Setujui

                </button>

            </form>

            <!-- TOLAK -->
            <form action="{{ route('pegawai.surat.tolak', $item->id) }}"
                method="POST">

                @csrf

                <button
                    class="h-10 px-4 rounded-xl border border-red-500
                    text-red-600 hover:bg-red-50 transition
                    text-sm font-medium">

                    Tolak

                </button>

            </form>

            @endif

        </div>

    </td>

</tr>

@empty

<tr>

    <td colspan="8"
        class="px-6 py-12 text-center text-sm text-slate-500">

        Belum ada data tanda tangan

    </td>

</tr>

@endforelse

    </tbody>

</table>

            </div>

            <!-- PAGINATION -->
            <div class="flex flex-col md:flex-row items-center justify-between gap-4 mt-6">

                <!-- INFO -->
                <p class="text-sm text-slate-500">

                Menampilkan

                <span class="font-semibold text-slate-700">
                    {{ $ttd->firstItem() ?? 0 }}
                </span>

                -

                <span class="font-semibold text-slate-700">
                    {{ $ttd->lastItem() ?? 0 }}
                </span>

                dari

                <span class="font-semibold text-slate-700">
                    {{ $ttd->total() }}
                </span>

                data

            </p>

                <!-- PAGE -->
                <div class="flex items-center gap-2">

                    <div class="flex items-center gap-2">

                        {{ $ttd->links() }}

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<script>

    // SUCCESS
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

    // ERROR
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