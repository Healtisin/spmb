<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = [
            [
                'nisn' => '1001001001',
                'nik' => '3573021234567001',
                'nama_lengkap' => 'Budi Santoso',
                'email' => 'budi.santoso@example.com',
                'nomor_hp' => '081234567001',
                'password' => Hash::make('3573021234567001'),
            ],
            [
                'nisn' => '1001001002',
                'nik' => '3573021234567002',
                'nama_lengkap' => 'Ani Wijaya',
                'email' => 'ani.wijaya@example.com',
                'nomor_hp' => '081234567002',
                'password' => Hash::make('3573021234567002'),
            ],
            [
                'nisn' => '1001001003',
                'nik' => '3573021234567003',
                'nama_lengkap' => 'Chandra Kusuma',
                'email' => 'chandra.kusuma@example.com',
                'nomor_hp' => '081234567003',
                'password' => Hash::make('3573021234567003'),
            ],
            [
                'nisn' => '1001001004',
                'nik' => '3573021234567004',
                'nama_lengkap' => 'Dewi Anggraini',
                'email' => 'dewi.anggraini@example.com',
                'nomor_hp' => '081234567004',
                'password' => Hash::make('3573021234567004'),
            ],
            [
                'nisn' => '1001001005',
                'nik' => '3573021234567005',
                'nama_lengkap' => 'Eko Prasetyo',
                'email' => 'eko.prasetyo@example.com',
                'nomor_hp' => '081234567005',
                'password' => Hash::make('3573021234567005'),
            ],
            [
                'nisn' => '1001001006',
                'nik' => '3573021234567006',
                'nama_lengkap' => 'Fitri Nurhayati',
                'email' => 'fitri.nurhayati@example.com',
                'nomor_hp' => '081234567006',
                'password' => Hash::make('3573021234567006'),
            ],
            [
                'nisn' => '1001001007',
                'nik' => '3573021234567007',
                'nama_lengkap' => 'Gunawan Wibowo',
                'email' => 'gunawan.wibowo@example.com',
                'nomor_hp' => '081234567007',
                'password' => Hash::make('3573021234567007'),
            ],
            [
                'nisn' => '1001001008',
                'nik' => '3573021234567008',
                'nama_lengkap' => 'Heni Susilowati',
                'email' => 'heni.susilowati@example.com',
                'nomor_hp' => '081234567008',
                'password' => Hash::make('3573021234567008'),
            ],
            [
                'nisn' => '1001001009',
                'nik' => '3573021234567009',
                'nama_lengkap' => 'Indra Permana',
                'email' => 'indra.permana@example.com',
                'nomor_hp' => '081234567009',
                'password' => Hash::make('3573021234567009'),
            ],
            [
                'nisn' => '1001001010',
                'nik' => '3573021234567010',
                'nama_lengkap' => 'Juwita Sari',
                'email' => 'juwita.sari@example.com',
                'nomor_hp' => '081234567010',
                'password' => Hash::make('3573021234567010'),
            ],
        ];

        foreach ($students as $student) {
            Student::create($student);
        }
    }
}
