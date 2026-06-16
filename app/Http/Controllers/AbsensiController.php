<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\AbsensiSetting;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class AbsensiController extends Controller
{
    public function indexPegawai()
    {
        $now = Carbon::now('Asia/Jakarta');

        $pegawai = Pegawai::where('user_id', Auth::id())->firstOrFail();

        $absensiHariIni = Absensi::where('pegawai_id', $pegawai->id)
            ->whereDate('tanggal', $now->toDateString())
            ->first();

        return view('pegawai.absensi_pegawai', compact('pegawai', 'absensiHariIni'));
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
        $request->validate([
            'latitude' => 'nullable',
            'longitude' => 'nullable',
            'foto_masuk' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $now = Carbon::now('Asia/Jakarta');

        $pegawai = Pegawai::where('user_id', Auth::id())->firstOrFail();
        $setting = AbsensiSetting::first();

        if (!$setting) {
            return back()->with('error', 'Parameter absensi belum diatur admin.');
        }

        $sudahAbsen = Absensi::where('pegawai_id', $pegawai->id)
            ->whereDate('tanggal', $now->toDateString())
            ->first();

        if ($sudahAbsen) {
            return back()->with('error', 'Anda sudah melakukan check-in hari ini.');
        }

        $fotoMasuk = $request->file('foto_masuk')
            ->store('absensi/foto_masuk', 'public');

        $batasMasuk = Carbon::parse($setting->jam_masuk, 'Asia/Jakarta')
            ->addMinutes((int) $setting->toleransi_terlambat);

        $radiusAbsensi = (float) $setting->radius_absensi;

        $statusMasuk = $now->format('H:i:s') <= $batasMasuk->format('H:i:s')
            ? 'hadir'
            : 'terlambat';

        $menitTerlambat = 0;

        if ($statusMasuk === 'terlambat') {
            $menitTerlambat = Carbon::parse($setting->jam_masuk, 'Asia/Jakarta')
                ->diffInMinutes($now);
        }

        $jarakMasuk = $this->hitungJarakMeter(
            $request->latitude,
            $request->longitude,
            $setting->latitude_kantor,
            $setting->longitude_kantor
        );

        if ($setting->wajib_lokasi) {
            if ($jarakMasuk === null) {
                return back()->with('error', 'Lokasi GPS tidak terdeteksi.');
            }

            if ($jarakMasuk > $radiusAbsensi) {
                return back()->with('error', 'Anda berada di luar radius absensi. Jarak: ' . $jarakMasuk . ' meter.');
            }
        }

        Absensi::create([
            'pegawai_id' => $pegawai->id,
            'tanggal' => $now->toDateString(),
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

        return back()->with('success', 'Check-in berhasil.');
    }

    public function checkOut(Request $request)
    {
        $request->validate([
            'latitude' => 'nullable',
            'longitude' => 'nullable',
            'foto_pulang' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $now = Carbon::now('Asia/Jakarta');

        $pegawai = Pegawai::where('user_id', Auth::id())->firstOrFail();
        $setting = AbsensiSetting::first();

        if (!$setting) {
            return back()->with('error', 'Parameter absensi belum diatur admin.');
        }

        $absensi = Absensi::where('pegawai_id', $pegawai->id)
            ->whereDate('tanggal', $now->toDateString())
            ->first();

        if (!$absensi) {
            return back()->with('error', 'Anda belum melakukan check-in.');
        }

        if ($absensi->jam_pulang) {
            return back()->with('error', 'Anda sudah melakukan check-out hari ini.');
        }

        $fotoPulang = $request->file('foto_pulang')
            ->store('absensi/foto_pulang', 'public');

        $jamPulang = Carbon::parse($setting->jam_pulang, 'Asia/Jakarta');
        $jamMulaiLembur = Carbon::parse($setting->jam_mulai_lembur, 'Asia/Jakarta');

        $radiusAbsensi = (float) $setting->radius_absensi;

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

        if ($setting->wajib_lokasi) {
            if ($jarakPulang === null) {
                return back()->with('error', 'Lokasi GPS tidak terdeteksi.');
            }

            if ($jarakPulang > $radiusAbsensi) {
                return back()->with('error', 'Anda berada di luar radius absensi. Jarak: ' . $jarakPulang . ' meter.');
            }
        }

        $absensi->update([
            'jam_pulang' => $now->format('H:i:s'),

            'latitude_pulang' => $request->latitude,
            'longitude_pulang' => $request->longitude,
            'jarak_pulang' => $jarakPulang,
            'valid_lokasi_pulang' => true,

            'foto_pulang' => $fotoPulang,

            'status_pulang' => $statusPulang,
            'menit_pulang_cepat' => $menitPulangCepat,
            'total_menit_lembur' => $totalMenitLembur,
        ]);

        return back()->with('success', 'Check-out berhasil.');
    }

    public function rekapAdmin(Request $request)
    {
        $now = Carbon::now('Asia/Jakarta');

        $bulan = $request->bulan ?? $now->format('m');
        $tahun = $request->tahun ?? $now->format('Y');

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
        $now = Carbon::now('Asia/Jakarta');

        $bulan = $request->bulan ?? $now->format('m');
        $tahun = $request->tahun ?? $now->format('Y');

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

    public function lihatFoto($path)
        {
            if (!Storage::disk('public')->exists($path)) {
                abort(404);
            }

            return response()->file(
                storage_path('app/public/' . $path)
            );
        }

        public function printAdmin(Request $request)
{
    $bulan = $request->bulan ?? now()->format('m');
    $tahun = $request->tahun ?? now()->year;

    $jumlahHari = \Carbon\Carbon::create($tahun, $bulan, 1)->daysInMonth;

    $pegawais = Pegawai::with(['absensis' => function ($query) use ($bulan, $tahun) {
        $query->whereMonth('tanggal', $bulan)
              ->whereYear('tanggal', $tahun);
    }])
    ->orderBy('nama')
    ->get();

    return view('admin.printabsen_admin', compact(
        'pegawais',
        'bulan',
        'tahun',
        'jumlahHari'
    ));
}

}