@extends('layouts.pegawai.app')

@section('content')

<!-- ALERT SUCCESS -->
@if(session('success'))

<div id="alertSuccess" class="fixed top-5 right-5 z-50
        bg-emerald-500 text-white
        px-6 py-4 rounded-2xl shadow-2xl
        flex items-center gap-3
        animate-bounce">

    <i data-lucide="check-circle"></i>

    <span>

        {{ session('success') }}

    </span>

</div>

@endif

<!-- ALERT ERROR -->
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

<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">

    <div>

        <h1 class="text-3xl font-bold text-slate-800">
            Form Lembur
        </h1>

        <p class="text-slate-500 text-sm mt-1">
            Pembuatan form Lembur pegawai
        </p>

    </div>

</div>

<div class="bg-white p-6 rounded-xl shadow">
    <form id="formSurat" action="{{ route('pegawai.lembur.store') }}" method="POST" enctype="multipart/form-data">

        @csrf

        <!-- JENIS -->
        <div class="mb-6">

            <label class="font-semibold mb-2 block">
                Jenis Surat
            </label>

            <input type="text" value="Form Lembur" readonly class="input bg-slate-100">

            <input type="hidden" name="jenis_surat" value="Form Lembur">

        </div>

        <!-- BAGIAN -->
        <div class="mb-6">

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

            <div class="mt-4 box" id="listBagian"></div>

            <input type="hidden" id="bagianInput" name="bagian">

        </div>

        <!-- NOMOR & TANGGAL -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

            <div>

                <label class="font-semibold mb-2 block">
                    Nomor Surat
                </label>

                <input name="nomor_surat" class="input" placeholder="Contoh: 001/IT/V/2026">

            </div>

            <div>

                <label class="font-semibold mb-2 block">
                    Tanggal Surat
                </label>

                <input type="date" name="tanggal_surat" value="{{ date('Y-m-d') }}" class="input">

            </div>

        </div>

        <!-- KEPALA BAGIAN -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

    {{-- NAMA --}}
    <div>

        <label class="font-semibold block mb-2">
            Nama
        </label>

        <select
            name="kepala_bagian"
            id="kepalaBagianSelect"
            class="input"
            required>

            <option value="">
                -- Pilih Kepala Bagian --
            </option>

            @foreach($pegawai->where('jabatan_id', 3) as $p)

            <option
                value="{{ $p->id }}"

                data-jabatan="{{ $p->jabatanRelasi->nama_jabatan ?? '' }}"

                data-bagian="{{ $p->bagianRelasi->nama_bagian ?? '' }}">

                {{ $p->nama }}

            </option>

            @endforeach

        </select>

    </div>

    {{-- JABATAN --}}
    <div>

        <label class="font-semibold block mb-2">
            Jabatan
        </label>

        <input
            type="text"
            id="jabatanInput"
            readonly
            class="input bg-slate-100"
            placeholder="Jabatan otomatis muncul">

    </div>

</div>

        <!-- PEKERJAAN & AREA -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

            <div>

                <label class="font-semibold mb-2 block">
                    Pekerjaan
                </label>

                <input type="text" name="pekerjaan" class="input" placeholder="Contoh: Maintenance Server">

            </div>

            <div>

                <label class="font-semibold mb-2 block">
                    Area
                </label>

                <input type="text" name="area" class="input" placeholder="Contoh: Kantor Pusat">

            </div>

        </div>

        <!-- TANGGAL & JAM -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

            <div>

                <label class="font-semibold mb-2 block">
                    Tanggal Lembur
                </label>

                <input type="date" name="tanggal_lembur" class="input">

            </div>

            <div>

                <label class="font-semibold mb-2 block">
                    Jam Lembur
                </label>

                <input type="text" name="jam_lembur" class="input" placeholder="Contoh: 18:00 - 22:00">

            </div>

        </div>

        <!-- TENAGA KERJA -->
        <div class="mb-6">

            <label class="font-semibold mb-2 block">
                Jumlah Tenaga Kerja
            </label>

            <div class="flex gap-2">

                <select id="pegawaiSelect" class="input">

                    <option value="">
                        -- Pilih Pegawai --
                    </option>

                    @foreach($pegawai as $p)

                    <option value="{{ $p->id }}">

                        {{ $p->nama }}

                    </option>

                    @endforeach

                </select>

                <button type="button" onclick="addItem('pegawai')" class="btn-blue">

                    +

                </button>

            </div>

            <div class="mt-4 box" id="listPegawai"></div>

            <input type="hidden" id="pegawaiInput" name="pegawai_lembur">

        </div>

        <!-- TTD -->
        <div class="mb-6">

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

            <div class="mt-4 box" id="listTtd"></div>

            <input type="hidden" id="ttdInput" name="ttd">

        </div>

        <!-- BUTTON -->
        <div class="flex justify-end">

            <button type="submit" class="bg-blue-600 hover:bg-blue-700
            text-white px-6 py-3 rounded-xl
            shadow-lg transition">

                Kirim Form Lembur

            </button>

        </div>

    </form>
</div>

@endsection

<style>
    .input {
        width: 100%;
        border: 1px solid #ddd;
        padding: 8px;
        border-radius: 8px;
    }

    .btn-blue {
        background: #3b82f6;
        color: #fff;
        padding: 8px 14px;
        border-radius: 8px;
    }

    .box {
        min-height: 50px;
        border: 1px solid #ddd;
        padding: 10px;
        border-radius: 10px;
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        background: #f9fafb;
    }

    .tag {
        padding: 5px 10px;
        border-radius: 20px;
        display: flex;
        gap: 5px;
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

document.addEventListener(
    'DOMContentLoaded',
    function(){

        const select =
            document.getElementById(
                'kepalaBagianSelect'
            );

        if(select){

            select.addEventListener(
                'change',
                function(){

                    const selected =
                        this.options[
                            this.selectedIndex
                        ];

                    const jabatan =
                        selected.dataset.jabatan || '';

                    const bagian =
                        selected.dataset.bagian || '';

                    document.getElementById(
                        'jabatanInput'
                    ).value =

                        jabatan + ' - ' + bagian;

                }
            );

        }

    }
);


    let selectedBagian = [];
    let selectedTtd = [];
    let selectedPegawai = [];

    // =========================
    // ADD ITEM
    // =========================
    function addItem(type) {
        const select =
            document.getElementById(type + 'Select');

        const id = select.value;

        const text =
            select.options[select.selectedIndex].text;

        if (!id) return;

        let arr;

        if (type === 'bagian') {

            arr = selectedBagian;

        } else if (type === 'ttd') {

            arr = selectedTtd;

        } else {

            arr = selectedPegawai;

        }

        // cegah duplicate
        if (arr.some(v => v.id == id)) return;

        arr.push({

            id,
            text

        });

        render(type);
    }

    // =========================
    // REMOVE ITEM
    // =========================
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

    // =========================
    // RENDER TAG
    // =========================
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

            container.innerHTML = `

                <span class="text-gray-400 text-sm">
                    Belum ada
                </span>

            `;

            input.value = '';

            return;
        }

        container.innerHTML = arr.map(item => `

            <div class="tag ${color}">

                ${item.text}

                <button
                    type="button"
                    onclick="removeItem('${type}', ${item.id})"
                    class="ml-2 hover:opacity-70">

                    ✖

                </button>

            </div>

        `).join('');

        input.value =
            arr.map(v => v.id).join(',');
    }

    // =========================
    // AUTO CLOSE ALERT SUCCESS
    // =========================
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

    // =========================
    // AUTO CLOSE ALERT ERROR
    // =========================
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