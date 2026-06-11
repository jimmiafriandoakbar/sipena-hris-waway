<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Pegawai;
use App\Models\User;
use App\Models\Bagian;
use App\Models\Jabatan;
use App\Exports\GajiExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Payroll;

class PegawaiController extends Controller
{
    // ==============================
    // UPDATE PASSWORD (PEGAWAI)
    // ==============================
    public function updatePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required',
        'new_password' => [
            'required',
            'min:8',
            'confirmed',
            'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]+$/'
        ],
    ], [
        'new_password.regex' => 'Password harus mengandung huruf besar, huruf kecil, angka, dan karakter spesial.',
    ]);

    $user = Auth::user();

    if (!Hash::check($request->current_password, $user->password)) {
        return back()->withErrors([
            'current_password' => 'Password lama salah'
        ]);
    }

    $user->update([
        'password' => Hash::make($request->new_password)
    ]);

    return back()->with('success', 'Password berhasil diubah');
}

    // ==============================
    // LIST PEGAWAI (ADMIN)
    // ==============================
    public function indexAdmin()
    {
        $pegawai = Pegawai::with([
            'bagianRelasi',
            'jabatanRelasi'
        ])
        ->latest()
        ->paginate(5);

        return view('admin.daftarpegawai_admin', compact('pegawai'));
    }

    public function daftarGaji()
{
    $pegawai = Pegawai::with([
        'bagianRelasi',
        'jabatanRelasi'
    ])
    ->latest()
    ->paginate(5);
    $jabatan = Jabatan::orderBy('nama_jabatan')->get();

    return view('admin.daftargaji_admin', compact('pegawai','jabatan'));
}

public function editGaji($id)
{
    $pegawai = Pegawai::with('payroll')->findOrFail($id);

    return view('admin.editgaji_admin', compact('pegawai'));
}

public function updateGaji(Request $request, $id)
{
    $request->validate([
        'gaji_pokok' => 'nullable|numeric|min:0',
        'tunjangan_teller' => 'nullable|numeric|min:0',
        'tunjangan_anak' => 'nullable|numeric|min:0',
        'jumlah_anak' => 'nullable|integer|min:0|max:2',
        'tunjangan_istri' => 'nullable|numeric|min:0',
        'tunjangan_kemahalan' => 'nullable|numeric|min:0',
        'tunjangan_lain_lain' => 'nullable|numeric|min:0',
        'koperasi' => 'nullable|numeric|min:0',
        'koperasi_pinjaman' => 'nullable|numeric',
        'infaq' => 'nullable|numeric|min:0',
        'bpjs_kesehatan' => 'nullable|numeric|min:0',
        'bpjs_ketenagakerjaan' => 'nullable|numeric|min:0',
        'tabungan_pensiun' => 'nullable|numeric|min:0',
        'pinjaman_pegawai' => 'nullable|numeric|min:0',
        'potongan_lain_lain' => 'nullable|numeric|min:0',
    ]);

    Pegawai::findOrFail($id);

    Payroll::updateOrCreate(
        ['pegawai_id' => $id],
        [
            'gaji_pokok' => $request->gaji_pokok ?? 0,
            'tunjangan_teller' => $request->tunjangan_teller ?? 0,
            'tunjangan_anak' => $request->tunjangan_anak ?? 0,
            'jumlah_anak' => $request->jumlah_anak ?? 0,
            'tunjangan_istri' => $request->tunjangan_istri ?? 0,
            'tunjangan_kemahalan' => $request->tunjangan_kemahalan ?? 0,
            'tunjangan_lain_lain' => $request->tunjangan_lain_lain ?? 0,
            'koperasi' => $request->koperasi ?? 0,
            'koperasi_pinjaman' => $request->koperasi_pinjaman ?? 0,
            'infaq' => $request->infaq ?? 0,
            'bpjs_kesehatan' => $request->bpjs_kesehatan ?? 0,
            'bpjs_ketenagakerjaan' => $request->bpjs_ketenagakerjaan ?? 0,
            'tabungan_pensiun' => $request->tabungan_pensiun ?? 0,
            'pinjaman_pegawai' => $request->pinjaman_pegawai ?? 0,
            'potongan_lain_lain' => $request->potongan_lain_lain ?? 0,
        ]
    );

    return redirect()
        ->route('admin.daftargaji_admin')
        ->with('success', 'Data payroll pegawai berhasil diperbarui.');
}

