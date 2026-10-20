<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AbsenController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardKelasController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\IzinController;


// =====================================================
// PUBLIC ROUTES
// =====================================================

// ==================== LOGIN ====================

Route::get('/login', [LoginController::class, 'index'])
    ->name('login');

Route::post('/login', [LoginController::class, 'authenticate'])
    ->name('login.authenticate');


// ==================== ABSENSI PUBLIC ====================

// Halaman Absensi
Route::get('/', [AbsenController::class, 'index'])
    ->name('absen.index');

// Check data peserta
Route::post('/check-username', [AbsenController::class, 'checkUsername'])
    ->name('absen.checkUsername');

// Submit absensi
Route::post('/submit-absen', [AbsenController::class, 'submitAbsen'])
    ->name('absen.submit');


// =====================================================
// IZIN SEKOLAH - PUBLIC
// =====================================================

Route::prefix('izin')->group(function () {

    // Form Izin Sakit
    Route::get(
        '/sakit',
        [IzinController::class, 'izinSakit']
    )->name('izin.sakit');


    // Form Dispensasi
    Route::get(
        '/dispensasi',
        [IzinController::class, 'dispensasi']
    )->name('izin.dispensasi');


    // Form Urusan Keluarga
    Route::get(
        '/urusan-keluarga',
        [IzinController::class, 'urusanKeluarga']
    )->name('izin.urusan-keluarga');


    // Submit Izin
    Route::post(
        '/submit',
        [IzinController::class, 'submitIzin']
    )->name('izin.submit');

});


// =====================================================
// PROTECTED ROUTES
// =====================================================

Route::middleware(['check.login'])->group(function () {


    // =================================================
    // LOGOUT
    // =================================================

    Route::post(
        '/logout',
        [LoginController::class, 'logout']
    )->name('logout');


    // =================================================
    // DASHBOARD
    // =================================================

    Route::get(
        '/dashboard',
        [DashboardController::class, 'index']
    )->name('dashboard');


    // =================================================
    // DASHBOARD KELAS
    // =================================================

    Route::prefix('dashboard')->group(function () {


        // Dashboard Kelas
        Route::get(
            '/kelas',
            [DashboardKelasController::class, 'index']
        )->name('dashboard.kelas');


        // Permintaan Izin
        Route::get(
            '/permintaan-izin',
            [IzinController::class, 'permintaanIzin']
        )->name('dashboard.permintaan-izin');


        // Update Status Izin
        Route::post(
            '/izin/{id}/update-status',
            [IzinController::class, 'updateStatus']
        )->name('izin.update-status');

    });


    // =================================================
    // ADMIN ONLY
    // =================================================

    Route::middleware(['check.admin'])->group(function () {


        // =================================================
        // DATA USER / ANGGOTA
        // =================================================

        Route::prefix('user')->group(function () {


            // -----------------------------------------
            // Tambah Anggota
            // -----------------------------------------

            Route::get(
                '/add',
                [DataController::class, 'add']
            )->name('user.add');


            // -----------------------------------------
            // Simpan Anggota
            // -----------------------------------------

            Route::post(
                '/store',
                [DataController::class, 'store']
            )->name('user.store');


            // -----------------------------------------
            // EXPORT DATA ANGGOTA
            // -----------------------------------------

            Route::get(
                '/export-excel',
                [DataController::class, 'exportExcel']
            )->name('user.export.excel');


            // -----------------------------------------
            // Data Anggota
            // -----------------------------------------

            Route::get(
                '/',
                [DataController::class, 'index']
            )->name('user.index');


            // -----------------------------------------
            // Hapus Anggota
            // -----------------------------------------

            Route::delete(
                '/{id}',
                [DataController::class, 'destroy']
            )->name('user.destroy');

        });


        // =================================================
        // RIWAYAT ABSENSI
        // =================================================

        Route::prefix('absensi')->group(function () {


            // -----------------------------------------
            // Riwayat Absensi
            // -----------------------------------------

            Route::get(
                '/history',
                [DataController::class, 'history']
            )->name('absen.history');


            // -----------------------------------------
            // EXPORT RIWAYAT ABSENSI KE EXCEL
            // -----------------------------------------

            Route::get(
                '/export-excel',
                [DataController::class, 'exportAbsensiExcel']
            )->name('absen.export.excel');


            // -----------------------------------------
            // Hapus Riwayat Absensi
            // -----------------------------------------

            Route::delete(
                '/{id}',
                [DataController::class, 'destroyAbsen']
            )->name('absen.destroy');

        });

    });

});