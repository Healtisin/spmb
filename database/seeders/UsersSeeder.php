<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat user admin jika belum ada
        if (!User::where('email', 'admin@admin.com')->exists()) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('123'),
                'role' => 'admin',
            ]);
        } else {
            // Update role admin jika user sudah ada
            User::where('email', 'admin@admin.com')->update(['role' => 'admin']);
        }

        // Buat user siswa jika belum ada
        if (!User::where('email', 'siswa@siswa.com')->exists()) {
            User::create([
                'name' => 'Siswa',
                'email' => 'siswa@siswa.com',
                'password' => Hash::make('12345'),
                'role' => 'siswa',
            ]);
        } else {
            // Update role siswa jika user sudah ada
            User::where('email', 'siswa@siswa.com')->update(['role' => 'siswa']);
        }
    }
}
