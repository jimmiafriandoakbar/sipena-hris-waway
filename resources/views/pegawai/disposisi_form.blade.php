@extends('layouts.pegawai.app')

@section('content')

<style>

    .input{
        width:100%;
        border:1px solid #d1d5db;
        padding:12px 16px;
        border-radius:18px;
        background:#fff;
        transition:.2s;
    }

    .input:focus{
        border-color:#2563eb;
        box-shadow:0 0 0 4px rgba(37,99,235,.1);
        outline:none;
    }

</style>

<div class="p-6">

    <!-- HEADER -->
    <div class="flex items-center justify-between gap-4 mb-8">

        <div>

            <h1 class="text-3xl font-bold text-slate-800">
                Form Disposisi
            </h1>

            <p class="text-sm text-slate-500 mt-1">
                Tambahkan disposisi dan catatan tindak lanjut surat
            </p>

        </div>

        <a
            href="{{ route('pegawai.surat.preview', $surat->id) }}"
            class="h-11 px-5 rounded-xl border border-slate-300
            bg-white hover:bg-slate-50 transition
            text-sm font-medium text-slate-700
            inline-flex items-center">

            Kembali

        </a>

    </div>

    <!-- CARD -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

        <!-- HEADER -->
        <div class="px-8 py-6 border-b border-slate-100">

            <h2 class="text-2xl font-bold text-slate-800">
                Informasi Surat
            </h2>

        </div>

        <!-- BODY -->
        <div class="p-8">

            <form
                action="{{
                    $disposisiSaya->count()
                    ? route('pegawai.disposisi.update', $surat->id)
                    : route('pegawai.disposisi.store', $surat->id)
                }}"
                method="POST"
                class="space-y-8">

                @csrf

                <!-- INFORMASI -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- DARI -->
                    <div>

                        <label class="text-sm font-semibold text-slate-700 block mb-2">
                            Surat Masuk Dari
                        </label>

                        <div class="h-12 rounded-2xl border border-slate-200
                            bg-slate-50 px-4 flex items-center text-sm text-slate-700">

                            {{ $surat->dari ?? '-' }}

                        </div>

                    </div>

                    <!-- NOMOR -->
                    <div>

                        <label class="text-sm font-semibold text-slate-700 block mb-2">
                            Nomor Surat
                        </label>

                        <div class="h-12 rounded-2xl border border-slate-200
                            bg-slate-50 px-4 flex items-center text-sm text-slate-700">

                            {{ $surat->nomor_surat }}

                        </div>

                    </div>

                </div>

                <!-- BAGIAN -->
                <div>

                    <label class="text-sm font-semibold text-slate-700 block mb-3">
                        Disposisikan Ke Bagian
                    </label>

                    <div class="flex gap-3">

                        <!-- SELECT -->
                        <div class="flex-1">

                            <select
                                id="bagianSelect"
                                class="w-full h-14 rounded-2xl border border-slate-300
                                bg-slate-50 px-4 text-sm
                                focus:ring-2 focus:ring-blue-500
                                focus:border-blue-500 focus:bg-white
                                transition">

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

                        </div>

                        <!-- BUTTON -->
                        <div class="w-14 h-14">

                            <button
                                type="button"
                                onclick="tambahBagian()"
                                class="w-14 h-14 rounded-2xl
                                bg-blue-600 hover:bg-blue-700
                                transition text-white
                                text-3xl leading-none
                                flex items-center justify-center
                                shadow-sm">

                                +

                            </button>

                        </div>

                    </div>

                    <!-- LIST BAGIAN -->
                    <div
                        id="listBagian"
                        class="flex flex-wrap gap-3 mt-4">

                    </div>

                    <input
                        type="hidden"
                        name="bagian_id"
                        id="bagianInput">

                </div>

                <!-- CATATAN -->
                <div>

                    <label class="text-sm font-semibold text-slate-700 block mb-3">
                        Catatan / Tindak Lanjut
                    </label>

                    <div class="relative">

                        <textarea
                            name="catatan"
                            rows="7"
                            placeholder="Masukkan instruksi disposisi atau tindak lanjut..."
                            class="w-full rounded-3xl border border-slate-200
                            bg-gradient-to-b from-white to-slate-50
                            px-5 py-4 text-sm text-slate-700
                            shadow-sm
                            focus:ring-4 focus:ring-blue-100
                            focus:border-blue-500
                            focus:bg-white
                            transition duration-200
                            resize-none">{{ $disposisiSaya->first()->catatan ?? '' }}</textarea>

                        <div class="absolute bottom-4 right-4 text-xs text-slate-400">

                            Catatan disposisi

                        </div>

                    </div>

                </div>

                <!-- BUTTON -->
                <div class="flex justify-end">

                    <button
                        type="submit"
                        class="h-12 px-8 rounded-2xl
                        bg-blue-600 hover:bg-blue-700
                        transition text-white
                        text-sm font-semibold shadow-sm">

                        Simpan Disposisi

                    </button>

                </div>

            </form>

        </div>

    </div>

    <!-- RIWAYAT -->
    @if($riwayatDisposisi->count())

    <div class="mt-8">

        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

            <div class="px-8 py-6 border-b border-slate-100">

                <h2 class="text-xl font-bold text-slate-800">
                    Riwayat Disposisi
                </h2>

            </div>

            <div class="p-8 space-y-5">

                @foreach($riwayatDisposisi->groupBy('dari_pegawai_id') as $pegawaiId => $items)

                    <div class="rounded-3xl border border-slate-200 p-6">

                        <!-- HEADER -->
                        <div>

                            <h3 class="text-lg font-semibold text-slate-800">

                                {{ $items->first()->dariPegawai->nama ?? '-' }}

                            </h3>

                            <p class="text-sm text-emerald-600 mt-1">

                                ✔ Menyetujui dan mendisposisikan surat

                            </p>

                        </div>

                        <!-- BAGIAN -->
                        <div class="mt-5">

                            <label class="text-xs text-slate-400">
                                Disposisi Ke Bagian
                            </label>

                            <div class="flex flex-wrap gap-3 mt-3">

                                @foreach($items as $item)

                                    <div class="px-4 py-2 rounded-xl
                                        bg-amber-100 text-amber-700
                                        text-sm font-medium">

                                        {{ $item->bagian->nama_bagian ?? '-' }}

                                    </div>

                                @endforeach

                            </div>

                        </div>

                        <!-- CATATAN -->
                        <div class="mt-5">

                            <label class="text-xs text-slate-400">
                                Catatan Disposisi
                            </label>

                            <div class="mt-2 p-5 rounded-2xl
                                border border-amber-200
                                bg-amber-50">

                                <p class="text-sm text-slate-700 leading-relaxed">

                                    {{ $items->first()->catatan ?? '-' }}

                                </p>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        </div>

    </div>

    @endif

