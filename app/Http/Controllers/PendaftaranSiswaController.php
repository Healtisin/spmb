<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Student;
use App\Models\DetailSiswa;

class PendaftaranSiswaController extends Controller
{
    public function index()
    {
        $student = Auth::guard('siswa')->user();
        $detail = $student->detailSiswa;
        
        return view('pendaftaran_siswa.index', compact('student', 'detail'));
    }
    
    public function step1()
    {
        $student = Auth::guard('siswa')->user();
        $detail = $student->detailSiswa;
        
        return view('pendaftaran_siswa.step1', compact('student', 'detail'));
    }
    
    public function storeStep1(Request $request)
    {
        $request->validate([
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'no_reg_akta_lahir' => 'required|string|max:255',
            'agama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'kelurahan' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kabupaten' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
            'jalur_pendaftaran' => 'required|string|in:Jalur Afirmasi,Jalur Prestasi,Jalur Domisili,Jalur Mutasi',
            'bukti_kk' => 'nullable|file|mimes:pdf,jpeg,jpg|max:2048',
        ]);
        
        $student = Auth::guard('siswa')->user();
        $detail = $student->detailSiswa;
        
        $data = $request->except('bukti_kk');
        
        // Upload file jika ada
        if ($request->hasFile('bukti_kk')) {
            // Hapus file lama jika ada
            if ($detail->bukti_kk) {
                Storage::delete('public/bukti_kk/' . $detail->bukti_kk);
            }
            
            $file = $request->file('bukti_kk');
            $filename = $student->nisn . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/bukti_kk', $filename);
            
            $data['bukti_kk'] = $filename;
        }
        
        $detail->update($data);
        
        return redirect()->route('siswa.pendaftaran.step2')
                         ->with('success', 'Data siswa berhasil disimpan');
    }
    
    public function step2()
    {
        $student = Auth::guard('siswa')->user();
        $detail = $student->detailSiswa;
        
        return view('pendaftaran_siswa.step2', compact('student', 'detail'));
    }
    
    public function storeStep2(Request $request)
    {
        $request->validate([
            'dokumen_pendukung' => 'nullable|file|mimes:pdf,jpeg,jpg|max:2048',
            'keterangan_pendukung' => 'required|string',
        ]);
        
        $student = Auth::guard('siswa')->user();
        $detail = $student->detailSiswa;
        
        $data = $request->except('dokumen_pendukung');
        
        // Upload file jika ada
        if ($request->hasFile('dokumen_pendukung')) {
            // Hapus file lama jika ada
            if ($detail->dokumen_pendukung) {
                Storage::delete('public/dokumen_pendukung/' . $detail->dokumen_pendukung);
            }
            
            $file = $request->file('dokumen_pendukung');
            $filename = $student->nisn . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/dokumen_pendukung', $filename);
            
            $data['dokumen_pendukung'] = $filename;
        }
        
        $detail->update($data);
        
        return redirect()->route('siswa.pendaftaran.step3')
                         ->with('success', 'Data jalur pendaftaran berhasil disimpan');
    }
    
    public function step3()
    {
        $student = Auth::guard('siswa')->user();
        $detail = $student->detailSiswa;
        
        return view('pendaftaran_siswa.step3', compact('student', 'detail'));
    }
    
    public function storeStep3(Request $request)
    {
        $request->validate([
            'nama_ayah' => 'required|string|max:255',
            'nik_ayah' => 'required|string|max:255',
            'pendidikan_ayah' => 'required|string|max:255',
            'pekerjaan_ayah' => 'required|string|max:255',
            'penghasilan_ayah' => 'required|string|max:255',
            'no_hp_ayah' => 'required|string|max:255',
            
            'nama_ibu' => 'required|string|max:255',
            'nik_ibu' => 'required|string|max:255',
            'pendidikan_ibu' => 'required|string|max:255',
            'pekerjaan_ibu' => 'required|string|max:255',
            'penghasilan_ibu' => 'required|string|max:255',
            'no_hp_ibu' => 'required|string|max:255',
            
            'nama_wali' => 'nullable|string|max:255',
            'nik_wali' => 'nullable|string|max:255',
            'pendidikan_wali' => 'nullable|string|max:255',
            'pekerjaan_wali' => 'nullable|string|max:255',
            'penghasilan_wali' => 'nullable|string|max:255',
            'no_hp_wali' => 'nullable|string|max:255',
        ]);
        
        $student = Auth::guard('siswa')->user();
        $detail = $student->detailSiswa;
        
        $data = $request->all();
        $data['status_pendaftaran'] = 'submitted';
        
        $detail->update($data);
        
        return redirect()->route('siswa.pendaftaran.finish')
                         ->with('success', 'Data wali siswa berhasil disimpan');
    }
    
    public function finish()
    {
        $student = Auth::guard('siswa')->user();
        $detail = $student->detailSiswa;
        
        return view('pendaftaran_siswa.finish', compact('student', 'detail'));
    }
}
