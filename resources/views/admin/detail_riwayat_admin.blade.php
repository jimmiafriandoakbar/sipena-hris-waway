@extends('layouts.admin.app_admin')

@section('content')

<div class="p-6 space-y-6">

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Detail Riwayat Pegawai</h1>
                <p class="text-sm text-gray-500 mt-1">
                    Informasi riwayat pekerjaan, pelatihan, penghargaan, hukuman, dan dokumen pendukung pegawai.
                </p>
            </div>

            <a href="{{ route('admin.riwayat.pegawai') }}"
               class="inline-flex items-center justify-center px-5 py-2 rounded-xl border border-gray-300 text-gray-700 text-sm font-medium hover:bg-gray-50 transition">
                ← Kembali
            </a>
        </div>
    </div>

    {{-- PROFIL --}}
    <div class="bg-white rounded-2xl shadow border border-gray-100 p-6">
        <div class="flex flex-col md:flex-row md:items-center gap-5">
            <div class="w-20 h-20 rounded-2xl bg-blue-100 text-blue-700 flex items-center justify-center text-3xl font-bold">
                {{ strtoupper(substr($pegawai->nama ?? 'P', 0, 1)) }}
            </div>

            <div class="flex-1">
                <p class="text-sm text-gray-500">Pegawai</p>
                <h2 class="text-2xl font-bold text-gray-800">{{ $pegawai->nama ?? '-' }}</h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4 text-sm">
                    <div>
                        <p class="text-gray-400">NIP</p>
                        <p class="font-semibold text-gray-700">{{ $pegawai->nip ?? '-' }}</p>
                    </div>

                    <div>
                        <p class="text-gray-400">Jabatan</p>
                        <p class="font-semibold text-gray-700">{{ $pegawai->jabatanRelasi->nama_jabatan ?? '-' }}</p>
                    </div>

                    <div>
                        <p class="text-gray-400">Bagian</p>
                        <p class="font-semibold text-gray-700">{{ $pegawai->bagianRelasi->nama_bagian ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ACCORDION WRAPPER --}}
    <div class="space-y-4">

        {{-- RIWAYAT PEKERJAAN --}}
        <div class="bg-white rounded-2xl shadow border border-gray-100 overflow-hidden">
            <button type="button" onclick="toggleAccordion('accPekerjaan')"
                    class="w-full p-6 bg-gray-50 flex justify-between items-center text-left">
                <div>
                    <h2 class="text-lg font-bold text-gray-800">Riwayat Pekerjaan</h2>
                    <p class="text-sm text-gray-500">{{ $pegawai->riwayatPekerjaan->count() }} data pekerjaan</p>
                </div>
                <span class="text-gray-500 text-xl">⌄</span>
            </button>

            <div id="accPekerjaan" class="accordion-content">
                <div class="p-6 flex justify-end">
                    <button type="button" onclick="openModal('modalPekerjaan')"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-sm font-semibold">
                        + Tambah
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-white text-gray-600 border-y">
                            <tr>
                                <th class="px-5 py-4 text-left">Perusahaan</th>
                                <th class="px-5 py-4 text-left">Jabatan</th>
                                <th class="px-5 py-4 text-center">Tahun</th>
                                <th class="px-5 py-4 text-center">Jangka Waktu</th>
                                <th class="px-5 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">
                            @forelse($pegawai->riwayatPekerjaan->groupBy('perusahaan') as $perusahaan => $items)
                                @foreach($items as $index => $row)
                                    <tr class="hover:bg-gray-50">
                                        @if($index == 0)
                                            <td rowspan="{{ $items->count() }}" class="px-5 py-4 font-semibold text-gray-800 align-top">
                                                {{ $perusahaan }}
                                            </td>
                                        @endif

                                        <td class="px-5 py-4">{{ $row->jabatan ?? '-' }}</td>
                                        <td class="px-5 py-4 text-center">{{ $row->tahun ?? '-' }}</td>
                                        <td class="px-5 py-4 text-center">{{ $row->jangka_waktu ?? '-' }}</td>
                                        <td class="px-5 py-4 text-center">
                                            <button type="button" onclick="openModal('modalPekerjaan')" class="text-blue-600 text-xs font-semibold">
                                                Edit
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @empty
                                <tr>
                                    <td colspan="5" class="px-5 py-10 text-center text-gray-400">
                                        Belum ada riwayat pekerjaan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- RIWAYAT PELATIHAN --}}
        <div class="bg-white rounded-2xl shadow border border-gray-100 overflow-hidden">
            <button type="button" onclick="toggleAccordion('accPelatihan')"
                    class="w-full p-6 bg-gray-50 flex justify-between items-center text-left">
                <div>
                    <h2 class="text-lg font-bold text-gray-800">Riwayat Pelatihan / Sertifikasi</h2>
                    <p class="text-sm text-gray-500">{{ $pegawai->riwayatPelatihan->count() }} data pelatihan</p>
                </div>
                <span class="text-gray-500 text-xl">⌄</span>
            </button>

            <div id="accPelatihan" class="accordion-content hidden">
                <div class="p-6 flex justify-end">
                    <button type="button" onclick="openModal('modalPelatihan')"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-sm font-semibold">
                        + Tambah
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-white text-gray-600 border-y">
                            <tr>
                                <th class="px-5 py-4 text-left">Pelatihan</th>
                                <th class="px-5 py-4 text-left">Tempat</th>
                                <th class="px-5 py-4 text-center">Tanggal</th>
                                <th class="px-5 py-4 text-center">Sertifikat</th>
                                <th class="px-5 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">
                            @forelse($pegawai->riwayatPelatihan as $pelatihan)
                                @php
                                    $filePelatihan = $pelatihan->sertifikat ?? $pelatihan->file_path ?? null;
                                @endphp

                                <tr class="hover:bg-gray-50">
                                    <td class="px-5 py-4 font-semibold">{{ $pelatihan->pelatihan ?? '-' }}</td>
                                    <td class="px-5 py-4">{{ $pelatihan->tempat ?? '-' }}</td>
                                    <td class="px-5 py-4 text-center">
                                        {{ $pelatihan->tanggal ? \Carbon\Carbon::parse($pelatihan->tanggal)->format('d/m/Y') : '-' }}
                                    </td>
                                    <td class="px-5 py-4 text-center">
                                        @if($filePelatihan)
                                            <a href="{{ asset('storage/'.$filePelatihan) }}" target="_blank"
                                               class="inline-flex items-center gap-1 text-blue-600 text-xs font-medium hover:text-blue-800">
                                                <i data-lucide="eye" class="w-4 h-4"></i> Lihat
                                            </a>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 text-center">
                                        <button type="button" onclick="openModal('modalPelatihan')" class="text-blue-600 text-xs font-semibold">
                                            Edit
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-5 py-10 text-center text-gray-400">
                                        Belum ada riwayat pelatihan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- RIWAYAT PENGHARGAAN --}}
        <div class="bg-white rounded-2xl shadow border border-gray-100 overflow-hidden">
            <button type="button" onclick="toggleAccordion('accPenghargaan')"
                    class="w-full p-6 bg-gray-50 flex justify-between items-center text-left">
                <div>
                    <h2 class="text-lg font-bold text-gray-800">Riwayat Penghargaan</h2>
                    <p class="text-sm text-gray-500">{{ $pegawai->riwayatPenghargaan->count() }} data penghargaan</p>
                </div>
                <span class="text-gray-500 text-xl">⌄</span>
            </button>

            <div id="accPenghargaan" class="accordion-content hidden">
                <div class="p-6 flex justify-end">
                    <button type="button" onclick="openModal('modalPenghargaan')"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-sm font-semibold">
                        + Tambah
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-white text-gray-600 border-y">
                            <tr>
                                <th class="px-5 py-4 text-left">Award</th>
                                <th class="px-5 py-4 text-center">Tahun</th>
                                <th class="px-5 py-4 text-left">Tempat</th>
                                <th class="px-5 py-4 text-center">Sertifikat</th>
                                <th class="px-5 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">
                            @forelse($pegawai->riwayatPenghargaan as $penghargaan)
                                @php
                                    $filePenghargaan = $penghargaan->sertifikat ?? $penghargaan->file_path ?? null;
                                @endphp

                                <tr class="hover:bg-gray-50">
                                    <td class="px-5 py-4 font-semibold">{{ $penghargaan->award ?? '-' }}</td>
                                    <td class="px-5 py-4 text-center">{{ $penghargaan->tahun ?? '-' }}</td>
                                    <td class="px-5 py-4">{{ $penghargaan->tempat ?? '-' }}</td>
                                    <td class="px-5 py-4 text-center">
                                        @if($filePenghargaan)
                                            <a href="{{ asset('storage/'.$filePenghargaan) }}" target="_blank"
                                               class="inline-flex items-center gap-1 text-blue-600 text-xs font-medium hover:text-blue-800">
                                                <i data-lucide="eye" class="w-4 h-4"></i> Lihat
                                            </a>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 text-center">
                                        <button type="button" onclick="openModal('modalPenghargaan')" class="text-blue-600 text-xs font-semibold">
                                            Edit
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-5 py-10 text-center text-gray-400">
                                        Belum ada riwayat penghargaan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- RIWAYAT HUKUMAN --}}
        <div class="bg-white rounded-2xl shadow border border-gray-100 overflow-hidden">
            <button type="button" onclick="toggleAccordion('accHukuman')"
                    class="w-full p-6 bg-gray-50 flex justify-between items-center text-left">
                <div>
                    <h2 class="text-lg font-bold text-gray-800">Riwayat Hukuman</h2>
                    <p class="text-sm text-gray-500">{{ $pegawai->riwayatHukuman->count() }} data hukuman</p>
                </div>
                <span class="text-gray-500 text-xl">⌄</span>
            </button>

            <div id="accHukuman" class="accordion-content hidden">
                <div class="p-6 flex justify-end">
                    <button type="button" onclick="openModal('modalHukuman')"
                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-xl text-sm font-semibold">
                        + Tambah
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-white text-gray-600 border-y">
                            <tr>
                                <th class="px-5 py-4 text-left">Jenis SP</th>
                                <th class="px-5 py-4 text-center">Tanggal</th>
                                <th class="px-5 py-4 text-left">Keterangan</th>
                                <th class="px-5 py-4 text-center">File</th>
                                <th class="px-5 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">
                            @forelse($pegawai->riwayatHukuman as $hukuman)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-5 py-4">
                                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            {{ $hukuman->jenis_sp ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 text-center">
                                        {{ $hukuman->tanggal ? \Carbon\Carbon::parse($hukuman->tanggal)->format('d/m/Y') : '-' }}
                                    </td>
                                    <td class="px-5 py-4">{{ $hukuman->keterangan ?? '-' }}</td>
                                    <td class="px-5 py-4 text-center">
                                        @if($hukuman->file_path)
                                            <a href="{{ asset('storage/'.$hukuman->file_path) }}" target="_blank"
                                               class="inline-flex items-center gap-1 text-blue-600 text-xs font-medium hover:text-blue-800">
                                                <i data-lucide="eye" class="w-4 h-4"></i> Lihat
                                            </a>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 text-center">
                                        <button type="button" onclick="openModal('modalHukuman')" class="text-blue-600 text-xs font-semibold">
                                            Edit
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-5 py-10 text-center text-gray-400">
                                        Belum ada riwayat hukuman.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- DOKUMEN --}}
        <div class="bg-white rounded-2xl shadow border border-gray-100 overflow-hidden">
            <button type="button" onclick="toggleAccordion('accDokumen')"
                    class="w-full p-6 bg-gray-50 flex justify-between items-center text-left">
                <div>
                    <h2 class="text-lg font-bold text-gray-800">Dokumen Pendukung</h2>
                    <p class="text-sm text-gray-500">{{ $pegawai->riwayatDokumen->count() }} dokumen pendukung</p>
                </div>
                <span class="text-gray-500 text-xl">⌄</span>
            </button>

            <div id="accDokumen" class="accordion-content hidden">
                <div class="p-6 flex justify-end">
                    <button type="button" onclick="openModal('modalDokumen')"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-sm font-semibold">
                        + Upload
                    </button>
                </div>

                <div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($pegawai->riwayatDokumen as $dokumen)
                        @php
                            $fileDokumen = $dokumen->file_path ?? $dokumen->file ?? null;
                        @endphp

                        <div class="border border-gray-200 rounded-2xl p-5 hover:shadow-md transition">
                            <div class="flex justify-between items-start gap-3">
                                <div>
                                    <div class="w-11 h-11 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center mb-3">
                                        <i data-lucide="file-text" class="w-5 h-5"></i>
                                    </div>

                                    <h3 class="font-bold text-gray-800">{{ $dokumen->jenis_dokumen ?? '-' }}</h3>
                                    <p class="text-sm text-gray-500 mt-1">Dokumen pendukung pegawai</p>
                                </div>

                                @if($fileDokumen)
                                    <a href="{{ asset('storage/'.$fileDokumen) }}" target="_blank"
                                       class="inline-flex items-center gap-1 text-blue-600 text-xs font-medium hover:text-blue-800">
                                        <i data-lucide="eye" class="w-4 h-4"></i> Lihat
                                    </a>
                                @else
                                    <span class="text-gray-400 text-xs">-</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-10 text-center text-gray-400">
                            Belum ada dokumen pendukung.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>

