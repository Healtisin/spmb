<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\DetailSiswa;

class SiswaAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.siswa.login');
    }
    
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'nik' => 'required|string',
            'password' => 'required|string',
        ]);
        
        if (Auth::guard('siswa')->attempt($credentials)) {
            $request->session()->regenerate();
            
            // Periksa apakah sudah memiliki detail atau belum
            $student = Auth::guard('siswa')->user();
            $detailSiswa = DetailSiswa::where('student_id', $student->id)->first();
            
            if (!$detailSiswa) {
                // Jika belum ada detail, buat detail baru
                DetailSiswa::create([
                    'student_id' => $student->id,
                    'status_pendaftaran' => 'draft'
                ]);
            }
            
            return redirect()->intended(route('siswa.pendaftaran'));
        }
        
        return back()->withErrors([
            'nik' => 'NIK atau password salah',
        ])->withInput($request->only('nik'));
    }
    
    public function logout(Request $request)
    {
        Auth::guard('siswa')->logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('siswa.login');
    }
}
