<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Siswa;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Process login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $remember = $request->has('remember');

        // Coba login dengan model User (Admin)
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            // Mengecek role user dan mengarahkan ke dashboard yang sesuai
            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('siswa.dashboard');
            }
        }

        // Jika login dengan User gagal, coba login dengan model Siswa
        $siswa = Siswa::where('email', $request->email)->first();
        
        if ($siswa && Hash::check($request->password, $siswa->password)) {
            // Jika kredensial siswa valid, buat sesi User yang sesuai
            $user = User::firstOrCreate(
                ['email' => $siswa->email],
                [
                    'name' => $siswa->nama_lengkap,
                    'password' => $siswa->password, // Password sudah di-hash
                    'role' => 'siswa',
                ]
            );
            
            Auth::login($user, $remember);
            $request->session()->regenerate();
            
            return redirect()->route('siswa.dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // Show registration form
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Process registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'siswa', // Default role untuk user baru adalah siswa
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('siswa.dashboard')->with('success', 'Registrasi berhasil!');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}