{{-- MODAL PEKERJAAN --}}
<div id="modalPekerjaan" class="hidden fixed inset-0 z-50 bg-black/50 items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-xl">
        <form method="POST" action="{{ route('admin.riwayat.pegawai.pekerjaan.store', $pegawai->id) }}">
            @csrf
            <div class="p-6 border-b flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-800">Tambah Riwayat Pekerjaan</h3>
                <button type="button" onclick="closeModal('modalPekerjaan')" class="text-gray-400 hover:text-gray-700">✕</button>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="text-sm font-semibold text-gray-700">Perusahaan</label>
                    <input type="text" name="perusahaan" class="mt-1 w-full border rounded-xl px-4 py-2" placeholder="Perusahaan / Instansi" required>
                </div>

                <div>
                    <label class="text-sm font-semibold text-gray-700">Jabatan</label>
                    <input type="text" name="jabatan" class="mt-1 w-full border rounded-xl px-4 py-2" placeholder="Staff IT" required>
                </div>

                <div>
                    <label class="text-sm font-semibold text-gray-700">Tahun</label>
                    <input type="number" name="tahun" class="mt-1 w-full border rounded-xl px-4 py-2" placeholder="2026">
                </div>

                <div class="md:col-span-2">
                    <label class="text-sm font-semibold text-gray-700">Jangka Waktu</label>
                    <input type="text" name="jangka_waktu" class="mt-1 w-full border rounded-xl px-4 py-2" placeholder="3 Bulan / Sekarang">
                </div>
            </div>

            <div class="p-6 border-t flex justify-end gap-3">
                <button type="button" onclick="closeModal('modalPekerjaan')" class="px-5 py-2 rounded-xl bg-gray-100 text-gray-700">Batal</button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-blue-600 text-white">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL PELATIHAN --}}
