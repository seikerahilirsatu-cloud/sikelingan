<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PindahKeluarController;
use App\Http\Controllers\DataKeluargaController;
use App\Http\Controllers\BiodataWargaController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\RumahIbadahController;
use App\Http\Controllers\ImportRumahIbadahController;
use App\Http\Controllers\ExportController;

Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('data_keluarga', DataKeluargaController::class);
    Route::resource('biodata_warga', BiodataWargaController::class);
    Route::resource('rumah_ibadah', RumahIbadahController::class);
    Route::resource('umkm', \App\Http\Controllers\UmkmController::class);

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
    });

    Route::get('import', [ImportController::class,'form'])->name('import.form')->middleware('check.role:admin,staff');
    Route::post('import/preview', [ImportController::class,'preview'])->name('import.preview')->middleware('check.role:admin,staff');
    Route::post('import/commit', [ImportController::class,'commit'])->name('import.commit')->middleware('check.role:admin,staff');

    Route::get('export/biodata', [ExportController::class,'biodata'])->name('export.biodata');

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
