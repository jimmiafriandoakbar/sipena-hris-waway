@extends('layouts.admin.app_admin')

@section('content')

<div class="mb-7 flex flex-col md:flex-row md:items-center md:justify-between gap-4">

    <div>
            <h1 class="text-3xl font-bold text-slate-800">
                Daftar Gaji Pegawai
            </h1>

            <p class="text-slate-500 text-sm mt-1">
                Kelola data Gaji Pegawai Waway
            </p>

    </div>

</div>

<div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

    <!-- FILTER -->
    <div class="p-6 border-b bg-slate-50/60">

        <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-5">

            <!-- LEFT -->
            <div class="flex flex-col lg:flex-row lg:items-center gap-3 w-full">

                <!-- SEARCH -->
                <div class="relative w-full lg:w-80">

                    <input
                        type="text"
                        id="searchInput"
                        placeholder="Cari nama pegawai..."
                        class="w-full h-12 pl-11 pr-4 rounded-2xl border border-slate-300
                        bg-white text-sm shadow-sm
                        focus:ring-4 focus:ring-blue-100 focus:border-blue-500
                        transition">

                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">

                        <i data-lucide="search" class="w-4 h-4"></i>

                    </div>

                </div>

                <!-- FILTER -->
                <select id="filterJabatan"
                    class="h-12 px-4 rounded-2xl border border-slate-300 bg-white
                    text-sm shadow-sm
                    focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition">

                    <option value="">
                        Semua Jabatan
                    </option>

                    @foreach($jabatan as $item)

                                <option value="{{ $item->nama_jabatan }}"
                                    {{ old('jabatan', $pegawai->jabatan ?? '') == $item->nama_jabatan ? 'selected' : '' }}>

                                    {{ $item->nama_jabatan }}

                                </option>

                                @endforeach

                </select>

                <!-- RESET -->
                <button onclick="resetFilter()"
                    class="h-12 px-5 rounded-2xl border border-slate-300
                    bg-white hover:bg-slate-50 transition
                    text-sm font-medium shadow-sm">

                    Reset

                </button>

            </div>

            <!-- RIGHT -->
            <div class="flex items-center gap-3">

                <!-- TOTAL -->
                <div class="hidden md:block text-sm text-slate-500 whitespace-nowrap">

                    Total

                    <span id="totalData" class="font-semibold text-slate-700">
                        {{ $pegawai->total() }}
                    </span>

                    data

                </div>

                <!-- EXPORT -->
                    <a href="{{ route('admin.gaji.print') }}" target="_blank"
                    class="px-4 py-2 rounded-xl bg-red-600 text-white text-sm font-semibold hover:bg-red-700">
                        Print PDF
                    </a>

                <a href="{{ route('admin.gaji.export') }}"
                    class="h-12 px-5 rounded-2xl bg-emerald-600 hover:bg-emerald-700
                    text-white text-sm font-semibold transition shadow-sm
                    inline-flex items-center gap-2 whitespace-nowrap">

                    <i data-lucide="file-spreadsheet" class="w-4 h-4"></i>

                    Export Excel

                </a>

            </div>

        </div>

    </div>

    <!-- TABLE -->
    <div class="overflow-x-auto">

        <table class="w-full text-sm whitespace-nowrap">

            <thead class="bg-slate-50/80 text-slate-500 uppercase text-[11px] tracking-wide">

                <tr>

                    <th class="px-6 py-4 text-left">
                        No
                    </th>

                    <th class="px-6 py-4 text-left">
                        Nama Pegawai
                    </th>

                    <th class="px-6 py-4 text-left">
                        Jabatan
                    </th>

                    <th class="px-6 py-4 text-left">
                        Rekening
                    </th>

                    <th class="px-6 py-4 text-left">
                        Gaji Pokok
                    </th>

                    <th class="px-6 py-4 text-left">
                        Tunjangan
                    </th>

                    <th class="px-6 py-4 text-left">
                        Potongan
                    </th>

                    <th class="px-6 py-4 text-right">
                        Aksi
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($pegawai as $index => $p)

                <tr class="dataRow border-t border-slate-100 hover:bg-blue-50/30 transition duration-200">

                    <!-- NO -->
                    <td class="px-6 py-5 text-slate-700">
                        {{ $pegawai->firstItem() + $index }}
                    </td>

                    <!-- NAMA -->
                    <td class="px-6 py-5">

                        <div class="flex items-center gap-3">

                            <div class="w-11 h-11 rounded-2xl bg-blue-100
                                flex items-center justify-center">

                                <i data-lucide="user"
                                    class="w-5 h-5 text-blue-700"></i>

                            </div>

                            <div>

                                <div class="font-semibold text-slate-800 nama">
                                    {{ $p->nama }}
                                </div>

                                <div class="text-xs text-slate-400 mt-1">
                                    {{ $p->email }}
                                </div>

                            </div>

                        </div>

                    </td>

                    <!-- JABATAN -->
                    <td class="px-6 py-5 jabatan">

                        <span class="px-3 py-1 rounded-full bg-blue-100
                            text-blue-700 text-xs font-semibold">

                            {{ $p->jabatanRelasi->nama_jabatan ?? '-' }}

                        </span>

                    </td>

                    <!-- REKENING -->
                    <td class="px-6 py-5 text-slate-700">
                        {{ $p->nomor_rekening }}
                    </td>

                    <!-- GAJI -->
                    <td class="px-6 py-5 font-medium text-emerald-700">
                        Rp {{ number_format($p->payroll->gaji_pokok ?? 0, 0, ',', '.') }}
                    </td>

                    <!-- TUNJANGAN -->
                    <td class="px-6 py-5 text-slate-700">
                        Rp {{ number_format(
                            ($p->payroll->tunjangan_teller ?? 0) +
                            ($p->payroll->tunjangan_anak ?? 0) +
                            ($p->payroll->tunjangan_istri ?? 0) +
                            ($p->payroll->tunjangan_kemahalan ?? 0) +
                            ($p->payroll->tunjangan_lain_lain ?? 0)
                        ,0,',','.') }}
                    </td>

                    <!-- POTONGAN -->
                    <td class="px-6 py-5 text-red-600">
                        Rp {{ number_format(
                            ($p->payroll->koperasi ?? 0) +
                            ($p->payroll->koperasi_pinjaman ?? 0) +
                            ($p->payroll->infaq ?? 0) +
                            ($p->payroll->bpjs_kesehatan ?? 0) +
                            ($p->payroll->bpjs_ketenagakerjaan ?? 0) +
                            ($p->payroll->tabungan_pensiun ?? 0) +
                            ($p->payroll->pinjaman_pegawai ?? 0) +
                            ($p->payroll->potongan_lain_lain ?? 0)
                        ,0,',','.') }}
                    </td>

                    <!-- AKSI -->
                    <td class="px-6 py-5">

                        <div class="flex justify-end items-center gap-2">

                            @php
    $payroll = $p->payroll;

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
        ($payroll->gaji_pokok ?? 0) +
        $totalTunjangan -
        $totalPotongan;
