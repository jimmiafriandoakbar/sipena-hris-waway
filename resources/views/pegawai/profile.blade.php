@extends('layouts.pegawai.app')

@section('content')

@php
$p = Auth::user()->pegawai;
@endphp

<div class="max-w-6xl mx-auto">

    <!-- HEADER -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Profile Pegawai</h1>
        <p class="text-gray-500">Kelola informasi akun Anda</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- LEFT -->
        <div class="bg-white rounded-2xl shadow p-6">

            <!-- FOTO -->
            <div class="flex flex-col items-center">
                <div class="w-24 h-24 rounded-full bg-gray-200 flex items-center justify-center">
                    <i data-lucide="user" class="w-10 h-10 text-gray-500"></i>
                </div>

                <h2 class="mt-4 text-lg font-semibold text-slate-800 tracking-wide">
                    {{ Auth::user()->name }}
                </h2>

                <!-- EMAIL -->
                <p class="text-sm text-slate-500 mt-1">
                    {{ Auth::user()->email }}
                </p>

                <!-- ROLE -->
                <div class="mt-3">
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                        Pegawai
                    </span>
                </div>
            </div>

            <!-- TTD -->
            <form action="{{ route('pegawai.ttd.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- TTD -->
                <div class="mt-6">
                    <label class="text-sm font-medium text-gray-700">Tanda Tangan</label>

                    <input type="file" name="ttd" id="ttdInput" accept="image/*"
                        class="mt-2 w-full text-sm border rounded-lg p-2">

                    <!-- Preview -->
                    <div class="mt-3">
                        <img id="previewTTD" class="hidden h-24 object-contain border rounded-lg p-2 bg-white">
                    </div>

                    @if($p && $p->ttd)
                    <img src="{{ asset('storage/' . $p->ttd) }}" class="mt-3 h-24 border rounded bg-white p-2">
                    @endif

                    <button type="submit" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded">
                        Simpan
                    </button>
                </div>
            </form>

            <!-- BARCODE -->
            <div class="mt-6 text-center">

    <label class="text-sm font-medium text-gray-700">
        QR Code Pegawai
    </label>

    <div class="mt-3 bg-gray-100 p-6 rounded-2xl">

        @if($p && $p->nip)

            <div class="flex justify-center">

                <img
                    src="data:image/png;base64,{!! DNS2D::getBarcodePNG($p->nama, 'QRCODE') !!}"
                    class="w-40 h-40 rounded-xl bg-white p-2 shadow-sm">

            </div>

            <p class="text-xs mt-4 text-gray-500">

                {{ $p->nip }}

            </p>

        @else

            <p class="text-red-500 text-sm">
                NIP belum tersedia
            </p>

        @endif

    </div>

</div>

        </div>

        <!-- RIGHT -->
        <div class="lg:col-span-2 space-y-6">

            <!-- DATA -->
            <div class="bg-white rounded-2xl shadow p-6">
                <h3 class="text-lg font-semibold mb-4">Data Pegawai</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">

                    <div class="bg-gray-50 p-3 rounded-lg">
                        <p class="text-gray-500">Nama</p>
                        <p class="font-semibold">{{ $p->nama ?? '-' }}</p>
                    </div>

                    <div class="bg-gray-50 p-3 rounded-lg">
                        <p class="text-gray-500">NIP</p>
                        <p class="font-semibold">{{ $p->nip ?? '-' }}</p>
                    </div>

                    <div class="bg-gray-50 p-3 rounded-lg">
                        <p class="text-gray-500">Bagian</p>
                        <p class="font-semibold">{{ $p->bagianRelasi->nama_bagian ?? '-' }}</p>
                    </div>

                    <div class="bg-gray-50 p-3 rounded-lg">
                        <p class="text-gray-500">Jabatan</p>
                        <p class="font-semibold">{{ $p->jabatanRelasi->nama_jabatan ?? '-' }}</p>
                    </div>

                    <div class="bg-gray-50 p-3 rounded-lg">
                        <p class="text-gray-500">No HP</p>
                        <p class="font-semibold">{{ $p->no_hp ?? '-' }}</p>
                    </div>

                    <div class="bg-gray-50 p-3 rounded-lg">
                        <p class="text-gray-500">Pendidikan</p>
                        <p class="font-semibold">S1</p>
                    </div>

                    <div class="bg-gray-50 p-3 rounded-lg">
                        <p class="text-gray-500">Jurusan</p>
                        <p class="font-semibold">Ilmu Komputer</p>
                    </div>

                    <div class="bg-gray-50 p-3 rounded-lg">
                        <p class="text-gray-500">Mulai Bekerja</p>
                        <p class="font-semibold">05/04/2022</p>
                    </div>

                </div>
            </div>

            <!-- GAJI -->
            <!-- GAJI -->
