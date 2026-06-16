<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuratController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\BagianController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CutiController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AbsensiSettingController;


Route::get('/', function () {
    return redirect('/login');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin')->name('admin.')->middleware(['auth','role:admin'])->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/profile-admin', function () {
        return view('admin.profile_admin');
    })->name('profile_admin');

    Route::get('/daftar-jabatan', [JabatanController::class, 'index'])
        ->name('daftar.jabatan');

    Route::post('/jabatan/store', [JabatanController::class, 'store'])
        ->name('jabatan.store');

    Route::put('/jabatan/update/{id}', [JabatanController::class, 'update'])
        ->name('jabatan.update');

    Route::delete('/jabatan/delete/{id}', [JabatanController::class, 'destroy'])
        ->name('jabatan.delete');
    
    Route::get('/daftar-bagian', [BagianController::class, 'index'])
        ->name('daftar.bagian');

    Route::post('/bagian/store', [BagianController::class, 'store'])
        ->name('bagian.store');

    Route::put('/bagian/update/{id}', [BagianController::class, 'update'])
        ->name('bagian.update');

    Route::delete('/bagian/delete/{id}', [BagianController::class, 'destroy'])
        ->name('bagian.delete');
    
    Route::get('/daftar-pegawai', [PegawaiController::class, 'indexAdmin'])
        ->name('daftarpegawai_admin');

    Route::get('/daftar-gaji-pegawai', [PegawaiController::class, 'daftarGaji'])
        ->name('daftargaji_admin');

    Route::get('/editgaji/{id}', [PegawaiController::class, 'editGaji'])
        ->name('editgaji');

    Route::put('/editgaji/update/{id}', [PegawaiController::class, 'updateGaji'])
        ->name('editgaji.update');

    Route::get('/gaji/print', [PegawaiController::class, 'printGaji'])
    ->name('gaji.print');

    Route::get('/gaji/export', [PegawaiController::class, 'exportGaji'])
        ->name('gaji.export');

    Route::get('/pegawai/create', [PegawaiController::class, 'create'])
        ->name('pegawai.create');

    Route::post('/pegawai/store', [PegawaiController::class, 'store'])
        ->name('pegawai.store');

    Route::delete('/pegawai/{id}', [PegawaiController::class, 'destroy'])
        ->name('pegawai.delete');

    Route::get('/pegawai/edit/{id}', [PegawaiController::class, 'edit'])
    ->name('pegawai.edit');

    Route::put('/pegawai/update/{id}', [PegawaiController::class, 'update'])
        ->name('pegawai.update');
    
    Route::get('/absensi-setting',[AbsensiSettingController::class, 'index'])
        ->name('absensi.setting');

    Route::post('/absensi-setting/update',[AbsensiSettingController::class, 'update'])
        ->name('absensi.setting.update');

    Route::get('/absensi/rekap', [AbsensiController::class, 'rekapAdmin'])
        ->name('absensi.rekap');
    
    Route::get('/absensi/detail/{pegawai}', [AbsensiController::class, 'detailAdmin'])
        ->name('absensi.detail');

});