<div id="modalPelatihan" class="hidden fixed inset-0 z-50 bg-black/50 items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-xl">
        <form method="POST" action="{{ route('admin.riwayat.pegawai.pelatihan.store', $pegawai->id) }}" enctype="multipart/form-data">
            @csrf
            <div class="p-6 border-b flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-800">Tambah Pelatihan / Sertifikasi</h3>
                <button type="button" onclick="closeModal('modalPelatihan')" class="text-gray-400 hover:text-gray-700">✕</button>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-semibold text-gray-700">Nama Pelatihan</label>
                    <input type="text" name="pelatihan" class="mt-1 w-full border rounded-xl px-4 py-2" required>
                </div>

                <div>
                    <label class="text-sm font-semibold text-gray-700">Tempat</label>
                    <input type="text" name="tempat" class="mt-1 w-full border rounded-xl px-4 py-2">
                </div>

                <div>
                    <label class="text-sm font-semibold text-gray-700">Tanggal</label>
                    <input type="date" name="tanggal" class="mt-1 w-full border rounded-xl px-4 py-2">
                </div>

                <div>
                    <label class="text-sm font-semibold text-gray-700">Sertifikat</label>
                    <input type="file" name="sertifikat" class="mt-1 w-full border rounded-xl px-4 py-2">
                </div>
            </div>

            <div class="p-6 border-t flex justify-end gap-3">
                <button type="button" onclick="closeModal('modalPelatihan')" class="px-5 py-2 rounded-xl bg-gray-100 text-gray-700">Batal</button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-blue-600 text-white">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL PENGHARGAAN --}}
