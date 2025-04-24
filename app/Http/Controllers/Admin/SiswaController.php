<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Siswa::query();

        // Implementasi search
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('nisn', 'like', "%{$searchTerm}%")
                  ->orWhere('nama_lengkap', 'like', "%{$searchTerm}%")
                  ->orWhere('email', 'like', "%{$searchTerm}%")
                  ->orWhere('nomor_hp', 'like', "%{$searchTerm}%")
                  ->orWhere('nik', 'like', "%{$searchTerm}%");
            });
        }

        // Filter berdasarkan bulan (jika ada)
        if ($request->has('month') && !empty($request->month)) {
            $query->whereMonth('created_at', $request->month);
        }

        // Filter berdasarkan hari (jika ada)
        if ($request->has('day') && !empty($request->day)) {
            $query->whereDate('created_at', $request->day);
        }

        $siswas = $query->latest()->paginate(20);
        return view('admin.siswa.index', compact('siswas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.siswa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nisn' => 'required|unique:siswas,nisn',
            'nik' => 'required|string|size:16|unique:siswas,nik',
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:siswas,email',
            'nomor_hp' => 'required|string|max:15',
            'password' => 'required|string|min:6',
        ]);

        Siswa::create([
            'nisn' => $request->nisn,
            'nik' => $request->nik,
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'nomor_hp' => $request->nomor_hp,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil ditambahkan. Siswa dapat login menggunakan email dan password yang telah didaftarkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Siswa $siswa)
    {
        return view('admin.siswa.edit', compact('siswa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'nisn' => 'required|unique:siswas,nisn,' . $siswa->id,
            'nik' => 'required|string|size:16|unique:siswas,nik,' . $siswa->id,
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:siswas,email,' . $siswa->id,
            'nomor_hp' => 'required|string|max:15',
            'password' => 'nullable|string|min:6',
        ]);

        $data = $request->except('password');
        
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $siswa->update($data);

        $message = 'Data siswa berhasil diperbarui.';
        if ($request->filled('password')) {
            $message .= ' Password untuk login juga telah diperbarui.';
        }

        return redirect()->route('admin.siswa.index')
            ->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Siswa $siswa)
    {
        $siswa->delete();

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil dihapus.');
    }
}
