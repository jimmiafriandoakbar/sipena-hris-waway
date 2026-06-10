@extends('layouts.admin.app_admin')

@section('content')

@php
    $payroll = $pegawai->payroll;
@endphp

<div class="max-w-7xl mx-auto space-y-6">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <div>
            <h1 class="text-3xl font-bold text-slate-800">
                Edit Payroll Pegawai
            </h1>

            <p class="text-sm text-slate-500 mt-1">
                Pengaturan komponen gaji, tunjangan, dan potongan pegawai.
            </p>
        </div>

        <a href="{{ url()->previous() }}"
            class="h-11 px-5 rounded-2xl border border-slate-300 bg-white
            text-slate-700 hover:bg-slate-50 transition text-sm font-semibold
            inline-flex items-center justify-center gap-2 shadow-sm">

            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Kembali

        </a>

    </div>

    <form action="{{ route('admin.editgaji.update', $pegawai->id) }}" method="POST">

        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

            <div class="xl:col-span-2 space-y-6">

                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

                    <div class="px-6 py-5 border-b bg-slate-50/70">
                        <h2 class="text-lg font-bold text-slate-800">
                            Komponen Gaji
                        </h2>
                    </div>

                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">

                        <div class="md:col-span-2">
                            <label class="label-payroll">Gaji Pokok</label>

                            <input type="number"
                                name="gaji_pokok"
                                value="{{ old('gaji_pokok', intval($payroll->gaji_pokok ?? 0)) }}"
                                class="input-payroll"
                                placeholder="0">
                        </div>

                        <div>
                        <label class="label-payroll block">
                            Tunjangan Teller
                        </label>

                        <p class="text-xs text-gray-500 mb-2">
                            Dibayarkan 1 kali dalam setahun (bulan Desember)
                        </p>

                        <input
                            type="number"
                            name="tunjangan_teller"
                            value="{{ old('tunjangan_teller', intval($payroll->tunjangan_teller ?? 0)) }}"
                            class="input-payroll"
                            placeholder="0"
                        >
                    </div>

                    </div>

                </div>

                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

                    <div class="px-6 py-5 border-b bg-slate-50/70">
                        <h2 class="text-lg font-bold text-slate-800">
                            Rincian Tunjangan
                        </h2>
                    </div>

                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">

                        <div>
                            <label class="label-payroll">Tunjangan Anak</label>

                            <input type="number"
                                name="tunjangan_anak"
                                value="{{ old('tunjangan_anak', intval($payroll->tunjangan_anak ?? 0)) }}"
                                class="input-payroll"
                                placeholder="0">
                        </div>

                        <div>
                            <label class="label-payroll">Jumlah Anak</label>

                            <select name="jumlah_anak" class="input-payroll">
                                <option value="0" {{ old('jumlah_anak', $payroll->jumlah_anak ?? 0) == 0 ? 'selected' : '' }}>0 Anak</option>
                                <option value="1" {{ old('jumlah_anak', $payroll->jumlah_anak ?? 0) == 1 ? 'selected' : '' }}>1 Anak</option>
                                <option value="2" {{ old('jumlah_anak', $payroll->jumlah_anak ?? 0) == 2 ? 'selected' : '' }}>2 Anak</option>
                            </select>
                        </div>

                        <div>
                            <label class="label-payroll">Tunjangan Istri</label>

                            <input type="number"
                                name="tunjangan_istri"
                                value="{{ old('tunjangan_istri', intval($payroll->tunjangan_istri ?? 0)) }}"
                                class="input-payroll"
                                placeholder="0">
                        </div>

                        <div>
                            <label class="label-payroll">Tunjangan Kemahalan</label>

                            <input type="number"
                                name="tunjangan_kemahalan"
                                value="{{ old('tunjangan_kemahalan', intval($payroll->tunjangan_kemahalan ?? 0)) }}"
                                class="input-payroll"
                                placeholder="0">
                        </div>

                        <div class="md:col-span-2">
                            <label class="label-payroll">Tunjangan Jabatan</label>

                            <input type="number"
                                name="tunjangan_lain_lain"
                                value="{{ old('tunjangan_lain_lain', intval($payroll->tunjangan_lain_lain ?? 0)) }}"
                                class="input-payroll"
                                placeholder="0">
                        </div>

                    </div>

                </div>

                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

                    <div class="px-6 py-5 border-b bg-slate-50/70">
                        <h2 class="text-lg font-bold text-slate-800">
                            Kewajiban & Potongan Pegawai
                        </h2>
                    </div>

                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">

                        <div>
                            <label class="label-payroll">Koperasi</label>

                            <input type="number"
                                name="koperasi"
                                value="{{ old('koperasi', intval($payroll->koperasi ?? 0)) }}"
                                class="input-payroll"
                                placeholder="0">
                        </div>

                        <div>
                            <label class="label-payroll">Koperasi Pinjaman</label>

                            <input type="number"
                                name="koperasi_pinjaman"
                                value="{{ old('koperasi_pinjaman', intval($payroll->koperasi_pinjaman ?? 0)) }}"
                                class="input-payroll"
                                placeholder="0">
                        </div>

                        <div>
                            <label class="label-payroll">Infaq</label>

                            <input type="number"
                                name="infaq"
                                value="{{ old('infaq', intval($payroll->infaq ?? 0)) }}"
                                class="input-payroll"
                                placeholder="0">
                        </div>

                        <div>
                            <label class="label-payroll">BPJS Kesehatan</label>

                            <input type="number"
                                name="bpjs_kesehatan"
                                value="{{ old('bpjs_kesehatan', intval($payroll->bpjs_kesehatan ?? 0)) }}"
                                class="input-payroll"
                                placeholder="0">
                        </div>

                        <div>
                            <label class="label-payroll">BPJS Ketenagakerjaan</label>

                            <input type="number"
                                name="bpjs_ketenagakerjaan"
                                value="{{ old('bpjs_ketenagakerjaan', intval($payroll->bpjs_ketenagakerjaan ?? 0)) }}"
                                class="input-payroll"
                                placeholder="0">
                        </div>

                        <div>
                            <label class="label-payroll">Tabungan Pensiun</label>

                            <input type="number"
                                name="tabungan_pensiun"
                                value="{{ old('tabungan_pensiun', intval($payroll->tabungan_pensiun ?? 0)) }}"
                                class="input-payroll"
                                placeholder="0">
                        </div>

                        <div>
                            <label class="label-payroll">Pinjaman Pegawai</label>

                            <input type="number"
                                name="pinjaman_pegawai"
                                value="{{ old('pinjaman_pegawai', intval($payroll->pinjaman_pegawai ?? 0)) }}"
                                class="input-payroll"
                                placeholder="0">
                        </div>

                        <div>
                            <label class="label-payroll">Potongan Lain-lain</label>

                            <input type="number"
                                name="potongan_lain_lain"
                                value="{{ old('potongan_lain_lain', intval($payroll->potongan_lain_lain ?? 0)) }}"
                                class="input-payroll"
                                placeholder="0">
                        </div>

                    </div>

                </div>

            </div>

            <div class="space-y-6">

                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sticky top-6">

                    <h2 class="text-lg font-bold text-slate-800 mb-4">
                        Ringkasan Payroll
                    </h2>

                    <div class="space-y-4">

                    <div class="summary-card">
                        <span>Total Gaji & Tunjangan</span>
                        <b id="totalPendapatan">
                            Rp 0
                        </b>
                    </div>

                    <div class="summary-card">
                        <span>Total Potongan</span>
                        <b id="totalPotongan" class="text-red-600">
                            Rp 0
                        </b>
                    </div>

                    <div class="rounded-2xl bg-blue-50 border border-blue-100 p-5">

                        <span class="text-sm text-blue-600">
                            Take Home Pay
                        </span>

                        <h3 id="takeHomePay"
                            class="text-2xl font-bold text-blue-700 mt-1">

                            Rp 0

                        </h3>

                    </div>

                </div>

                    <button type="submit"
                        class="w-full h-12 mt-6 rounded-2xl bg-blue-600 text-white
                        hover:bg-blue-700 transition font-semibold shadow-sm
                        inline-flex items-center justify-center gap-2">

                        <i data-lucide="save" class="w-4 h-4"></i>
                        Simpan Payroll

                    </button>

                </div>

            </div>

        </div>

    </form>

