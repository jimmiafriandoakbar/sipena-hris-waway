<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\SuratMasuk;
use App\Models\SuratTtd;
use App\Models\Pegawai;
use App\Models\Absensi;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $pegawai = Pegawai::where('user_id', Auth::id())->firstOrFail();

        $suratMasuk = SuratMasuk::with('surat')
            ->where('bagian_id', $pegawai->bagian_id)
            ->where('dibaca', false)
            ->get();

        $totalMasuk = SuratMasuk::where('bagian_id', $pegawai->bagian_id)
            ->count();

        $suratKeluar = Surat::where('user_id', Auth::id())
            ->get();

        $totalKeluar = Surat::where('user_id', Auth::id())
            ->count();

        $approval = SuratTtd::where('pegawai_id', $pegawai->id)
            ->where('status', 'pending')
            ->get();

        $totalApproval = SuratTtd::where('pegawai_id', $pegawai->id)
            ->where('status', 'pending')
            ->count();

        $totalSemua =
            $totalMasuk +
            $totalKeluar +
            $totalApproval;

        $suratTerbaru = Surat::with([
            'tujuan.bagian',
            'pegawai'
        ])
        ->whereHas('pegawai', function ($q) use ($pegawai) {
            $q->where('bagian_id', $pegawai->bagian_id);
        })
        ->latest()
        ->paginate(5);

        return view('pegawai.dashboard', compact(
            'suratMasuk',
            'suratKeluar',
            'approval',
            'suratTerbaru',
            'totalMasuk',
            'totalKeluar',
            'totalApproval',
            'totalSemua'
        ));
    }

    public function admin()
    {
        $today = Carbon::now('Asia/Jakarta')->toDateString();

        $jumlahPegawai = Pegawai::count();

        $pegawaiSudahAbsenMasuk = Absensi::whereDate('tanggal', $today)
            ->whereNotNull('jam_masuk')
            ->distinct('pegawai_id')
            ->count('pegawai_id');

        $pegawaiTidakAbsenMasuk = Pegawai::whereNotIn('id', function ($q) use ($today) {
            $q->select('pegawai_id')
                ->from('absensis')
                ->whereDate('tanggal', $today)
                ->whereNotNull('jam_masuk');
        })->count();

        $pegawaiBelumAbsenMasuk = Pegawai::with('jabatanRelasi')
            ->whereNotIn('id', function ($q) use ($today) {
                $q->select('pegawai_id')
                    ->from('absensis')
                    ->whereDate('tanggal', $today)
                    ->whereNotNull('jam_masuk');
            })
            ->orderBy('nama')
            ->get();

        $pegawaiTidakAbsenPulang = Absensi::with('pegawai.jabatanRelasi')
            ->whereDate('tanggal', $today)
            ->whereNotNull('jam_masuk')
            ->whereNull('jam_pulang')
            ->orderBy('jam_masuk')
            ->get();

        $pegawaiTerlambat = Absensi::with('pegawai.jabatanRelasi')
            ->whereDate('tanggal', $today)
            ->where('status_masuk', 'terlambat')
            ->orderBy('jam_masuk')
            ->get();

        $pegawaiPulangCepat = Absensi::with('pegawai.jabatanRelasi')
            ->whereDate('tanggal', $today)
            ->where('status_pulang', 'pulang_cepat')
            ->orderBy('jam_pulang')
            ->get();

        $jumlahTidakAbsenPulang = $pegawaiTidakAbsenPulang->count();
        $jumlahTerlambat = $pegawaiTerlambat->count();
        $jumlahPulangCepat = $pegawaiPulangCepat->count();

        return view('admin.dashboard', compact(
            'jumlahPegawai',
            'pegawaiSudahAbsenMasuk',
            'pegawaiTidakAbsenMasuk',
            'pegawaiBelumAbsenMasuk',
            'pegawaiTidakAbsenPulang',
            'pegawaiTerlambat',
            'pegawaiPulangCepat',
            'jumlahTidakAbsenPulang',
            'jumlahTerlambat',
            'jumlahPulangCepat'
        ));
    }
}