@extends('layouts.pegawai.app')

@section('content')

{{-- ALERT SUCCESS --}}
@if(session('success'))

<div id="alertSuccess" class="fixed top-5 right-5 z-50
    bg-emerald-500 text-white
    px-6 py-4 rounded-2xl shadow-2xl
    flex items-center gap-3">

    <i data-lucide="check-circle"></i>

    <span>

        {{ session('success') }}

    </span>

</div>

@endif

{{-- ALERT ERROR --}}
@if($errors->any())

<div id="alertError" class="fixed top-5 right-5 z-50
    bg-red-500 text-white
    px-6 py-4 rounded-2xl shadow-2xl
    flex items-center gap-3">

    <i data-lucide="x-circle"></i>

    <span>

        {{ $errors->first() }}

    </span>

</div>

@endif

{{-- HEADER --}}
<div class="flex items-center justify-between mb-8">

    <div>

        <h1 class="text-3xl font-bold text-slate-800">
            Form Cuti
        </h1>

        <p class="text-slate-500 mt-1">
            Pengajuan cuti pegawai PT BPR Waway Lampung
        </p>

    </div>

</div>

<form id="formSurat" action="{{ route('pegawai.cuti.store') }}" method="POST" enctype="multipart/form-data">

    @csrf

    {{-- CARD UTAMA --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8 mb-8">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- JENIS --}}
            <div>

                <label class="font-semibold mb-2 block">
                    Jenis Surat
                </label>

                <input type="text" value="Form Cuti" readonly class="input bg-slate-100">

                <input type="hidden" name="jenis_surat" value="Form Cuti">

            </div>

            {{-- NOMOR --}}
            <div>

                <label class="font-semibold mb-2 block">
                    Nomor Surat
                </label>

                <input type="text" name="nomor_surat" class="input" placeholder="001/SDM/V/2026">

            </div>

            {{-- TANGGAL --}}
            <div>

                <label class="font-semibold mb-2 block">
                    Tanggal Surat
                </label>

                <input type="date" name="tanggal_surat" value="{{ date('Y-m-d') }}" class="input">

            </div>

            {{-- BAGIAN --}}
            <div>

                <label class="font-semibold mb-2 block">
                    Kirim Ke Bagian
                </label>

                <div class="flex gap-2">

                    <select id="bagianSelect" class="input">

                        <option value="">
                            -- Pilih Bagian --
                        </option>

                        @foreach($bagian as $b)

                        <option value="{{ $b->id }}">

                            {{ $b->nama_bagian }}

                        </option>

                        @endforeach

                    </select>

                    <button type="button" onclick="addItem('bagian')" class="btn-blue">

                        +

                    </button>

                </div>

                <div class="mt-4 box" id="listBagian">

                </div>

                <input type="hidden" id="bagianInput" name="bagian">

            </div>

        </div>

    </div>

    {{-- FORM CUTI --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8 mb-8">

        <div class="mb-6">

            <h3 class="text-xl font-bold text-slate-800">
                Form Permohonan Cuti
            </h3>

            <p class="text-sm text-slate-500 mt-1">
                Informasi pengajuan cuti pegawai
            </p>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>

                <label class="font-semibold mb-2 block">
                    Mulai Cuti
                </label>

                <input type="date" name="mulai_cuti" class="input">

            </div>

            <div>

                <label class="font-semibold mb-2 block">
                    Sampai Tanggal
                </label>

                <input type="date" name="akhir_cuti" class="input">

            </div>

            <div>

                <label class="font-semibold mb-2 block">
                    Masuk Kembali
                </label>

                <input type="date" name="tgl_masuk" class="input">

            </div>

            <div>

                <label class="font-semibold mb-2 block">
                    Total Hari
                </label>

                <input type="number" name="total_hari" class="input" placeholder="0">

            </div>

            <div>

                <label class="font-semibold mb-2 block">
                    Jenis Cuti
                </label>

                <select name="jenis_cuti" class="input">

                    <option value="">
                        -- Pilih Jenis Cuti --
                    </option>

                    <option value="Cuti Tahunan">
                        Cuti Tahunan
                    </option>

                    <option value="Cuti Sakit">
                        Cuti Sakit
                    </option>

                    <option value="Cuti Khusus">
                        Cuti Khusus
                    </option>

                </select>

            </div>

            <div>

                <label class="font-semibold mb-2 block">
                    Keterangan Cuti
                </label>

                <input type="text" name="keterangan" class="input" placeholder="Liburan">

            </div>

            <div>

                <label class="font-semibold mb-2 block">
                    Nomor yang Bisa Dihubungi
                </label>

                <input type="text" name="nomor" class="input" placeholder="08xxxx">

            </div>

            <div>

                <label class="font-semibold mb-2 block">
                    User Core Banking
                </label>

                <input type="text" name="cbs" class="input" placeholder="username">

            </div>

        </div>

        <div class="mt-5">

            <label class="font-semibold mb-2 block">
                Alamat Selama Cuti
            </label>

            <input type="text" name="alamat" class="input" placeholder="Bandar Lampung">

        </div>

    </div>

    {{-- BACKUP --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8 mb-8">

        <div class="mb-6">

            <h3 class="text-xl font-bold text-slate-800">
                Petugas Back-up
            </h3>

        </div>

        <div>

            <label class="font-semibold mb-2 block">
                Pilih Pegawai
            </label>

            <div class="flex gap-2">

                <select id="pegawaiSelect" class="input">

                    <option value="">
                        -- Pilih Pegawai --
                    </option>

                    @foreach($pegawai as $p)

                    <option value="{{ $p->id }}">

                        {{ $p->nama }}
                        -
                        {{ $p->jabatanRelasi->nama_jabatan ?? '-' }}

                    </option>

                    @endforeach

                </select>

                <button type="button" onclick="addItem('pegawai')" class="btn-blue">

                    +

                </button>

            </div>

            <div class="mt-4 box" id="listPegawai">

            </div>

            <input type="hidden" id="pegawaiInput" name="pegawai_backup">

        </div>

    </div>

    {{-- TTD --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8 mb-8">

        <div class="mb-6">

            <h3 class="text-xl font-bold text-slate-800">
                Approval Tanda Tangan
            </h3>

        </div>

        <div>

            <label class="font-semibold mb-2 block">
                Tanda Tangan
            </label>

            <div class="flex gap-2">

                <select id="ttdSelect" class="input">

                    <option value="">
                        -- Pilih Approval --
                    </option>

                    @foreach($pegawai as $p)

                    <option value="{{ $p->id }}">

                        {{ $p->nama }}
                        -
                        {{ $p->jabatanRelasi->nama_jabatan ?? '-' }}
                        -
                        {{ $p->bagianRelasi->nama_bagian ?? '-' }}


                    </option>

                    @endforeach

                </select>

                <button type="button" onclick="addItem('ttd')" class="btn-blue">

                    +

                </button>

            </div>

            <div class="mt-4 box" id="listTtd">

            </div>

            <input type="hidden" id="ttdInput" name="ttd">

            <input type="hidden" name="jenis_surat" value="Form Cuti">

        </div>

    </div>

    {{-- BUTTON --}}
    <div class="flex justify-end">

        <button type="submit" onclick="return confirm('Kirim form cuti?')" class="bg-blue-600 hover:bg-blue-700
            text-white px-8 py-3 rounded-xl
            shadow-lg transition">

            Kirim Form Cuti

        </button>

    </div>

</form>

@endsection

<style>
    .input {
        width: 100%;
        border: 1px solid #d1d5db;
        padding: 12px 14px;
        border-radius: 12px;
        background: white;
    }

    .input:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .1);
    }

    .btn-blue {
        background: #2563eb;
        color: white;
        padding: 0 16px;
        border-radius: 12px;
        font-weight: 600;
    }

    .box {
        min-height: 55px;
        border: 1px dashed #cbd5e1;
        padding: 12px;
        border-radius: 14px;
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        background: #f8fafc;
    }

    .tag {
        padding: 8px 14px;
        border-radius: 999px;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        font-weight: 500;
    }

    .blue {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .green {
        background: #dcfce7;
        color: #15803d;
    }

    .purple {
        background: #ede9fe;
        color: #7c3aed;
    }
</style>

<script>
    let selectedBagian = [];
    let selectedTtd = [];
    let selectedPegawai = [];

    function addItem(type) {
        const select =
            document.getElementById(type + 'Select');

        const id = select.value;

        const text =
            select.options[
                select.selectedIndex
            ].text;

        if (!id) return;

        let arr;

        if (type === 'bagian') {

            arr = selectedBagian;

        } else if (type === 'ttd') {

            arr = selectedTtd;

        } else {

            arr = selectedPegawai;

        }

        if (arr.some(v => v.id == id)) return;

        arr.push({
            id,
            text
        });

        render(type);
    }

    function removeItem(type, id) {
        let arr;

        if (type === 'bagian') {

            arr = selectedBagian;

        } else if (type === 'ttd') {

            arr = selectedTtd;

        } else {

            arr = selectedPegawai;

        }

        arr = arr.filter(v => v.id != id);

        if (type === 'bagian') {

            selectedBagian = arr;

        } else if (type === 'ttd') {

            selectedTtd = arr;

        } else {

            selectedPegawai = arr;

        }

        render(type);
    }

    function render(type) {
        let arr;
        let container;
        let input;
        let color;

        if (type === 'bagian') {

            arr = selectedBagian;
            container = document.getElementById('listBagian');
            input = document.getElementById('bagianInput');
            color = 'blue';

        } else if (type === 'ttd') {

            arr = selectedTtd;
            container = document.getElementById('listTtd');
            input = document.getElementById('ttdInput');
            color = 'green';

        } else {

            arr = selectedPegawai;
            container = document.getElementById('listPegawai');
            input = document.getElementById('pegawaiInput');
            color = 'purple';

        }

        if (!arr.length) {

            container.innerHTML =
                '<span class="text-slate-400 text-sm">Belum ada data</span>';

            input.value = '';

            return;
        }

        container.innerHTML = arr.map(item => `

        <div class="tag ${color}">

            ${item.text}

            <button
                type="button"
                onclick="removeItem('${type}', ${item.id})">

                ✖

            </button>

        </div>

    `).join('');

        input.value =
            arr.map(v => v.id).join(',');
    }

    setTimeout(() => {

        const success =
            document.getElementById('alertSuccess');

        if (success) {

            success.style.transition = '.4s';
            success.style.opacity = '0';

            setTimeout(() => {

                success.remove();

            }, 400);
        }

    }, 3000);

    setTimeout(() => {

        const error =
            document.getElementById('alertError');

        if (error) {

            error.style.transition = '.4s';
            error.style.opacity = '0';

            setTimeout(() => {

                error.remove();

            }, 400);
        }

    }, 3000);
</script>