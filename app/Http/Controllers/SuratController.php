<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Surat;
use App\Models\Pegawai;
use App\Models\SuratTujuan;
use App\Models\SuratTtd;
use App\Models\Bagian;
use App\Models\SuratMasuk;
use App\Models\Lembur;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\User;


class SuratController extends Controller
{
    public function notaDinas()
{
    $bagian = Bagian::orderBy('nama_bagian')->get();

    $pegawai = Pegawai::orderBy('nama')->get();

    return view('pegawai.surat_notadinas', compact(
        'bagian',
        'pegawai'
    ));
}


    public function storeNotaDinas(Request $request)
{
    $request->validate([

        'nomor_surat' => 'required',
        'tanggal_surat' => 'required',
        'perihal' => 'required',
        'isi_surat' => 'required',

    ]);

    // upload file
    $filePath = null;

    if ($request->hasFile('file_pdf')) {

        $file = $request->file('file_pdf')[0];

        $filePath = $file->store('surat', 'public');
    }

    // =========================
    // SIMPAN SURAT
    // =========================
    $surat = Surat::create([

        'user_id' => Auth::id(),

        'jenis_surat' => 'Nota Dinas',

        'nomor_surat' => $request->nomor_surat,

        'tanggal_surat' => $request->tanggal_surat,

        'perihal' => $request->perihal,

        'isi_surat' => $request->isi_surat,

        'file_pdf' => $filePath,

        'status' => 'pending',

    ]);

    // =========================
    // TUJUAN BAGIAN
    // =========================
    if ($request->bagian) {

        $bagians = explode(',', $request->bagian);

        foreach ($bagians as $bagianId) {

            SuratTujuan::create([

                'surat_id' => $surat->id,

                'bagian_id' => $bagianId

            ]);
        }
    }

    // =========================
    // TANDA TANGAN
    // =========================
    if ($request->ttd) {

        $ttds = explode(',', $request->ttd);

        foreach ($ttds as $index => $pegawaiId) {

            SuratTtd::create([

                'surat_id' => $surat->id,

                'pegawai_id' => $pegawaiId,

                'urutan' => $index + 1,

                'status' => 'pending'

            ]);

        }

        // =========================
        // KIRIM EMAIL NOTIFIKASI
        // =========================
        foreach ($ttds as $pegawaiId) {

            $pegawaiTtd = Pegawai::find($pegawaiId);

            if ($pegawaiTtd && $pegawaiTtd->user_id) {

                $user = User::find($pegawaiTtd->user_id);

                if ($user && $user->email) {

                    Mail::send([], [], function ($message) use ($user, $surat) {

    $message->to($user->email)
        ->subject('Notifikasi Surat Masuk - '.$surat->perihal)
        ->html("
            <h2>Notifikasi Surat Masuk</h2>

            <p>Yth. Bapak/Ibu,</p>

            <p>Terdapat surat yang memerlukan persetujuan.</p>

            <table border='1' cellpadding='8' cellspacing='0'>
                <tr>
                    <td><b>Jenis Surat</b></td>
                    <td>Nota Dinas</td>
                </tr>
                <tr>
                    <td><b>Perihal</b></td>
                    <td>{$surat->perihal}</td>
                </tr>
                <tr>
                    <td><b>Nomor Surat</b></td>
                    <td>{$surat->nomor_surat}</td>
                </tr>
            </table>

            <br>

            <p>
                Silakan login ke HRIS BANK WAWAY untuk melakukan approval.
            </p>

            <p>
                <a href='https://hris.bankwawaylampung.com'>
                    Buka HRIS BANK WAWAY
                </a>
            </p>

            <hr>

            <small>
                Email ini dikirim otomatis oleh Sistem HRIS BANK WAWAY Bank Waway Lampung.
                Mohon tidak membalas email ini.
            </small>
        ");

});

                }

            }

        }

    }

    return redirect()
        ->back()
        ->with('success', 'Surat berhasil dikirim');
}

public function tandaTangan(Request $request)
{
    $pegawai = Pegawai::where(
        'user_id',
        Auth::id()
    )->first();

    $query = SuratTtd::with([

        'surat',
        'surat.pegawai',
        'surat.pegawai.bagianRelasi'

    ])
    ->where('pegawai_id', $pegawai->id);

    // search
    if ($request->search) {

        $query->whereHas('surat.pegawai', function ($q) use ($request) {

            $q->where(
                'nama',
                'like',
                '%' . $request->search . '%'
            );

        });

    }

    // status
    if ($request->status) {

        $query->where(
            'status',
            strtolower($request->status)
        );

    }

    $ttd = $query
        ->latest()
        ->paginate(5)
        ->withQueryString();

    return view(
        'pegawai.tanda_tangan',
        compact('ttd')
    );
}

public function setujui($id)
{
    $ttd = SuratTtd::findOrFail($id);

    // approve
    $ttd->update([

        'status' => 'disetujui',

        'tanggal_ttd' => now()

    ]);

    // ambil surat
    $surat = Surat::findOrFail(
        $ttd->surat_id
    );

    // cek masih ada pending?
    $pending = SuratTtd::where(

        'surat_id',
        $ttd->surat_id

    )
    ->where(
        'status',
        'pending'
    )
    ->count();

    // =========================
    // JIKA SEMUA SUDAH APPROVE
    // =========================
    if($pending == 0){

        Surat::where(
            'id',
            $ttd->surat_id
        )->update([

            'status' => 'disetujui'

        ]);

    }

    // =========================
    // JIKA SURAT DISPOSISI
    // =========================
    if(
        strtolower($surat->jenis_surat)
        == 'disposisi'
    ){

        return redirect()->route(

            'pegawai.disposisi.form',

            $surat->id

        );

    }

    // =========================
    // SURAT BIASA
    // =========================
    if($pending == 0){

        $tujuan = SuratTujuan::where(
            'surat_id',
            $ttd->surat_id
        )->get();

        foreach($tujuan as $item){

            SuratMasuk::create([

                'surat_id' => $ttd->surat_id,

                'bagian_id' => $item->bagian_id,

                'dibaca' => false,

                'is_disposisi' => false

            ]);

        }

    }

    return back()->with(

        'success',

        'Surat berhasil disetujui'

    );
}

public function editDisposisi($id)
{
    $surat = Surat::findOrFail($id);

    $bagian = Bagian::all();

    $disposisi = SuratMasuk::where(
        'surat_id',
        $id
    )
    ->where(
        'is_disposisi',
        true
    )
    ->get();

    return view(

        'pegawai.disposisi_form',

        compact(
            'surat',
            'bagian',
            'disposisi'
        )

    );
}

public function tolak($id)
{
    $ttd = SuratTtd::findOrFail($id);

    // update approval
    $ttd->update([

        'status' => 'ditolak',

        'tanggal_ttd' => now()

    ]);

    // update surat
    Surat::where(
        'id',
        $ttd->surat_id
    )->update([

        'status' => 'ditolak'

    ]);

    return back()->with(

        'error',
        'Surat berhasil ditolak'

    );
}

public function previewSurat($id)
{
    SuratMasuk::where(
        'surat_id',
        $id
    )
    ->where(
        'bagian_id',
        auth()->user()->pegawai->bagian_id ?? null
    )
    ->update([

        'dibaca' => true

    ]);

    $surat = Surat::with([

        'pegawai',
        'tujuan.bagian',
        'ttd.pegawai'

    ])->findOrFail($id);

    // riwayat disposisi
    $riwayatDisposisi = SuratMasuk::with([

        'bagian',
        'dariPegawai'

    ])
    ->where(
        'surat_id',
        $id
    )
    ->where(
        'is_disposisi',
        true
    )
    ->latest()
    ->get();

    return view(

        'pegawai.preview_surat',

        compact(

            'surat',
            'riwayatDisposisi'

        )

    );
}

public function printSurat($id)
{
    $surat = Surat::with([

        'pegawai.bagianRelasi',
        'pegawai.jabatanRelasi',
        'tujuan.bagian',
        'ttd.pegawai.jabatanRelasi'

    ])->findOrFail($id);

    return view(
        'pegawai.print_surat',
        compact('surat')
    );
}

public function suratMasuk(Request $request)
{
    $pegawai = Pegawai::where(
        'user_id',
        Auth::id()
    )->first();

    $query = SuratMasuk::with([

        'surat',
        'surat.pegawai',
        'surat.pegawai.bagianRelasi'

    ])
    ->where(
        'bagian_id',
        $pegawai->bagian_id
    );

    // search
    if ($request->search) {

        $query->whereHas('surat', function ($q) use ($request) {

            $q->where(
                'perihal',
                'like',
                '%' . $request->search . '%'
            );

        });

    }

    // jenis surat
    if ($request->jenis) {

        $query->whereHas('surat', function ($q) use ($request) {

            $q->where(
                'jenis_surat',
                $request->jenis
            );

        });

    }

    $suratMasuk = $query
        ->latest()
        ->paginate(5)
        ->withQueryString();

    return view(
        'pegawai.surat_masuk',
        compact('suratMasuk')
    );
}

public function suratKeluar(Request $request)
{
    $query = Surat::with([

        'tujuan.bagian',
        'cuti'
    ])
    ->where(
        'user_id',
        Auth::id()
    )

    // =====================
    // SEMBUNYIKAN FORM CUTI
    // =====================
    ->where(
        'jenis_surat',
        '!=',
        'Form Cuti'
    );

    // search
    if ($request->search) {

        $query->where(function ($q) use ($request) {

            $q->where(
                'nomor_surat',
                'like',
                '%' . $request->search . '%'
            )
            ->orWhere(
                'perihal',
                'like',
                '%' . $request->search . '%'
            );

        });

    }

    // filter jenis
    if ($request->jenis) {

        $query->where(
            'jenis_surat',
            $request->jenis
        );

    }

    // filter tanggal
    if ($request->start_date) {

        $query->whereDate(
            'tanggal_surat',
            '>=',
            $request->start_date
        );

    }

    if ($request->end_date) {

        $query->whereDate(
            'tanggal_surat',
            '<=',
            $request->end_date
        );

    }

    $suratKeluar = $query
        ->latest()
        ->paginate(5)
        ->withQueryString();

    return view(
        'pegawai.surat_keluar',
        compact('suratKeluar')
    );
}

public function importSurat()
{
    $bagian = Bagian::orderBy(
        'nama_bagian'
    )->get();

    $pegawai = Pegawai::with([

    'jabatanRelasi',
    'bagianRelasi'

    ])->orderBy(

        'nama'

    )->get();

    return view(
        'pegawai.import_surat',
        compact(
            'bagian',
            'pegawai'
        )
    );
}
public function storeImport(Request $request)
{
    $request->validate([

        'jenis_surat' => 'required',

        'nomor_surat' => 'required',

        'perihal' => 'required',

        'file_pdf' => 'required|mimes:pdf'

    ]);

    // upload pdf
    $filePath = $request
        ->file('file_pdf')
        ->store('surat', 'public');

    // simpan surat
    $surat = Surat::create([

        'user_id' => Auth::id(),

        'jenis_surat' => $request->jenis_surat,

        'nomor_surat' => $request->nomor_surat,

        'tanggal_surat' => now(),

        'perihal' => $request->perihal,
        
        'dari' => $request->dari,

        'isi_surat' => 'Import PDF',

        'file_pdf' => $filePath,

        'status' => 'pending'

    ]);

    // tujuan
    foreach (explode(',', $request->bagian) as $item) {

        SuratTujuan::create([

            'surat_id' => $surat->id,

            'bagian_id' => $item

        ]);
    }

    // ttd
    foreach (explode(',', $request->ttd) as $index => $pegawaiId) {

    SuratTtd::create([

        'surat_id' => $surat->id,

        'pegawai_id' => $pegawaiId,

        'urutan' => $index + 1,

        'status' => 'pending'

    ]);

}

// =========================
// KIRIM EMAIL NOTIFIKASI
// =========================
foreach (explode(',', $request->ttd) as $pegawaiId) {

    $pegawaiTtd = Pegawai::find($pegawaiId);

    if ($pegawaiTtd && $pegawaiTtd->user_id) {

        $user = User::find($pegawaiTtd->user_id);

        if ($user && $user->email) {

            Mail::send([], [], function ($message) use ($user, $surat) {

    $message->to($user->email)
        ->subject('Notifikasi Surat Masuk - '.$surat->perihal)
        ->html("
            <h2>Notifikasi Surat Masuk</h2>

            <p>Yth. Bapak/Ibu,</p>

            <p>Terdapat surat yang memerlukan persetujuan.</p>

            <table border='1' cellpadding='8' cellspacing='0'>
                <tr>
                    <td><b>Jenis Surat</b></td>
                    <td>Nota Dinas</td>
                </tr>
                <tr>
                    <td><b>Perihal</b></td>
                    <td>{$surat->perihal}</td>
                </tr>
                <tr>
                    <td><b>Nomor Surat</b></td>
                    <td>{$surat->nomor_surat}</td>
                </tr>
            </table>

            <br>

            <p>
                Silakan login ke HRIS BANK WAWAY untuk melakukan approval.
            </p>

            <p>
                <a href='https://hris.bankwawaylampung.com'>
                    Buka HRIS BANK WAWAY
                </a>
            </p>

            <hr>

            <small>
                Email ini dikirim otomatis oleh Sistem HRIS BANK WAWAY Bank Waway Lampung.
                Mohon tidak membalas email ini.
            </small>
        ");

});

        }

    }

}

    return redirect()
        ->back()
        ->with(

            'success',

            'Import surat berhasil dikirim'

        );
}

public function formDisposisi($id)
{
    $surat = Surat::findOrFail($id);

    $bagian = Bagian::orderBy(
        'nama_bagian'
    )->get();

    // semua riwayat disposisi
    $riwayatDisposisi = SuratMasuk::with([

        'bagian',
        'dariPegawai'

    ])
    ->where(
        'surat_id',
        $surat->id
    )
    ->where(
        'is_disposisi',
        true
    )
    ->latest()
    ->get();

    // disposisi milik user login
    $disposisiSaya = SuratMasuk::with(
        'bagian'
    )
    ->where(
        'surat_id',
        $surat->id
    )
    ->where(
        'is_disposisi',
        true
    )
    ->where(
        'dari_pegawai_id',
        auth()->user()->pegawai->id
    )
    ->get();

    return view(

        'pegawai.disposisi_form',

        compact(

            'surat',
            'bagian',
            'riwayatDisposisi',
            'disposisiSaya'

        )

    );
}

public function storeDisposisi(
    Request $request,
    $id
){

    $request->validate([

        'bagian_id' => 'required',

        'catatan' => 'required'

    ]);

    $surat = Surat::findOrFail($id);

    // hapus disposisi user login
    SuratMasuk::where(
        'surat_id',
        $surat->id
    )
    ->where(
        'is_disposisi',
        true
    )
    ->where(
        'dari_pegawai_id',
        auth()->user()->pegawai->id
    )
    ->delete();

    $bagianIds = explode(
        ',',
        $request->bagian_id
    );

    // insert ulang
    foreach($bagianIds as $bagianId){

        SuratMasuk::create([

            'surat_id' => $surat->id,

            'bagian_id' => (int)$bagianId,

            'dibaca' => false,

            'catatan' => $request->catatan,

            'dari_pegawai_id' => auth()->user()->pegawai->id,

            'is_disposisi' => true

        ]);

    }

    return redirect()
        ->route(

            'pegawai.surat.preview',

            $surat->id

        )
        ->with(

            'success',

            'Disposisi berhasil disimpan'

        );
}

public function updateDisposisi(
    Request $request,
    $id
){

    $request->validate([

        'bagian_id' => 'required',

        'catatan' => 'required'

    ]);

    $surat = Surat::findOrFail($id);

    // hapus disposisi user login
    SuratMasuk::where(
        'surat_id',
        $surat->id
    )
    ->where(
        'is_disposisi',
        true
    )
    ->where(
        'dari_pegawai_id',
        auth()->user()->pegawai->id
    )
    ->delete();

    $bagianIds = explode(
        ',',
        $request->bagian_id
    );

    // insert ulang
    foreach($bagianIds as $bagianId){

        SuratMasuk::create([

            'surat_id' => $surat->id,

            'bagian_id' => (int)$bagianId,

            'dibaca' => false,

            'catatan' => $request->catatan,

            'dari_pegawai_id' => auth()->user()->pegawai->id,

            'is_disposisi' => true

        ]);

    }

    return redirect()
        ->route(

            'pegawai.surat.preview',

            $surat->id

        )
        ->with(

            'success',

            'Disposisi berhasil diperbarui'

        );
}

public function storeLembur(Request $request)
{
    $request->validate([

        'kepala_bagian' => 'required',

        'nomor_surat' => 'required',

        'tanggal_surat' => 'required',

        'pekerjaan' => 'required',

        'area' => 'required',

        'tanggal_lembur' => 'required',

        'jam_lembur' => 'required',

        'bagian' => 'required',

        'pegawai_lembur' => 'required',

        'ttd' => 'required'

    ]);

    $kepalaBagian = Pegawai::with([

        'jabatanRelasi',
        'bagianRelasi'

    ])->findOrFail(

        $request->kepala_bagian

    );

    $pegawaiIds = explode(
        ',',
        $request->pegawai_lembur
    );

    $pegawaiLembur = Pegawai::whereIn(
        'id',
        $pegawaiIds
    )->pluck('nama')->toArray();

    $isiSurat = "

FORM LEMBUR

Nama :
{$kepalaBagian->nama}

Jabatan :
{$kepalaBagian->jabatanRelasi->nama_jabatan}
-
{$kepalaBagian->bagianRelasi->nama_bagian}

Pekerjaan :
{$request->pekerjaan}

Area :
{$request->area}

Tanggal :
{$request->tanggal_lembur}

Jam :
{$request->jam_lembur}

Jumlah Tenaga Kerja :
" . implode(', ', $pegawaiLembur);

    $filePath = null;

    if ($request->hasFile('file_pdf')) {

        $filePath = $request
            ->file('file_pdf')[0]
            ->store(
                'surat',
                'public'
            );
    }

    $surat = Surat::create([

        'user_id' => Auth::id(),

        'jenis_surat' => 'Form Lembur',

        'nomor_surat' => $request->nomor_surat,

        'tanggal_surat' => $request->tanggal_surat,

        'perihal' => 'Form Lembur',

        'isi_surat' => $isiSurat,

        'file_pdf' => $filePath,

        'status' => 'pending'

    ]);

    Lembur::create([

        'surat_id' => $surat->id,

        'pegawai_id' => $kepalaBagian->id,

        'pekerjaan' => $request->pekerjaan,

        'area' => $request->area,

        'tanggal_lembur' => $request->tanggal_lembur,

        'jam_lembur' => $request->jam_lembur,

        'jumlah_tenaga' => count(
            $pegawaiIds
        ),

        'pegawai_lembur' => json_encode(
            $pegawaiIds
        )

    ]);

    foreach (explode(',', $request->bagian) as $item) {

        SuratTujuan::create([

            'surat_id' => $surat->id,

            'bagian_id' => $item

        ]);

    }

    $ttds = explode(',', $request->ttd);

    foreach ($ttds as $index => $pegawaiId) {

        SuratTtd::create([

            'surat_id' => $surat->id,

            'pegawai_id' => $pegawaiId,

            'urutan' => $index + 1,

            'status' => 'pending'

        ]);

    }

    // =========================
    // EMAIL NOTIFIKASI
    // =========================
    foreach ($ttds as $pegawaiId) {

        $pegawaiTtd = Pegawai::find($pegawaiId);

        if ($pegawaiTtd && $pegawaiTtd->user_id) {

            $user = User::find($pegawaiTtd->user_id);

            if ($user && $user->email) {

               Mail::send([], [], function ($message) use ($user, $surat) {

    $message->to($user->email)
        ->subject('Notifikasi Form Lembur - '.$surat->nomor_surat)
        ->html("
            <h2>Notifikasi Form Lembur</h2>

            <p>Yth. Bapak/Ibu,</p>

            <p>Terdapat form lembur yang memerlukan persetujuan.</p>

            <table border='1' cellpadding='8' cellspacing='0'>
                <tr>
                    <td><b>Perihal</b></td>
                    <td>{$surat->perihal}</td>
                </tr>
                <tr>
                    <td><b>Nomor Surat</b></td>
                    <td>{$surat->nomor_surat}</td>
                </tr>
            </table>

            <br>

            <p>Silakan login ke HRIS BANK WAWAY untuk melakukan approval.</p>

            <p>
                <a href='https://hris.bankwawaylampung.com'>
                    Buka HRIS BANK WAWAY
                </a>
            </p>

            <hr>

            <small>
                Email ini dikirim otomatis oleh Sistem HRIS BANK WAWAY.
                Mohon tidak membalas email ini.
            </small>
        ");

});

            }

        }

    }

    return redirect()
        ->back()
        ->with(

            'success',

            'Form lembur berhasil dikirim'

        );
}
}