<div id="modalPenghargaan" class="hidden fixed inset-0 z-50 bg-black/50 items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-xl">
        <form method="POST" action="{{ route('admin.riwayat.pegawai.penghargaan.store', $pegawai->id) }}" enctype="multipart/form-data">
            @csrf
            <div class="p-6 border-b flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-800">Tambah Penghargaan</h3>
                <button type="button" onclick="closeModal('modalPenghargaan')" class="text-gray-400 hover:text-gray-700">✕</button>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-semibold text-gray-700">Award</label>
                    <input type="text" name="award" class="mt-1 w-full border rounded-xl px-4 py-2" required>
                </div>

                <div>
                    <label class="text-sm font-semibold text-gray-700">Tahun</label>
                    <input type="number" name="tahun" class="mt-1 w-full border rounded-xl px-4 py-2">
                </div>

                <div>
                    <label class="text-sm font-semibold text-gray-700">Tempat</label>
                    <input type="text" name="tempat" class="mt-1 w-full border rounded-xl px-4 py-2">
                </div>

                <div>
                    <label class="text-sm font-semibold text-gray-700">Sertifikat</label>
                    <input type="file" name="sertifikat" class="mt-1 w-full border rounded-xl px-4 py-2">
                </div>
            </div>

            <div class="p-6 border-t flex justify-end gap-3">
                <button type="button" onclick="closeModal('modalPenghargaan')" class="px-5 py-2 rounded-xl bg-gray-100 text-gray-700">Batal</button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-blue-600 text-white">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL HUKUMAN --}}
