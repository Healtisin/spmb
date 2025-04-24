<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard admin
     */
    public function index()
    {
        // Cek apakah user sudah login
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        
        // Cek apakah user memiliki role admin
        if (!auth()->user()->isAdmin()) {
            return redirect()->route('siswa.dashboard')
                ->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        
        // Redirect ke halaman siswa
        return redirect()->route('admin.siswa.index');
    }
}
