<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Siswa - SPMB 2025</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar {
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            overflow: hidden;
            transition: transform 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .btn-warning {
            border: none;
            padding: 8px 20px;
            border-radius: 5px;
            transition: all 0.3s;
        }
        .btn-warning:hover {
            transform: scale(1.05);
        }
        .form-control:focus {
            border-color: #ffc107;
            box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.15);
        }
        .form-label {
            font-weight: 500;
            color: #495057;
        }
        .card-header {
            border-bottom: none;
            padding: 1.5rem 1.5rem 0.5rem;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <i class="fas fa-university me-2"></i>
                <span>Logo SPMB</span>
            </a>
            <div class="ms-auto d-flex align-items-center">
                <div class="d-flex align-items-center me-3">
                    <i class="fas fa-user-circle text-light me-2"></i>
                    <span class="text-light">{{ Auth::user()->name }}</span>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">
                        <i class="fas fa-sign-out-alt me-1"></i> Log Out
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <div class="row mb-3">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Siswa</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 text-warning">
                            <i class="fas fa-user-edit me-2"></i>Edit Data Siswa
                        </h5>
                        <p class="text-muted small mb-0">Edit data siswa dengan NISN: {{ $student->nisn }}</p>
                    </div>
                    <div class="card-body p-4">
                        @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Terjadi kesalahan!</strong> Periksa formulir di bawah ini.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <ul class="mt-2 mb-0">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <form action="{{ route('students.update', $student->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nisn" class="form-label">
                                        <i class="fas fa-id-card me-1 text-muted"></i> NISN
                                    </label>
                                    <input type="text" class="form-control" id="nisn" name="nisn" 
                                           value="{{ old('nisn', $student->nisn) }}" required>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="nik" class="form-label">
                                        <i class="fas fa-id-badge me-1 text-muted"></i> NIK
                                    </label>
                                    <input type="text" class="form-control" id="nik" name="nik" 
                                           value="{{ old('nik', $student->nik) }}" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="nama_lengkap" class="form-label">
                                    <i class="fas fa-user me-1 text-muted"></i> Nama Lengkap
                                </label>
                                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" 
                                       value="{{ old('nama_lengkap', $student->nama_lengkap) }}" required>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">
                                        <i class="fas fa-envelope me-1 text-muted"></i> Email
                                    </label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="{{ old('email', $student->email) }}" required>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="nomor_hp" class="form-label">
                                        <i class="fas fa-phone me-1 text-muted"></i> Nomor Handphone
                                    </label>
                                    <input type="text" class="form-control" id="nomor_hp" name="nomor_hp" 
                                           value="{{ old('nomor_hp', $student->nomor_hp) }}" required>
                                </div>
                            </div>
                            
                            <div class="mb-3 mt-2">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="reset_password" name="reset_password">
                                    <label class="form-check-label" for="reset_password">
                                        <i class="fas fa-key me-1 text-muted"></i> Reset Password (password akan diatur ulang sama dengan NIK)
                                    </label>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-1"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save me-1"></i> Perbarui Data
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5><i class="fas fa-university me-2"></i> SPMB 2025</h5>
                    <p class="small">Sistem Penerimaan Mahasiswa Baru</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="small">&copy; 2025 All Rights Reserved</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html> 