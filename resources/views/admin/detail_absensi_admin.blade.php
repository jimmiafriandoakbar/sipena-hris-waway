@extends('layouts.admin.app_admin')

@section('content')

<div class="p-6 bg-slate-50 min-h-screen">

    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <div>
            <h1 class="text-3xl font-bold text-slate-800">
                Detail Absensi Pegawai
            </h1>
            <p class="text-slate-500 mt-1">
                {{ $pegawai->nama }} -
                {{ \Carbon\Carbon::createFromDate($tahun, $bulan, 1)->translatedFormat('F Y') }}
            </p>
        </div>

        <a href="{{ route('admin.absensi.rekap', [
                'bulan' => $bulan,
                'tahun' => $tahun
            ]) }}"
           class="px-5 py-3 rounded-xl bg-slate-800 text-white font-semibold">
            Kembali
        </a>

    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6 mb-6">

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

            <div class="p-4 rounded-2xl bg-slate-50 border">
                <p class="text-slate-500 text-sm">Nama Pegawai</p>
                <p class="font-bold text-slate-800">
                    {{ $pegawai->nama }}
                </p>
            </div>

            <div class="p-4 rounded-2xl bg-slate-50 border">
                <p class="text-slate-500 text-sm">Jabatan</p>
                <p class="font-bold text-slate-800">
                    {{ $pegawai->jabatanRelasi->nama_jabatan ?? '-' }}
                </p>
            </div>

            <div class="p-4 rounded-2xl bg-slate-50 border">
                <p class="text-slate-500 text-sm">Periode</p>
                <p class="font-bold text-slate-800">
                    {{ \Carbon\Carbon::createFromDate($tahun, $bulan, 1)->translatedFormat('F Y') }}
                </p>
            </div>

            <div class="p-4 rounded-2xl bg-blue-50 border border-blue-200">
                <p class="text-blue-600 text-sm">Total Data Absensi</p>
                <p class="font-bold text-blue-700">
                    {{ $absensis->count() }} Hari
                </p>
            </div>

        </div>

    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-100 text-slate-700">
                    <tr>
                        <th class="px-4 py-3 text-left">Tanggal</th>
                        <th class="px-4 py-3 text-center">Hari</th>
                        <th class="px-4 py-3 text-center">Jam Masuk</th>
                        <th class="px-4 py-3 text-center">Jam Pulang</th>
                        <th class="px-4 py-3 text-center">Status Masuk</th>
                        <th class="px-4 py-3 text-center">Status Pulang</th>
                        <th class="px-4 py-3 text-center">Telat</th>
                        <th class="px-4 py-3 text-center">Pulang Cepat</th>
                        <th class="px-4 py-3 text-center">Lembur</th>
                        <th class="px-4 py-3 text-center">Jarak Masuk</th>
                        <th class="px-4 py-3 text-center">Jarak Pulang</th>
                        <th class="px-4 py-3 text-center">Foto</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse($absensis as $item)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3 font-semibold">
                                {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}
                            </td>

                            <td class="px-4 py-3 text-center">
                                {{ $item->nama_hari ?? '-' }}
                            </td>

                            <td class="px-4 py-3 text-center">
                                {{ $item->jam_masuk ?? '-' }}
                            </td>

                            <td class="px-4 py-3 text-center">
                                {{ $item->jam_pulang ?? '-' }}
                            </td>

                            <td class="px-4 py-3 text-center">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    {{ $item->status_masuk == 'terlambat'
                                        ? 'bg-red-100 text-red-700'
                                        : 'bg-green-100 text-green-700' }}">
                                    {{ ucfirst($item->status_masuk) }}
                                </span>
                            </td>

                            <td class="px-4 py-3 text-center">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    {{ $item->status_pulang == 'pulang_cepat'
                                        ? 'bg-orange-100 text-orange-700'
                                        : 'bg-blue-100 text-blue-700' }}">
                                    {{ ucfirst(str_replace('_', ' ', $item->status_pulang)) }}
                                </span>
                            </td>

                            <td class="px-4 py-3 text-center">
                                {{ $item->menit_terlambat }} Menit
                            </td>

                            <td class="px-4 py-3 text-center">
                                {{ $item->menit_pulang_cepat }} Menit
                            </td>

                            <td class="px-4 py-3 text-center font-semibold">
                                {{ floor($item->total_menit_lembur / 60) }}
                                Jam
                                {{ $item->total_menit_lembur % 60 }}
                                Menit
                            </td>

                            <td class="px-4 py-3 text-center">
                                {{ $item->jarak_masuk ?? '-' }} m
                            </td>

                            <td class="px-4 py-3 text-center">
                                {{ $item->jarak_pulang ?? '-' }} m
                            </td>

                            <td class="px-4 py-3 text-center">
                                <div class="flex justify-center gap-3">

                                    @if($item->foto_masuk)
                                        <a href="{{ asset('storage/' . $item->foto_masuk) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $item->foto_masuk) }}"
                                                class="w-14 h-14 rounded-xl object-cover border border-green-300">
                                        </a>
                                    @else
                                        <span class="text-slate-400">-</span>
                                    @endif

                                    @if($item->foto_pulang)
                                        <a href="{{ asset('storage/' . $item->foto_pulang) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $item->foto_pulang) }}"
                                                class="w-14 h-14 rounded-xl object-cover border border-red-300">
                                        </a>
                                    @endif

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="px-4 py-6 text-center text-slate-500">
                                Belum ada data absensi pada periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>

</div>

@endsection