<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
        
        // Debugging CSRF token
        Log::info('CSRF token in session: ' . $request->session()->token());
        Log::info('CSRF token in request: ' . $request->input('_token'));
        
        // Debugging auth attempt
        Log::info('Attempting auth with credentials', ['nik' => $credentials['nik']]);
        
        if (Auth::guard('siswa')->attempt($credentials)) {
            Log::info('Auth successful for NIK: ' . $credentials['nik']);
            $request->session()->regenerate();
            
            // Periksa apakah sudah memiliki detail atau belum
            $student = Auth::guard('siswa')->user();
            $detailSiswa = DetailSiswa::where('student_id', $student->id)->first();
            
            if (!$detailSiswa) {
                // Jika belum ada detail, buat detail baru
                Log::info('Creating new detail record for student ID: ' . $student->id);
                DetailSiswa::create([
                    'student_id' => $student->id,
                    'status_pendaftaran' => 'draft'
                ]);
            }
            
            return redirect()->intended(route('siswa.pendaftaran'));
        }
        
        Log::warning('Auth failed for NIK: ' . $credentials['nik']);
        
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
