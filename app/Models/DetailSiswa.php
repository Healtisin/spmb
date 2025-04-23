<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailSiswa extends Model
{
    protected $table = 'detail_siswa';
    
    protected $fillable = [
        'student_id',
        'tempat_lahir',
        'tanggal_lahir',
        'no_reg_akta_lahir',
        'agama',
        'alamat',
        'kelurahan',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'bukti_kk',
        'jalur_pendaftaran',
        'dokumen_pendukung',
        'keterangan_pendukung',
        'nama_ayah',
        'nik_ayah',
        'pendidikan_ayah',
        'pekerjaan_ayah',
        'penghasilan_ayah',
        'no_hp_ayah',
        'nama_ibu',
        'nik_ibu',
        'pendidikan_ibu',
        'pekerjaan_ibu',
        'penghasilan_ibu',
        'no_hp_ibu',
        'nama_wali',
        'nik_wali',
        'pendidikan_wali',
        'pekerjaan_wali',
        'penghasilan_wali',
        'no_hp_wali',
        'status_pendaftaran',
    ];
    
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
