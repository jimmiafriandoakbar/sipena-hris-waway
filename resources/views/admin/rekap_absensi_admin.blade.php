@extends('layouts.admin.app_admin')

@section('content')

@php
    $grandHadir = 0;
    $grandTerlambat = 0;
    $grandPulangCepat = 0;
    $grandTidakAbsenPulang = 0;
    $grandMenitLembur = 0;
@endphp

<div class="p-6 bg-slate-50 min-h-screen">

    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-3xl font-bold text-slate-800">
                Rekap Absensi Bulanan
            </h1>
            <p class="text-slate-500 mt-1">
                Monitoring kehadiran, keterlambatan, pulang cepat, tidak absen pulang, dan lembur pegawai.
            </p>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6 mb-6 no-print">

        <form method="GET"
            action="{{ route('admin.absensi.rekap') }}"
            class="space-y-5">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Tanggal Mulai
                    </label>
                    <input type="date"
                        name="tanggal_mulai"
                        value="{{ $tanggalMulai }}"
                        class="w-full h-12 px-4 rounded-2xl border border-slate-300 bg-white text-sm">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Tanggal Selesai
                    </label>
                    <input type="date"
                        name="tanggal_selesai"
                        value="{{ $tanggalSelesai }}"
                        class="w-full h-12 px-4 rounded-2xl border border-slate-300 bg-white text-sm">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Cari Pegawai
                </label>

                <div class="relative">
                    <input type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama, NIP, atau jabatan..."
                        class="w-full h-12 pl-11 pr-4 rounded-2xl border border-slate-300 bg-white text-sm focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition">

                    <i data-lucide="search"
                    class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                </div>
            </div>

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 pt-2">

                <div class="text-sm text-slate-500">
                    Periode:
                    <span class="font-bold text-blue-700">
                        {{ \Carbon\Carbon::parse($tanggalMulai)->format('d/m/Y') }}
                        s/d
                        {{ \Carbon\Carbon::parse($tanggalSelesai)->format('d/m/Y') }}
                    </span>
                </div>

                <div class="flex flex-col sm:flex-row gap-3">

                    <button type="submit"
                            class="h-12 px-6 rounded-2xl bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700 transition shadow-sm inline-flex items-center justify-center gap-2">
                        <i data-lucide="filter" class="w-4 h-4"></i>
                        Tampilkan
                    </button>

                    <a href="{{ route('admin.absensi.rekap') }}"
                    class="h-12 px-6 rounded-2xl border border-slate-300 bg-white text-slate-700 text-sm font-semibold hover:bg-slate-50 transition shadow-sm inline-flex items-center justify-center gap-2">
                        <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                        Reset
                    </a>

                    <a href="{{ route('admin.absensi.print', [
                            'tanggal_mulai' => $tanggalMulai,
                            'tanggal_selesai' => $tanggalSelesai,
                            'search' => request('search')
                        ]) }}"
                        target="_blank" class="h-12 px-6 rounded-2xl bg-slate-800 text-white text-sm font-semibold hover:bg-slate-900 transition shadow-sm inline-flex items-center justify-center gap-2">
                        <i data-lucide="printer" class="w-4 h-4"></i>
                        Print
                    </a>

                </div>

            </div>

        </form>

    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">

        <div class="px-6 py-5 border-b border-slate-200 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="font-bold text-slate-800 text-lg">
                    Daftar Rekap Absensi
                </h2>
                <p class="text-sm text-slate-500">
                  Periode:  {{ \Carbon\Carbon::parse($tanggalMulai)->format('d/m/Y') }}
                    s/d
                    {{ \Carbon\Carbon::parse($tanggalSelesai)->format('d/m/Y') }}
                </p>
            </div>

            <div class="text-sm text-slate-500">
                Total
                <span class="font-bold text-slate-800">
                    {{ method_exists($pegawais, 'total') ? $pegawais->total() : $pegawais->count() }}
                </span>
                pegawai
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-100 text-slate-700">
                    <tr>
                        <th class="px-4 py-4 text-left">No</th>
                        <th class="px-4 py-4 text-left">Nama Pegawai</th>
                        <th class="px-4 py-4 text-left">Jabatan</th>
                        <th class="px-4 py-4 text-center">Hadir</th>
                        <th class="px-4 py-4 text-center">Terlambat</th>
                        <th class="px-4 py-4 text-center">Pulang Cepat</th>
                        <th class="px-4 py-4 text-center">Tidak Absen Pulang</th>
                        <th class="px-4 py-4 text-center">Total Lembur</th>
                        <th class="px-4 py-4 text-center no-print">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse($pegawais as $pegawai)

                        @php
                            $absensis = $pegawai->absensis;

                            $totalHadir = $absensis->whereIn('status_masuk', ['hadir', 'terlambat'])->count();
                            $totalTerlambat = $absensis->where('status_masuk', 'terlambat')->count();
                            $totalPulangCepat = $absensis->where('status_pulang', 'pulang_cepat')->count();

                            $totalTidakAbsenPulang = $absensis->filter(function ($item) {
                                return !$item->jam_pulang;
                            })->count();

                            $totalMenitLembur = $absensis->sum('total_menit_lembur');

                            $jamLembur = floor($totalMenitLembur / 60);
                            $menitLembur = $totalMenitLembur % 60;

                            $grandHadir += $totalHadir;
                            $grandTerlambat += $totalTerlambat;
                            $grandPulangCepat += $totalPulangCepat;
                            $grandTidakAbsenPulang += $totalTidakAbsenPulang;
                            $grandMenitLembur += $totalMenitLembur;

                            $nomor = method_exists($pegawais, 'firstItem')
                                ? $pegawais->firstItem() + $loop->index
                                : $loop->iteration;
                        @endphp

                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-4 py-4 text-slate-600">
                                {{ $nomor }}
                            </td>

                            <td class="px-4 py-4">
                                <div class="font-bold text-slate-800">
                                    {{ $pegawai->nama }}
                                </div>
                                <div class="text-xs text-slate-500">
                                    NIP: {{ $pegawai->nip ?? '-' }}
                                </div>
                            </td>

                            <td class="px-4 py-4 text-slate-600">
                                {{ $pegawai->jabatanRelasi->nama_jabatan ?? '-' }}
                            </td>

                            <td class="px-4 py-4 text-center">
                                <span class="px-3 py-1 rounded-full bg-green-50 text-green-700 font-bold">
                                    {{ $totalHadir }}
                                </span>
                            </td>

                            <td class="px-4 py-4 text-center">
                                <span class="px-3 py-1 rounded-full {{ $totalTerlambat > 0 ? 'bg-red-50 text-red-700' : 'bg-slate-100 text-slate-500' }} font-bold">
                                    {{ $totalTerlambat }}
                                </span>
                            </td>

                            <td class="px-4 py-4 text-center">
                                <span class="px-3 py-1 rounded-full {{ $totalPulangCepat > 0 ? 'bg-orange-50 text-orange-700' : 'bg-slate-100 text-slate-500' }} font-bold">
                                    {{ $totalPulangCepat }}
                                </span>
                            </td>

                            <td class="px-4 py-4 text-center">
                                <span class="px-3 py-1 rounded-full {{ $totalTidakAbsenPulang > 0 ? 'bg-yellow-50 text-yellow-700' : 'bg-slate-100 text-slate-500' }} font-bold">
                                    {{ $totalTidakAbsenPulang }}
                                </span>
                            </td>

                            <td class="px-4 py-4 text-center font-bold text-blue-700">
                                {{ $jamLembur }} Jam {{ $menitLembur }} Menit
                            </td>

                            <td class="px-4 py-4 text-center no-print">
                                <a href="{{ route('admin.absensi.detail', [
                                        'pegawai' => $pegawai->id,
                                        'tanggal_mulai' => $tanggalMulai,
                                        'tanggal_selesai' => $tanggalSelesai
                                    ]) }}"
                                    class="inline-flex items-center justify-center px-4 py-2 rounded-xl bg-blue-50 text-blue-700 font-semibold hover:bg-blue-100 transition">
                                    Detail
                                </a>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="9" class="px-4 py-10 text-center text-slate-500">
                                Data pegawai tidak ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

                <tfoot class="bg-slate-100 font-bold text-slate-800">
                    <tr>
                        <td colspan="3" class="px-4 py-4 text-center">
                            TOTAL HALAMAN INI
                        </td>
                        <td class="px-4 py-4 text-center">{{ $grandHadir }}</td>
                        <td class="px-4 py-4 text-center">{{ $grandTerlambat }}</td>
                        <td class="px-4 py-4 text-center">{{ $grandPulangCepat }}</td>
                        <td class="px-4 py-4 text-center">{{ $grandTidakAbsenPulang }}</td>
                        <td class="px-4 py-4 text-center">
                            {{ floor($grandMenitLembur / 60) }} Jam {{ $grandMenitLembur % 60 }} Menit
                        </td>
                        <td class="px-4 py-4 no-print"></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        @if(method_exists($pegawais, 'links'))
            <div class="px-6 py-5 border-t bg-slate-50 no-print flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                <div class="text-sm text-slate-500">
                    Menampilkan
                    <span class="font-semibold text-slate-700">
                        {{ $pegawais->firstItem() ?? 0 }}
                    </span>
                    -
                    <span class="font-semibold text-slate-700">
                        {{ $pegawais->lastItem() ?? 0 }}
                    </span>
                    dari
                    <span class="font-semibold text-slate-700">
                        {{ $pegawais->total() }}
                    </span>
                    data
                </div>

                <div class="flex items-center gap-2">

                    @if($pegawais->onFirstPage())
                        <span class="h-10 px-4 rounded-xl border border-slate-200 bg-slate-100 text-slate-400 text-sm font-semibold flex items-center gap-2 cursor-not-allowed">
                            <i data-lucide="chevron-left" class="w-4 h-4"></i>
                            Prev
                        </span>
                    @else
                        <a href="{{ $pegawais->previousPageUrl() }}"
                           class="h-10 px-4 rounded-xl border border-slate-300 bg-white text-slate-700 text-sm font-semibold hover:bg-slate-100 transition flex items-center gap-2">
                            <i data-lucide="chevron-left" class="w-4 h-4"></i>
                            Prev
                        </a>
                    @endif

                    <div class="h-10 px-4 rounded-xl bg-blue-600 text-white text-sm font-semibold flex items-center justify-center">
                        Page {{ $pegawais->currentPage() }} / {{ $pegawais->lastPage() }}
                    </div>

                    @if($pegawais->hasMorePages())
                        <a href="{{ $pegawais->nextPageUrl() }}"
                           class="h-10 px-4 rounded-xl border border-slate-300 bg-white text-slate-700 text-sm font-semibold hover:bg-slate-100 transition flex items-center gap-2">
                            Next
                            <i data-lucide="chevron-right" class="w-4 h-4"></i>
                        </a>
                    @else
                        <span class="h-10 px-4 rounded-xl border border-slate-200 bg-slate-100 text-slate-400 text-sm font-semibold flex items-center gap-2 cursor-not-allowed">
                            Next
                            <i data-lucide="chevron-right" class="w-4 h-4"></i>
                        </span>
                    @endif

                </div>
            </div>
        @endif

    </div>

</div>

<style>
@media print {
    body {
        background: white !important;
    }

    .no-print {
        display: none !important;
    }

    .shadow-sm,
    .shadow {
        box-shadow: none !important;
    }

    .rounded-3xl,
    .rounded-2xl {
        border-radius: 0 !important;
    }

    table {
        font-size: 11px;
    }
}
</style>

<script>
    if (window.lucide) {
        lucide.createIcons();
    }
</script>

@endsection