@extends('layouts.pegawai.app')

@section('content')
<div class="p-6 bg-slate-50 min-h-screen">
    <div class="max-w-5xl mx-auto">

        <div class="mb-6">
            <h1 class="text-3xl font-bold text-slate-800">
                Absensi Pegawai
            </h1>
            <p class="text-slate-500 mt-1">
                Check-in dan check-out menggunakan kamera selfie serta lokasi GPS.
            </p>
        </div>

        @if(session('success'))
        <div class="mb-4 p-4 rounded-2xl bg-green-50 border border-green-200 text-green-700 font-semibold">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="mb-4 p-4 rounded-2xl bg-red-50 border border-red-200 text-red-700 font-semibold">
            {{ session('error') }}
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div class="lg:col-span-2 bg-white rounded-3xl shadow-sm border border-slate-200 p-6">

                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-slate-800">
                            {{ $pegawai->nama }}
                        </h2>
                        <p class="text-slate-500">
                            {{ now('Asia/Jakarta')->translatedFormat('l, d F Y') }}
                        </p>
                    </div>

                    <div class="text-right">
                        <p class="text-sm text-slate-500">Jam Sekarang</p>
                        <p id="clock" class="text-2xl font-bold text-blue-700"></p>
                    </div>
                </div>

                @if(!$absensiHariIni)

                <form id="formCheckin" method="POST" action="{{ route('pegawai.absensi.checkin') }}">
                    @csrf

                    <input type="hidden" name="latitude" id="latitude_masuk">
                    <input type="hidden" name="longitude" id="longitude_masuk">

                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4 mb-5">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="font-bold text-slate-700">
                                Kamera Selfie Masuk
                            </h3>

                            <span id="lokasiStatus"
                                class="text-xs px-3 py-1 rounded-full bg-yellow-100 text-yellow-700">
                                Mengambil lokasi...
                            </span>
                        </div>

                        <div class="relative overflow-hidden rounded-2xl bg-black">
                            <video id="video_masuk" autoplay playsinline muted
                                class="w-full h-[320px] object-cover"></video>
                        </div>

                        <canvas id="canvas_masuk" class="hidden"></canvas>

                        <div id="previewFotoMasuk" class="hidden mt-4">
                            <p class="font-semibold text-slate-700 mb-2">
                                Preview Foto
                            </p>
                            <img id="previewImageMasuk"
                                class="w-40 h-40 object-cover rounded-2xl border border-slate-200 shadow-sm">
                        </div>

                        <div class="flex flex-wrap gap-3 mt-4">
                            <button type="button" id="captureMasuk"
                                class="px-5 py-3 rounded-xl bg-emerald-600 text-white font-semibold hover:bg-emerald-700 transition">
                                Ambil Foto
                            </button>

                            <button type="button" id="retakeMasuk"
                                class="hidden px-5 py-3 rounded-xl bg-slate-200 text-slate-700 font-semibold hover:bg-slate-300 transition">
                                Foto Ulang
                            </button>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full px-5 py-4 rounded-2xl bg-blue-600 text-white font-bold hover:bg-blue-700 transition">
                        Check-in Sekarang
                    </button>
                </form>

                @elseif(!$absensiHariIni->jam_pulang)

                <div class="mb-5 rounded-2xl bg-blue-50 border border-blue-200 p-4">
                    <p class="text-slate-600">Jam Masuk</p>
                    <p class="text-2xl font-bold text-blue-700">
                        {{ $absensiHariIni->jam_masuk }}
                    </p>
                    <p class="mt-2">
                        Status:
                        <strong>{{ ucfirst($absensiHariIni->status_masuk) }}</strong>
                    </p>
                </div>

                <form id="formCheckout" method="POST" action="{{ route('pegawai.absensi.checkout') }}">
                    @csrf

                    <input type="hidden" name="latitude" id="latitude_pulang">
                    <input type="hidden" name="longitude" id="longitude_pulang">

                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4 mb-5">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="font-bold text-slate-700">
                                Kamera Selfie Pulang
                            </h3>

                            <span id="lokasiStatus"
                                class="text-xs px-3 py-1 rounded-full bg-yellow-100 text-yellow-700">
                                Mengambil lokasi...
                            </span>
                        </div>

                        <div class="relative overflow-hidden rounded-2xl bg-black">
                            <video id="video_pulang" autoplay playsinline muted
                                class="w-full h-[320px] object-cover"></video>
                        </div>

                        <canvas id="canvas_pulang" class="hidden"></canvas>

                        <div id="previewFotoPulang" class="hidden mt-4">
                            <p class="font-semibold text-slate-700 mb-2">
                                Preview Foto
                            </p>
                            <img id="previewImagePulang"
                                class="w-40 h-40 object-cover rounded-2xl border border-slate-200 shadow-sm">
                        </div>

                        <div class="flex flex-wrap gap-3 mt-4">
                            <button type="button" id="capturePulang"
                                class="px-5 py-3 rounded-xl bg-emerald-600 text-white font-semibold hover:bg-emerald-700 transition">
                                Ambil Foto
                            </button>

                            <button type="button" id="retakePulang"
                                class="hidden px-5 py-3 rounded-xl bg-slate-200 text-slate-700 font-semibold hover:bg-slate-300 transition">
                                Foto Ulang
                            </button>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full px-5 py-4 rounded-2xl bg-red-600 text-white font-bold hover:bg-red-700 transition">
                        Check-out Sekarang
                    </button>
                </form>

                @else

                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                    <h3 class="text-lg font-bold text-slate-800 mb-4">
                        Absensi Hari Ini Selesai
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-4 bg-white rounded-2xl border">
                            <p class="text-slate-500">Jam Masuk</p>
                            <p class="text-xl font-bold">{{ $absensiHariIni->jam_masuk }}</p>
                        </div>

                        <div class="p-4 bg-white rounded-2xl border">
                            <p class="text-slate-500">Jam Pulang</p>
                            <p class="text-xl font-bold">{{ $absensiHariIni->jam_pulang }}</p>
                        </div>

                        <div class="p-4 bg-white rounded-2xl border">
                            <p class="text-slate-500">Status Masuk</p>
                            <p class="text-xl font-bold">{{ ucfirst($absensiHariIni->status_masuk) }}</p>
                        </div>

                        <div class="p-4 bg-white rounded-2xl border">
                            <p class="text-slate-500">Status Pulang</p>
                            <p class="text-xl font-bold">
                                {{ ucfirst(str_replace('_', ' ', $absensiHariIni->status_pulang)) }}
                            </p>
                        </div>

                        <div class="p-4 bg-white rounded-2xl border md:col-span-2">
                            <p class="text-slate-500">Total Lembur</p>
                            <p class="text-xl font-bold">
                                {{ floor(($absensiHariIni->total_menit_lembur ?? 0) / 60) }}
                                Jam
                                {{ ($absensiHariIni->total_menit_lembur ?? 0) % 60 }}
                                Menit
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-5">
                        @if($absensiHariIni->foto_masuk)
                        <div class="p-4 bg-white rounded-2xl border">
                            <p class="font-semibold mb-2">Foto Masuk</p>

                            <a href="{{ route('pegawai.absensi.foto', ['path' => $absensiHariIni->foto_masuk]) }}"
                                target="_blank">
                                <img src="{{ route('pegawai.absensi.foto', ['path' => $absensiHariIni->foto_masuk]) }}"
                                    class="w-40 h-40 object-cover rounded-2xl border">
                            </a>
                        </div>
                        @endif

                        @if($absensiHariIni->foto_pulang)
                        <div class="p-4 bg-white rounded-2xl border">
                            <p class="font-semibold mb-2">Foto Pulang</p>

                            <a href="{{ route('pegawai.absensi.foto', ['path' => $absensiHariIni->foto_pulang]) }}"
                                target="_blank">
                                <img src="{{ route('pegawai.absensi.foto', ['path' => $absensiHariIni->foto_pulang]) }}"
                                    class="w-40 h-40 object-cover rounded-2xl border">
                            </a>
                        </div>
                        @endif
                    </div>
                </div>

                @endif
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6 h-fit">
                <h3 class="text-lg font-bold text-slate-800 mb-4">
                    Informasi Absensi
                </h3>

                <div class="space-y-4 text-sm">
                    <div class="p-4 rounded-2xl bg-slate-50 border">
                        <p class="text-slate-500">Status GPS</p>
                        <p id="gpsText" class="font-semibold text-slate-800">
                            Menunggu lokasi...
                        </p>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-50 border">
                        <p class="text-slate-500">Latitude</p>
                        <p id="latText" class="font-semibold text-slate-800">-</p>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-50 border">
                        <p class="text-slate-500">Longitude</p>
                        <p id="lngText" class="font-semibold text-slate-800">-</p>
                    </div>

                    <div class="p-4 bg-white rounded-2xl border">
                        <p class="text-slate-500">Jarak Check-in</p>
                        <p class="text-xl font-bold">
                            {{ $absensiHariIni->jarak_masuk ?? '-' }} meter
                        </p>
                    </div>

                    <div class="p-4 bg-white rounded-2xl border">
                        <p class="text-slate-500">Jarak Check-out</p>
                        <p class="text-xl font-bold">
                            {{ $absensiHariIni->jarak_pulang ?? '-' }} meter
                        </p>
                    </div>

                    <div class="p-4 rounded-2xl bg-blue-50 border border-blue-200 text-blue-700">
                        Pastikan izin lokasi dan kamera aktif sebelum melakukan absensi.
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    function updateClock() {
        const now = new Date();
        const clock = document.getElementById('clock');

        if (clock) {
            clock.innerText = now.toLocaleTimeString('id-ID', {
                timeZone: 'Asia/Jakarta',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
        }
    }

    setInterval(updateClock, 1000);
    updateClock();

    const latitudeMasuk = document.getElementById('latitude_masuk');
    const longitudeMasuk = document.getElementById('longitude_masuk');
    const latitudePulang = document.getElementById('latitude_pulang');
    const longitudePulang = document.getElementById('longitude_pulang');

    const gpsText = document.getElementById('gpsText');
    const latText = document.getElementById('latText');
    const lngText = document.getElementById('lngText');

    const lokasiStatusList = document.querySelectorAll('#lokasiStatus');

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function (position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;

                if (latitudeMasuk) latitudeMasuk.value = lat;
                if (longitudeMasuk) longitudeMasuk.value = lng;

                if (latitudePulang) latitudePulang.value = lat;
                if (longitudePulang) longitudePulang.value = lng;

                if (gpsText) gpsText.innerText = 'Lokasi berhasil didapatkan';
                if (latText) latText.innerText = lat;
                if (lngText) lngText.innerText = lng;

                lokasiStatusList.forEach(function (el) {
                    el.innerText = 'Lokasi aktif';
                    el.className = 'text-xs px-3 py-1 rounded-full bg-green-100 text-green-700';
                });
            },
            function () {
                if (gpsText) gpsText.innerText = 'Gagal mengambil lokasi';

                lokasiStatusList.forEach(function (el) {
                    el.innerText = 'Lokasi gagal';
                    el.className = 'text-xs px-3 py-1 rounded-full bg-red-100 text-red-700';
                });
            }, {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            }
        );
    }

    function setupCameraForm(config) {
        const form = document.getElementById(config.formId);

        if (!form) {
            return;
        }

        const video = document.getElementById(config.videoId);
        const canvas = document.getElementById(config.canvasId);
        const capture = document.getElementById(config.captureId);
        const retake = document.getElementById(config.retakeId);
        const previewFoto = document.getElementById(config.previewBoxId);
        const previewImage = document.getElementById(config.previewImageId);

        let fotoBlob = null;
        let streamAktif = null;

        async function startCamera() {
            try {
                streamAktif = await navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: "user"
                    },
                    audio: false
                });

                video.srcObject = streamAktif;
            } catch (error) {
                alert('Kamera gagal dibuka. Pastikan izin kamera aktif dan akses pakai HTTPS.');
            }
        }

        function stopCamera() {
            if (streamAktif) {
                streamAktif.getTracks().forEach(track => track.stop());
            }
        }

        capture.addEventListener('click', function () {
            canvas.width = 320;
            canvas.height = 240;

            const ctx = canvas.getContext('2d');
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

            canvas.toBlob(function (blob) {
                fotoBlob = blob;

                previewImage.src = URL.createObjectURL(blob);
                previewFoto.classList.remove('hidden');

                video.classList.add('hidden');
                capture.classList.add('hidden');
                retake.classList.remove('hidden');

                stopCamera();
            }, 'image/jpeg', 0.4);
        });

        retake.addEventListener('click', function () {
            fotoBlob = null;

            previewImage.src = '';
            previewFoto.classList.add('hidden');

            video.classList.remove('hidden');
            capture.classList.remove('hidden');
            retake.classList.add('hidden');

            startCamera();
        });

        form.addEventListener('submit', function (e) {
            e.preventDefault();

            if (!fotoBlob) {
                alert('Ambil foto selfie dulu.');
                return;
            }

            const formData = new FormData(form);
            formData.append(config.fieldName, fotoBlob, config.fileName);

            fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                        'Accept': 'text/html'
                    }
                })
                .then(response => {
                    if (response.ok || response.redirected) {
                        window.location.href = "{{ route('pegawai.absensi.index') }}";
                    } else {
                        alert('Absensi gagal dikirim.');
                    }
                })
                .catch(() => {
                    alert('Gagal mengirim absensi.');
                });
        });

        startCamera();
    }

    setupCameraForm({
        formId: 'formCheckin',
        videoId: 'video_masuk',
        canvasId: 'canvas_masuk',
        captureId: 'captureMasuk',
        retakeId: 'retakeMasuk',
        previewBoxId: 'previewFotoMasuk',
        previewImageId: 'previewImageMasuk',
        fieldName: 'foto_masuk',
        fileName: 'foto_masuk.jpg'
    });

    setupCameraForm({
        formId: 'formCheckout',
        videoId: 'video_pulang',
        canvasId: 'canvas_pulang',
        captureId: 'capturePulang',
        retakeId: 'retakePulang',
        previewBoxId: 'previewFotoPulang',
        previewImageId: 'previewImagePulang',
        fieldName: 'foto_pulang',
        fileName: 'foto_pulang.jpg'
    });
</script>
@endsection