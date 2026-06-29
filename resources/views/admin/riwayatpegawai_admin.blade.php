@extends('layouts.admin.app_admin')

@section('content')

<div class="p-6 space-y-6">

    {{-- HEADER --}}
    <div class="bg-white rounded-2xl shadow p-6 mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Riwayat Pegawai</h1>
    <p class="text-gray-500 mt-1">
        Daftar pegawai untuk melihat riwayat pekerjaan, pelatihan, penghargaan, hukuman, dan dokumen pendukung.
    </p>
</div>

    {{-- CARD --}}
    <div class="bg-white rounded-2xl shadow border border-gray-100">

        {{-- SEARCH --}}
        <div class="p-6 border-b border-gray-100">
            <form method="GET" action="{{ route('admin.riwayat.pegawai') }}">
                <div class="flex flex-col md:flex-row gap-3">
                    <div class="relative flex-1">
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Cari nama, NIP, jabatan, atau bagian..."
                               class="w-full border border-gray-300 rounded-xl px-4 py-3 pl-11 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">

                        <i data-lucide="search"
                    class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                    </div>

                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl text-sm font-semibold shadow">
                        Cari
                    </button>

                    <a href="{{ route('admin.riwayat.pegawai') }}"
                       class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-xl text-sm font-semibold text-center">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        {{-- TABLE --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 border-b">
                        <th class="px-5 py-4 text-center w-16">No</th>
                        <th class="px-5 py-4 text-left">Nama Pegawai</th>
                        <th class="px-5 py-4 text-left">NIP</th>
                        <th class="px-5 py-4 text-left">Jabatan</th>
                        <th class="px-5 py-4 text-left">Bagian</th>
                        <th class="px-5 py-4 text-center w-40">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse($pegawais as $pegawai)
                        <tr class="hover:bg-blue-50/40 transition">

                            <td class="px-5 py-4 text-center text-gray-500">
                                {{ $loop->iteration + ($pegawais->currentPage() - 1) * $pegawais->perPage() }}
                            </td>

                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold">
                                        {{ strtoupper(substr($pegawai->nama, 0, 1)) }}
                                    </div>

                                    <div>
                                        <p class="font-semibold text-gray-800">
                                            {{ $pegawai->nama }}
                                        </p>
                                        <p class="text-xs text-gray-400">
                                            Pegawai SIPENA
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-5 py-4 text-gray-700">
                                {{ $pegawai->nip ?? '-' }}
                            </td>

                            <td class="px-5 py-4">
                                <span class="inline-flex px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold">
                                    {{ $pegawai->jabatanRelasi->nama_jabatan ?? '-' }}
                                </span>
                            </td>

                            <td class="px-5 py-4">
                                <span class="inline-flex px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-semibold">
                                    {{ $pegawai->bagianRelasi->nama_bagian ?? '-' }}
                                </span>
                            </td>

                            <td class="px-5 py-4 text-center">
                                <a href="{{ route('admin.riwayat.pegawai.detail', $pegawai->id) }}"
                                class="inline-flex items-center bg-slate-900 hover:bg-slate-800 text-white px-4 py-2 rounded-lg text-xs">
                                    Lihat Riwayat
                                </a>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-10 text-center text-gray-500">
                                Data pegawai tidak ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION NEXT PREV --}}
        <div class="p-6 border-t border-gray-100 flex flex-col md:flex-row justify-between items-center gap-3">

            <p class="text-sm text-gray-500">
                Menampilkan
                <b>{{ $pegawais->firstItem() ?? 0 }}</b>
                sampai
                <b>{{ $pegawais->lastItem() ?? 0 }}</b>
                dari
                <b>{{ $pegawais->total() }}</b>
                data
            </p>

            <div class="flex items-center gap-2">

                @if ($pegawais->onFirstPage())
                    <span class="px-4 py-2 rounded-lg bg-gray-100 text-gray-400 text-sm cursor-not-allowed">
                        Prev
                    </span>
                @else
                    <a href="{{ $pegawais->previousPageUrl() }}"
                       class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-semibold">
                        Prev
                    </a>
                @endif

                <span class="px-4 py-2 rounded-lg bg-blue-600 text-white text-sm font-semibold">
                    {{ $pegawais->currentPage() }}
                </span>

                @if ($pegawais->hasMorePages())
                    <a href="{{ $pegawais->nextPageUrl() }}"
                       class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-semibold">
                        Next
                    </a>
                @else
                    <span class="px-4 py-2 rounded-lg bg-gray-100 text-gray-400 text-sm cursor-not-allowed">
                        Next
                    </span>
                @endif

            </div>
        </div>

    </div>
</div>

@endsection