@extends('layouts.admin')

@section('title', 'Tambah Siswa')

@section('styles')
<style>
    .form-label {
        font-weight: 600;
        color: #4e73df;
    }
    
    .required::after {
        content: ' *';
        color: #e74a3b;
    }
    
    .card-form {
        border-top: 4px solid #4e73df;
    }
</style>
@endsection

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Siswa Baru</h1>
    <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left fa-sm"></i> Kembali
    </a>
</div>

<div class="card shadow mb-4 card-form">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Tambah Siswa</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.siswa.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nisn" class="form-label required">NISN</label>
                    <input type="text" class="form-control @error('nisn') is-invalid @enderror" id="nisn" name="nisn" value="{{ old('nisn') }}" placeholder="Masukkan NISN" required>
                    @error('nisn')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">NISN (Nomor Induk Siswa Nasional), hanya angka.</small>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="nik" class="form-label required">NIK</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik" name="nik" value="{{ old('nik') }}" placeholder="Masukkan NIK" required>
                        @error('nik')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <small class="text-muted">NIK (16 digit), hanya angka.</small>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="nama_lengkap" class="form-label required">Nama Lengkap</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" placeholder="Masukkan Nama Lengkap" required>
                        @error('nama_lengkap')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label required">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="Masukkan Email" required>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="nomor_hp" class="form-label required">Nomor HP</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        <input type="text" class="form-control @error('nomor_hp') is-invalid @enderror" id="nomor_hp" name="nomor_hp" value="{{ old('nomor_hp') }}" placeholder="Masukkan Nomor HP" required>
                        @error('nomor_hp')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <small class="text-muted">Nomor HP, hanya angka.</small>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label required">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Masukkan Password" required>
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <small class="text-muted">Minimal 6 karakter. Password ini akan digunakan siswa untuk login ke sistem.</small>
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-end">
                <button type="reset" class="btn btn-outline-secondary me-2">
                    <i class="fas fa-undo"></i> Reset
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 