@extends('layouts.admin.app_admin')

@section('content')

<div class="max-w-5xl mx-auto mt-8">

    <div class="bg-white rounded-2xl shadow border border-gray-200 overflow-hidden">

        <!-- FORM -->
        <form action="{{ route('admin.pegawai.update', $pegawai->id) }}" method="POST" enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <!-- HEADER -->
            <div class="px-8 py-6 border-b bg-gradient-to-r from-slate-50 to-white flex items-center justify-between">

                <div>

                    <h2 class="text-xl font-semibold text-slate-800">
                        Edit Pegawai
                    </h2>

                    <p class="text-sm text-slate-500 mt-1">
                        Perbarui data pegawai dengan benar dan sesuai dokumen resmi.
                    </p>

                </div>

                <div class="px-4 py-2 rounded-xl bg-blue-50 border border-blue-100">

                    <p class="text-xs text-blue-500 font-medium">
                        ID PEGAWAI
                    </p>

                    <p class="text-lg font-bold text-blue-700">
                        #{{ $pegawai->id }}
                    </p>

                </div>

            </div>


            <!-- ERROR -->
            @if ($errors->any())

            <div class="mx-8 mt-6 rounded-xl border border-red-200 bg-red-50 p-4">

                <ul class="text-sm text-red-600 space-y-1">

                    @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                    @endforeach

                </ul>

            </div>

            @endif


            <div class="p-8 space-y-10">

                <!-- ========================= -->
                <!-- DATA PEGAWAI -->
                <!-- ========================= -->
                <div>

                    <div class="flex items-center gap-3 mb-6">

                        <div class="w-9 h-9 rounded-lg bg-blue-50 flex items-center justify-center">

                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5.121 17.804A9 9 0 1118.88 17.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />

                            </svg>

                        </div>

                        <div>

                            <h3 class="text-base font-semibold text-slate-800">
                                Data Pegawai
                            </h3>

                            <p class="text-sm text-slate-500">
                                Informasi identitas pegawai
                            </p>

                        </div>

                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                        <!-- NAMA -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Nama Lengkap
                            </label>

                            <input type="text" name="nama" value="{{ old('nama', $pegawai->nama) }}"
                                placeholder="Masukkan nama lengkap" class="w-full h-12 px-4 rounded-xl border border-slate-300 bg-white
        focus:ring-4 focus:ring-blue-100 focus:border-blue-500
        transition duration-200 text-sm outline-none shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                NIP
                            </label>

                            <input type="text" name="nip" value="{{ old('nip', $pegawai->nip) }}"
                                placeholder="Masukkan NIP" class="w-full h-12 px-4 rounded-xl border border-slate-300 bg-white
        focus:ring-4 focus:ring-blue-100 focus:border-blue-500
        transition duration-200 text-sm outline-none shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Bagian
                            </label>

                            <select name="bagian_id" class="w-full h-12 px-4 rounded-xl border border-slate-300 bg-white
                                focus:ring-4 focus:ring-blue-100 focus:border-blue-500
                                transition duration-200 text-sm outline-none shadow-sm">

                                <option value="">
                                    Pilih Bagian
                                </option>

                                @foreach($bagian as $item)

                                    <option
                                        value="{{ $item->id }}"
                                        {{ old('bagian_id', $pegawai->bagian_id ?? '') == $item->id ? 'selected' : '' }}>

                                        {{ $item->nama_bagian }}

                                    </option>

                                @endforeach

                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Jabatan
                            </label>

                            <select name="jabatan_id" class="w-full h-12 px-4 rounded-xl border border-slate-300 bg-white
    focus:ring-4 focus:ring-blue-100 focus:border-blue-500
    transition duration-200 text-sm outline-none shadow-sm">

                                <option value="">
                                    Pilih Jabatan
                                </option>

                                @foreach($jabatan as $item)

                                        <option value="{{ $item->id }}"
                                            {{ old('jabatan_id', $pegawai->jabatan_id ?? '') == $item->id ? 'selected' : '' }}>

                                            {{ $item->nama_jabatan }}

                                        </option>

                                @endforeach

                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Pendidikan
                            </label>

                            <input type="text" name="pendidikan" value="{{ old('pendidikan', $pegawai->pendidikan) }}"
                                placeholder="Contoh: S1" class="w-full h-12 px-4 rounded-xl border border-slate-300 bg-white
        focus:ring-4 focus:ring-blue-100 focus:border-blue-500
        transition duration-200 text-sm outline-none shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Jurusan
                            </label>

                            <input type="text" name="jurusan" value="{{ old('jurusan', $pegawai->jurusan) }}"
                                placeholder="Contoh: Teknik Informatika" class="w-full h-12 px-4 rounded-xl border border-slate-300 bg-white
        focus:ring-4 focus:ring-blue-100 focus:border-blue-500
        transition duration-200 text-sm outline-none shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Mulai Bekerja
                            </label>

                            <input type="date" name="mulai_bekerja"
                                value="{{ old('mulai_bekerja', $pegawai->mulai_bekerja) }}" class="w-full h-12 px-4 rounded-xl border border-slate-300 bg-white
        focus:ring-4 focus:ring-blue-100 focus:border-blue-500
        transition duration-200 text-sm outline-none shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Email
                            </label>

                            <input type="email" name="email" value="{{ old('email', $pegawai->email) }}"
                                placeholder="email@domain.com" class="w-full h-12 px-4 rounded-xl border border-slate-300 bg-white
        focus:ring-4 focus:ring-blue-100 focus:border-blue-500
        transition duration-200 text-sm outline-none shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                No HP
                            </label>

                            <input type="text" name="no_hp" value="{{ old('no_hp', $pegawai->no_hp) }}"
                                placeholder="08xxxx" class="w-full h-12 px-4 rounded-xl border border-slate-300 bg-white
        focus:ring-4 focus:ring-blue-100 focus:border-blue-500
        transition duration-200 text-sm outline-none shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Nomor Rekening
                            </label>

                            <input type="text" name="nomor_rekening"
                                value="{{ old('nomor_rekening', $pegawai->nomor_rekening) }}"
                                placeholder="Nomor rekening" class="w-full h-12 px-4 rounded-xl border border-slate-300 bg-white
        focus:ring-4 focus:ring-blue-100 focus:border-blue-500
        transition duration-200 text-sm outline-none shadow-sm">
                        </div>

                    </div>


                    <!-- ========================= -->
                    <!-- DATA GAJI -->
                    <!-- ========================= -->
                    <div class="mb-6">

                        <div class="flex items-center gap-3 mb-6 ">

                            <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center">

                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3
                    3-1.343 3-3-1.343-3-3-3z" />

                                </svg>

                            </div>

                            <div>

                                <h3 class="text-lg font-semibold text-slate-800">
                                    Data Gaji
                                </h3>

                                <p class="text-sm text-slate-500">
                                    Informasi penghasilan pegawai
                                </p>

                            </div>

                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

                            <!-- GAJI POKOK -->
                            <div>

                                <label class="block text-sm font-medium text-slate-700 mb-2">
                                    Gaji Pokok
                                </label>

                                <input type="number" name="gaji_pokok"
                                    value="{{ old('gaji_pokok', $pegawai->gaji_pokok) }}"
                                    placeholder="Masukkan gaji pokok" class="w-full h-12 px-4 rounded-xl border border-slate-300 bg-white
                focus:ring-4 focus:ring-emerald-100 focus:border-emerald-500
                transition duration-200 text-sm outline-none shadow-sm">

                            </div>

                            <!-- TUNJANGAN -->
                            <div>

                                <label class="block text-sm font-medium text-slate-700 mb-2">
                                    Tunjangan
                                </label>

                                <input type="number" name="tunjangan"
                                    value="{{ old('tunjangan', $pegawai->tunjangan) }}" placeholder="Masukkan tunjangan"
                                    class="w-full h-12 px-4 rounded-xl border border-slate-300 bg-white
                focus:ring-4 focus:ring-emerald-100 focus:border-emerald-500
                transition duration-200 text-sm outline-none shadow-sm">

                            </div>

                            <!-- BONUS -->
                            <div>

                                <label class="block text-sm font-medium text-slate-700 mb-2">
                                    Bonus
                                </label>

                                <input type="number" name="bonus" value="{{ old('bonus', $pegawai->bonus) }}"
                                    placeholder="Masukkan bonus" class="w-full h-12 px-4 rounded-xl border border-slate-300 bg-white
                focus:ring-4 focus:ring-emerald-100 focus:border-emerald-500
                transition duration-200 text-sm outline-none shadow-sm">

                            </div>

                            <!-- POTONGAN -->
                            <div>

                                <label class="block text-sm font-medium text-slate-700 mb-2">
                                    Potongan
                                </label>

                                <input type="number" name="potongan" value="{{ old('potongan', $pegawai->potongan) }}"
                                    placeholder="Masukkan potongan" class="w-full h-12 px-4 rounded-xl border border-slate-300 bg-white
                focus:ring-4 focus:ring-emerald-100 focus:border-emerald-500
                transition duration-200 text-sm outline-none shadow-sm">

                            </div>

                        </div>

                    </div>


                    <!-- ========================= -->
                    <!-- UPLOAD TTD -->
                    <!-- ========================= -->
                    <div>

                        <div class="flex items-center gap-3 mb-5">

                            <div class="w-9 h-9 rounded-lg bg-orange-50 flex items-center justify-center">
                                ✍️
                            </div>

                            <div>

                                <h3 class="text-base font-semibold text-slate-800">
                                    Tanda Tangan
                                </h3>

                                <p class="text-sm text-slate-500">
                                    Upload file tanda tangan pegawai
                                </p>

                            </div>

                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <!-- UPLOAD -->
                            <div>

                                <label for="ttdInput" class="flex flex-col items-center justify-center border-2 border-dashed
                                border-slate-300 rounded-2xl py-10 px-6 cursor-pointer
                                hover:border-blue-400 hover:bg-blue-50 transition">

                                    <div class="text-4xl mb-3">
                                        📄
                                    </div>

                                    <p class="text-sm font-medium text-slate-700">
                                        Klik untuk upload tanda tangan
                                    </p>

                                    <p class="text-xs text-slate-400 mt-1">
                                        JPG, PNG atau PDF
                                    </p>

                                    <input type="file" name="ttd" id="ttdInput" class="hidden">

                                </label>

                            </div>

                            <!-- PREVIEW -->
                            <div>

                                @if($pegawai->ttd)

                                <div class="border border-slate-200 rounded-2xl p-5 bg-slate-50 h-full">

                                    <p class="text-sm font-medium text-slate-700 mb-4">
                                        Preview TTD Saat Ini
                                    </p>

                                    <div class="flex items-center justify-center h-40">

                                        <img src="{{ asset('storage/' . $pegawai->ttd) }}"
                                            class="max-h-28 object-contain">

                                    </div>

                                </div>

                                @endif

                            </div>

                        </div>

                    </div>

                </div>


                <!-- FOOTER -->
                <div class="px-8 py-6 border-t border-slate-200 bg-slate-50">

                    <div class="flex items-center justify-between">

                        <!-- INFO -->
                        <div>

                            <p class="text-sm font-medium text-slate-700">
                                Pastikan data pegawai sudah benar
                            </p>

                            <p class="text-xs text-slate-500 mt-1">
                                Perubahan data akan langsung tersimpan ke sistem SIPENA.
                            </p>

                        </div>

                        <!-- BUTTON -->
                        <div class="flex items-center gap-3">

                            <a href="{{ route('admin.daftarpegawai_admin') }}" class="h-11 px-5 inline-flex items-center justify-center
                rounded-xl border border-slate-300 bg-white
                text-sm font-medium text-slate-700
                hover:bg-slate-100 transition shadow-sm">

                                Batal

                            </a>

                            <button type="submit" class="h-11 px-6 inline-flex items-center justify-center
                rounded-xl bg-blue-600 text-white
                text-sm font-semibold
                hover:bg-blue-700 transition shadow-lg shadow-blue-100">

                                Simpan Perubahan

                            </button>

                        </div>

                    </div>

                </div>

        </form>

    </div>

</div>


<style>
    .form-label {
        @apply block text-sm font-medium text-slate-700 mb-2;
    }

    .form-input {
        @apply w-full h-11 px-4 rounded-xl border border-slate-300 bg-white focus: ring-4 focus:ring-blue-100 focus:border-blue-500 transition text-sm outline-none;
    }
</style>

@endsection