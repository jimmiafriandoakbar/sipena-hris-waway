@extends('layouts.pegawai.app')

@section('content')

<style>
    .input{
        width:100%;
        border:1px solid #d1d5db;
        padding:10px 14px;
        border-radius:12px;
        background:white;
        outline:none;
        transition:.2s;
    }

    .input:focus{
        border-color:#3b82f6;
        box-shadow:0 0 0 4px rgba(59,130,246,.1);
    }

    .btn-primary{
        background:#2563eb;
        color:white;
        padding:10px 16px;
        border-radius:12px;
        font-weight:600;
        transition:.2s;
    }

    .btn-primary:hover{
        background:#1d4ed8;
    }

    .box-list{
        min-height:54px;
        border:1px solid #e5e7eb;
        padding:10px;
        border-radius:14px;
        display:flex;
        flex-wrap:wrap;
        gap:8px;
        background:#f8fafc;
        margin-top:10px;
    }

    .tag{
        padding:8px 12px;
        border-radius:999px;
        display:flex;
        align-items:center;
        gap:8px;
        font-size:13px;
        font-weight:500;
    }

    .tag button{
        border:none;
        background:none;
        cursor:pointer;
        font-size:12px;
    }

    .tag.blue{
        background:#dbeafe;
        color:#1d4ed8;
    }

    .tag.green{
        background:#dcfce7;
        color:#15803d;
    }
</style>

<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">

    <div>

        <h1 class="text-3xl font-bold text-slate-800">
            Import Surat
        </h1>

        <p class="text-slate-500 text-sm mt-1">
            Import surat PDF dan kirim ke bagian terkait
        </p>

    </div>

</div>

{{-- ALERT SUCCESS --}}
@if(session('success'))

    <div
        id="alertSuccess"
        class="fixed top-5 right-5 z-50
        min-w-[320px] max-w-sm
        rounded-2xl border border-emerald-200
        bg-white shadow-2xl overflow-hidden
        animate-bounce">

        <div class="h-1 bg-emerald-500"></div>

        <div class="p-5 flex items-start gap-4">

            <div
                class="w-11 h-11 rounded-2xl
                bg-emerald-100 text-emerald-600
                flex items-center justify-center
                text-xl font-bold">

                ✔

            </div>

            <div class="flex-1">

                <h3 class="font-bold text-slate-800">
                    Berhasil
                </h3>

                <p class="text-sm text-slate-500 mt-1">

                    {{ session('success') }}

                </p>

            </div>

            <button
                onclick="closeAlert('alertSuccess')"
                class="text-slate-400 hover:text-slate-600">

                ✕

            </button>

        </div>

    </div>

@endif

