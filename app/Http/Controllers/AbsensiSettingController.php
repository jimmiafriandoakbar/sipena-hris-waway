<?php

namespace App\Http\Controllers;

use App\Models\AbsensiSetting;
use Illuminate\Http\Request;

class AbsensiSettingController extends Controller
{
    public function index()
    {
        $setting = AbsensiSetting::first();

        return view('admin.absensi_setting_admin', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'jam_masuk' => 'required',
            'jam_pulang' => 'required',
            'jam_mulai_lembur' => 'required',
            'toleransi_terlambat' => 'required|numeric',
            'radius_absensi' => 'required|numeric',
            'latitude_kantor' => 'nullable|numeric',
            'longitude_kantor' => 'nullable|numeric',
            'hari_kerja' => 'nullable|array',
        ]);

        AbsensiSetting::updateOrCreate(
            ['id' => 1],
            [
                'jam_masuk' => $request->jam_masuk,
                'jam_pulang' => $request->jam_pulang,
                'jam_mulai_lembur' => $request->jam_mulai_lembur,
                'toleransi_terlambat' => $request->toleransi_terlambat,
                'radius_absensi' => $request->radius_absensi,
                'latitude_kantor' => $request->latitude_kantor,
                'longitude_kantor' => $request->longitude_kantor,
                'hari_kerja' => $request->hari_kerja ?? [],
                'wajib_foto' => $request->has('wajib_foto') ? 1 : 0,
                'wajib_lokasi' => $request->has('wajib_lokasi') ? 1 : 0,
            ]
        );

        return back()->with('success', 'Parameter absensi berhasil disimpan.');
    }
}