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
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PembimbingSiswaController;
use App\Http\Controllers\PembimbingMonitoringController;
use App\Http\Controllers\PembimbingNilaiController;
use App\Http\Controllers\PembimbingLaporanSidangController;
use App\Http\Controllers\PembimbingInfoController;
use App\Http\Controllers\PembimbingBimbinganController;
use App\Http\Controllers\PembimbingChatDudiController;
use App\Http\Controllers\SiswaTempatController;
use App\Http\Controllers\SiswaAbsensiController;
use App\Http\Controllers\SiswaJurnalController;
use App\Http\Controllers\SiswaLaporanController;
use App\Http\Controllers\SiswaBimbinganController;
use App\Http\Controllers\SiswaInfoController;
use App\Http\Controllers\DudiSiswaController;
use App\Http\Controllers\DudiNilaiController;
use App\Http\Controllers\DudiChatController;
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

// Halaman login DUDI (menggunakan handler yang sama dengan login admin/pembimbing)
Route::get('/login/dudi', [AuthController::class, 'showDudiLoginForm'])->name('login.dudi');
Route::post('/login/dudi', [AuthController::class, 'loginAdmin'])->name('login.dudi.submit');

// Registrasi DUDI
Route::get('/register/dudi', [AuthController::class, 'showDudiRegisterForm'])->name('register.dudi');
Route::post('/register/dudi', [AuthController::class, 'registerDudi'])->name('register.dudi.submit');

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
        Route::get('admin/settings', [AdminSettingController::class, 'index'])->name('admin.settings.index');
        Route::put('admin/settings', [AdminSettingController::class, 'update'])->name('admin.settings.update');
    });

    Route::middleware('role:pembimbing')->group(function () {
        Route::get('/dashboard/pembimbing', [DashboardController::class, 'pembimbing'])->name('dashboard.pembimbing');
        Route::get('/pembimbing/siswa-bimbingan', [PembimbingSiswaController::class, 'index'])->name('pembimbing.siswa-bimbingan.index');
        Route::get('/pembimbing/monitoring', [PembimbingMonitoringController::class, 'index'])->name('pembimbing.monitoring.index');
        Route::get('/pembimbing/nilai', [PembimbingNilaiController::class, 'index'])->name('pembimbing.nilai.index');
        Route::get('/pembimbing/nilai/{tempat}', [PembimbingNilaiController::class, 'edit'])->name('pembimbing.nilai.edit');
        Route::post('/pembimbing/nilai/{tempat}', [PembimbingNilaiController::class, 'save'])->name('pembimbing.nilai.save');
        Route::get('/pembimbing/laporan-sidang', [PembimbingLaporanSidangController::class, 'index'])->name('pembimbing.laporan-sidang.index');
        Route::get('/pembimbing/chat-dudi', [PembimbingChatDudiController::class, 'index'])->name('pembimbing.chat-dudi.index');
        Route::get('/pembimbing/chat-dudi/{dudi}', [PembimbingChatDudiController::class, 'show'])->name('pembimbing.chat-dudi.show');
        Route::post('/pembimbing/chat-dudi/{dudi}', [PembimbingChatDudiController::class, 'store'])->name('pembimbing.chat-dudi.store');
        Route::get('/pembimbing/info', [PembimbingInfoController::class, 'index'])->name('pembimbing.info.index');
        Route::get('/pembimbing/bimbingan/{tempat}', [PembimbingBimbinganController::class, 'show'])->name('pembimbing.bimbingan.show');
        Route::post('/pembimbing/bimbingan/{tempat}', [PembimbingBimbinganController::class, 'store'])->name('pembimbing.bimbingan.store');
    });

    Route::middleware('role:siswa')->group(function () {
        Route::get('/dashboard/siswa', [DashboardController::class, 'siswa'])->name('dashboard.siswa');
        Route::get('/siswa/tempat', [SiswaTempatController::class, 'index'])->name('siswa.tempat.index');
        Route::get('/siswa/absensi', [SiswaAbsensiController::class, 'index'])->name('siswa.absensi.index');
        Route::get('/siswa/absensi/create', [SiswaAbsensiController::class, 'create'])->name('siswa.absensi.create');
        Route::post('/siswa/absensi', [SiswaAbsensiController::class, 'store'])->name('siswa.absensi.store');
        Route::get('/siswa/jurnal', [SiswaJurnalController::class, 'index'])->name('siswa.jurnal.index');
        Route::get('/siswa/jurnal/create', [SiswaJurnalController::class, 'create'])->name('siswa.jurnal.create');
        Route::post('/siswa/jurnal', [SiswaJurnalController::class, 'store'])->name('siswa.jurnal.store');
        Route::get('/siswa/laporan', [SiswaLaporanController::class, 'index'])->name('siswa.laporan.index');
        Route::get('/siswa/laporan/create', [SiswaLaporanController::class, 'create'])->name('siswa.laporan.create');
        Route::post('/siswa/laporan', [SiswaLaporanController::class, 'store'])->name('siswa.laporan.store');
        Route::get('/siswa/bimbingan', [SiswaBimbinganController::class, 'index'])->name('siswa.bimbingan.index');
        Route::get('/siswa/bimbingan/{tempat}', [SiswaBimbinganController::class, 'show'])->name('siswa.bimbingan.show');
        Route::post('/siswa/bimbingan/{tempat}', [SiswaBimbinganController::class, 'store'])->name('siswa.bimbingan.store');
        Route::get('/siswa/info', [SiswaInfoController::class, 'index'])->name('siswa.info.index');
    });

    Route::middleware('role:dudi')->group(function () {
        Route::get('/dashboard/dudi', [DashboardController::class, 'dudi'])->name('dashboard.dudi');
        Route::get('/dudi/siswa-pkl', [DudiSiswaController::class, 'index'])->name('dudi.siswa.index');
        Route::get('/dudi/nilai/{tempat}', [DudiNilaiController::class, 'edit'])->name('dudi.nilai.edit');
        Route::post('/dudi/nilai/{tempat}', [DudiNilaiController::class, 'update'])->name('dudi.nilai.update');
        Route::get('/dudi/chat', [DudiChatController::class, 'index'])->name('dudi.chat.index');
        Route::post('/dudi/chat', [DudiChatController::class, 'store'])->name('dudi.chat.store');
    });
});
