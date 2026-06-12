<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\AbsensiSetting;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AbsensiController extends Controller
{
    public function indexPegawai()
    {
        $pegawai = Pegawai::where('user_id', Auth::id())->firstOrFail();

        $absensiHariIni = Absensi::where('pegawai_id', $pegawai->id)
            ->whereDate('tanggal', today())
            ->first();

        return view('pegawai.absensi_pegawai', compact('pegawai', 'absensiHariIni'));
    }

    private function simpanFotoBase64($base64, $folder)
    {
        if (!$base64) {
            return null;
        }

        if (!preg_match('/^data:image\/(\w+);base64,/', $base64, $type)) {
            return null;
        }

        $image = substr($base64, strpos($base64, ',') + 1);
        $extension = strtolower($type[1]);

        if (!in_array($extension, ['jpg', 'jpeg', 'png'])) {
            return null;
        }

        $image = base64_decode($image);

        if ($image === false) {
            return null;
        }

        $fileName = $folder . '/' . date('Ymd_His') . '_' . Str::random(10) . '.' . $extension;

        Storage::disk('public')->put($fileName, $image);

        return $fileName;
    }

    private function hitungJarakMeter($lat1, $lon1, $lat2, $lon2)
    {
        if (!$lat1 || !$lon1 || !$lat2 || !$lon2) {
            return null;
        }

        $earthRadius = 6371000;

        $latFrom = deg2rad((float) $lat1);
        $lonFrom = deg2rad((float) $lon1);
        $latTo = deg2rad((float) $lat2);
        $lonTo = deg2rad((float) $lon2);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $a = sin($latDelta / 2) * sin($latDelta / 2) +
            cos($latFrom) * cos($latTo) *
            sin($lonDelta / 2) * sin($lonDelta / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return round($earthRadius * $c, 2);
    }

    

    public function checkIn(Request $request)
    {
        dd('MASUK CONTROLLER CHECKIN');
        
        $request->validate([
            'latitude' => 'nullable',
            'longitude' => 'nullable',
            'foto_masuk' => 'required|string',
        ]);

        $pegawai = Pegawai::where('user_id', Auth::id())->firstOrFail();
        $setting = AbsensiSetting::first();

        if (!$setting) {
            return back()->with('error', 'Parameter absensi belum diatur admin.');
        }

        $sudahAbsen = Absensi::where('pegawai_id', $pegawai->id)
            ->whereDate('tanggal', today())
            ->first();

        if ($sudahAbsen) {
            return back()->with('error', 'Anda sudah melakukan check-in hari ini.');
        }

        $now = Carbon::now();

        $batasMasuk = Carbon::parse($setting->jam_masuk)
            ->addMinutes($setting->toleransi_terlambat);

        $statusMasuk = $now->format('H:i:s') <= $batasMasuk->format('H:i:s')
            ? 'hadir'
            : 'terlambat';

        $menitTerlambat = 0;

        if ($statusMasuk === 'terlambat') {
            $jamNormal = Carbon::parse($setting->jam_masuk);
            $menitTerlambat = $jamNormal->diffInMinutes($now);
        }

        $jarakMasuk = $this->hitungJarakMeter(
            $request->latitude,
            $request->longitude,
            $setting->latitude_kantor,
            $setting->longitude_kantor
        );

        $validLokasiMasuk = true;

        if ($setting->wajib_lokasi) {
            if ($jarakMasuk === null) {
                return back()->with('error', 'Lokasi GPS tidak terdeteksi. Aktifkan lokasi terlebih dahulu.');
            }

            if ($jarakMasuk > $setting->radius_absensi) {
                return back()->with('error', 'Anda berada di luar radius absensi. Jarak Anda: ' . $jarakMasuk . ' meter.');
            }
        }

        $fotoMasuk = $this->simpanFotoBase64(
            $request->foto_masuk,
            'absensi/foto_masuk'
        );

        if (!$fotoMasuk) {
            return back()->with('error', 'Foto masuk gagal disimpan. Silakan ambil foto ulang.');
        }

        dd([
    'request' => $request->all(),
    'pegawai' => $pegawai,
    'setting' => $setting,
    'jarakMasuk' => $jarakMasuk,
    'fotoMasuk' => $fotoMasuk,
]);

        Absensi::create([
            'pegawai_id' => $pegawai->id,
            'tanggal' => today(),
            'nama_hari' => $now->translatedFormat('l'),

            'jam_masuk' => $now->format('H:i:s'),

            'latitude_masuk' => $request->latitude,
            'longitude_masuk' => $request->longitude,
            'jarak_masuk' => $jarakMasuk,
            'valid_lokasi_masuk' => $validLokasiMasuk,

            'foto_masuk' => $fotoMasuk,

            'status_masuk' => $statusMasuk,
            'menit_terlambat' => $menitTerlambat,

            'ip_address' => $request->ip(),
            'device' => $request->userAgent(),
        ]);

        return back()->with('success', 'Check-in berhasil.');
    }

    public function checkOut(Request $request)
    {
        $request->validate([
            'latitude' => 'nullable',
            'longitude' => 'nullable',
            'foto_pulang' => 'required|string',
        ]);

        $pegawai = Pegawai::where('user_id', Auth::id())->firstOrFail();
        $setting = AbsensiSetting::first();

        if (!$setting) {
            return back()->with('error', 'Parameter absensi belum diatur admin.');
        }

        $absensi = Absensi::where('pegawai_id', $pegawai->id)
            ->whereDate('tanggal', today())
            ->first();

        if (!$absensi) {
            return back()->with('error', 'Anda belum melakukan check-in.');
        }

        if ($absensi->jam_pulang) {
            return back()->with('error', 'Anda sudah melakukan check-out hari ini.');
        }

        $now = Carbon::now();

        $jamPulang = Carbon::parse($setting->jam_pulang);
        $jamMulaiLembur = Carbon::parse($setting->jam_mulai_lembur);

        $statusPulang = 'normal';
        $menitPulangCepat = 0;
        $totalMenitLembur = 0;

        if ($now->format('H:i:s') < $jamPulang->format('H:i:s')) {
            $statusPulang = 'pulang_cepat';
            $menitPulangCepat = $now->diffInMinutes($jamPulang);
        }

        if ($now->format('H:i:s') > $jamMulaiLembur->format('H:i:s')) {
            $totalMenitLembur = $jamMulaiLembur->diffInMinutes($now);
        }

        $jarakPulang = $this->hitungJarakMeter(
            $request->latitude,
            $request->longitude,
            $setting->latitude_kantor,
            $setting->longitude_kantor
        );

        $validLokasiPulang = true;

        if ($setting->wajib_lokasi) {
            if ($jarakPulang === null) {
                return back()->with('error', 'Lokasi GPS tidak terdeteksi. Aktifkan lokasi terlebih dahulu.');
            }

            if ($jarakPulang > $setting->radius_absensi) {
                return back()->with('error', 'Anda berada di luar radius absensi. Jarak Anda: ' . $jarakPulang . ' meter.');
            }
        }

        $fotoPulang = $this->simpanFotoBase64(
            $request->foto_pulang,
            'absensi/foto_pulang'
        );

        if (!$fotoPulang) {
            return back()->with('error', 'Foto pulang gagal disimpan. Silakan ambil foto ulang.');
        }

        $absensi->update([
            'jam_pulang' => $now->format('H:i:s'),

            'latitude_pulang' => $request->latitude,
            'longitude_pulang' => $request->longitude,
            'jarak_pulang' => $jarakPulang,
            'valid_lokasi_pulang' => $validLokasiPulang,

            'foto_pulang' => $fotoPulang,

            'status_pulang' => $statusPulang,
            'menit_pulang_cepat' => $menitPulangCepat,
            'total_menit_lembur' => $totalMenitLembur,
        ]);

        return back()->with('success', 'Check-out berhasil.');
    }

    public function rekapAdmin(Request $request)
        {
            $bulan = $request->bulan ?? now()->format('m');
            $tahun = $request->tahun ?? now()->format('Y');

            $pegawais = Pegawai::with(['jabatanRelasi', 'absensis' => function ($query) use ($bulan, $tahun) {
                $query->whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal', $tahun);
            }])->orderBy('nama')->get();

            return view('admin.rekap_absensi_admin', compact(
                'pegawais',
                'bulan',
                'tahun'
            ));
        }

    public function detailAdmin(Request $request, Pegawai $pegawai)
        {
            $bulan = $request->bulan ?? now()->format('m');
            $tahun = $request->tahun ?? now()->format('Y');

            $absensis = Absensi::where('pegawai_id', $pegawai->id)
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)
                ->orderBy('tanggal', 'asc')
                ->get();

            return view('admin.detail_absensi_admin', compact(
                'pegawai',
                'absensis',
                'bulan',
                'tahun'
            ));
        }
}