Route::prefix('pegawai')->name('pegawai.')->middleware(['auth','role:pegawai'])->group(function () {

    Route::get(
    '/dashboard',
    [DashboardController::class, 'dashboard']
    )->name('dashboard');

    Route::get('/create-surat', [SuratController::class, 'notaDinas'])
    ->name('surat.nota_dinas');

    Route::post('/surat/create-surat/store', [SuratController::class, 'storeNotaDinas'])
    ->name('surat.nota_dinas.store');

    Route::get(
        '/import-surat',
        [SuratController::class, 'importSurat']
    )->name('import.surat');

    Route::post(
        '/import-surat/store',
        [SuratController::class, 'storeImport']
    )->name('import.store');
    
    Route::get('/profile', function () {
        return view('pegawai.profile');
    })->name('profile');

    Route::get('/surat-masuk',
    [SuratController::class, 'suratMasuk'])
    ->name('surat.masuk');
    
    Route::get('/surat-keluar',
    [SuratController::class, 'suratKeluar'])
    ->name('surat.keluar');

    Route::get('/tanda-tangan', [SuratController::class, 'tandaTangan'])
    ->name('surat.tanda_tangan');

    Route::post('/surat/{id}/setujui',
    [SuratController::class, 'setujui'])
    ->name('surat.setujui');

    Route::post('/surat/{id}/tolak',
    [SuratController::class, 'tolak'])
    ->name('surat.tolak');

    Route::get('/surat/preview/{id}',
    [SuratController::class, 'previewSurat'])
    ->name('surat.preview');

    Route::get('/surat/print/{id}',
    [SuratController::class, 'printSurat'])
    ->name('surat.print');

    Route::get(
        '/pegawai/disposisi/{id}',
        [SuratController::class, 'formDisposisi']
    )->name('disposisi.form');

    Route::post(
        '/pegawai/disposisi/store/{id}',
        [SuratController::class, 'storeDisposisi']
    )->name('disposisi.store');

    Route::post(
    '/pegawai/disposisi/{surat}/update',
        [SuratController::class, 'updateDisposisi']
    )->name('disposisi.update');

    Route::get(
    '/pegawai/disposisi/{surat}/edit',
        [SuratController::class, 'editDisposisi']
    )->name('disposisi.edit');

    Route::get('/surat/lembur', [PegawaiController::class, 'lembur'])
    ->name('surat.lembur');

    Route::post(
    '/lembur/store',
        [SuratController::class, 'storeLembur']
    )->name('lembur.store');

    Route::get('/surat/cuti', [PegawaiController::class, 'cuti'])
    ->name('surat.cuti');

    Route::post('/cuti/store', [CutiController::class, 'storeCuti']
    )->name('cuti.store');

    Route::post('/cuti/approve/{id}', [CutiController::class, 'approveCuti']
    )->name('cuti.approve');

    Route::get('/cuti/approval/{id}', [CutiController::class, 'approvalCuti']
    )->name(
    'cuti.approval');

    Route::get('/list-cuti', [CutiController::class, 'listCuti']
    )->name('list.cuti');

    Route::get('/preview-cuti/{id}', [CutiController::class, 'previewCuti']
    )->name('preview.cuti');

    Route::get('/print-cuti/{id}', [CutiController::class, 'printCuti']
    )->name('print.cuti');

    // ABSENSI PEGAWAI
    Route::get('/absensi', [AbsensiController::class, 'indexPegawai'])
        ->name('absensi.index');

    Route::post('/absensi/check-in', [AbsensiController::class, 'checkIn'])
        ->name('absensi.checkin');

    Route::post('/absensi/check-out', [AbsensiController::class, 'checkOut'])
        ->name('absensi.checkout');

    Route::get('/absensi/check-in', function () {
        return redirect()->route('pegawai.absensi.index');
    });

    Route::get('/absensi/check-out', function () {
        return redirect()->route('pegawai.absensi.index');
    });

    Route::post('/absensi/check-in-test', function () {
    dd('POST TEST MASUK');
})->name('absensi.checkin.test');

Route::get('/absensi/check-in-test', function () {
    dd('GET TEST MASUK');
});

    Route::get('/detail-gaji', function () {
    return view('pegawai.detail_gaji');
})->name('detail.gaji');
    
    // Route::get('/surat/{id}/preview', [SuratController::class, 'preview']);
    // Route::get('/surat/{id}/download', [SuratController::class, 'download'])->name('surat.download');

    // Route::post('/surat/{id}/setujui', [SuratController::class, 'setujui'])->name('surat.setujui');
    // Route::post('/surat/{id}/tolak', [SuratController::class, 'tolak'])->name('surat.tolak');

});

Route::post('/pegawai/update-password', [App\Http\Controllers\PegawaiController::class, 'updatePassword'])
    ->name('pegawai.updatePassword')
    ->middleware('auth');

Route::post('/admin/update-password', [App\Http\Controllers\AdminController::class, 'updatePassword'])
    ->name('admin.update-password')
    ->middleware(['auth','role:admin']);

Route::post('/pegawai/ttd', [ProfileController::class, 'storeTTD'])
    ->name('pegawai.ttd.store');

require __DIR__.'/auth.php';

