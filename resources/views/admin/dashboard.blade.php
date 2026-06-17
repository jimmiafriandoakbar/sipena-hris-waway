@extends('layouts.admin.app_admin')

@section('content')

<div class="mb-7 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h1 class="text-3xl font-bold text-slate-800">
            Dashboard Admin
        </h1>
        <p class="text-slate-500 mt-1">
            Monitoring pegawai dan absensi hari ini.
        </p>
    </div>

    <div class="px-5 py-3 rounded-2xl bg-white border border-slate-200 shadow-sm">
        <p class="text-xs text-slate-500">Tanggal</p>
        <p class="font-bold text-blue-700">
            {{ \Carbon\Carbon::now('Asia/Jakarta')->translatedFormat('d F Y') }}
        </p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-5 mb-7">

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-slate-500">Total Pegawai</p>
                <h2 class="text-3xl font-bold text-slate-800 mt-1">
                    {{ $jumlahPegawai }}
                </h2>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center">
                <i data-lucide="users" class="w-6 h-6"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-slate-500">Sudah Absen Masuk</p>
                <h2 class="text-3xl font-bold text-emerald-600 mt-1">
                    {{ $pegawaiSudahAbsenMasuk }}
                </h2>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <i data-lucide="check-circle" class="w-6 h-6"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-slate-500">Belum Absen Masuk</p>
                <h2 class="text-3xl font-bold text-red-600 mt-1">
                    {{ $pegawaiTidakAbsenMasuk }}
                </h2>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center">
                <i data-lucide="x-circle" class="w-6 h-6"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-slate-500">Terlambat</p>
                <h2 class="text-3xl font-bold text-orange-600 mt-1">
                    {{ $pegawaiTerlambat->count() }}
                </h2>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-orange-50 text-orange-600 flex items-center justify-center">
                <i data-lucide="clock" class="w-6 h-6"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-slate-500">Pulang Cepat</p>
                <h2 class="text-3xl font-bold text-yellow-600 mt-1">
                    {{ $pegawaiPulangCepat->count() }}
                </h2>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-yellow-50 text-yellow-600 flex items-center justify-center">
                <i data-lucide="log-out" class="w-6 h-6"></i>
            </div>
        </div>
    </div>

</div>

<div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b bg-slate-50">
            <h2 class="font-bold text-slate-800">
                Pegawai Belum Absen Masuk
            </h2>
            <p class="text-sm text-slate-500 mt-1">
                Daftar pegawai yang belum melakukan check-in hari ini.
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-white text-slate-500 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4 text-left">Nama</th>
                        <th class="px-6 py-4 text-left">NIP</th>
                        <th class="px-6 py-4 text-left">Jabatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pegawaiBelumAbsenMasuk as $p)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 font-semibold text-slate-800">
                                {{ $p->nama }}
                            </td>
                            <td class="px-6 py-4 text-slate-500">
                                {{ $p->nip ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-slate-500">
                                {{ $p->jabatanRelasi->nama_jabatan ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-slate-500">
                                Semua pegawai sudah absen masuk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b bg-slate-50">
            <h2 class="font-bold text-slate-800">
                Pegawai Tidak Absen Pulang
            </h2>
            <p class="text-sm text-slate-500 mt-1">
                Pegawai yang sudah masuk tetapi belum check-out.
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-white text-slate-500 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4 text-left">Nama</th>
                        <th class="px-6 py-4 text-left">Jam Masuk</th>
                        <th class="px-6 py-4 text-left">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pegawaiTidakAbsenPulang as $a)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 font-semibold text-slate-800">
                                {{ $a->pegawai->nama ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-slate-500">
                                {{ $a->jam_masuk ?? '-' }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full bg-yellow-50 text-yellow-700 text-xs font-bold">
                                    Belum Absen Pulang
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-slate-500">
                                Tidak ada pegawai yang belum absen pulang.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mt-6">

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b bg-slate-50">
            <h2 class="font-bold text-slate-800">
                Pegawai Terlambat
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-white text-slate-500 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4 text-left">Nama</th>
                        <th class="px-6 py-4 text-left">Jam Masuk</th>
                        <th class="px-6 py-4 text-left">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pegawaiTerlambat as $a)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 font-semibold text-slate-800">
                                {{ $a->pegawai->nama ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-slate-500">
                                {{ $a->jam_masuk ?? '-' }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full bg-red-50 text-red-700 text-xs font-bold">
                                    Terlambat
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-slate-500">
                                Tidak ada pegawai terlambat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b bg-slate-50">
            <h2 class="font-bold text-slate-800">
                Pegawai Pulang Cepat
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-white text-slate-500 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4 text-left">Nama</th>
                        <th class="px-6 py-4 text-left">Jam Pulang</th>
                        <th class="px-6 py-4 text-left">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pegawaiPulangCepat as $a)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 font-semibold text-slate-800">
                                {{ $a->pegawai->nama ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-slate-500">
                                {{ $a->jam_pulang ?? '-' }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full bg-orange-50 text-orange-700 text-xs font-bold">
                                    Pulang Cepat
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-slate-500">
                                Tidak ada pegawai pulang cepat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<script>
    if (window.lucide) {
        lucide.createIcons();
    }
</script>

@endsection