<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Step 1: Data Siswa - SPMB 2025</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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
        .form-card {
            max-width: 800px;
            margin: 0 auto;
        }
        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
        }
        .form-control, .form-select {
            padding: 0.6rem 1rem;
            border-radius: 8px;
            border: 1px solid #ced4da;
            transition: all 0.3s ease;
        }
        .form-control:focus, .form-select:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        }
        .form-text {
            font-size: 0.85rem;
            color: #6c757d;
        }
        .section-title {
            display: flex;
            align-items: center;
            font-size: 1.1rem;
            color: #0d6efd;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #dee2e6;
        }
        .section-title i {
            margin-right: 0.5rem;
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
        .btn-outline-secondary {
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-outline-secondary:hover {
            transform: translateY(-2px);
        }
        .readonly-field {
            background-color: #f8f9fa;
            cursor: not-allowed;
        }
        .file-upload {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 2rem;
            border: 2px dashed #ced4da;
            border-radius: 10px;
            background-color: #f8f9fa;
            transition: all 0.3s ease;
        }
        .file-upload:hover {
            border-color: #0d6efd;
            background-color: #e9f2ff;
        }
        .file-upload i {
            font-size: 2.5rem;
            color: #6c757d;
            margin-bottom: 1rem;
        }
        .file-upload-input {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }
        .file-upload-info {
            text-align: center;
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
            <div class="step active">
                <div class="step-circle">1</div>
                <div class="step-title">Step 1</div>
                <div class="step-subtitle">Data Siswa</div>
            </div>
            <div class="step">
                <div class="step-circle">2</div>
                <div class="step-title">Step 2</div>
                <div class="step-subtitle">Jalur Pendaftaran</div>
            </div>
            <div class="step">
                <div class="step-circle">3</div>
                <div class="step-title">Step 3</div>
                <div class="step-subtitle">Data Wali Siswa</div>
            </div>
        </div>

        <div class="card form-card">
            <div class="card-body p-4">
                <h4 class="card-title text-center mb-4">Masukkan Data Diri Siswa</h4>
                <p class="text-muted text-center mb-4">Masukkan data dengan sebenar-benarnya dan pastikan semua data sudah benar sebelum melanjutkan</p>

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

                <form action="{{ route('siswa.pendaftaran.step1') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="section-title">
                        <i class="fas fa-user"></i> Data Pribadi
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nisn" class="form-label">NISN</label>
                            <input type="text" class="form-control readonly-field" id="nisn" name="nisn" value="{{ $student->nisn }}" readonly>
                            <div class="form-text">Nomor Induk Siswa Nasional (otomatis)</div>
                        </div>
                        <div class="col-md-6">
                            <label for="nik" class="form-label">NIK</label>
                            <input type="text" class="form-control readonly-field" id="nik" name="nik" value="{{ $student->nik }}" readonly>
                            <div class="form-text">Nomor Induk Kependudukan (otomatis)</div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                            <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir', $detail->tempat_lahir) }}" placeholder="Contoh: Jakarta" required>
                        </div>
                        <div class="col-md-6">
                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="text" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $detail->tanggal_lahir) }}" placeholder="DD/MM/YYYY" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="no_reg_akta_lahir" class="form-label">No. Reg. Akta Lahir</label>
                        <input type="text" class="form-control" id="no_reg_akta_lahir" name="no_reg_akta_lahir" value="{{ old('no_reg_akta_lahir', $detail->no_reg_akta_lahir) }}" placeholder="Masukkan nomor registrasi akta lahir" required>
                    </div>

                    <div class="mb-3">
                        <label for="agama" class="form-label">Agama</label>
                        <select class="form-select" id="agama" name="agama" required>
                            <option value="" selected disabled>-- Pilih Agama --</option>
                            @php
                                $agamaOptions = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu', 'Lainnya'];
                                $selectedAgama = old('agama', $detail->agama);
                            @endphp
                            @foreach($agamaOptions as $agama)
                                <option value="{{ $agama }}" {{ $selectedAgama == $agama ? 'selected' : '' }}>{{ $agama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="section-title mt-4">
                        <i class="fas fa-map-marker-alt"></i> Data Alamat
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat Lengkap</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat lengkap (termasuk jalan, nomor rumah, RT/RW)" required>{{ old('alamat', $detail->alamat) }}</textarea>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="kelurahan" class="form-label">Kelurahan</label>
                            <input type="text" class="form-control" id="kelurahan" name="kelurahan" value="{{ old('kelurahan', $detail->kelurahan) }}" placeholder="Masukkan nama kelurahan" required>
                        </div>
                        <div class="col-md-6">
                            <label for="kecamatan" class="form-label">Kecamatan</label>
                            <input type="text" class="form-control" id="kecamatan" name="kecamatan" value="{{ old('kecamatan', $detail->kecamatan) }}" placeholder="Masukkan nama kecamatan" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="kabupaten" class="form-label">Kabupaten/Kota</label>
                            <input type="text" class="form-control" id="kabupaten" name="kabupaten" value="{{ old('kabupaten', $detail->kabupaten) }}" placeholder="Masukkan nama kabupaten/kota" required>
                        </div>
                        <div class="col-md-6">
                            <label for="provinsi" class="form-label">Provinsi</label>
                            <input type="text" class="form-control" id="provinsi" name="provinsi" value="{{ old('provinsi', $detail->provinsi) }}" placeholder="Masukkan nama provinsi" required>
                        </div>
                    </div>

                    <div class="section-title mt-4">
                        <i class="fas fa-file-upload"></i> Dokumen Pendukung
                    </div>

                    <div class="mb-3">
                        <label for="bukti_kk" class="form-label">Bukti Kartu Keluarga (KK)</label>
                        <div class="file-upload">
                            <i class="fas fa-upload" id="upload-icon"></i>
                            <div class="file-upload-info" id="file-info">
                                <h5 class="mb-2">Unggah Dokumen KK</h5>
                                <p class="text-muted mb-0">Format: PDF, JPG, JPEG (Maks. 2MB)</p>
                            </div>
                            <input type="file" class="file-upload-input" id="bukti_kk" name="bukti_kk" accept=".pdf,.jpg,.jpeg">
                        </div>
                        @if($detail->bukti_kk)
                        <div class="alert alert-info mt-2">
                            <i class="fas fa-file-alt me-2"></i>
                            <span>File sudah terunggah: {{ $detail->bukti_kk }}</span>
                        </div>
                        @endif
                    </div>

                    <div class="section-title mt-4">
                        <i class="fas fa-road"></i> Jalur Pendaftaran
                    </div>

                    <div class="mb-4">
                        <label for="jalur_pendaftaran" class="form-label">Pilih Jalur</label>
                        <select class="form-select" id="jalur_pendaftaran" name="jalur_pendaftaran" required>
                            <option value="" selected disabled>-- Pilih Jalur Pendaftaran --</option>
                            @php
                                $jalurOptions = ['Jalur Afirmasi', 'Jalur Prestasi', 'Jalur Domisili', 'Jalur Mutasi'];
                                $selectedJalur = old('jalur_pendaftaran', $detail->jalur_pendaftaran);
                            @endphp
                            @foreach($jalurOptions as $jalur)
                                <option value="{{ $jalur }}" {{ $selectedJalur == $jalur ? 'selected' : '' }}>{{ $jalur }}</option>
                            @endforeach
                        </select>
                        <div class="form-text">Pilih jalur pendaftaran yang sesuai dengan kondisi Anda</div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('siswa.pendaftaran') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            Simpan & Lanjutkan <i class="fas fa-arrow-right ms-2"></i>
                        </button>
                    </div>
                </form>
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
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        // Initialize date picker
        flatpickr("#tanggal_lahir", {
            dateFormat: "Y-m-d",
            maxDate: "today",
        });

        // File upload preview
        document.getElementById('bukti_kk').addEventListener('change', function(e) {
            const fileInput = e.target;
            const fileInfo = document.getElementById('file-info');
            const uploadIcon = document.getElementById('upload-icon');
            
            if (fileInput.files.length > 0) {
                const file = fileInput.files[0];
                const fileSize = (file.size / 1024 / 1024).toFixed(2); // in MB
                
                if (fileSize > 2) {
                    alert('Ukuran file terlalu besar. Maksimal 2MB.');
                    fileInput.value = '';
                    return;
                }
                
                uploadIcon.classList.remove('fa-upload');
                uploadIcon.classList.add('fa-file-alt');
                uploadIcon.style.color = '#0d6efd';
                
                fileInfo.innerHTML = `
                    <h5 class="mb-1">${file.name}</h5>
                    <p class="text-muted mb-0">Ukuran: ${fileSize} MB</p>
                `;
            } else {
                uploadIcon.classList.remove('fa-file-alt');
                uploadIcon.classList.add('fa-upload');
                uploadIcon.style.color = '#6c757d';
                
                fileInfo.innerHTML = `
                    <h5 class="mb-2">Unggah Dokumen KK</h5>
                    <p class="text-muted mb-0">Format: PDF, JPG, JPEG (Maks. 2MB)</p>
                `;
            }
        });
    </script>
</body>

</html> 