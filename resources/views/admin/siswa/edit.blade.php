@extends('layouts.admin')

@section('title', 'Edit Siswa')

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
        border-top: 4px solid #f6c23e;
    }
    
    .page-header {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .page-header .avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: #f6c23e;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 18px;
    }
    
    /* Modal styles */
    .modal-confirm {
        color: #636363;
    }
    
    .modal-confirm .modal-content {
        padding: 20px;
        border-radius: 12px;
        border: none;
    }
    
    .modal-confirm .modal-header {
        border-bottom: none;
        position: relative;
        text-align: center;
        margin: -20px -20px 0;
        border-radius: 12px 12px 0 0;
        padding: 35px;
        background-color: #f6c23e;
    }
    
    .modal-confirm h4 {
        color: white;
        text-align: center;
        font-size: 26px;
        margin: 0;
    }
    
    .modal-confirm .icon-box {
        color: #fff;
        position: absolute;
        margin: 0 auto;
        left: 0;
        right: 0;
        top: -30px;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        z-index: 9;
        background: #f6c23e;
        padding: 15px;
        text-align: center;
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);
    }
    
    .modal-confirm .icon-box i {
        font-size: 24px;
        margin-top: 6px;
    }
    
    .modal-confirm .btn {
        color: #fff;
        border-radius: 4px;
        text-decoration: none;
        transition: all 0.4s;
        min-width: 120px;
    }
    
    .modal-confirm .btn-warning {
        background: #f6c23e;
        border: none;
    }
    
    .modal-confirm .btn-secondary {
        background: #c1c1c1;
        border: none;
    }
    
    .modal-confirm .btn:hover {
        opacity: 0.8;
    }
    
    .modal-confirm .modal-body {
        padding: 20px;
    }
    
    .modal-confirm .modal-footer {
        border: none;
        text-align: center;
        border-radius: 0 0 12px 12px;
        padding: 10px 0 20px;
    }
    
    /* Style untuk memastikan summary perubahan terlihat jelas */
    #summaryChanges {
        max-height: 200px;
        overflow-y: auto;
        margin-top: 10px;
    }
    
    .change-item {
        display: flex;
        margin-bottom: 8px;
        padding-bottom: 8px;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .change-label {
        width: 40%;
        font-weight: 600;
        color: #4e73df;
    }
    
    .change-value {
        width: 60%;
    }
    
    .old-value {
        text-decoration: line-through;
        color: #e74a3b;
        display: block;
        font-size: 0.85rem;
    }
    
    .new-value {
        color: #1cc88a;
        font-weight: 500;
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Data awal siswa
        const originalData = {
            nisn: "{{ $siswa->nisn }}",
            nik: "{{ $siswa->nik }}",
            nama_lengkap: "{{ $siswa->nama_lengkap }}",
            email: "{{ $siswa->email }}",
            nomor_hp: "{{ $siswa->nomor_hp }}"
        };
        
        // Form update
        const updateForm = document.getElementById('updateForm');
        
        // Tombol update
        const updateButton = document.getElementById('updateButton');
        
        // Modal konfirmasi
        const updateModal = new bootstrap.Modal(document.getElementById('updateModal'));
        
        // Tombol konfirmasi di modal
        const confirmUpdateButton = document.getElementById('confirmUpdateButton');
        
        // Container untuk menampilkan perubahan
        const summaryChanges = document.getElementById('summaryChanges');
        
        // Event listener untuk tombol update
        if (updateButton) {
            updateButton.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Cek form validity
                if (!updateForm.checkValidity()) {
                    // Trigger validasi bawaan HTML
                    updateForm.reportValidity();
                    return;
                }
                
                // Data yang akan diupdate
                const formData = new FormData(updateForm);
                const newData = {};
                let hasChanges = false;
                
                // Ambil nilai form untuk dibandingkan
                formData.forEach((value, key) => {
                    if (key !== '_token' && key !== '_method' && key !== 'password') {
                        newData[key] = value;
                        
                        // Cek apakah ada perubahan
                        if (originalData[key] !== value) {
                            hasChanges = true;
                        }
                    }
                });
                
                // Tambahkan kasus khusus untuk password
                const passwordField = document.getElementById('password');
                if (passwordField && passwordField.value.trim() !== '') {
                    hasChanges = true;
                    newData['password'] = '********'; // Tidak menampilkan password asli
                }
                
                // Jika tidak ada perubahan, tampilkan peringatan
                if (!hasChanges) {
                    alert('Tidak ada perubahan data. Silakan ubah minimal satu data untuk melakukan update.');
                    return;
                }
                
                // Bersihkan summary sebelum menambahkan perubahan baru
                summaryChanges.innerHTML = '';
                
                // Tampilkan perubahan data
                for (const key in newData) {
                    if (originalData[key] !== newData[key] || key === 'password') {
                        const changeItem = document.createElement('div');
                        changeItem.className = 'change-item';
                        
                        const labelElement = document.createElement('div');
                        labelElement.className = 'change-label';
                        
                        const valueElement = document.createElement('div');
                        valueElement.className = 'change-value';
                        
                        // Label yang lebih manusiawi
                        let label = key;
                        switch(key) {
                            case 'nisn': label = 'NISN'; break;
                            case 'nik': label = 'NIK'; break;
                            case 'nama_lengkap': label = 'Nama Lengkap'; break;
                            case 'email': label = 'Email'; break;
                            case 'nomor_hp': label = 'Nomor HP'; break;
                            case 'password': label = 'Password'; break;
                        }
                        
                        labelElement.textContent = label;
                        
                        if (key === 'password') {
                            const newValueElement = document.createElement('span');
                            newValueElement.className = 'new-value';
                            newValueElement.textContent = 'Password akan diubah';
                            valueElement.appendChild(newValueElement);
                        } else {
                            const oldValueElement = document.createElement('span');
                            oldValueElement.className = 'old-value';
                            oldValueElement.textContent = originalData[key];
                            
                            const newValueElement = document.createElement('span');
                            newValueElement.className = 'new-value';
                            newValueElement.textContent = newData[key];
                            
                            valueElement.appendChild(oldValueElement);
                            valueElement.appendChild(newValueElement);
                        }
                        
                        changeItem.appendChild(labelElement);
                        changeItem.appendChild(valueElement);
                        summaryChanges.appendChild(changeItem);
                    }
                }
                
                // Tampilkan modal
                updateModal.show();
            });
        }
        
        // Event listener untuk tombol konfirmasi di modal
        if (confirmUpdateButton) {
            confirmUpdateButton.addEventListener('click', function() {
                // Submit form
                updateForm.submit();
            });
        }
    });