@endphp

<button
    onclick='openDetailModal({
        nama: @json($p->nama),
        jabatan: @json($p->jabatanRelasi->nama_jabatan ?? "-"),
        nomor_rekening: @json($p->nomor_rekening),

        gaji_pokok: @json(intval($payroll->gaji_pokok ?? 0)),
        tunjangan_teller: @json(intval($payroll->tunjangan_teller ?? 0)),
        tunjangan_anak: @json(intval($payroll->tunjangan_anak ?? 0)),
        jumlah_anak: @json(intval($payroll->jumlah_anak ?? 0)),
        tunjangan_istri: @json(intval($payroll->tunjangan_istri ?? 0)),
        tunjangan_kemahalan: @json(intval($payroll->tunjangan_kemahalan ?? 0)),
        tunjangan_lain_lain: @json(intval($payroll->tunjangan_lain_lain ?? 0)),

        koperasi: @json(intval($payroll->koperasi ?? 0)),
        koperasi_pinjaman: @json(intval($payroll->koperasi_pinjaman ?? 0)),
        infaq: @json(intval($payroll->infaq ?? 0)),
        bpjs_kesehatan: @json(intval($payroll->bpjs_kesehatan ?? 0)),
        bpjs_ketenagakerjaan: @json(intval($payroll->bpjs_ketenagakerjaan ?? 0)),
        tabungan_pensiun: @json(intval($payroll->tabungan_pensiun ?? 0)),
        pinjaman_pegawai: @json(intval($payroll->pinjaman_pegawai ?? 0)),
        potongan_lain_lain: @json(intval($payroll->potongan_lain_lain ?? 0)),

        total_tunjangan: @json(intval($totalTunjangan)),
        total_potongan: @json(intval($totalPotongan)),
        take_home_pay: @json(intval($takeHomePay))
    })'
    class="h-10 w-10 rounded-xl border border-blue-200
    bg-blue-50 text-blue-700 hover:bg-blue-100
    flex items-center justify-center shadow-sm">

    <i data-lucide="eye" class="w-4 h-4"></i>

