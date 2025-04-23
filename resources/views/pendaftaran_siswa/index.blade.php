<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Siswa - SPMB 2025</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            border: none;
            overflow: hidden;
            margin-bottom: 20px;
        }
        .wizard-container {
            padding: 2rem 0;
        }
        .wizard-nav {
            display: flex;
            justify-content: space-between;
            position: relative;
            margin-bottom: 2rem;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }
        .wizard-nav::before {
            content: '';
            position: absolute;
            top: 35px;
            left: 0;
            right: 0;
            height: 2px;
            background-color: #dee2e6;
            z-index: 1;
        }
        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 2;
            width: 30%;
        }
        .step-circle {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background-color: #fff;
            border: 2px solid #dee2e6;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.5rem;
            margin-bottom: 10px;
            position: relative;
            transition: all 0.3s ease;
        }
        .step-title {
            text-align: center;
            font-weight: 500;
            color: #6c757d;
            transition: all 0.3s ease;
        }
        .step-subtitle {
            text-align: center;
            font-size: 0.85rem;
            color: #adb5bd;
        }
        .step.active .step-circle {
            background-color: #0d6efd;
            border-color: #0d6efd;
            color: white;
            transform: scale(1.1);
            box-shadow: 0 0 0 5px rgba(13, 110, 253, 0.2);
        }
        .step.active .step-title {
            color: #0d6efd;
            font-weight: 600;
        }
        .step.completed .step-circle {
            background-color: #198754;
            border-color: #198754;
            color: white;
        }
        .step.completed .step-title {
            color: #198754;
        }
        .welcome-card {
            max-width: 800px;
            margin: 0 auto;
        }
        .btn-primary {
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(13, 110, 253, 0.3);
        }
        .avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            background-color: #e9ecef;
            color: #0d6efd;
            margin: 0 auto 1.5rem;
        }
        .info-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .info-item i {
            width: 30px;
            color: #6c757d;
        }
        .info-label {
            font-weight: 600;
            width: 120px;
        }
        .progress-info {
            display: flex;
            align-items: center;
            margin-top: 15px;
        }
        .progress-status {
            border-radius: 20px;
            padding: 5px 15px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-left: 15px;
        }
        .status-draft {
            background-color: #fff7db;
            color: #ffc107;
        }
        .status-submitted {
            background-color: #dcf5e7;
            color: #198754;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-university me-2"></i>
                SPMB 2025
            </a>
            <div class="d-flex align-items-center">
                <span class="text-white me-3">{{ $student->nama_lengkap }}</span>
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('siswa.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container wizard-container">
        <div class="text-center mb-4">
            <h2>Pendaftaran Siswa Baru</h2>
            <p class="text-muted">Silakan lengkapi data pendaftaran melalui tahapan berikut</p>
        </div>

        <div class="wizard-nav">
            <div class="step {{ $detail->status_pendaftaran == 'draft' ? 'active' : '' }} {{ $detail->tempat_lahir ? 'completed' : '' }}">
                <div class="step-circle">1</div>
                <div class="step-title">Step 1</div>
                <div class="step-subtitle">Data Siswa</div>
            </div>
            <div class="step {{ $detail->tempat_lahir && !$detail->dokumen_pendukung ? 'active' : '' }} {{ $detail->dokumen_pendukung ? 'completed' : '' }}">
                <div class="step-circle">2</div>
                <div class="step-title">Step 2</div>
                <div class="step-subtitle">Jalur Pendaftaran</div>
            </div>
            <div class="step {{ $detail->dokumen_pendukung && $detail->status_pendaftaran != 'submitted' ? 'active' : '' }} {{ $detail->status_pendaftaran == 'submitted' ? 'completed' : '' }}">
                <div class="step-circle">3</div>
                <div class="step-title">Step 3</div>
                <div class="step-subtitle">Data Wali Siswa</div>
            </div>
        </div>

        <div class="card welcome-card">
            <div class="card-body p-4 text-center">
                <div class="avatar">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <h3 class="card-title">Selamat Datang, {{ $student->nama_lengkap }}!</h3>
                <p class="card-text mb-4">
                    Terima kasih telah menggunakan Sistem Penerimaan Mahasiswa Baru 2025. Untuk melanjutkan proses pendaftaran, 
                    silakan lengkapi data diri Anda melalui 3 tahapan yang tersedia.
                </p>

                <div class="row mb-4 justify-content-center">
                    <div class="col-md-8">
                        <div class="card bg-light">
                            <div class="card-body text-start">
                                <h5><i class="fas fa-info-circle me-2 text-primary"></i>Informasi Siswa</h5>
                                <hr>
                                <div class="info-item">
                                    <i class="fas fa-id-card"></i>
                                    <span class="info-label">NISN:</span>
                                    <span>{{ $student->nisn }}</span>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-id-badge"></i>
                                    <span class="info-label">NIK:</span>
                                    <span>{{ $student->nik }}</span>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-envelope"></i>
                                    <span class="info-label">Email:</span>
                                    <span>{{ $student->email }}</span>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-phone"></i>
                                    <span class="info-label">No. HP:</span>
                                    <span>{{ $student->nomor_hp }}</span>
                                </div>
                                <hr>
                                <div class="progress-info">
                                    <div class="progress w-100" style="height: 10px;">
                                        @php
                                            $progress = 0;
                                            if ($detail->tempat_lahir) $progress += 33;
                                            if ($detail->dokumen_pendukung) $progress += 33;
                                            if ($detail->status_pendaftaran == 'submitted') $progress += 34;
                                        @endphp
                                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $progress }}%;" 
                                             aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <span class="progress-status {{ $detail->status_pendaftaran == 'submitted' ? 'status-submitted' : 'status-draft' }}">
                                        {{ ucfirst($detail->status_pendaftaran) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($detail->status_pendaftaran == 'submitted')
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>
                    <strong>Pendaftaran Berhasil!</strong> Anda telah menyelesaikan semua tahapan pendaftaran.
                </div>
                <a href="{{ route('siswa.pendaftaran.finish') }}" class="btn btn-success">
                    <i class="fas fa-check me-2"></i>Lihat Hasil Pendaftaran
                </a>
                @else
                <div class="d-grid gap-2 col-md-6 mx-auto">
                    @if (!$detail->tempat_lahir)
                    <a href="{{ route('siswa.pendaftaran.step1') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-right me-2"></i>Mulai Pendaftaran
                    </a>
                    @elseif (!$detail->dokumen_pendukung)
                    <a href="{{ route('siswa.pendaftaran.step2') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-right me-2"></i>Lanjutkan ke Jalur Pendaftaran
                    </a>
                    @else
                    <a href="{{ route('siswa.pendaftaran.step3') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-right me-2"></i>Lanjutkan ke Data Wali
                    </a>
                    @endif
                </div>
                @endif
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