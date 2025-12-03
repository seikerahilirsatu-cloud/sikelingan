<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PindahKeluarController;
use App\Http\Controllers\DataKeluargaController;
use App\Http\Controllers\BiodataWargaController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\RumahIbadahController;
use App\Http\Controllers\ImportRumahIbadahController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\PendidikanFormalController;
use App\Http\Controllers\PendidikanNonFormalController;

Route::get('/', [DashboardController::class, 'index']);

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/m', function () {
    return view('mobile_react');
})->name('mobile.react');

// Statistics pages
use App\Http\Controllers\StatsController;
Route::get('/stats/penduduk', [StatsController::class, 'penduduk'])->name('stats.penduduk');
Route::get('/stats/ibadah', [StatsController::class, 'ibadah'])->name('stats.ibadah');
Route::get('/stats/umkm', [StatsController::class, 'umkm'])->name('stats.umkm');
Route::get('/stats/pendidikan', [StatsController::class, 'pendidikan'])->name('stats.pendidikan');
Route::get('/stats/olahraga', [StatsController::class, 'olahraga'])->name('stats.olahraga');
Route::get('/stats/pasar', [StatsController::class, 'pasar'])->name('stats.pasar');
Route::get('/stats/mutasi', [StatsController::class, 'mutasi'])->middleware(['auth','check.role:admin,staff'])->name('stats.mutasi');
Route::get('/stats/mutasi/export', [StatsController::class, 'exportMutasiCsv'])->middleware(['auth','check.role:admin,staff'])->name('stats.mutasi.export');
Route::get('/stats/mutasi/export-excel', [StatsController::class, 'exportMutasiExcel'])->middleware(['auth','check.role:admin,staff'])->name('stats.mutasi.export_excel');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('data_keluarga', DataKeluargaController::class);
    Route::resource('biodata_warga', BiodataWargaController::class);
    Route::resource('rumah_ibadah', RumahIbadahController::class);
    Route::resource('umkm', \App\Http\Controllers\UmkmController::class);
    Route::resource('pendidikan_formal', PendidikanFormalController::class);
    Route::resource('pendidikan_non_formal', PendidikanNonFormalController::class);

    Route::middleware('check.role:admin,staff')->group(function () {
        Route::get('import/rumah_ibadah', [ImportRumahIbadahController::class,'form'])->name('import.rumah_ibadah.form');
        Route::post('import/rumah_ibadah/preview', [ImportRumahIbadahController::class,'preview'])->name('import.rumah_ibadah.preview');
        Route::post('import/rumah_ibadah/commit', [ImportRumahIbadahController::class,'commit'])->name('import.rumah_ibadah.commit');
        Route::get('import/rumah_ibadah/template', [ImportRumahIbadahController::class,'template'])->name('import.rumah_ibadah.template');
        Route::get('export/rumah_ibadah', [ExportController::class,'rumahIbadah'])->name('export.rumah_ibadah');

        Route::get('import/umkm', [\App\Http\Controllers\ImportUmkmController::class,'form'])->name('import.umkm.form');
        Route::post('import/umkm/preview', [\App\Http\Controllers\ImportUmkmController::class,'preview'])->name('import.umkm.preview');
        Route::post('import/umkm/commit', [\App\Http\Controllers\ImportUmkmController::class,'commit'])->name('import.umkm.commit');
        Route::get('import/umkm/template', [\App\Http\Controllers\ImportUmkmController::class,'template'])->name('import.umkm.template');
        Route::get('export/umkm', [ExportController::class,'umkm'])->name('export.umkm');

        // Import Biodata Warga
        Route::get('import/biodata', [ImportController::class,'biodataForm'])->name('import.biodata.form');
        Route::post('import/biodata/preview', [ImportController::class,'preview'])->name('import.biodata.preview');
        Route::post('import/biodata/commit', [ImportController::class,'commit'])->name('import.biodata.commit');
        Route::get('import/biodata/template', [ImportController::class,'biodataTemplate'])->name('import.biodata.template');

        // Import Data Keluarga
        Route::get('import/data_keluarga', [ImportController::class,'familyForm'])->name('import.data_keluarga.form');
        Route::post('import/data_keluarga/preview', [ImportController::class,'familyPreview'])->name('import.data_keluarga.preview');
        Route::post('import/data_keluarga/commit', [ImportController::class,'familyCommit'])->name('import.data_keluarga.commit');
        Route::get('import/data_keluarga/template', [ImportController::class,'familyTemplate'])->name('import.data_keluarga.template');

        // Import Pendidikan Formal
        Route::get('import/pendidikan_formal', [\App\Http\Controllers\ImportPendidikanFormalController::class,'form'])->name('import.pendidikan_formal.form');
        Route::post('import/pendidikan_formal/preview', [\App\Http\Controllers\ImportPendidikanFormalController::class,'preview'])->name('import.pendidikan_formal.preview');
        Route::post('import/pendidikan_formal/commit', [\App\Http\Controllers\ImportPendidikanFormalController::class,'commit'])->name('import.pendidikan_formal.commit');
        Route::get('import/pendidikan_formal/template', [\App\Http\Controllers\ImportPendidikanFormalController::class,'template'])->name('import.pendidikan_formal.template');

        // Import Pendidikan Non-Formal
        Route::get('import/pendidikan_non_formal', [\App\Http\Controllers\ImportPendidikanNonFormalController::class,'form'])->name('import.pendidikan_non_formal.form');
        Route::post('import/pendidikan_non_formal/preview', [\App\Http\Controllers\ImportPendidikanNonFormalController::class,'preview'])->name('import.pendidikan_non_formal.preview');
        Route::post('import/pendidikan_non_formal/commit', [\App\Http\Controllers\ImportPendidikanNonFormalController::class,'commit'])->name('import.pendidikan_non_formal.commit');
        Route::get('import/pendidikan_non_formal/template', [\App\Http\Controllers\ImportPendidikanNonFormalController::class,'template'])->name('import.pendidikan_non_formal.template');
    });

    Route::get('import', [ImportController::class,'form'])->name('import.form')->middleware('check.role:admin,staff');
    Route::post('import/preview', [ImportController::class,'preview'])->name('import.preview')->middleware('check.role:admin,staff');
    Route::post('import/commit', [ImportController::class,'commit'])->name('import.commit')->middleware('check.role:admin,staff');

    Route::get('export/biodata', [ExportController::class,'biodata'])->name('export.biodata');
    Route::get('export/keluarga', [ExportController::class,'keluarga'])->name('export.keluarga');
    Route::get('export/pendidikan_formal', [ExportController::class,'pendidikanFormal'])->name('export.pendidikan_formal');
    Route::get('export/pendidikan_non_formal', [ExportController::class,'pendidikanNonFormal'])->name('export.pendidikan_non_formal');
    Route::get('export/pendidikan_formal/excel', [ExportController::class,'pendidikanFormalExcel'])->name('export.pendidikan_formal_excel');
    Route::get('export/pendidikan_non_formal/excel', [ExportController::class,'pendidikanNonFormalExcel'])->name('export.pendidikan_non_formal_excel');

    // import jobs
    Route::get('import/jobs', [\App\Http\Controllers\ImportJobController::class, 'index'])->name('import.jobs.index')->middleware('check.role:admin,staff');
    Route::get('import/jobs/{id}', [\App\Http\Controllers\ImportJobController::class, 'show'])->name('import.jobs.show')->middleware('check.role:admin,staff');
    Route::get('import/jobs/{id}/download', [\App\Http\Controllers\ImportJobController::class, 'downloadErrors'])->name('import.jobs.download')->middleware('check.role:admin,staff');

    // Admin user role management
    Route::get('admin/users', [\App\Http\Controllers\UserRoleController::class, 'index'])->name('admin.users.index')->middleware('check.role:admin');
    Route::get('admin/users/create', [\App\Http\Controllers\UserRoleController::class, 'create'])->name('admin.users.create')->middleware('check.role:admin');
    Route::post('admin/users', [\App\Http\Controllers\UserRoleController::class, 'store'])->name('admin.users.store')->middleware('check.role:admin');
    Route::put('admin/users/{id}', [\App\Http\Controllers\UserRoleController::class, 'update'])->name('admin.users.update')->middleware('check.role:admin');
});

require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {
    Route::resource('pindah_keluar', PindahKeluarController::class)->only(['index','create','store','edit','update','show','destroy']);
    Route::resource('pindah_masuk', \App\Http\Controllers\PindahMasukController::class)->only(['index','create','store','edit','update','show','destroy']);
    Route::resource('warga_meninggal', \App\Http\Controllers\WargaMeninggalController::class)->only(['index','create','store','edit','update','show','destroy']);
});