<div id="modalHukuman" class="hidden fixed inset-0 z-50 bg-black/50 items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-xl">
        <form method="POST" action="{{ route('admin.riwayat.pegawai.hukuman.store', $pegawai->id) }}" enctype="multipart/form-data">
            @csrf
            <div class="p-6 border-b flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-800">Tambah Riwayat Hukuman</h3>
                <button type="button" onclick="closeModal('modalHukuman')" class="text-gray-400 hover:text-gray-700">✕</button>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-semibold text-gray-700">Jenis SP</label>
                    <select name="jenis_sp" class="mt-1 w-full border rounded-xl px-4 py-2" required>
                        <option value="">Pilih SP</option>
                        <option value="SP 1">SP 1</option>
                        <option value="SP 2">SP 2</option>
                        <option value="SP 3">SP 3</option>
                    </select>
                </div>

                <div>
                    <label class="text-sm font-semibold text-gray-700">Tanggal</label>
                    <input type="date" name="tanggal" class="mt-1 w-full border rounded-xl px-4 py-2">
                </div>

                <div class="md:col-span-2">
                    <label class="text-sm font-semibold text-gray-700">Keterangan</label>
                    <textarea name="keterangan" rows="3" class="mt-1 w-full border rounded-xl px-4 py-2"></textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="text-sm font-semibold text-gray-700">Upload File SP</label>
                    <input type="file" name="file_path" class="mt-1 w-full border rounded-xl px-4 py-2">
                    <p class="text-xs text-gray-400 mt-1">Format: PDF, JPG, JPEG, PNG. Maksimal 2MB.</p>
                </div>
            </div>

            <div class="p-6 border-t flex justify-end gap-3">
                <button type="button" onclick="closeModal('modalHukuman')" class="px-5 py-2 rounded-xl bg-gray-100 text-gray-700">Batal</button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-red-600 text-white">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL DOKUMEN --}}
<div id="modalDokumen" class="hidden fixed inset-0 z-50 bg-black/50 items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-xl">
        <form method="POST" action="{{ route('admin.riwayat.pegawai.dokumen.store', $pegawai->id) }}" enctype="multipart/form-data">
            @csrf
            <div class="p-6 border-b flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-800">Upload Dokumen Pendukung</h3>
                <button type="button" onclick="closeModal('modalDokumen')" class="text-gray-400 hover:text-gray-700">✕</button>
            </div>

            <div class="p-6 grid grid-cols-1 gap-4">
                <div>
                    <label class="text-sm font-semibold text-gray-700">Jenis Dokumen</label>
                    <select name="jenis_dokumen" class="mt-1 w-full border rounded-xl px-4 py-2" required>
                        <option value="">Pilih Dokumen</option>
                        <option value="CV PDF">CV PDF</option>
                        <option value="Ijazah">Ijazah</option>
                        <option value="KTP">KTP</option>
                        <option value="NPWP">NPWP</option>
                        <option value="BPJS">BPJS</option>
                    </select>
                </div>

                <div>
                    <label class="text-sm font-semibold text-gray-700">File Dokumen</label>
                    <input type="file" name="file" class="mt-1 w-full border rounded-xl px-4 py-2" required>
                    <p class="text-xs text-gray-400 mt-1">Format disarankan: PDF, JPG, PNG.</p>
                </div>
            </div>

            <div class="p-6 border-t flex justify-end gap-3">
                <button type="button" onclick="closeModal('modalDokumen')" class="px-5 py-2 rounded-xl bg-gray-100 text-gray-700">Batal</button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-blue-600 text-white">Upload</button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleAccordion(id) {
        const el = document.getElementById(id);
        el.classList.toggle('hidden');

        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }

    function openModal(id) {
        const modal = document.getElementById(id);
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('[id^="modal"]').forEach(function(modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            });
        }
    });

    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
</script>

@endsection