<div class="bg-white rounded-2xl shadow p-6">

    <h3 class="text-lg font-semibold mb-4">
        Gaji Pegawai
    </h3>

    @php
        $payroll = $p->payroll;

        $gajiPokok = $payroll->gaji_pokok ?? 0;

        $totalTunjangan =
            ($payroll->tunjangan_teller ?? 0) +
            ($payroll->tunjangan_anak ?? 0) +
            ($payroll->tunjangan_istri ?? 0) +
            ($payroll->tunjangan_kemahalan ?? 0) +
            ($payroll->tunjangan_lain_lain ?? 0);

        $totalPotongan =
            ($payroll->koperasi ?? 0) +
            ($payroll->koperasi_pinjaman ?? 0) +
            ($payroll->infaq ?? 0) +
            ($payroll->bpjs_kesehatan ?? 0) +
            ($payroll->bpjs_ketenagakerjaan ?? 0) +
            ($payroll->tabungan_pensiun ?? 0) +
            ($payroll->pinjaman_pegawai ?? 0) +
            ($payroll->potongan_lain_lain ?? 0);

        $takeHomePay =
            $gajiPokok +
            $totalTunjangan -
            $totalPotongan;
    @endphp

    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">

            <div class="bg-gray-50 p-3 rounded-lg">
                <p class="text-slate-500">
                    Gaji Pokok
                </p>

                <b>
                    Rp {{ number_format($gajiPokok,0,',','.') }}
                </b>
            </div>

            <div class="bg-gray-50 p-3 rounded-lg">
                <p class="text-slate-500">
                    Total Tunjangan
                </p>

                <b class="text-blue-600">
                    Rp {{ number_format($totalTunjangan,0,',','.') }}
                </b>
            </div>

            <div class="bg-gray-50 p-3 rounded-lg">
                <p class="text-slate-500">
                    Total Potongan
                </p>

                <b class="text-red-500">
                    Rp {{ number_format($totalPotongan,0,',','.') }}
                </b>
            </div>

            <div class="bg-green-50 p-3 rounded-lg">
                <p class="text-slate-500">
                    Take Home Pay
                </p>

                <b class="text-green-600">
                    Rp {{ number_format($takeHomePay,0,',','.') }}
                </b>
            </div>

            <div class="bg-blue-50 p-3 rounded-lg">
                <p class="text-slate-500">
                    Nomor Rekening
                </p>

                <b class="text-blue-600">
                    {{ $p->nomor_rekening ?? '-' }}
                </b>
            </div>

            <div class="bg-yellow-50 p-3 rounded-lg">
                <p class="text-slate-500">
                    Jumlah Anak
                </p>

                <b class="text-yellow-600">
                    {{ $payroll->jumlah_anak ?? 0 }}
                </b>
            </div>

        </div>

        <a href="{{ route('pegawai.detail.gaji') }}"
        class="mt-4 inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-xl shadow-sm transition">
            Detail Gaji
        </a>

    </div>

            <div class="bg-white rounded-2xl shadow p-6">
                <h3 class="text-lg font-semibold mb-4">Ubah Password</h3>

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

                <form action="{{ route('pegawai.updatePassword') }}" method="POST">
                    @csrf

                    <div class="space-y-3">
                        <input type="password" name="current_password" placeholder="Password Lama"
                            class="w-full border rounded-lg p-2" required>

                        <input type="password" name="new_password" placeholder="Password Baru"
                            class="w-full border rounded-lg p-2" required>

                        <input type="password" name="new_password_confirmation" placeholder="Konfirmasi Password"
                            class="w-full border rounded-lg p-2" required>
                    </div>

                    <button type="submit"
                        class="mt-4 bg-indigo-500 text-white px-4 py-2 rounded-lg hover:bg-indigo-600">
                        Update Password
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
    window.onload = function () {

        const input = document.getElementById('ttdInput');
        const preview = document.getElementById('previewTTD');

        if (!input || !preview) {
            console.log("TTD element tidak ditemukan");
            return;
        }

        input.onchange = function () {
            const file = this.files[0];

            console.log("File dipilih:", file); // DEBUG

            if (!file) return;

            const reader = new FileReader();

            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = "block"; // paksa tampil
            };

            reader.readAsDataURL(file);
        };

    };

     // AUTO HIDE SUCCESS
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

    // AUTO HIDE ERROR
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