</button>
                            <a href="{{ route('admin.editgaji', $p->id) }}"
                                class="h-10 w-10 rounded-xl border border-yellow-200
                                bg-yellow-50 text-yellow-700 hover:bg-yellow-100
                                flex items-center justify-center shadow-sm">

                                <i data-lucide="pencil" class="w-4 h-4"></i>

                            </a>

                        </div>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="9"
                        class="py-16 text-center text-slate-500">

                        Tidak ada data pegawai

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <!-- PAGINATION -->
    <div class="flex flex-col md:flex-row items-center justify-between gap-4 px-6 py-5 border-t bg-slate-50/70">

        <!-- INFO -->
        <p class="text-sm text-slate-500">

            Menampilkan

            <span class="font-semibold text-slate-700">
                {{ $pegawai->firstItem() }}
            </span>

            -

            <span class="font-semibold text-slate-700">
                {{ $pegawai->lastItem() }}
            </span>

            dari

            <span class="font-semibold text-slate-700">
                {{ $pegawai->total() }}
            </span>

            data

        </p>

        <!-- PAGE -->
        <div class="flex items-center gap-2">

            {{ $pegawai->links() }}

        </div>

    </div>

</div>

<!-- MODAL DETAIL -->
<div id="detailModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm p-4">

    <div class="relative w-full max-w-5xl bg-white rounded-3xl shadow-2xl overflow-hidden">

        <!-- HEADER -->
        <div class="border-b px-8 py-5 flex items-center justify-between">

            <div>

                <h2 class="text-2xl font-bold text-slate-800">
                    Detail Gaji Pegawai
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Informasi detail penggajian pegawai SIPENA
                </p>

            </div>

            <button onclick="closeDetailModal()"
                class="w-10 h-10 rounded-xl hover:bg-red-50
                text-slate-400 hover:text-red-500 transition
                flex items-center justify-center text-xl">

                ✕

            </button>

        </div>

        <!-- CONTENT -->
        <div class="p-8 space-y-8">

            <!-- DATA -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                <div class="detail-card">

                    <label>
                        Nama Pegawai
                    </label>

                    <h4 id="detailNama"></h4>

                </div>

                <div class="detail-card">

                    <label>
                        Jabatan
                    </label>

                    <h4 id="detailJabatan"></h4>

                </div>

                <div class="detail-card">

                    <label>
                        Nomor Rekening
                    </label>

                    <h4 id="detailRekening"></h4>

                </div>

            </div>

            <!-- GAJI -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

    <div class="rounded-2xl bg-emerald-50 border border-emerald-100 p-5">
        <p class="text-xs uppercase tracking-wide text-emerald-600 mb-2">
            Total Gaji & Tunjangan
        </p>

        <h3 class="text-2xl font-bold text-emerald-700">
            Rp <span id="detailTotalPendapatan"></span>
        </h3>
    </div>

    <div class="rounded-2xl bg-red-50 border border-red-100 p-5">
        <p class="text-xs uppercase tracking-wide text-red-600 mb-2">
            Total Potongan
        </p>

        <h3 class="text-2xl font-bold text-red-700">
            Rp <span id="detailTotalPotongan"></span>
        </h3>
    </div>

    <div class="rounded-2xl bg-blue-50 border border-blue-100 p-5">
        <p class="text-xs uppercase tracking-wide text-blue-600 mb-2">
            Take Home Pay
        </p>

        <h3 class="text-2xl font-bold text-blue-700">
            Rp <span id="detailTakeHomePay"></span>
        </h3>
    </div>