</div>

<!-- SCRIPT -->
<script>

    let bagianDipilih = [

        @foreach($disposisiSaya as $item)

            '{{ $item->bagian_id }}',

        @endforeach

    ];

    function tambahBagian(){

        const select =
            document.getElementById(
                'bagianSelect'
            );

        const value = select.value;

        if(!value) return;

        if(bagianDipilih.includes(value)) return;

        bagianDipilih.push(value);

        renderBagian();

    }

    function hapusBagian(id){

        bagianDipilih =
            bagianDipilih.filter(
                item => item != id
            );

        renderBagian();

    }

    function renderBagian(){

        const list =
            document.getElementById(
                'listBagian'
            );

        const select =
            document.getElementById(
                'bagianSelect'
            );

        list.innerHTML = '';

        bagianDipilih.forEach(id => {

            const option =
                [...select.options]
                .find(opt => opt.value == id);

            if(!option) return;

            const label =
                option.dataset.label;

            list.innerHTML += `

                <div class="flex items-center gap-2
                    px-4 py-2 rounded-2xl
                    bg-blue-100 text-blue-700
                    text-sm font-medium">

                    ${label}

                    <button
                        type="button"
                        onclick="hapusBagian('${id}')"
                        class="text-red-500 hover:text-red-700">

                        ✕

                    </button>

                </div>

            `;
        });

        document.getElementById(
            'bagianInput'
        ).value = bagianDipilih.join(',');

    }

    renderBagian();

</script>

@endsection