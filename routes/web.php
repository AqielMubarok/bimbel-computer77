<?php

use App\Exports\PembayaranExport;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\KumpulTugasController;
use App\Http\Controllers\NilaiController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\Crypt;

// Public Routes
Route::get('/Computer77', function () { return view('pages.app.LandingPage.landing'); })->middleware('guest')->name('landing');

// Rute Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Rute Register
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Rute Forgot Password
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
    ->middleware('guest')
    ->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->middleware('guest')
    ->name('password.email');

// Rute Reset Password    
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])
    ->middleware('guest')
    ->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])
    ->middleware('guest')
    ->name('password.update');

// Rute Middleware Auth
Route::middleware(['auth'])->group(function () {
    // Rute Dashboard
    Route::get('/home', function () {
        $role = auth()->user()->rul;
        if (in_array($role, ['ADMIN', 'PEMATERI'])) {
            return redirect()->route('dashboard');
        } elseif ($role === 'PESERTA') {
            return redirect()->route('dashboard_lms');
        } else {
            return redirect()->route('login')->with('error', 'Akses tidak sah.');
        }
    })->name('home');

    // Rute Profil
    Route::get('/profil', function () { return view('pages.Profile.UserProfile'); })->name('pages.Profile.UserProfile');

    // Rute Logout
    Route::post('/Computer77/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('landing');
    })->name('custom-logout');

    // Rute Ganti Password
    Route::get('/password/change', function () { return view('pages.auth.auth-ganti-password'); })->name('password.change');
    Route::put('/user/password', [ConfirmPasswordController::class, 'updatePassword'])->name('user-password.update');

    // Rute peserta
    Route::middleware(['peserta'])->group(function () {
        // Rute Dashboard Peserta
        Route::get('/dashboard_lms', function () { return view('pages.app.dashboard_lms'); })->name('dashboard_lms');
    });

    // Rute admin
    Route::middleware(['admin'])->group(function () {
        // Rute Dashboard Admin
        Route::get('/dashboard', function () { return view('pages.app.dashboard_admin'); })->name('dashboard');
        // Rute Materi
        Route::get('/lecturer/create', [LecturerController::class, 'create'])->name('lecturer.create');
        Route::get('/lecturer/{lecturer}/edit', [LecturerController::class, 'edit'])->name('lecturer.edit');
        Route::post('/lecturer', [LecturerController::class, 'store'])->name('lecturer.store');
        Route::put('/lecturer/{lecturer}', [LecturerController::class, 'update'])->name('lecturer.update');
        Route::delete('/lecturer/{lecturer}', [LecturerController::class, 'destroy'])->name('lecturer.destroy');
        // Rute Tugas
        Route::get('/tugas/create', [TugasController::class, 'create'])->name('tugas.create');
        // Rute Kumpul Tugas
        Route::get('/kumpul/index', [KumpulTugasController::class, 'index'])->name('kumpul.index');
        // Rute Nilai
        Route::get('/nilai', [NilaiController::class, 'index'])->name('nilai.index');
        Route::get('nilai/{encryptedId}/create', [NilaiController::class, 'create'])->name('nilai.create');
        Route::get('/nilai/{id}/edit', [NilaiController::class, 'edit'])->name('nilai.edit');
    });

    // Rute pemateri
    Route::middleware(['pemateri'])->group(function () {
        //Kosong
    });

    // Rute CheckAccess All User dan membutuhkan pembayaran di Approved untuk Peserta
    Route::middleware(['auth', 'checkAccess', 'checkPaymentStatus'])->group(function () {
        Route::get('/lecturer', [LecturerController::class, 'index'])->name('lecturer.index');
        Route::get('/tugas', [TugasController::class, 'index'])->name('tugas.index');
        Route::get('/lihatnilai', [NilaiController::class, 'lihatnilai'])->name('lihatnilai.index');
        Route::get('/kumpul/create', [KumpulTugasController::class, 'create'])->name('kumpul.create');
        Route::get('/pembayaran/history', [PembayaranController::class, 'history'])->name('pembayaran.history'); // Pindahkan ke sini
    });

    // Rute CheckAccess Peserta dan bisa diakses sebelum pembayaran
    Route::middleware(['checkAccess', 'checkPaymentStatus'])->group(function () {
        // Rute Pilih Paket
        Route::get('/paket', function () {return view('pages.Pembayaran.paket');})->name('pages.Pembayaran.paket');
        // Rute Form Pembayaran
        Route::get('/form.bayar', [PembayaranController::class, 'formBayar'])->name('form.bayar');
    });

    // Rute CheckAccess Admin
    Route::middleware(['auth', 'checkAccess'])->group(function () {
        // Rute User (Admin)
        Route::resource('user', UserController::class); 
        Route::get('user/{encryptedId}/edit', [UserController::class, 'edit'])->name('user.edit.encrypted');
        // Rute Pembayaran (Admin)
        Route::get('pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');
        Route::get('/pembayaran/{id}/edit', [PembayaranController::class, 'edit'])->name('pembayaran.edit');
    });
    
    // Rute Tugas
    Route::post('tugas', [TugasController::class, 'store'])->name('tugas.store');
    Route::get('tugas/{learning}/edit', [TugasController::class, 'edit'])->name('tugas.edit');
    Route::put('tugas/{learning}', [TugasController::class, 'update'])->name('tugas.update');
    Route::delete('tugas/{learning}', [TugasController::class, 'destroy'])->name('tugas.destroy');
    Route::get('tugas/download/{learning}', [TugasController::class, 'download'])->name('tugas.download');

    // Rute Kumpul Tugas 
    Route::post('kumpul', [KumpulTugasController::class, 'store'])->name('kumpul.store');
    Route::delete('kumpul/{id}', [KumpulTugasController::class, 'destroy'])->name('kumpul.destroy');
    Route::get('kumpul/download/{id}', [KumpulTugasController::class, 'download'])->name('kumpul.download');

    // Rute Nilai
    Route::post('/nilai/store', [NilaiController::class, 'store'])->name('nilai.store');
    Route::get('nilai/sertifikat/{id}', [NilaiController::class, 'downloadCertificate'])->name('nilai.downloadCertificate');
    Route::put('/nilai/{id}', [NilaiController::class, 'update'])->name('nilai.update');
    Route::delete('/nilai/{id}', [NilaiController::class, 'destroy'])->name('nilai.destroy');
    
    // Rute Pembayaran
    Route::post('/bayar', [PembayaranController::class, 'StorePembayaranRequest'])->name('pembayaran.store');
    Route::get('/formbayar/download/{id}', [PembayaranController::class, 'download'])->name('formbayar.download');
    Route::put('/pembayaran/{id}', [PembayaranController::class, 'update'])->name('pembayaran.update');
    Route::delete('/pembayaran/{pembayaran}', [PembayaranController::class, 'destroy'])->name('pembayaran.destroy');
    Route::get('/Pembayaran/export', function () {
        return Excel::download(new PembayaranExport, 'Pembayaran.xlsx');
    })->name('Pembayaran.export');
    Route::get('/pembayaran/print/{id}', [PembayaranController::class, 'printStruk'])->name('pembayaran.print');
});