</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    <div class="rounded-2xl border border-slate-200 overflow-hidden">
        <div class="px-5 py-4 bg-slate-50 border-b">
            <h3 class="font-bold text-slate-800">
                Rincian Gaji & Tunjangan
            </h3>
        </div>

        <table class="w-full text-sm">
            <tbody class="divide-y divide-slate-100">
                <tr>
                    <td class="px-5 py-3 text-slate-500">Gaji Pokok</td>
                    <td class="px-5 py-3 text-right font-semibold">
                        Rp <span id="detailGajiPokok"></span>
                    </td>
                </tr>
                <tr>
                    <td class="px-5 py-3 text-slate-500">Tunjangan Teller</td>
                    <td class="px-5 py-3 text-right font-semibold">
                        Rp <span id="detailTunjanganTeller"></span>
                    </td>
                </tr>
                <tr>
                    <td class="px-5 py-3 text-slate-500">Tunjangan Anak</td>
                    <td class="px-5 py-3 text-right font-semibold">
                        Rp <span id="detailTunjanganAnak"></span>
                    </td>
                </tr>
                <tr>
                    <td class="px-5 py-3 text-slate-500">Jumlah Anak</td>
                    <td class="px-5 py-3 text-right font-semibold">
                        <span id="detailJumlahAnak"></span> Anak
                    </td>
                </tr>
                <tr>
                    <td class="px-5 py-3 text-slate-500">Tunjangan Istri</td>
                    <td class="px-5 py-3 text-right font-semibold">
                        Rp <span id="detailTunjanganIstri"></span>
                    </td>
                </tr>
                <tr>
                    <td class="px-5 py-3 text-slate-500">Tunjangan Kemahalan</td>
                    <td class="px-5 py-3 text-right font-semibold">
                        Rp <span id="detailTunjanganKemahalan"></span>
                    </td>
                </tr>
                <tr>
                    <td class="px-5 py-3 text-slate-500">Tunjangan Lain-lain</td>
                    <td class="px-5 py-3 text-right font-semibold">
                        Rp <span id="detailTunjanganLainLain"></span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="rounded-2xl border border-slate-200 overflow-hidden">
        <div class="px-5 py-4 bg-slate-50 border-b">
            <h3 class="font-bold text-slate-800">
                Rincian Potongan
            </h3>
        </div>

        <table class="w-full text-sm">
            <tbody class="divide-y divide-slate-100">
                <tr>
                    <td class="px-5 py-3 text-slate-500">Koperasi</td>
                    <td class="px-5 py-3 text-right font-semibold text-red-600">
                        Rp <span id="detailKoperasi"></span>
                    </td>
                </tr>
                <tr>
                    <td class="px-5 py-3 text-slate-500">Koperasi Pinjaman</td>
                    <td class="px-5 py-3 text-right font-semibold text-red-600">
                        Rp <span id="detailKoperasiPinjaman"></span>
                    </td>
                </tr>
                <tr>
                    <td class="px-5 py-3 text-slate-500">Infaq</td>
                    <td class="px-5 py-3 text-right font-semibold text-red-600">
                        Rp <span id="detailInfaq"></span>
                    </td>
                </tr>
                <tr>
                    <td class="px-5 py-3 text-slate-500">BPJS Kesehatan</td>
                    <td class="px-5 py-3 text-right font-semibold text-red-600">
                        Rp <span id="detailBpjsKesehatan"></span>
                    </td>
                </tr>
                <tr>
                    <td class="px-5 py-3 text-slate-500">BPJS Ketenagakerjaan</td>
                    <td class="px-5 py-3 text-right font-semibold text-red-600">
                        Rp <span id="detailBpjsKetenagakerjaan"></span>
                    </td>
                </tr>
                <tr>
                    <td class="px-5 py-3 text-slate-500">Tabungan Pensiun</td>
                    <td class="px-5 py-3 text-right font-semibold text-red-600">
                        Rp <span id="detailTabunganPensiun"></span>
                    </td>
                </tr>
                <tr>
                    <td class="px-5 py-3 text-slate-500">Pinjaman Pegawai</td>
                    <td class="px-5 py-3 text-right font-semibold text-red-600">
                        Rp <span id="detailPinjamanPegawai"></span>
                    </td>
                </tr>
                <tr>
                    <td class="px-5 py-3 text-slate-500">Potongan Lain-lain</td>
                    <td class="px-5 py-3 text-right font-semibold text-red-600">
                        Rp <span id="detailPotonganLainLain"></span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</div>

        </div>

        <!-- FOOTER -->
        <div class="border-t px-8 py-5 flex justify-end">

            <button onclick="closeDetailModal()"
                class="h-11 px-6 rounded-xl border border-slate-300
                text-sm font-medium hover:bg-slate-50 transition">

                Tutup

            </button>

        </div>

    </div>

</div>

<style>

.detail-card{
    @apply bg-slate-50 rounded-2xl p-5 border border-slate-100;
}

