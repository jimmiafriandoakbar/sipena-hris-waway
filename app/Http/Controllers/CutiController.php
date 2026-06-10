<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Surat;
use App\Models\SuratTujuan;
use App\Models\Cuti;
use App\Models\CutiApproval;
use App\Models\Pegawai;
use App\Models\Bagian;

class CutiController extends Controller
{
    public function approvalCuti($id)
{
    $cuti = Cuti::with([

        'pegawai',
        'pegawai.jabatanRelasi',
        'pegawai.bagianRelasi',

        'surat',

        'approval',
        'approval.pegawai'

    ])->findOrFail($id);

    $approvalAktif = CutiApproval::with([

        'pegawai',
        'cuti'

    ])
    ->where(

        'cuti_id',
        $cuti->id

    )
    ->where(

        'pegawai_id',
        auth()->user()->pegawai->id

    )
    ->where(

        'status',
        'pending'

    )
    ->whereRaw('

        urutan = (

            select MIN(urutan)

            from cuti_approval ca

            where ca.cuti_id = cuti_approval.cuti_id

            and ca.status = "pending"

        )

    ')
    ->get();

    return view(

        'pegawai.approval_cuti',

        compact(

            'cuti',
            'approvalAktif'

        )

    );
}

    public function storeCuti(Request $request)
{
    $request->validate([

        'nomor_surat' => 'required',

        'tanggal_surat' => 'required',

        'jenis_cuti' => 'required',

        'mulai_cuti' => 'required',

        'akhir_cuti' => 'required',

        'total_hari' => 'required',

        'tgl_masuk' => 'required',

        'bagian' => 'required',

        'pegawai_backup' => 'required',

        'ttd' => 'required'

    ]);

    // =====================
    // BUAT SURAT
    // =====================
    $surat = Surat::create([

        'user_id' => Auth::id(),

        'jenis_surat' => 'Form Cuti',

        'nomor_surat' => $request->nomor_surat,

        'tanggal_surat' => $request->tanggal_surat,

        'perihal' => 'Permohonan Cuti',

        'isi_surat' => 'FORM CUTI',

        'status' => 'pending'

    ]);

    // =====================
    // TUJUAN BAGIAN
    // =====================
    foreach(explode(',', $request->bagian) as $item){

        SuratTujuan::create([

            'surat_id' => $surat->id,

            'bagian_id' => $item

        ]);

    }

    // =====================
    // BUAT CUTI
    // =====================
    $cuti = Cuti::create([

        'surat_id' => $surat->id,

        'pegawai_id' => auth()->user()->pegawai->id,

        'jenis_cuti' => $request->jenis_cuti,

        'mulai_cuti' => $request->mulai_cuti,

        'akhir_cuti' => $request->akhir_cuti,

        'tgl_masuk' => $request->tgl_masuk,

        'total_hari' => $request->total_hari,

        'keterangan' => $request->keterangan,

        'alamat' => $request->alamat,

        'nomor_hp' => $request->nomor,

        'user_cbs' => $request->cbs

    ]);

    // =====================
// DATA PEGAWAI PENGAJU
// =====================
$pegawaiPengaju = auth()->user()->pegawai;


// =====================
// 1. BACKUP
// =====================
foreach(explode(',', $request->pegawai_backup) as $backup){

    CutiApproval::create([

        'cuti_id' => $cuti->id,

        'pegawai_id' => $backup,

        'urutan' => 1,

        'role_approval' => 'backup',

        'status' => 'pending'

    ]);

}


// =====================
// 2. KEPALA BAGIAN
// sesuai bagian pengaju
// =====================
$kepalaBagian = Pegawai::where(

    'bagian_id',
    $pegawaiPengaju->bagian_id

)
->where(

    'jabatan_id',
    3 // Kepala Bagian

)
->first();

if($kepalaBagian){

    CutiApproval::create([

        'cuti_id' => $cuti->id,

        'pegawai_id' => $kepalaBagian->id,

        'urutan' => 2,

        'role_approval' => 'kepala_bagian',

        'status' => 'pending'

    ]);

}


// =====================
// 3. USDM
// ambil dari tabel bagian
// =====================
$bagianSdm = Bagian::where(

    'kode_bagian',
    'USDM'

)->first();

if($bagianSdm){

    $sdm = Pegawai::where(

        'bagian_id',
        $bagianSdm->id

    )->first();

    if($sdm){

        CutiApproval::create([

            'cuti_id' => $cuti->id,

            'pegawai_id' => $sdm->id,

            'urutan' => 3,

            'role_approval' => 'sdm',

            'status' => 'pending'

        ]);

    }

}


// =====================
// 4. DIREKTUR OPERASIONAL
// ambil dari bagian DIROP
// =====================
$bagianDirop = Bagian::where(

    'kode_bagian',
    'DIROP'

)->first();

if($bagianDirop){

    $dirop = Pegawai::where(

        'bagian_id',
        $bagianDirop->id

    )
    ->where(

        'jabatan_id',
        1 // Direktur Operasional

    )
    ->first();

    if($dirop){

        CutiApproval::create([

            'cuti_id' => $cuti->id,

            'pegawai_id' => $dirop->id,

            'urutan' => 4,

            'role_approval' => 'direktur_operasional',

            'status' => 'pending'

        ]);

    }

}


// =====================
// 5. DIREKTUR UTAMA
// ambil dari bagian DIRUT
// =====================
$bagianDirut = Bagian::where(

    'kode_bagian',
    'DIRUT'

)->first();

if($bagianDirut){

    $dirut = Pegawai::where(

        'bagian_id',
        $bagianDirut->id

    )
    ->where(

        'jabatan_id',
        2 // Direktur Utama

    )
    ->first();

    if($dirut){

        CutiApproval::create([

            'cuti_id' => $cuti->id,

            'pegawai_id' => $dirut->id,

            'urutan' => 5,

            'role_approval' => 'direktur_utama',

            'status' => 'pending'

        ]);

    }

}


return redirect()
    ->back()
    ->with(

        'success',

        'Form cuti berhasil dikirim'

    );
}

public function approveCuti(
    Request $request,
    $id
)
{
    $approval = CutiApproval::findOrFail($id);

    // =====================
    // VALIDASI BERJENJANG
    // =====================
    $approvalAktif = CutiApproval::where(

        'cuti_id',
        $approval->cuti_id

    )
    ->where(

        'status',
        'pending'

    )
    ->min('urutan');

    // jika bukan urutan aktif
    if($approval->urutan != $approvalAktif){

        return back()->with(

            'error',

            'Approval belum tersedia'

        );
    }

    // =====================
    // UPDATE APPROVAL
    // =====================
    $approval->update([

        'status' => $request->status,

        'catatan' => $request->catatan,

        'tanggal_approval' => now(),

        // kepala bagian / dirut
        'cuti_efektif' => $request->cuti_efektif,

        'sampai_dengan' => $request->sampai_dengan,

        'petugas_pengganti' => $request->petugas_pengganti,

        // SDM
        'hak_hari_cuti' => $request->hak_hari_cuti,

        'telah_dijalani' => $request->telah_dijalani,

        'izin_potong_cuti' => $request->izin_potong_cuti,

        'sisa_hari_cuti' => $request->sisa_hari_cuti,

        'sisa_setelah_cuti' => $request->sisa_setelah_cuti,

        'jumlah_hari' => $request->jumlah_hari

    ]);

    // =====================
    // JIKA DITOLAK
    // =====================
    if($request->status == 'ditolak'){

        $approval->cuti
            ->surat
            ->update([

                'status' => 'ditolak'

            ]);

        return back()->with(

            'success',

            'Pengajuan cuti ditolak'

        );
    }

    // =====================
    // MASIH ADA PENDING?
    // =====================
    $masihPending = CutiApproval::where(

        'cuti_id',
        $approval->cuti_id

    )
    ->where(

        'status',
        'pending'

    )
    ->exists();

    // =====================
    // JIKA SEMUA APPROVE
    // =====================
    if(!$masihPending){

        $approval->cuti
            ->surat
            ->update([

                'status' => 'disetujui'

            ]);

    }

    return back()->with(

        'success',

        'Approval berhasil'

    );

    // =====================
// UPDATE STATUS SURAT
// =====================
$nextApproval = CutiApproval::where(

    'cuti_id',
    $approval->cuti_id

)
->where(

    'status',
    'pending'

)
->orderBy(
    'urutan'
)
->first();

if($nextApproval){

    $statusSurat = match($nextApproval->role_approval){

        'backup' => 'Pending Backup',

        'kepala_bagian' => 'Pending Kepala Bagian',

        'sdm' => 'Pending SDM',

        'direktur_operasional' => 'Pending Direktur Operasional',

        'direktur_utama' => 'Pending Direktur Utama',

        default => 'Pending Approval'

    };

    $approval->cuti
        ->surat
        ->update([

            'status' => $statusSurat

        ]);

}
}

public function listCuti()
{
    $pegawaiId = auth()->user()->pegawai->id;

    $cuti = Cuti::with([

        'pegawai',
        'pegawai.jabatanRelasi',
        'pegawai.bagianRelasi',

        'surat',

        'approval',
        'approval.pegawai'

    ])

    // =====================
    // HANYA USER TERKAIT
    // =====================
    ->where(function($q) use ($pegawaiId){

        // pembuat cuti
        $q->where(

            'pegawai_id',
            $pegawaiId

        )

        // approval terkait
        ->orWhereHas(

            'approval',

            function($approval) use ($pegawaiId){

                $approval->where(

                    'pegawai_id',
                    $pegawaiId

                );

            }

        );

    })

    ->latest()

    ->paginate(10);

    return view(

        'pegawai.list_cuti',

        compact(

            'cuti'

        )

    );
}


// =====================
// PREVIEW CUTI
// =====================
public function previewCuti($id)
{
    $cuti = Cuti::with([

        'pegawai',
        'pegawai.jabatanRelasi',
        'pegawai.bagianRelasi',

        'surat',

        'approval',
        'approval.pegawai'

    ])->findOrFail($id);

    return view(

        'pegawai.preview_cuti',

        compact(

            'cuti'

        )

    );
}


// =====================
// PRINT CUTI
// =====================
public function printCuti($id)
{
    $cuti = Cuti::with([

        'pegawai',
        'pegawai.jabatanRelasi',
        'pegawai.bagianRelasi',

        'surat',

        'approval',
        'approval.pegawai'

    ])->findOrFail($id);

    return view(

        'pegawai.print_cuti',

        compact(

            'cuti'

        )

    );
}
}