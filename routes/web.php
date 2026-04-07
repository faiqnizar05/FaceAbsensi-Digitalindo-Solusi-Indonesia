<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AbsenController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardKelasController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\IzinController;

// ==================== PUBLIC ROUTES (Semua Role) ====================

// Halaman Login
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');

// Halaman Absensi (Home) - Accessible untuk semua role
Route::get('/', [AbsenController::class, 'index'])->name('absen.index');
Route::post('/check-username', [AbsenController::class, 'checkUsername'])->name('absen.checkUsername');
Route::post('/submit-absen', [AbsenController::class, 'submitAbsen'])->name('absen.submit');

// ==================== IZIN SEKOLAH (PUBLIC) ====================
// Bisa diakses siswa tanpa login

Route::prefix('izin')->group(function () {
    // Form Izin
    Route::get('/sakit', [IzinController::class, 'izinSakit'])->name('izin.sakit');
    Route::get('/dispensasi', [IzinController::class, 'dispensasi'])->name('izin.dispensasi');
    Route::get('/urusan-keluarga', [IzinController::class, 'urusanKeluarga'])->name('izin.urusan-keluarga');
    
    // Submit Izin
    Route::post('/submit', [IzinController::class, 'submitIzin'])->name('izin.submit');
});

// ==================== PROTECTED ROUTES (Login Required) ====================

Route::middleware(['check.login'])->group(function () {
    
    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    // Dashboard Route (Admin & Guru)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ==================== DASHBOARD KELAS (Admin & Guru) ====================
    Route::prefix('dashboard')->group(function () {
        Route::get('/kelas', [DashboardKelasController::class, 'index'])->name('dashboard.kelas');
        
        // Permintaan Izin (Approval)
        Route::get('/permintaan-izin', [IzinController::class, 'permintaanIzin'])->name('dashboard.permintaan-izin');
        Route::post('/izin/{id}/update-status', [IzinController::class, 'updateStatus'])->name('izin.update-status');
    });

    // ==================== ADMIN ONLY ROUTES ====================
    Route::middleware(['check.admin'])->group(function () {
        
        Route::prefix('user')->group(function () {
            // Tambah Anggota
            Route::get('/add', [DataController::class, 'add'])->name('user.add');
            Route::post('/store', [DataController::class, 'store'])->name('user.store');
            
            // Data Anggota
            Route::get('/', [DataController::class, 'index'])->name('user.index');
            Route::delete('/{id}', [DataController::class, 'destroy'])->name('user.destroy');
        });

        // Riwayat Absensi Routes
        Route::prefix('absensi')->group(function () {
            Route::get('/history', [DataController::class, 'history'])->name('absen.history');
            Route::delete('/{id}', [DataController::class, 'destroyAbsen'])->name('absen.destroy');
        });
        
    });
    
});