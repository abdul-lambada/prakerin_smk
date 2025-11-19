<?php

use App\Http\Controllers\Admin\SiswaController as AdminSiswaController;
use App\Http\Controllers\Admin\IndustriController as AdminIndustriController;
use App\Http\Controllers\Admin\PembimbingController as AdminPembimbingController;
use App\Http\Controllers\Admin\JurusanController as AdminJurusanController;
use App\Http\Controllers\Admin\KelasController as AdminKelasController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\TempatController as AdminTempatController;
use App\Http\Controllers\Admin\InfoController as AdminInfoController;
use App\Http\Controllers\Admin\NilaiController as AdminNilaiController;
use App\Http\Controllers\Admin\SidangController as AdminSidangController;
use App\Http\Controllers\Admin\AbsensiController as AdminAbsensiController;
use App\Http\Controllers\Admin\JurnalController as AdminJurnalController;
use App\Http\Controllers\Admin\LaporanController as AdminLaporanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Redirect root ke halaman login admin/pembimbing
Route::get('/', function () {
    return redirect()->route('login.admin');
});

// Halaman login admin & pembimbing
Route::get('/login', function () {
    return redirect()->route('login.admin');
})->name('login');

Route::get('/login/admin', [AuthController::class, 'showAdminLoginForm'])->name('login.admin');
Route::post('/login/admin', [AuthController::class, 'loginAdmin'])->name('login.admin.submit');

// Halaman login siswa
Route::get('/login/siswa', [AuthController::class, 'showSiswaLoginForm'])->name('login.siswa');
Route::post('/login/siswa', [AuthController::class, 'loginSiswa'])->name('login.siswa.submit');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route dashboard & profil, wajib login
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::middleware('role:admin')->group(function () {
        Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');

        Route::resource('admin/siswa', AdminSiswaController::class)->names('admin.siswa');
        Route::resource('admin/industri', AdminIndustriController::class)->names('admin.industri');
        Route::resource('admin/pembimbing', AdminPembimbingController::class)->names('admin.pembimbing');
        Route::resource('admin/jurusan', AdminJurusanController::class)->names('admin.jurusan');
        Route::resource('admin/kelas', AdminKelasController::class)->names('admin.kelas');
        Route::resource('admin/user', AdminUserController::class)->names('admin.user');
        Route::resource('admin/tempat', AdminTempatController::class)->names('admin.tempat');
        Route::resource('admin/info', AdminInfoController::class)->names('admin.info');
        Route::resource('admin/nilai', AdminNilaiController::class)->names('admin.nilai');
        Route::resource('admin/sidang', AdminSidangController::class)->names('admin.sidang');
        Route::resource('admin/absensi', AdminAbsensiController::class)->names('admin.absensi');
        Route::resource('admin/jurnal', AdminJurnalController::class)->names('admin.jurnal');
        Route::resource('admin/laporan', AdminLaporanController::class)->names('admin.laporan');
    });

    Route::middleware('role:pembimbing')->group(function () {
        Route::get('/dashboard/pembimbing', [DashboardController::class, 'pembimbing'])->name('dashboard.pembimbing');
    });

    Route::middleware('role:siswa')->group(function () {
        Route::get('/dashboard/siswa', [DashboardController::class, 'siswa'])->name('dashboard.siswa');
    });
});
