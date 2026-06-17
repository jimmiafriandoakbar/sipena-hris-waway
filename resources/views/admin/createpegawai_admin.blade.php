@extends('layouts.admin.app_admin')

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
@if($errors->any())

    <div
        id="alertError"
        class="fixed top-5 right-5 z-50
        bg-red-500 text-white
        px-6 py-4 rounded-2xl shadow-2xl
        flex items-center gap-3">

        <i data-lucide="x-circle" class="w-5 h-5"></i>

        <span>

            {{ $errors->first() }}

        </span>

    </div>

@endif

<div class="max-w-5xl mx-auto mt-8">

    <div class="bg-white rounded-2xl shadow border border-gray-200">

        <!-- FORM -->
        <form action="{{ route('admin.pegawai.store') }}" method="POST" enctype="multipart/form-data"
            class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

            @csrf

            <!-- HEADER -->
            <div class="px-8 py-6 border-b bg-gradient-to-r from-slate-50 to-white">
                <h2 class="text-xl font-semibold text-slate-800">
                    Tambah Pegawai
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Lengkapi data pegawai dengan benar dan sesuai dokumen resmi.
                </p>
            </div>

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

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- NAMA -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Nama Lengkap
                            </label>

                            <input type="text" name="nama" placeholder="Masukkan nama lengkap" class="w-full h-11 px-4 rounded-xl border border-slate-300 bg-white
                                  focus:ring-4 focus:ring-blue-100 focus:border-blue-500
                                  transition text-sm">
                        </div>

                        <!-- NIP -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                NIP
                            </label>

                            <input type="text" name="nip" value="{{ old('nip') }}" placeholder="Nomor induk pegawai"
                                class="w-full h-11 px-4 rounded-xl border
                                @error('nip')
                                    border-red-500 focus:ring-red-100 focus:border-red-500
                                @else
                                    border-slate-300 focus:ring-blue-100 focus:border-blue-500
                                @enderror
                                transition text-sm">

                            @error('nip')
                            <p class="text-red-500 text-xs mt-2">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <!-- BAGIAN -->
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

                        <!-- JABATAN -->
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

                                <option
                                    value="{{ $item->id }}"
                                    {{ old('jabatan_id', $pegawai->jabatan_id ?? '') == $item->id ? 'selected' : '' }}>

                                    {{ $item->nama_jabatan }}

                                </option>

                            @endforeach

                            </select>
                        </div>

                        <!-- PENDIDIKAN -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Pendidikan
                            </label>

                            <input type="text" name="pendidikan" placeholder="Contoh: S1" class="w-full h-11 px-4 rounded-xl border border-slate-300
                                  focus:ring-4 focus:ring-blue-100 focus:border-blue-500
                                  transition text-sm">
                        </div>

                        <!-- JURUSAN -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Jurusan
                            </label>

                            <input type="text" name="jurusan" placeholder="Contoh: Teknik Informatika" class="w-full h-11 px-4 rounded-xl border border-slate-300
                                  focus:ring-4 focus:ring-blue-100 focus:border-blue-500
                                  transition text-sm">
                        </div>

                        <!-- MULAI BEKERJA -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Mulai Bekerja
                            </label>

                            <input type="date" name="mulai_bekerja" class="w-full h-11 px-4 rounded-xl border border-slate-300
                                  focus:ring-4 focus:ring-blue-100 focus:border-blue-500
                                  transition text-sm">
                        </div>


                        <!-- EMAIL -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Email
                            </label>

                            <input type="email" name="email" placeholder="pegawai@sipena.com" class="w-full h-11 px-4 rounded-xl border border-slate-300
                                  focus:ring-4 focus:ring-blue-100 focus:border-blue-500
                                  transition text-sm">
                        </div>

                        <!-- NO HP -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                No HP
                            </label>

                            <input type="text" name="no_hp" placeholder="08xxxxxxxxxx" class="w-full h-11 px-4 rounded-xl border border-slate-300
                                  focus:ring-4 focus:ring-blue-100 focus:border-blue-500
                                  transition text-sm">
                        </div>

                        <!-- NO REKENING -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Nomor Rekening
                            </label>

                            <input type="text" name="nomor_rekening" placeholder="Masukkan nomor rekening" class="w-full h-11 px-4 rounded-xl border border-slate-300
                                  focus:ring-4 focus:ring-blue-100 focus:border-blue-500
                                  transition text-sm">
                        </div>

                    </div>
                </div>

                <!-- ========================= -->
                <!-- DATA GAJI -->
                <!-- ========================= -->
                <!-- <div>

                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-9 h-9 rounded-lg bg-emerald-50 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3
                                 3-1.343 3-3-1.343-3-3-3z" />
                            </svg>
                        </div>

                        <div>
                            <h3 class="text-base font-semibold text-slate-800">
                                Data Gaji
                            </h3>

                            <p class="text-sm text-slate-500">
                                Informasi penghasilan pegawai
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Gaji Pokok
                            </label>

                            <input type="number" name="gaji_pokok"
                                class="w-full h-11 px-4 rounded-xl border border-slate-300">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Tunjangan
                            </label>

                            <input type="number" name="tunjangan"
                                class="w-full h-11 px-4 rounded-xl border border-slate-300">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Bonus
                            </label>

                            <input type="number" name="bonus"
                                class="w-full h-11 px-4 rounded-xl border border-slate-300">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Potongan
                            </label>

                            <input type="number" name="potongan"
                                class="w-full h-11 px-4 rounded-xl border border-slate-300">
                        </div>

                    </div>
                </div> -->

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

                    <label for="ttdInput" class="flex flex-col items-center justify-center border-2 border-dashed
                          border-slate-300 rounded-2xl py-10 px-6 cursor-pointer
                          hover:border-blue-400 hover:bg-blue-50 transition">

                        <div class="text-4xl mb-3">📄</div>

                        <p class="text-sm font-medium text-slate-700">
                            Klik untuk upload tanda tangan
                        </p>

                        <p class="text-xs text-slate-400 mt-1">
                            JPG, PNG atau PDF
                        </p>

                        <input type="file" name="ttd" id="ttdInput" class="hidden">

                    </label>

                </div>

            </div>

            <!-- FOOTER BUTTON -->
            <div class="px-8 py-5 border-t bg-slate-50 flex justify-end gap-3">

                <a href="{{ route('admin.daftarpegawai_admin') }}" class="h-11 px-5 inline-flex items-center rounded-xl border border-slate-300
                  text-sm font-medium text-slate-700 hover:bg-white transition">

                    Batal

                </a>

                <button class="h-11 px-6 inline-flex items-center rounded-xl bg-blue-600
                   text-white text-sm font-medium hover:bg-blue-700 transition shadow-sm">

                    Simpan Pegawai

                </button>

            </div>

        </form>

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