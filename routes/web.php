<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SiswaAuthController;
use App\Http\Controllers\PendaftaranSiswaController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [StudentController::class, 'index'])->name('dashboard');
    Route::resource('students', StudentController::class);
});

// Rute untuk siswa
Route::middleware('guest:siswa')->group(function () {
    Route::get('/siswa/login', [SiswaAuthController::class, 'showLoginForm'])->name('siswa.login');
    Route::post('/siswa/login', [SiswaAuthController::class, 'login'])->name('siswa.login.post');
});

Route::middleware('auth:siswa')->prefix('siswa')->group(function () {
    Route::post('/logout', [SiswaAuthController::class, 'logout'])->name('siswa.logout');
    
    // Rute pendaftaran siswa
    Route::get('/pendaftaran', [PendaftaranSiswaController::class, 'index'])->name('siswa.pendaftaran');
    
    // Step 1 - Data Siswa
    Route::get('/pendaftaran/step1', [PendaftaranSiswaController::class, 'step1'])->name('siswa.pendaftaran.step1');
    Route::post('/pendaftaran/step1', [PendaftaranSiswaController::class, 'storeStep1']);
    
    // Step 2 - Jalur Pendaftaran
    Route::get('/pendaftaran/step2', [PendaftaranSiswaController::class, 'step2'])->name('siswa.pendaftaran.step2');
    Route::post('/pendaftaran/step2', [PendaftaranSiswaController::class, 'storeStep2']);
    
    // Step 3 - Data Wali Siswa
    Route::get('/pendaftaran/step3', [PendaftaranSiswaController::class, 'step3'])->name('siswa.pendaftaran.step3');
    Route::post('/pendaftaran/step3', [PendaftaranSiswaController::class, 'storeStep3']);
    
    // Finish
    Route::get('/pendaftaran/finish', [PendaftaranSiswaController::class, 'finish'])->name('siswa.pendaftaran.finish');
});