</script>
@endsection

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div class="page-header">
        <div class="avatar">
            <i class="fas fa-user-edit"></i>
        </div>
        <div>
            <h1 class="h3 mb-0 text-gray-800">Edit Data Siswa</h1>
            <p class="text-muted mb-0">Update informasi untuk siswa: {{ $siswa->nama_lengkap }}</p>
        </div>
    </div>
    <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left fa-sm"></i> Kembali
    </a>
</div>

<div class="card shadow mb-4 card-form">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-warning">Form Edit Siswa</h6>
        <span class="badge bg-info text-white">
            <i class="fas fa-clock"></i> Terdaftar: {{ $siswa->created_at->format('d M Y') }}
        </span>
    </div>
    <div class="card-body">
        <form id="updateForm" action="{{ route('admin.siswa.update', $siswa->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nisn" class="form-label required">NISN</label>
                    <input type="text" class="form-control @error('nisn') is-invalid @enderror" id="nisn" name="nisn" value="{{ old('nisn', $siswa->nisn) }}" placeholder="Masukkan NISN" required>
                    @error('nisn')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">NISN (Nomor Induk Siswa Nasional), hanya angka.</small>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="nik" class="form-label required">NIK</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik" name="nik" value="{{ old('nik', $siswa->nik) }}" placeholder="Masukkan NIK" required>
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
                        <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $siswa->nama_lengkap) }}" placeholder="Masukkan Nama Lengkap" required>
                        @error('nama_lengkap')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label required">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $siswa->email) }}" placeholder="Masukkan Email" required>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="nomor_hp" class="form-label required">Nomor HP</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        <input type="text" class="form-control @error('nomor_hp') is-invalid @enderror" id="nomor_hp" name="nomor_hp" value="{{ old('nomor_hp', $siswa->nomor_hp) }}" placeholder="Masukkan Nomor HP" required>
                        @error('nomor_hp')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <small class="text-muted">Nomor HP, hanya angka.</small>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Masukkan Password (kosongkan jika tidak ingin mengubah)">
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <small class="text-muted">Minimal 6 karakter. Kosongkan jika tidak ingin mengubah password. Password digunakan siswa untuk login ke sistem.</small>
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-end">
                <a href="{{ route('admin.siswa.index') }}" class="btn btn-outline-secondary me-2">
                    <i class="fas fa-times"></i> Batal
                </a>
                <button type="button" id="updateButton" class="btn btn-warning">
                    <i class="fas fa-save"></i> Update Data
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Konfirmasi Update -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-confirm">
        <div class="modal-content">
            <div class="modal-header">
                <div class="icon-box">
                    <i class="fas fa-save text-white"></i>
                </div>
                <h4 class="modal-title" id="updateModalLabel">Konfirmasi Update</h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-center">Apakah Anda yakin ingin mengupdate data siswa ini?</p>
                <h6 class="text-center mb-3">Ringkasan Perubahan:</h6>
                <div id="summaryChanges" class="border rounded p-3 bg-light">
                    <!-- Daftar perubahan akan ditampilkan di sini -->
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" id="confirmUpdateButton" class="btn btn-warning">Update</button>
            </div>
        </div>
    </div>
</div>
@endsection 