public function exportGaji()
{
    return Excel::download(
        new GajiExport,
        'daftar-gaji-pegawai.xlsx'
    );
}

    // ==============================
    // FORM CREATE
    // ==============================
    public function create()
    {
        $bagian = Bagian::orderBy('nama_bagian')->get();
        $jabatan = Jabatan::orderBy('nama_jabatan')->get();

        return view('admin.createpegawai_admin', compact('bagian','jabatan'));
    }

    // ==============================
    // STORE DATA PEGAWAI + USER
    // ==============================
    public function store(Request $request)
    {
        $request->validate([
    'nama' => 'required',
    'nip' => 'required|unique:pegawai,nip',
    'bagian_id' => 'required',
    'jabatan_id' => 'required',
    'email' => 'required|email|unique:users,email',
    'no_hp' => 'required',
], [
    'nip.unique' => 'NIP sudah digunakan.',
    'email.unique' => 'Email sudah digunakan.',
]);

        DB::beginTransaction();

        try {

            // =====================
            // 1. BUAT USER
            // =====================
            $user = User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->nip),
                'role' => 'pegawai'
            ]);

            // =====================
            // 2. UPLOAD TTD
            // =====================
            if ($request->hasFile('ttd')) {
                $ttd = $request->file('ttd')->store('ttd', 'public');
            } else {
                $ttd = null;
            }

            // =====================
            // 3. BUAT PEGAWAI
            // =====================
            Pegawai::create([
            'user_id' => $user->id,
            'nama' => $request->nama,
            'nip' => $request->nip,
            'bagian_id' => $request->bagian_id,
            'jabatan_id' => $request->jabatan_id,
            'pendidikan' => $request->pendidikan,
            'jurusan' => $request->jurusan,
            'mulai_bekerja' => $request->mulai_bekerja,
            'nomor_rekening' => $request->nomor_rekening,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'gaji_pokok' => $request->gaji_pokok ?? 0,
            'tunjangan' => $request->tunjangan ?? 0,
            'bonus' => $request->bonus ?? 0,
            'potongan' => $request->potongan ?? 0,
            'ttd' => $ttd
        ]);

            DB::commit();

            return redirect()->route('admin.daftarpegawai_admin')
                ->with('success', 'Pegawai & User berhasil dibuat');

         } catch (\Exception $e) {

    DB::rollBack();

    return back()
        ->withInput()
        ->withErrors([

            'error' => 'Gagal membuat pegawai: ' . $e->getMessage()

        ]);
}
    }

public function printGaji()
{
    $payrolls = Payroll::with('pegawai')->get();

    return view('admin.printgaji_admin', compact('payrolls'));
}

    // ==============================
    // DELETE PEGAWAI + USER
    // ==============================
    public function destroy($id)
    {
        DB::beginTransaction();

        try {

            $pegawai = Pegawai::with([
                'bagianRelasi',
                'jabatanRelasi'
            ])->findOrFail($id);

            // hapus user terkait
            User::where('id', $pegawai->user_id)->delete();

            // hapus pegawai
            $pegawai->delete();

            DB::commit();

            return back()->with('success', 'Pegawai berhasil dihapus');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->withErrors('Gagal hapus: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $pegawai = Pegawai::findOrFail($id);

        $bagian = Bagian::orderBy('nama_bagian')->get();

        $jabatan = Jabatan::orderBy('nama_jabatan')->get();

        return view('admin.editpegawai_admin', compact('pegawai','bagian','jabatan'));
    }

    public function update(Request $request, $id)
{
    $pegawai = Pegawai::findOrFail($id);

    $request->validate([
        'nama' => 'required',
        'nip' => 'required|unique:pegawai,nip,' . $pegawai->id,
        'email' => 'required|email|unique:users,email,' . $pegawai->user_id,
        'bagian_id' => 'required',
        'jabatan_id' => 'required',
    ]);

    // =====================
    // UPDATE USER
    // =====================
    User::where('id', $pegawai->user_id)->update([

        'name' => $request->nama,
        'email' => $request->email,

    ]);

    // =====================
    // UPLOAD TTD
    // =====================
    if ($request->hasFile('ttd')) {

        $ttd = $request->file('ttd')->store('ttd', 'public');

        $pegawai->ttd = $ttd;
    }

    // =====================
    // UPDATE PEGAWAI
    // =====================
    $pegawai->update([

        'nama' => $request->nama,
        'nip' => $request->nip,
        'bagian_id' => $request->bagian_id,
        'jabatan_id' => $request->jabatan_id,
        'pendidikan' => $request->pendidikan,
        'jurusan' => $request->jurusan,
        'mulai_bekerja' => $request->mulai_bekerja,
        'nomor_rekening' => $request->nomor_rekening,
        'email' => $request->email,
        'no_hp' => $request->no_hp,
        'gaji_pokok' => $request->gaji_pokok ?? 0,
        'tunjangan' => $request->tunjangan ?? 0,
        'bonus' => $request->bonus ?? 0,
        'potongan' => $request->potongan ?? 0,
        'ttd' => $pegawai->ttd

    ]);

    return redirect()
        ->route('admin.daftarpegawai_admin')
        ->with('success', 'Data pegawai berhasil diperbarui');
}

public function lembur()
{
    $bagian = Bagian::all();
    $pegawai = Pegawai::all();

    return view('pegawai.lembur_form', compact('bagian', 'pegawai'));
}

public function cuti()
{
    $bagian = Bagian::all();
    $pegawai = Pegawai::all();

    return view('pegawai.cuti_form', compact('bagian', 'pegawai'));
}

public function absensis()
{
    return $this->hasMany(Absensi::class);
}

}