</div>

<style>
    .label-payroll {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #334155;
        margin-bottom: 8px;
    }

    .input-payroll {
        width: 100%;
        height: 46px;
        padding: 0 16px;
        border-radius: 16px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        font-size: 14px;
        color: #0f172a;
        transition: all .2s ease;
        outline: none;
    }

    .input-payroll:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px #dbeafe;
    }

    .summary-card {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        padding: 16px;
        border-radius: 18px;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
    }

    .summary-card span {
        font-size: 13px;
        color: #64748b;
    }

    .summary-card b {
        font-size: 15px;
        color: #0f172a;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {

    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    function getValue(name) {
        const input = document.querySelector(`[name="${name}"]`);

        if (!input) {
            return 0;
        }

        return parseInt(input.value) || 0;
    }

    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID').format(angka);
    }

    function hitungPayroll() {
        const totalPendapatan =
            getValue('gaji_pokok') +
            getValue('tunjangan_teller') +
            getValue('tunjangan_anak') +
            getValue('tunjangan_istri') +
            getValue('tunjangan_kemahalan') +
            getValue('tunjangan_lain_lain');

        const totalPotongan =
            getValue('koperasi') +
            getValue('koperasi_pinjaman') +
            getValue('infaq') +
            getValue('bpjs_kesehatan') +
            getValue('bpjs_ketenagakerjaan') +
            getValue('tabungan_pensiun') +
            getValue('pinjaman_pegawai') +
            getValue('potongan_lain_lain');

        const takeHomePay = totalPendapatan - totalPotongan;

        document.getElementById('totalPendapatan').innerText =
            'Rp ' + formatRupiah(totalPendapatan);

        document.getElementById('totalPotongan').innerText =
            'Rp ' + formatRupiah(totalPotongan);

        document.getElementById('takeHomePay').innerText =
            'Rp ' + formatRupiah(takeHomePay);
    }

    document.querySelectorAll('input[type="number"], select[name="jumlah_anak"]')
        .forEach(function (el) {
            el.addEventListener('input', hitungPayroll);
            el.addEventListener('change', hitungPayroll);
        });

    hitungPayroll();

});
</script>

@endsection