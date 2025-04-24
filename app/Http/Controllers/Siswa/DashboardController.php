<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard siswa
     */
    public function index()
    {
        // Cek apakah user sudah login
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        
        // Cek apakah user memiliki role siswa
        if (!auth()->user()->isSiswa()) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        
        return view('siswa.dashboard');
    }
}
