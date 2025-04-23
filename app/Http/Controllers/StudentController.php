<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::all();
        return view('dashboard', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('students.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nisn' => 'required|string|unique:students',
            'nik' => 'required|string|unique:students',
            'nama_lengkap' => 'required|string',
            'email' => 'required|email|unique:students',
            'nomor_hp' => 'required|string',
        ]);

        $student = new Student();
        $student->nisn = $request->nisn;
        $student->nik = $request->nik;
        $student->nama_lengkap = $request->nama_lengkap;
        $student->email = $request->email;
        $student->nomor_hp = $request->nomor_hp;
        $student->password = Hash::make($request->nik); // Default password is NIK
        $student->save();

        return redirect()->route('dashboard')->with('success', 'Data siswa berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $student = Student::findOrFail($id);
        return view('students.edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $student = Student::findOrFail($id);

        $request->validate([
            'nisn' => 'required|string|unique:students,nisn,' . $id,
            'nik' => 'required|string|unique:students,nik,' . $id,
            'nama_lengkap' => 'required|string',
            'email' => 'required|email|unique:students,email,' . $id,
            'nomor_hp' => 'required|string',
        ]);

        $student->nisn = $request->nisn;
        $student->nik = $request->nik;
        $student->nama_lengkap = $request->nama_lengkap;
        $student->email = $request->email;
        $student->nomor_hp = $request->nomor_hp;
        
        // Reset password jika diperlukan
        if ($request->has('reset_password')) {
            $student->password = Hash::make($request->nik);
        }
        
        $student->save();

        return redirect()->route('dashboard')->with('success', 'Data siswa berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect()->route('dashboard')->with('success', 'Data siswa berhasil dihapus');
    }
}
