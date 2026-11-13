<?php

use App\Http\Controllers\AkademikController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('login'));

// Route Autentikasi (Guest & Logout)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Route Terlindungi Autentikasi & Role Middleware (CheckRole)
Route::middleware(['auth'])->group(function () {

    // Dashboard Utama (Admin, Dosen, Mahasiswa)
    Route::get('/dashboard', [AkademikController::class, 'dashboard'])
        ->middleware('role:admin,dosen,mahasiswa')
        ->name('dashboard');

    // 1. Route Manajemen Pengguna — Hanya Admin (role:admin)
    Route::middleware('role:admin')->group(function () {
        Route::get('/users', [AkademikController::class, 'usersIndex'])->name('users.index');
        Route::post('/users', [AkademikController::class, 'usersStore'])->name('users.store');
    });

    // 2. Route Materi Perkuliahan
    // Akses Lihat Materi: Admin, Dosen, Mahasiswa
    Route::get('/materi', [AkademikController::class, 'materiIndex'])
        ->middleware('role:admin,dosen,mahasiswa')
        ->name('materi.index');

    // Akses Tambah & Hapus Materi: Hanya Admin & Dosen (Mahasiswa -> 403 Forbidden)
    Route::middleware('role:admin,dosen')->group(function () {
        Route::post('/materi', [AkademikController::class, 'materiStore'])->name('materi.store');
        Route::delete('/materi/{materi}', [AkademikController::class, 'materiDestroy'])->name('materi.destroy');
    });

    // 3. Route Nilai Akademik
    // Akses Lihat Nilai / Transkrip: Admin, Dosen, Mahasiswa
    Route::get('/nilai', [AkademikController::class, 'nilaiIndex'])
        ->middleware('role:admin,dosen,mahasiswa')
        ->name('nilai.index');

    // Akses Input & Kelola Nilai: Hanya Admin & Dosen (Mahasiswa -> 403 Forbidden)
    Route::middleware('role:admin,dosen')->group(function () {
        Route::get('/nilai/manage', [AkademikController::class, 'nilaiIndex'])->name('nilai.manage');
        Route::post('/nilai/manage', [AkademikController::class, 'nilaiStore'])->name('nilai.store');
    });
});
