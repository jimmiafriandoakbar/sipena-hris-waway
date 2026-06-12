<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\AbsensiSetting;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

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
        if (!$base64 || !str_starts_with($base64, 'data:image')) {
            return null;
        }

        if (!preg_match('/^data:image\/(\w+);base64,/', $base64, $type)) {
            return null;
        }

        $extension = strtolower($type[1]);

        if ($extension === 'jpeg') {
            $extension = 'jpg';
        }

        if (!in_array($extension, ['jpg', 'png'])) {
            return null;
        }

        $image = substr($base64, strpos($base64, ',') + 1);
        $image = str_replace(' ', '+', $image);
        $image = base64_decode($image);

        if ($image === false) {
            return null;
        }

        $fileName = $folder . '/' . date('Ymd_His') . '_' . Str::random(10) . '.' . $extension;

        try {
            Storage::disk('public')->put($fileName, $image);
            return $fileName;
        } catch (\Exception $e) {
            return null;
        }
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
    Log::info('CHECKIN MASUK', $request->all());

    $request->validate([
        'latitude' => 'nullable',
        'longitude' => 'nullable',
        'foto_masuk' => 'required|string',
    ]);

    $pegawai = Pegawai::where('user_id', Auth::id())->firstOrFail();
    $setting = AbsensiSetting::first();

    if (!$setting) {
        Log::info('SETTING KOSONG');
        return redirect()->route('pegawai.absensi.index')
            ->with('error', 'Parameter absensi belum diatur admin.');
    }

    $sudahAbsen = Absensi::where('pegawai_id', $pegawai->id)
        ->whereDate('tanggal', today())
        ->first();

    if ($sudahAbsen) {
        Log::info('SUDAH ABSEN');
        return redirect()->route('pegawai.absensi.index')
            ->with('error', 'Anda sudah melakukan check-in hari ini.');
    }

    $now = Carbon::now();

    $jarakMasuk = $this->hitungJarakMeter(
        $request->latitude,
        $request->longitude,
        $setting->latitude_kantor ?? null,
        $setting->longitude_kantor ?? null
    );

    Log::info('JARAK MASUK', ['jarak' => $jarakMasuk]);

    if ((int) $setting->wajib_lokasi === 1) {
        if ($jarakMasuk === null) {
            Log::info('GPS NULL');
            return redirect()->route('pegawai.absensi.index')
                ->with('error', 'Lokasi GPS atau titik kantor belum terdeteksi.');
        }

        if ($jarakMasuk > (float) $setting->radius_absensi) {
            Log::info('LUAR RADIUS', ['jarak' => $jarakMasuk]);
            return redirect()->route('pegawai.absensi.index')
                ->with('error', 'Anda berada di luar radius absensi. Jarak Anda: ' . $jarakMasuk . ' meter.');
        }
    }

    Log::info('SEBELUM SIMPAN FOTO');

    $fotoMasuk = $this->simpanFotoBase64(
        $request->foto_masuk,
        'absensi/foto_masuk'
    );

    Log::info('HASIL FOTO', ['foto' => $fotoMasuk]);

    if (!$fotoMasuk) {
        return redirect()->route('pegawai.absensi.index')
            ->with('error', 'Foto masuk gagal disimpan. Kecilkan ukuran foto / cek permission storage.');
    }

    $batasMasuk = Carbon::parse($setting->jam_masuk)
        ->addMinutes((int) $setting->toleransi_terlambat);

    $statusMasuk = $now->format('H:i:s') <= $batasMasuk->format('H:i:s')
        ? 'hadir'
        : 'terlambat';

    $menitTerlambat = 0;

    if ($statusMasuk === 'terlambat') {
        $jamNormal = Carbon::parse($setting->jam_masuk);
        $menitTerlambat = $jamNormal->diffInMinutes($now);
    }

    Log::info('SEBELUM INSERT');

    Absensi::create([
        'pegawai_id' => $pegawai->id,
        'tanggal' => now()->toDateString(),
        'nama_hari' => $now->translatedFormat('l'),
        'jam_masuk' => $now->format('H:i:s'),
        'latitude_masuk' => $request->latitude,
        'longitude_masuk' => $request->longitude,
        'jarak_masuk' => $jarakMasuk,
        'valid_lokasi_masuk' => true,
        'foto_masuk' => $fotoMasuk,
        'status_masuk' => $statusMasuk,
        'menit_terlambat' => $menitTerlambat,
        'ip_address' => $request->ip(),
        'device' => $request->userAgent(),
    ]);

    Log::info('INSERT BERHASIL');

    return redirect()->route('pegawai.absensi.index')
        ->with('success', 'Check-in berhasil disimpan.');
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
            return redirect()
                ->route('pegawai.absensi.index')
                ->with('error', 'Parameter absensi belum diatur admin.');
        }

        $absensi = Absensi::where('pegawai_id', $pegawai->id)
            ->whereDate('tanggal', today())
            ->first();

        if (!$absensi) {
            return redirect()
                ->route('pegawai.absensi.index')
                ->with('error', 'Anda belum melakukan check-in.');
        }

        if ($absensi->jam_pulang) {
            return redirect()
                ->route('pegawai.absensi.index')
                ->with('error', 'Anda sudah melakukan check-out hari ini.');
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
            $setting->latitude_kantor ?? null,
            $setting->longitude_kantor ?? null
        );

        $validLokasiPulang = true;

        if ((int) $setting->wajib_lokasi === 1) {
            if ($jarakPulang === null) {
                return redirect()
                    ->route('pegawai.absensi.index')
                    ->with('error', 'Lokasi GPS atau titik kantor belum terdeteksi.');
            }

            if ($jarakPulang > (float) $setting->radius_absensi) {
                return redirect()
                    ->route('pegawai.absensi.index')
                    ->with('error', 'Anda berada di luar radius absensi. Jarak Anda: ' . $jarakPulang . ' meter.');
            }
        }

        $fotoPulang = $this->simpanFotoBase64(
            $request->foto_pulang,
            'absensi/foto_pulang'
        );

        if (!$fotoPulang) {
            return redirect()
                ->route('pegawai.absensi.index')
                ->with('error', 'Foto pulang gagal disimpan. Kecilkan ukuran foto / cek permission storage.');
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

        return redirect()
            ->route('pegawai.absensi.index')
            ->with('success', 'Check-out berhasil disimpan.');
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