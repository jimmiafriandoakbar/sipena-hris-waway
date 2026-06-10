@extends('layouts.pegawai.app')

@section('content')

<div class="p-3">

    {{-- HEADER --}}
    <div class="mb-6">

        <h1 class="text-2xl font-bold text-slate-800">

            Detail Gaji Pegawai

        </h1>

        <p class="text-slate-500 mt-1">

            Informasi rincian gaji dan tunjangan pegawai

        </p>

    </div>

    {{-- CARD TOTAL --}}
    <div class="bg-gradient-to-r from-slate-800 to-slate-900
        rounded-3xl p-8 text-white shadow-xl mb-8">

        <div class="flex items-center justify-between">

            <div>

                <p class="text-slate-300 text-sm">

                    Total Gaji Diterima

                </p>

                <h2 class="text-4xl font-bold mt-2">

                    Rp
                    {{

                        number_format(

                            auth()->user()->pegawai->gaji_pokok +

                            auth()->user()->pegawai->tunjangan +

                            auth()->user()->pegawai->bonus -

                            auth()->user()->pegawai->potongan,

                            0,
                            ',',
                            '.'

                        )

                    }}

                </h2>

            </div>

            <div
                class="w-20 h-20 rounded-3xl bg-white/10
                flex items-center justify-center">

                <i
                    data-lucide="wallet"
                    class="w-10 h-10"></i>

            </div>

        </div>

    </div>

    {{-- GRID --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- GAJI --}}
        <div class="bg-white rounded-3xl shadow-sm border p-6">

            <h2 class="text-lg font-bold text-slate-800 mb-5">

                Gaji & Bonus

            </h2>

            <div class="space-y-4">

                <div
                    class="flex items-center justify-between
                    border-b pb-3">

                    <span class="text-slate-600">
                        Gaji Pokok
                    </span>

                    <span class="font-semibold">

                        Rp
                        {{

                            number_format(

                                auth()->user()->pegawai->gaji_pokok,

                                0,
                                ',',
                                '.'

                            )

                        }}

                    </span>

                </div>

                <div
                    class="flex items-center justify-between
                    border-b pb-3">

                    <span class="text-slate-600">
                        Bonus
                    </span>

                    <span class="font-semibold">

                        Rp
                        {{

                            number_format(

                                auth()->user()->pegawai->bonus,

                                0,
                                ',',
                                '.'

                            )

                        }}

                    </span>

                </div>

                <div
                    class="flex items-center justify-between">

                    <span class="text-slate-600">
                        Tunjangan Teller
                    </span>

                    <span class="font-semibold">

                        Rp 500.000

                    </span>

                </div>

            </div>

        </div>

        {{-- TUNJANGAN --}}
        <div class="bg-white rounded-3xl shadow-sm border p-6">

            <h2 class="text-lg font-bold text-slate-800 mb-5">

                Rincian Tunjangan

            </h2>

            <div class="space-y-4">

                <div
                    class="flex items-center justify-between
                    border-b pb-3">

                    <div>

                        <p class="font-medium">
                            Tunjangan Anak
                        </p>

                        <span class="text-xs text-slate-500">

                            2 Anak

                        </span>

                    </div>

                    <span class="font-semibold">

                        Rp 300.000

                    </span>

                </div>

                <div
                    class="flex items-center justify-between
                    border-b pb-3">

                    <span>
                        Tunjangan Istri
                    </span>

                    <span class="font-semibold">

                        Rp 250.000

                    </span>

                </div>

                <div
                    class="flex items-center justify-between
                    border-b pb-3">

                    <span>
                        Tunjangan Kemahalan
                    </span>

                    <span class="font-semibold">

                        Rp 500.000

                    </span>

                </div>

                <div
                    class="flex items-center justify-between
                    border-b pb-3">

                    <span>
                        Tunjangan Lain-lain
                    </span>

                    <span class="font-semibold">

                        Rp 200.000

                    </span>

                </div>

                <div
                    class="flex items-center justify-between">

                    <span class="font-semibold">
                        Total Tunjangan
                    </span>

                    <span
                        class="font-bold text-emerald-600">

                        Rp
                        {{

                            number_format(

                                auth()->user()->pegawai->tunjangan,

                                0,
                                ',',
                                '.'

                            )

                        }}

                    </span>

                </div>

            </div>

        </div>

        {{-- Kewajiban Pegawai --}}
        <div class="bg-white rounded-3xl shadow-sm border p-6 lg:col-span-2">

            <h2 class="text-lg font-bold text-slate-800 mb-5">

                Rincian Kewajiban Pegawai

            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <div
                    class="flex items-center justify-between
                    border rounded-2xl p-4">

                    <span>
                        Koperasi
                    </span>

                    <span class="font-semibold text-red-600">

                        Rp 100.000

                    </span>

                </div>

                <div
                    class="flex items-center justify-between
                    border rounded-2xl p-4">

                    <span>
                        Tabungan Pensiun
                    </span>

                    <span class="font-semibold text-red-600">

                        Rp 150.000

                    </span>

                </div>

                <div
                    class="flex items-center justify-between
                    border rounded-2xl p-4">

                    <span>
                        Infaq
                    </span>

                    <span class="font-semibold text-red-600">

                        Rp 50.000

                    </span>

                </div>

                <div
                    class="flex items-center justify-between
                    border rounded-2xl p-4">

                    <span>
                        BPJS Ketenagakerjaan
                    </span>

                    <span class="font-semibold text-red-600">

                        Rp 80.000

                    </span>

                </div>

                <div
                    class="flex items-center justify-between
                    border rounded-2xl p-4">

                    <span>
                        BPJS Kesehatan
                    </span>

                    <span class="font-semibold text-red-600">

                        Rp 75.000

                    </span>

                </div>

                <div
                    class="flex items-center justify-between
                    border rounded-2xl p-4">

                    <span>
                        Pinjaman Pegawai
                    </span>

                    <span class="font-semibold text-red-600">

                        Rp 200.000

                    </span>

                </div>

                <div
                    class="flex items-center justify-between
                    border rounded-2xl p-4">

                    <span>
                        Lain-lain
                    </span>

                    <span class="font-semibold text-red-600">

                        Rp 50.000

                    </span>

                </div>

                <div
                    class="flex items-center justify-between
                    border-2 border-red-200
                    bg-red-50 rounded-2xl p-4">

                    <span class="font-semibold">
                        Total Potongan
                    </span>

                    <span
                        class="font-bold text-red-600">

                        Rp
                        {{

                            number_format(

                                auth()->user()->pegawai->potongan,

                                0,
                                ',',
                                '.'

                            )

                        }}

                    </span>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection