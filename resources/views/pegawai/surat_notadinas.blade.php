@extends('layouts.pegawai.app')

@section('content')

<!-- ALERT SUCCESS -->
@if(session('success'))

    <div
        id="alertSuccess"
        class="fixed top-5 right-5 z-50
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

    <div
        id="alertError"
        class="fixed top-5 right-5 z-50
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
                Buat Surat
            </h1>

            <p class="text-slate-500 text-sm mt-1">
                Pembuatan surat pegawai SIPENA
            </p>

        </div>

</div>

<div class="bg-white p-6 rounded-xl shadow">
    <form
        id="formSurat"
        action="{{ route('pegawai.surat.nota_dinas.store') }}"
        method="POST"
        enctype="multipart/form-data">

        @csrf

        <!-- BAGIAN -->
        <div class="mb-6">
            
        <div class="mb-6">
            <label for="jenisSurat" class="font-semibold mb-2 block">
                Jenis Surat
            </label>

            <select id="jenisSurat" name="jenis_surat"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none">

                <option value="Nota Dinas">Nota Dinas</option>
                <option value="Berita Acara">Berita Acara</option>
                <option value="Risalah Rapat">Risalah Rapat</option>
                <option value="SPT">Surat Perintah Tugas</option>

            </select>
        </div>

            <label class="font-semibold mb-2 block">Kirim Ke Bagian</label>

            <div class="flex gap-2">
                <select id="bagianSelect" class="input">
                    <option value="">-- Pilih Bagian Tujuan --</option>
                    @foreach($bagian as $b)

                        <option value="{{ $b->id }}">

                            {{ $b->nama_bagian }}

                        </option>

                    @endforeach
                </select>

                <button type="button" onclick="addItem('bagian')" class="btn-blue">+</button>
            </div>

            <div class="mt-4 box" id="listBagian"></div>
            <input type="hidden" id="bagianInput" name="bagian">
        </div>

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

        <!-- PERIHAL -->
        <div class="mb-6">
            <label class="font-semibold mb-2 block">Perihal</label>
            <input id="perihal" name="perihal" class="input" placeholder="Contoh: Permohonan Data Nasabah">
        </div>

        <!-- ISI -->
        <div class="mb-6">
            <label class="font-semibold mb-2 block">Isi Surat</label>
            <textarea id="isi" name="isi_surat" rows="6" class="input"
                placeholder="Tuliskan isi surat secara lengkap dan jelas..."></textarea>
        </div>

        <!-- LAMPIRAN -->
        <div class="mb-6">
            <label class="font-semibold block mb-2">Import Lampiran (PDF / JPG / PNG)</label>
            <input type="file"
                    id="lampiranFile"
                    name="file_pdf[]" class="input" accept=".pdf,.jpg,.jpeg,.png" multiple>
        </div>

        <!-- TTD -->
        <div class="mb-6">
            <label class="font-semibold mb-2 block">Tanda Tangan</label>

            <div class="flex gap-2">
                <select id="ttdSelect" class="input">
                    <option value="">-- Pilih Persetujuan --</option>
                    @foreach($pegawai as $p)

                        <option value="{{ $p->id }}">

                            {{ $p->nama }}
                        -
                        {{ $p->jabatanRelasi->nama_jabatan ?? '-' }} -
                        {{ $p->bagianRelasi->nama_bagian ?? '-' }}


                        </option>

                    @endforeach
                </select>

                <button type="button" onclick="addItem('ttd')" class="btn-blue">+</button>
            </div>

            <div class="mt-4 box" id="listTtd"></div>
            <input type="hidden" id="ttdInput" name="ttd">
        </div>

        <!-- BUTTON -->
        <div class="flex justify-end gap-3 mt-4">
            
            <button type="submit"
                class="flex items-center gap-2 bg-blue-500 text-white px-4 py-2.5 rounded-xl shadow hover:bg-blue-600 transition">
                Kirim
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
</style>

<script>
    let selectedBagian = [];
    let selectedTtd = [];

    function addItem(type)
{
    const select = document.getElementById(type + 'Select');

    const id = select.value;

    const text = select.options[select.selectedIndex].text;

    if (!id) return;

    let arr = type === 'bagian'
        ? selectedBagian
        : selectedTtd;

    if (arr.some(v => v.id == id)) return;

    arr.push({
        id,
        text
    });

    render(type);
}

    function removeItem(type, id)
{
    let arr = type === 'bagian'
        ? selectedBagian
        : selectedTtd;

    arr = arr.filter(v => v.id != id);

    if (type === 'bagian')
        selectedBagian = arr;
    else
        selectedTtd = arr;

    render(type);
}

    function render(type)
{
    const arr = type === 'bagian'
        ? selectedBagian
        : selectedTtd;

    const container = document.getElementById(
        type === 'bagian'
            ? 'listBagian'
            : 'listTtd'
    );

    const input = document.getElementById(
        type === 'bagian'
            ? 'bagianInput'
            : 'ttdInput'
    );

    if (!arr.length) {

        container.innerHTML =
            '<span class="text-gray-400 text-sm">Belum ada</span>';

        return;
    }

    container.innerHTML = arr.map(item => `

        <div class="tag ${type==='bagian'?'blue':'green'}">

            ${item.text}

            <button type="button"
                onclick="removeItem('${type}', ${item.id})">

                ✖

            </button>

        </div>

    `).join('');

    input.value = arr.map(v => v.id).join(',');
}
 
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