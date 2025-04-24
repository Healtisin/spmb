<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;
use Illuminate\Support\Facades\Route;

// Redirect root to login
Route::redirect('/', '/login');

// Guest routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Protected routes
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Dashboard
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
Route::resource('/admin/siswa', SiswaController::class)->names([
    'index' => 'admin.siswa.index',
    'create' => 'admin.siswa.create',
    'store' => 'admin.siswa.store',
    'edit' => 'admin.siswa.edit',
    'update' => 'admin.siswa.update',
    'destroy' => 'admin.siswa.destroy',
])->except(['show']);

// Siswa Dashboard
Route::get('/siswa/dashboard', [SiswaDashboardController::class, 'index'])->name('siswa.dashboard');

// Fallback route for dashboard (will be redirected based on role)
Route::get('/dashboard', function () {
    if (!auth()->check()) {
        return redirect()->route('login');
    }
    
    if (auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    } else {
        return redirect()->route('siswa.dashboard');
    }
})->name('dashboard');