@extends('layouts.admin.app_admin')

@section('content')

<!-- HEADER -->
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Dashboard Pegawai</h1>
    <p class="text-gray-500">Kelola surat masuk dan keluar dengan mudah.</p>
</div>

<!-- CARD STATISTIK -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">

    <!-- Surat Masuk -->
    <div class="bg-white p-5 rounded-xl shadow flex items-center justify-between">
        <div>
            <p class="text-gray-500">Surat Masuk</p>
            <h2 class="text-2xl font-bold">10</h2>
        </div>
        <div class="bg-blue-500 text-white p-3 rounded-lg">
            <i data-lucide="inbox"></i>
        </div>
    </div>

    <!-- Surat Keluar -->
    <div class="bg-white p-5 rounded-xl shadow flex items-center justify-between">
        <div>
            <p class="text-gray-500">Surat Keluar</p>
            <h2 class="text-2xl font-bold">5</h2>
        </div>
        <div class="bg-green-500 text-white p-3 rounded-lg">
            <i data-lucide="send"></i>
        </div>
    </div>

    <!-- Draft -->
    <div class="bg-white p-5 rounded-xl shadow flex items-center justify-between">
        <div>
            <p class="text-gray-500">Draft Surat</p>
            <h2 class="text-2xl font-bold">2</h2>
        </div>
        <div class="bg-yellow-500 text-white p-3 rounded-lg">
            <i data-lucide="file-edit"></i>
        </div>
    </div>

    <!-- Total -->
    <div class="bg-white p-5 rounded-xl shadow flex items-center justify-between">
        <div>
            <p class="text-gray-500">Total Surat</p>
            <h2 class="text-2xl font-bold">17</h2>
        </div>
        <div class="bg-red-500 text-white p-3 rounded-lg">
            <i data-lucide="file-text"></i>
        </div>
    </div>

</div>

<!-- TABEL SURAT TERBARU -->
<div class="bg-white p-6 rounded-xl shadow">

    <h2 class="text-xl font-semibold mb-4">Surat Terbaru</h2>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">

            <thead>
                <tr class="bg-gray-800 text-white">
                    <th class="p-3">No Surat</th>
                    <th class="p-3">Perihal</th>
                    <th class="p-3">Tanggal</th>
                    <th class="p-3">Jenis</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>

            <tbody>

                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3">ND-001</td>
                    <td class="p-3">Permohonan Dana</td>
                    <td class="p-3">17 Apr 2026</td>
                    <td class="p-3">Masuk</td>
                    <td class="p-3">
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                            Disetujui
                        </span>
                    </td>
                    <td class="p-3 flex gap-2">
                        <button
                            class="px-2 py-1 bg-blue-500 hover:bg-blue-600 text-white rounded flex items-center justify-center transition">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </button>

                        <button
                            class="px-2 py-1 bg-yellow-500 hover:bg-yellow-600 text-white rounded flex items-center justify-center transition">
                            <i data-lucide="pencil" class="w-4 h-4"></i>
                        </button>
                    </td>
                </tr>

                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3">ND-002</td>
                    <td class="p-3">Laporan Bulanan</td>
                    <td class="p-3">16 Apr 2026</td>
                    <td class="p-3">Keluar</td>
                    <td class="p-3">
                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm">
                            Proses
                        </span>
                    </td>
                    <td class="p-3 flex gap-2">
                        <button
                            class="px-2 py-1 bg-blue-500 hover:bg-blue-600 text-white rounded flex items-center justify-center transition">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </button>

                        <button
                            class="px-2 py-1 bg-yellow-500 hover:bg-yellow-600 text-white rounded flex items-center justify-center transition">
                            <i data-lucide="pencil" class="w-4 h-4"></i>
                        </button>
                    </td>
                </tr>

            </tbody>

        </table>
    </div>

</div>

@endsection