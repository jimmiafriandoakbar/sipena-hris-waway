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

        <div class="px-5 py-3 rounded-2xl bg-white border border-slate-200 shadow-sm">
            <p class="text-xs text-slate-500">Periode</p>
            <p class="font-bold text-blue-700">
                {{ \Carbon\Carbon::createFromDate($tahun, $bulan, 1)->translatedFormat('F Y') }}
            </p>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6 mb-6 no-print">
        <form method="GET"
              action="{{ route('admin.absensi.rekap') }}"
              class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Bulan
                </label>

                <select name="bulan"
                        class="w-full border-slate-300 rounded-xl focus:ring-blue-500 focus:border-blue-500">
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ sprintf('%02d', $i) }}"
                            {{ $bulan == sprintf('%02d', $i) ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                        </option>
                    @endfor
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Tahun
                </label>

                <select name="tahun"
                        class="w-full border-slate-300 rounded-xl focus:ring-blue-500 focus:border-blue-500">
                    @for($y = now()->year; $y >= now()->year - 5; $y--)
                        <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endfor
                </select>
            </div>

            <div>
                <button class="w-full px-5 py-3 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700 transition">
                    Tampilkan
                </button>
            </div>

            <div>
                <a href="{{ route('admin.absensi.print', [
                        'bulan' => $bulan,
                        'tahun' => $tahun
                        ]) }}"
                    target="_blank"
                    class="block text-center w-full px-5 py-3 rounded-xl bg-slate-800 text-white font-semibold hover:bg-slate-900 transition">
                        Print
                </a>
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
                    Periode {{ \Carbon\Carbon::createFromDate($tahun, $bulan, 1)->translatedFormat('F Y') }}
                </p>
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
                        @endphp

                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-4 py-4 text-slate-600">
                                {{ $loop->iteration }}
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
                                        'bulan' => $bulan,
                                        'tahun' => $tahun
                                    ]) }}"
                                   class="inline-flex items-center justify-center px-4 py-2 rounded-xl bg-blue-50 text-blue-700 font-semibold hover:bg-blue-100 transition">
                                    Detail
                                </a>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="9" class="px-4 py-8 text-center text-slate-500">
                                Data pegawai belum tersedia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

                <tfoot class="bg-slate-100 font-bold text-slate-800">
                    <tr>
                        <td colspan="3" class="px-4 py-4 text-center">
                            TOTAL KESELURUHAN
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

@endsection