.detail-card label{
    @apply text-xs uppercase tracking-wide text-slate-500 block mb-2;
}

.detail-card h4{
    @apply text-base font-semibold text-slate-800;
}

</style>

<script>

lucide.createIcons();

function rupiah(value)
{
    return new Intl.NumberFormat('id-ID').format(value ?? 0);
}

function setText(id, value)
{
    const el = document.getElementById(id);

    if (el) {
        el.innerText = value;
    }
}

function openDetailModal(p)
{
    setText('detailNama', p.nama ?? '-');
    setText('detailJabatan', p.jabatan ?? '-');
    setText('detailRekening', p.nomor_rekening ?? '-');

    const totalPendapatan =
        (p.gaji_pokok ?? 0) +
        (p.tunjangan_teller ?? 0) +
        (p.tunjangan_anak ?? 0) +
        (p.tunjangan_istri ?? 0) +
        (p.tunjangan_kemahalan ?? 0) +
        (p.tunjangan_lain_lain ?? 0);

    const totalPotongan =
        (p.koperasi ?? 0) +
        (p.koperasi_pinjaman ?? 0) +
        (p.infaq ?? 0) +
        (p.bpjs_kesehatan ?? 0) +
        (p.bpjs_ketenagakerjaan ?? 0) +
        (p.tabungan_pensiun ?? 0) +
        (p.pinjaman_pegawai ?? 0) +
        (p.potongan_lain_lain ?? 0);

    const takeHomePay = totalPendapatan - totalPotongan;

    setText('detailTotalPendapatan', rupiah(totalPendapatan));
    setText('detailTotalPotongan', rupiah(totalPotongan));
    setText('detailTakeHomePay', rupiah(takeHomePay));

    setText('detailGajiPokok', rupiah(p.gaji_pokok));
    setText('detailTunjanganTeller', rupiah(p.tunjangan_teller));
    setText('detailTunjanganAnak', rupiah(p.tunjangan_anak));
    setText('detailJumlahAnak', p.jumlah_anak ?? 0);
    setText('detailTunjanganIstri', rupiah(p.tunjangan_istri));
    setText('detailTunjanganKemahalan', rupiah(p.tunjangan_kemahalan));
    setText('detailTunjanganLainLain', rupiah(p.tunjangan_lain_lain));

    setText('detailKoperasi', rupiah(p.koperasi));
    setText('detailKoperasiPinjaman', rupiah(p.koperasi_pinjaman));
    setText('detailInfaq', rupiah(p.infaq));
    setText('detailBpjsKesehatan', rupiah(p.bpjs_kesehatan));
    setText('detailBpjsKetenagakerjaan', rupiah(p.bpjs_ketenagakerjaan));
    setText('detailTabunganPensiun', rupiah(p.tabungan_pensiun));
    setText('detailPinjamanPegawai', rupiah(p.pinjaman_pegawai));
    setText('detailPotonganLainLain', rupiah(p.potongan_lain_lain));

    document.getElementById('detailModal').classList.remove('hidden');
    document.getElementById('detailModal').classList.add('flex');
}

function closeDetailModal()
{
    document.getElementById('detailModal').classList.add('hidden');
    document.getElementById('detailModal').classList.remove('flex');
}

function closeDetailModal(){

    document.getElementById('detailModal').classList.add('hidden');

    document.getElementById('detailModal').classList.remove('flex');

}

document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('searchInput');

    const filterJabatan = document.getElementById('filterJabatan');

    const rows = document.querySelectorAll('.dataRow');

    window.resetFilter = function () {

        searchInput.value = '';

        filterJabatan.value = '';

        filterData();

    }

    function filterData(){

        const keyword = searchInput.value.toLowerCase();

        const jabatan = filterJabatan.value.toLowerCase();

        let visible = 0;

        rows.forEach(row => {

            const nama = row.querySelector('.nama')
                .innerText
                .toLowerCase();

            const jabatanRow = row.querySelector('.jabatan')
                .innerText
                .toLowerCase();

            const matchNama =
                nama.includes(keyword);

            const matchJabatan =
                !jabatan || jabatanRow.includes(jabatan);

            if(matchNama && matchJabatan){

                row.style.display = '';

                visible++;

            }else{

                row.style.display = 'none';

            }

        });

        document.getElementById('totalData').innerText = visible;

    }

    searchInput.addEventListener('keyup', filterData);

    filterJabatan.addEventListener('change', filterData);

});

</script>

@endsection