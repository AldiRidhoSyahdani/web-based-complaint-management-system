<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PengaduanController;

// ADMIN CONTROLLERS
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminPengaduanController;
use App\Http\Controllers\Admin\AdminStatistikController;
use App\Http\Controllers\Admin\AdminAkunController;

/*
|--------------------------------------------------------------------------
| HALAMAN UTAMA — LANGSUNG KE LOGIN
|--------------------------------------------------------------------------
*/
Route::redirect('/', '/login');

/*
|--------------------------------------------------------------------------
| FORM PENGADUAN — BOLEH TANPA LOGIN
|--------------------------------------------------------------------------
*/
Route::get('/form', [PengaduanController::class, 'form'])->name('form');
Route::post('/form/kirim', [PengaduanController::class, 'store'])->name('pengaduan.store');

/*
|--------------------------------------------------------------------------
| AUTH MASYARAKAT
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])
     ->middleware('auth')
     ->name('logout');

/*
|--------------------------------------------------------------------------
| DASHBOARD USER
|--------------------------------------------------------------------------
*/
Route::get('/home', [HomeController::class, 'index'])
     ->middleware('auth')
     ->name('home');

/*
|--------------------------------------------------------------------------
| DETAIL PENGADUAN MASYARAKAT — HANYA UNTUK YANG LOGIN & MILIK SENDIRI
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/pengaduan/{pengaduan}', [PengaduanController::class, 'show'])
         ->name('pengaduan.show');
});

/*
|--------------------------------------------------------------------------
| ADMIN AREA — GUARD admin
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {

    // === LOGIN ADMIN ===
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
    });

    // === AREA ADMIN (HARUS LOGIN ADMIN) ===
    Route::middleware('auth:admin')->group(function () {

        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

        Route::get('/dashboard', [AdminPengaduanController::class, 'dashboard'])->name('dashboard');

        Route::get('/pengaduan/export-pdf', [AdminPengaduanController::class, 'exportPdf'])
             ->name('pengaduan.exportPdf');

        Route::get('/pengaduan', [AdminPengaduanController::class, 'index'])
             ->name('pengaduan.index');

        Route::get('/pengaduan/{id}', [AdminPengaduanController::class, 'show'])
             ->name('pengaduan.show');

        Route::patch('/pengaduan/{pengaduan}/status', [AdminPengaduanController::class, 'updateStatus'])
             ->name('pengaduan.status');

        Route::get('/statistik', [AdminStatistikController::class, 'index'])->name('statistik.index');
        Route::get('/akun', [AdminAkunController::class, 'index'])->name('akun.index');
    });
});
