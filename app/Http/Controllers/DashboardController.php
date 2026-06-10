<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\SuratMasuk;
use App\Models\SuratTtd;
use App\Models\Pegawai;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // =========================
        // PEGAWAI LOGIN
        // =========================
        $pegawai = Pegawai::where(
            'user_id',
            Auth::id()
        )->first();

        // =========================
        // SURAT MASUK BELUM DIBACA
        // =========================
        $suratMasuk = SuratMasuk::with(
            'surat'
        )
        ->where(
            'bagian_id',
            $pegawai->bagian_id
        )
        ->where(
            'dibaca',
            false
        )
        ->get();

        // =========================
        // TOTAL SURAT MASUK
        // =========================
        $totalMasuk = SuratMasuk::where(
            'bagian_id',
            $pegawai->bagian_id
        )->count();

        // =========================
        // SURAT KELUAR USER LOGIN
        // =========================
        $suratKeluar = Surat::where(
            'user_id',
            Auth::id()
        )->get();

        // total surat keluar
        $totalKeluar = Surat::where(
            'user_id',
            Auth::id()
        )->count();

        // =========================
        // APPROVAL PENDING
        // =========================
        $approval = SuratTtd::where(
            'pegawai_id',
            $pegawai->id
        )
        ->where(
            'status',
            'pending'
        )
        ->get();

        // total approval pending
        $totalApproval = SuratTtd::where(
            'pegawai_id',
            $pegawai->id
        )
        ->where(
            'status',
            'pending'
        )
        ->count();

        // =========================
        // TOTAL SEMUA
        // =========================
        $totalSemua =

            $totalMasuk +

            $totalKeluar +

            $totalApproval;

        // =========================
        // SURAT TERBARU
        // =========================
        $suratTerbaru = Surat::with([

            'tujuan.bagian',
            'pegawai'

        ])
        ->whereHas('pegawai', function ($q) use ($pegawai) {

            $q->where(
                'bagian_id',
                $pegawai->bagian_id
            );

        })
        ->latest()
        ->paginate(5);

        return view(
            'pegawai.dashboard',
            compact(

                'suratMasuk',
                'suratKeluar',
                'approval',
                'suratTerbaru',

                'totalMasuk',
                'totalKeluar',
                'totalApproval',
                'totalSemua'

            )
        );
    }
}