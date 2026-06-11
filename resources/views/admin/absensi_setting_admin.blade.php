@extends('layouts.admin.app_admin')

@section('content')

<div class="p-6 bg-slate-50 min-h-screen">

    <div class="max-w-6xl mx-auto">

        <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-slate-800">
                    Parameter Absensi
                </h1>
                <p class="text-slate-500 mt-1">
                    Pengaturan jam kerja, lembur, lokasi kantor, radius absensi, dan validasi GPS pegawai.
                </p>
            </div>

            <div class="px-5 py-3 rounded-2xl bg-white border border-slate-200 shadow-sm">
                <p class="text-xs text-slate-500">Status</p>
                <p class="font-bold text-blue-700">Absensi Aktif</p>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-5 p-4 rounded-2xl bg-green-50 border border-green-200 text-green-700 font-semibold">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-5 p-4 rounded-2xl bg-red-50 border border-red-200 text-red-700">
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.absensi.setting.update') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <div class="lg:col-span-2 space-y-6">

                    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                            <h2 class="font-bold text-slate-800">
                                Jam Kerja & Lembur
                            </h2>
                            <p class="text-sm text-slate-500 mt-1">
                                Atur jadwal masuk, pulang, toleransi terlambat, dan jam mulai lembur.
                            </p>
                        </div>

                        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Jam Masuk
                                </label>
                                <input type="time"
                                       name="jam_masuk"
                                       value="{{ old('jam_masuk', $setting->jam_masuk ?? '08:00') }}"
                                       class="w-full rounded-2xl border-slate-300 focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Jam Pulang
                                </label>
                                <input type="time"
                                       name="jam_pulang"
                                       value="{{ old('jam_pulang', $setting->jam_pulang ?? '16:30') }}"
                                       class="w-full rounded-2xl border-slate-300 focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Jam Mulai Lembur
                                </label>
                                <input type="time"
                                       name="jam_mulai_lembur"
                                       value="{{ old('jam_mulai_lembur', $setting->jam_mulai_lembur ?? '17:00') }}"
                                       class="w-full rounded-2xl border-slate-300 focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Toleransi Terlambat
                                </label>
                                <div class="relative">
                                    <input type="number"
                                           name="toleransi_terlambat"
                                           value="{{ old('toleransi_terlambat', $setting->toleransi_terlambat ?? 15) }}"
                                           class="w-full rounded-2xl border-slate-300 pr-20 focus:border-blue-500 focus:ring-blue-500">
                                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm text-slate-500">
                                        menit
                                    </span>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                            <h2 class="font-bold text-slate-800">
                                Lokasi Kantor
                            </h2>
                            <p class="text-sm text-slate-500 mt-1">
                                Koordinat digunakan untuk menghitung jarak pegawai saat check-in dan check-out.
                            </p>
                        </div>

                        <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-5">

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Radius Absensi
                                </label>
                                <div class="relative">
                                    <input type="number"
                                           name="radius_absensi"
                                           value="{{ old('radius_absensi', $setting->radius_absensi ?? 100) }}"
                                           class="w-full rounded-2xl border-slate-300 pr-20 focus:border-blue-500 focus:ring-blue-500">
                                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm text-slate-500">
                                        meter
                                    </span>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Latitude Kantor
                                </label>
                                <input type="text"
                                       name="latitude_kantor"
                                       value="{{ old('latitude_kantor', $setting->latitude_kantor ?? '') }}"
                                       placeholder="-5.3971400"
                                       class="w-full rounded-2xl border-slate-300 focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Longitude Kantor
                                </label>
                                <input type="text"
                                       name="longitude_kantor"
                                       value="{{ old('longitude_kantor', $setting->longitude_kantor ?? '') }}"
                                       placeholder="105.2667900"
                                       class="w-full rounded-2xl border-slate-300 focus:border-blue-500 focus:ring-blue-500">
                            </div>

                        </div>

                        <div class="px-6 pb-6">
                            <div class="rounded-2xl bg-blue-50 border border-blue-200 p-4 text-sm text-blue-700">
                                Ambil koordinat dari Google Maps dengan klik titik kantor, lalu salin angka latitude dan longitude.
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                            <h2 class="font-bold text-slate-800">
                                Hari Kerja
                            </h2>
                            <p class="text-sm text-slate-500 mt-1">
                                Pilih hari kerja yang berlaku untuk absensi pegawai.
                            </p>
                        </div>

                        @php
                            $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu','Minggu'];
                            $hariKerja = old('hari_kerja', $setting->hari_kerja ?? []);
                        @endphp

                        <div class="p-6 grid grid-cols-2 md:grid-cols-3 gap-3">
                            @foreach($hari as $item)
                                <label class="flex items-center gap-3 p-4 rounded-2xl border border-slate-200 hover:bg-blue-50 hover:border-blue-200 cursor-pointer transition">
                                    <input type="checkbox"
                                           name="hari_kerja[]"
                                           value="{{ $item }}"
                                           {{ in_array($item, $hariKerja) ? 'checked' : '' }}
                                           class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                    <span class="font-semibold text-slate-700">
                                        {{ $item }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                </div>

                <div class="space-y-6">

                    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                            <h2 class="font-bold text-slate-800">
                                Validasi Absensi
                            </h2>
                            <p class="text-sm text-slate-500 mt-1">
                                Atur kewajiban selfie dan lokasi GPS.
                            </p>
                        </div>

                        <div class="p-6 space-y-4">

                            <label class="flex items-start gap-3 p-4 rounded-2xl border border-slate-200 hover:bg-slate-50 cursor-pointer">
                                <input type="checkbox"
                                       name="wajib_foto"
                                       {{ old('wajib_foto', $setting->wajib_foto ?? true) ? 'checked' : '' }}
                                       class="mt-1 rounded border-slate-300 text-blue-600 focus:ring-blue-500">

                                <div>
                                    <p class="font-bold text-slate-800">
                                        Wajib Foto Selfie
                                    </p>
                                    <p class="text-sm text-slate-500">
                                        Pegawai wajib mengambil foto melalui kamera saat absensi.
                                    </p>
                                </div>
                            </label>

                            <label class="flex items-start gap-3 p-4 rounded-2xl border border-slate-200 hover:bg-slate-50 cursor-pointer">
                                <input type="checkbox"
                                       name="wajib_lokasi"
                                       {{ old('wajib_lokasi', $setting->wajib_lokasi ?? true) ? 'checked' : '' }}
                                       class="mt-1 rounded border-slate-300 text-blue-600 focus:ring-blue-500">

                                <div>
                                    <p class="font-bold text-slate-800">
                                        Wajib Lokasi GPS
                                    </p>
                                    <p class="text-sm text-slate-500">
                                        Sistem menolak absensi di luar radius kantor.
                                    </p>
                                </div>
                            </label>

                        </div>
                    </div>

                    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6">
                        <h2 class="font-bold text-slate-800 mb-4">
                            Ringkasan Parameter
                        </h2>

                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-slate-500">Jam Masuk</span>
                                <strong>{{ $setting->jam_masuk ?? '08:00' }}</strong>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-slate-500">Jam Pulang</span>
                                <strong>{{ $setting->jam_pulang ?? '16:30' }}</strong>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-slate-500">Mulai Lembur</span>
                                <strong>{{ $setting->jam_mulai_lembur ?? '17:00' }}</strong>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-slate-500">Radius</span>
                                <strong>{{ $setting->radius_absensi ?? 100 }} m</strong>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-slate-500">GPS</span>
                                <strong>{{ ($setting->wajib_lokasi ?? true) ? 'Wajib' : 'Tidak Wajib' }}</strong>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-slate-500">Selfie</span>
                                <strong>{{ ($setting->wajib_foto ?? true) ? 'Wajib' : 'Tidak Wajib' }}</strong>
                            </div>
                        </div>
                    </div>

                    <div class="sticky bottom-6">
                        <button class="w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-4 rounded-2xl font-bold shadow-lg shadow-blue-100 transition">
                            Simpan Parameter Absensi
                        </button>
                    </div>

                </div>

            </div>

        </form>

    </div>

</div>

@endsection