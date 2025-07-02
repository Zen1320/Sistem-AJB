<?php

use App\Http\Controllers\Daftar_AJBController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Kelola_AnggotaController;
use App\Http\Controllers\Kelola_LaporanController;
use App\Http\Controllers\Kelola_MasyarakatController;
use App\Http\Controllers\Kelola_PenggunaController;
use App\Http\Controllers\KelolaJenisTransaksiController;
use App\Http\Controllers\Manajemen_PengajuanController;
use App\Http\Controllers\PembuatanAJBController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('homepage.beranda');
})->name('homepage.beranda');
Route::get('/tentang', function () {
    return view('homepage.tentang');
})->name('homepage.tentang');

// Route::get('/cek-zip', function () {
//     return class_exists('ZipArchive') ? 'ZipArchive Aktif!' : 'ZipArchive Belum Aktif';
// });


Route::middleware(['auth','verify'])->group(function(){
    Route::middleware(['checkrole:0,1,2','cekstatus'])->group(function(){
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });
    //Super Admin
    Route::middleware(['checkrole:0'])->group(function(){
        Route::get('/Kelola_JenisTransaksi', [KelolaJenisTransaksiController::class, 'index'])->name('Kelola_JenisTransaksi.index');
        Route::post('/Kelola_JenisTransaksi', [KelolaJenisTransaksiController::class, 'store'])->name('Kelola_JenisTransaksi.store');
        Route::put('/Kelola_JenisTransaksi/{id}/update', [KelolaJenisTransaksiController::class, 'update'])->name('Kelola_JenisTransaksi,update');
        Route::get('/Kelola_JenisTransaksi/{id}/edit', [KelolaJenisTransaksiController::class, 'edit'])->name('Kelola_JenisTransaksi.edit');
        Route::delete('/Kelola_JenisTransaksi/{id}/delete', [KelolaJenisTransaksiController::class, 'destroy'])->name('Kelola_JenisTransaksi.Destroy');

        Route::get('/Kelola_Pengguna', [Kelola_PenggunaController::class, 'index'])->name('Kelola_Pengguna.index');
        Route::post('/Kelola_Pengguna', [Kelola_PenggunaController::class, 'store'])->name('Kelola_Pengguna.store');
        Route::put('/Kelola_Pengguna/{id}/update', [Kelola_PenggunaController::class, 'update'])->name('Kelola_Pengguna,update');
        Route::get('/Kelola_Pengguna/{id}/edit', [Kelola_PenggunaController::class, 'edit'])->name('Kelola_Pengguna.edit');
        Route::delete('/Kelola_Pengguna/{id}/delete', [Kelola_PenggunaController::class, 'destroy'])->name('Kelola_Pengguna.Destroy');
    });
    //Super Admin dan Staff
    Route::middleware(['checkrole:0,1'])->group(function(){
        Route::get('/Kelola_Masyarakat', [Kelola_MasyarakatController::class, 'index'])->name('Kelola_Masyarakat.index');
        Route::get('/Kelola_Masyarakat/{id}/detail', [Kelola_MasyarakatController::class, 'detail'])->name('Kelola_Masyarakat.detail');
        Route::put('/Kelola_Masyarakat/{id}/update', [Kelola_MasyarakatController::class, 'change_status'])->name('Kelola_Masyarakat.update');

        Route::get('/Kelola_Anggota', [Kelola_AnggotaController::class, 'index'])->name('Kelola_Anggota.index');
        Route::post('/Kelola_Anggota', [Kelola_AnggotaController::class, 'store'])->name('Kelola_Anggota.store');
        Route::put('/Kelola_Anggota/{id}/update', [Kelola_AnggotaController::class, 'update'])->name('Kelola_Anggota,update');
        Route::get('/Kelola_Anggota/{id}/edit', [Kelola_AnggotaController::class, 'edit'])->name('Kelola_Anggota.edit');
        Route::delete('/Kelola_Anggota/{id}/delete', [Kelola_AnggotaController::class, 'destroy'])->name('Kelola_Anggota.Destroy');

        // Route::get('/Kelola_Laporan', [Kelola_LaporanController::class, 'index'])->name('Kelola_JenisTransaksi.index');
        // Route::put('/Kelola_Laporan/{id}/update', [Kelola_LaporanController::class, 'change_status'])->name('Kelola_JenisTransaksi,update');

        // Route::get('/Manajemen_PengajuanAJB', [Manajemen_PengajuanController::class, 'index'])->name('Kelola_JenisTransaksi.index');
        // Route::post('/Manajemen_PengajuanAJB', [Manajemen_PengajuanController::class, 'store'])->name('Kelola_JenisTransaksi.store');
        // Route::put('/Manajemen_PengajuanAJB/{id}/update', [Manajemen_PengajuanController::class, 'update'])->name('Kelola_JenisTransaksi,update');
        // Route::get('/Manajemen_PengajuanAJB/{id}/edit', [Manajemen_PengajuanController::class, 'edit'])->name('Kelola_JenisTransaksi.edit');
        // Route::delete('/Manajemen_PengajuanAJB/{id}/delete', [Manajemen_PengajuanController::class, 'destroy'])->name('Kelola_JenisTransaksi.Destroy');
    });
    //Masyarakat
    Route::middleware(['checkrole:2','cekstatus'])->group(function(){
        Route::get('/Pembuatan_AJB', [PembuatanAJBController::class, 'index'])->name('pengguna.pembuatanajb.index');
        Route::post('/Pembuatan_AJB', [PembuatanAJBController::class, 'store'])->name('pengguna.AJB.store');
        Route::get('/Daftar_AJB', [Daftar_AJBController::class, 'index'])->name('pengguna.daftar.index');
        Route::get('/Daftar_AJB/{id}/Detail', [Daftar_AJBController::class, 'detail'])->name('pengguna.daftar.detail');
        Route::get('/Daftar_AJB/{id}/edit', [Daftar_AJBController::class, 'edit'])->name('pengguna.daftar.edit');
        Route::put('/Daftar_AJB/{id}/update', [Daftar_AJBController::class, 'update'])->name('pengguna.AJB.update');
        Route::delete('/Daftar_AJB/{id}/destroy', [Daftar_AJBController::class, 'destroy'])->name('pengguna.AJB.destroy');
        Route::get('/Daftar_AJB/{id}/download/{file}', [Daftar_AJBController::class, 'downloadBerkas'])->name('pengajuan.download');
        Route::get('/Daftar_AJB/{id}/download-zip', [Daftar_AJBController::class, 'downloadZip'])->name('pengajuan.zip');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::get('/verify', [ProfileController::class, 'verify'])->name('profile.verify');
    Route::post('/verify', [ProfileController::class, 'store'])->name('profile.store');
    Route::get('/profile/settings', [ProfileController::class, 'edit'])->name('profile.settings');
    Route::post('/profile/update-photo', [ProfileController::class, 'updatePhoto'])->name('profile.update-photo');
    Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
});

require __DIR__.'/auth.php';