{{-- VALIDATION ERROR --}}
@if ($errors->any())

    <div
        id="alertValidation"
        class="fixed top-5 right-5 z-50
        min-w-[320px] max-w-sm
        rounded-2xl border border-red-200
        bg-white shadow-2xl overflow-hidden">

        <div class="h-1 bg-red-500"></div>

        <div class="p-5 flex items-start gap-4">

            <div
                class="w-11 h-11 rounded-2xl
                bg-red-100 text-red-600
                flex items-center justify-center
                text-xl font-bold">

                !

            </div>

            <div class="flex-1">

                <h3 class="font-bold text-slate-800">
                    Terjadi Kesalahan
                </h3>

                <ul class="text-sm text-slate-500 mt-2 space-y-1">

                    @foreach ($errors->all() as $error)

                        <li>
                            • {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

            <button
                onclick="closeAlert('alertValidation')"
                class="text-slate-400 hover:text-slate-600">

                ✕

            </button>

        </div>

    </div>

@endif
<div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">

    <form
        action="{{ route('pegawai.import.store') }}"
        method="POST"
        enctype="multipart/form-data">

        @csrf

        {{-- JENIS SURAT --}}
        <div class="mb-6">

            <label class="font-semibold mb-2 block">
                Jenis Surat
            </label>

            <select
                name="jenis_surat"
                id="jenisSurat" 
                onchange="toggleJenisSurat()"
                class="input">

                <option value="nota_dinas">
                    Nota Dinas
                </option>

                <option value="berita_acara">
                    Berita Acara
                </option>

                <option value="risalah_rapat">
                    Risalah Rapat
                </option>

                <option value="disposisi">
                    Disposisi
                </option>

            </select>

        </div>

        {{-- BAGIAN --}}
        <div class="mb-6">

            <label class="font-semibold mb-2 block">
                Kirim Ke Bagian
            </label>

            <div class="flex gap-3">

                <select
                    id="bagianSelect"
                    class="input">

                    <option value="">
                        -- Pilih Bagian --
                    </option>

                    @foreach($bagian as $item)

                        <option
                            value="{{ $item->id }}"
                            data-label="{{ $item->nama_bagian }}">

                            {{ $item->nama_bagian }}

                        </option>

                    @endforeach

                </select>

                <button
                    type="button"
                    onclick="tambahBagian()"
                    class="btn-primary">

                    +

                </button>

            </div>

            <div
                class="box-list"
                id="listBagian">

            </div>

            <input
                type="hidden"
                name="bagian"
                id="bagianInput">

        </div>

        {{-- NOMOR --}}
        <!-- NOMOR & TANGGAL -->
        <div class="flex gap-6 mb-6 flex-col md:flex-row">

            <div class="flex-1">
                <label class="font-semibold mb-2 block">Nomor Surat</label>
                <input id="nomor" name="nomor_surat" class="input" placeholder="Contoh: 001/IT/V/2026">
            </div>

            <div class="flex-1">
                <label class="font-semibold mb-2 block">Tanggal Surat</label>
                <input type="date" id="tanggal" name="tanggal_surat" class="input" value="{{ date('Y-m-d') }}">
            </div>

        </div>

        {{-- PERIHAL --}}
        <div class="flex gap-6 mb-6 flex-col md:flex-row">
            <div class="flex-1">
            <label class="font-semibold mb-2 block">
                Perihal
            </label>

            <input
                type="text"
                name="perihal"
                class="input"
                placeholder="Isi perihal surat">
            </div>

            <div
            class="flex-1 hidden"
            id="dariWrapper">
            <label class="font-semibold mb-2 block">
                Surat Masuk Dari
            </label>

            <input
                type="text"
                name="dari"
                class="input"
                placeholder="Contoh: PT Sumxxxr Jxxxx Megxxx">
            </div>
        </div>

        {{-- FILE PDF --}}
        <div class="mb-6">

            <label class="font-semibold mb-2 block">
                Upload PDF
            </label>

            <input
                type="file"
                name="file_pdf"
                accept="application/pdf"
                class="input">

        </div>

        {{-- TTD --}}
        <div class="mb-6">

            <label class="font-semibold mb-2 block">
                Tanda Tangan
            </label>

            <div class="flex gap-3">

                <select
                    id="ttdSelect"
                    class="input">

                    <option value="">
                        -- Pilih Penandatangan --
                    </option>

                    @foreach($pegawai as $item)

                        <option
                            value="{{ $item->id }}"
                            data-label="{{ $item->nama }}">

                            {{ $item->nama }}
                            -
                            {{ $item->jabatanRelasi->nama_jabatan ?? '-' }}
                            -
                            {{ $item->bagianRelasi->nama_bagian ?? '-' }}

                        </option>

                    @endforeach

                </select>

                <button
                    type="button"
                    onclick="tambahTtd()"
                    class="btn-primary">

                    +

                </button>

            </div>

            <div
                class="box-list"
                id="listTtd">

            </div>

            <input
                type="hidden"
                name="ttd"
                id="ttdInput">

        </div>

        {{-- BUTTON --}}
        <div class="flex justify-end">

            <button
                type="submit"
                class="btn-primary">

                Kirim Surat

            </button>

        </div>

    </form>

</div>

@endsection

<script>

    let selectedBagian = [];
    let selectedTtd = [];

    function getLabel(selectId, value)
    {
        const option = document.querySelector(
            `#${selectId} option[value="${value}"]`
        );

        return option
            ? option.dataset.label
            : value;
    }

    /* =========================
       BAGIAN
    ========================= */

    function tambahBagian()
    {
        let val = bagianSelect.value;

        if (!val || selectedBagian.includes(val))
            return;

        selectedBagian.push(val);

        renderBagian();
    }

    function renderBagian()
    {
        listBagian.innerHTML =
            selectedBagian.map(k => `

            <div class="tag blue">

                ${getLabel('bagianSelect', k)}

                <button
                    type="button"
                    onclick="hapusBagian('${k}')">

                    ✖

                </button>

            </div>

        `).join('');

        bagianInput.value =
            selectedBagian.join(',');
    }

    function hapusBagian(k)
    {
        selectedBagian =
            selectedBagian.filter(x => x !== k);

        renderBagian();
    }

    /* =========================
       TTD
    ========================= */

    function tambahTtd()
    {
        let val = ttdSelect.value;

        if (!val || selectedTtd.includes(val))
            return;

        selectedTtd.push(val);

        renderTtd();
    }

    function renderTtd()
    {
        listTtd.innerHTML =
            selectedTtd.map(k => `

            <div class="tag green">

                ${getLabel('ttdSelect', k)}

                <button
                    type="button"
                    onclick="hapusTtd('${k}')">

                    ✖

                </button>

            </div>

        `).join('');

        ttdInput.value =
            selectedTtd.join(',');
    }

    function hapusTtd(k)
    {
        selectedTtd =
            selectedTtd.filter(x => x !== k);

        renderTtd();
    }

     function toggleJenisSurat(){

        const jenis =
            document.getElementById(
                'jenisSurat'
            ).value;

        const dari =
            document.getElementById(
                'dariWrapper'
            );

        // JIKA DISPOSISI
        if(jenis === 'disposisi'){

            dari.classList.remove('hidden');

        }

        // SELAIN DISPOSISI
        else {

            dari.classList.add('hidden');

        }

    }

    // AUTO LOAD
    toggleJenisSurat();


    function closeAlert(id){

        const alert =
            document.getElementById(id);

        if(alert){

            alert.remove();

        }

    }

    // auto close
    setTimeout(() => {

        closeAlert('alertSuccess');
        closeAlert('alertError');

    }, 4000);

</script>