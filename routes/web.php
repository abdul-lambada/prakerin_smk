<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

// Redirect root ke halaman login admin/pembimbing
Route::get('/', function () {
    return redirect()->route('login.admin');
});

// Halaman login admin & pembimbing
Route::get('/login/admin', [AuthController::class, 'showAdminLoginForm'])->name('login.admin');
Route::post('/login/admin', [AuthController::class, 'loginAdmin'])->name('login.admin.submit');

// Halaman login siswa
Route::get('/login/siswa', [AuthController::class, 'showSiswaLoginForm'])->name('login.siswa');
Route::post('/login/siswa', [AuthController::class, 'loginSiswa'])->name('login.siswa.submit');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route dashboard, wajib login
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::middleware('role:admin')->group(function () {
        Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');
    });

    Route::middleware('role:pembimbing')->group(function () {
        Route::get('/dashboard/pembimbing', [DashboardController::class, 'pembimbing'])->name('dashboard.pembimbing');
    });

    Route::middleware('role:siswa')->group(function () {
        Route::get('/dashboard/siswa', [DashboardController::class, 'siswa'])->name('dashboard.siswa');
    });
});
