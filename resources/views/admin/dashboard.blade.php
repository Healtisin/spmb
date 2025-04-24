@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('styles')
<style>
    .card-stats {
        transition: transform 0.3s, box-shadow 0.3s;
        border-radius: 10px;
        overflow: hidden;
        border: none;
        height: 100%;
    }
    
    .card-stats:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
    
    .card-stats .icon-box {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }
    
    .bg-gradient-primary {
        background: linear-gradient(45deg, #4e73df, #224abe);
    }
    
    .bg-gradient-success {
        background: linear-gradient(45deg, #1cc88a, #13855c);
    }
    
    .bg-gradient-warning {
        background: linear-gradient(45deg, #f6c23e, #dda20a);
    }
    
    .dashboard-title {
        border-left: 4px solid #4e73df;
        padding-left: 15px;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(78, 115, 223, 0.05);
    }
    
    .stat-card-info {
        font-size: 0.875rem;
        color: #6c757d;
    }
    
    .stat-card-value {
        font-size: 2rem;
        font-weight: 700;
    }
    
    .table-recent img {
        height: 32px;
        width: 32px;
        border-radius: 50%;
    }
    
    .welcome-section {
        background: linear-gradient(45deg, rgba(78, 115, 223, 0.1), rgba(26, 49, 119, 0.1));
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 25px;
        border-left: 4px solid #4e73df;
    }
</style>
@endsection

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
</div>

<!-- Welcome Banner -->
<div class="welcome-section">
    <h4 class="mb-1">Selamat Datang, {{ Auth::user()->name }}!</h4>
    <p class="mb-0 text-muted">Ringkasan data SPMB 2025 tersaji untuk Anda</p>
</div>

<!-- Content Row -->
<div class="row">
    <!-- Total Siswa Card -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card card-stats border-left-primary shadow h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col-auto me-3">
                        <div class="icon-box bg-gradient-primary text-white">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                    <div class="col">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Siswa</div>
                        <div class="stat-card-value">{{ App\Models\Siswa::count() }}</div>
                        <div class="stat-card-info mt-2">
                            <i class="fas fa-info-circle me-1"></i> Total keseluruhan siswa
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('admin.siswa.index') }}" class="btn btn-sm btn-primary d-block">
                        Kelola Data <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Pendaftar Bulan Ini Card -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card card-stats border-left-success shadow h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col-auto me-3">
                        <div class="icon-box bg-gradient-success text-white">
                            <i class="fas fa-calendar"></i>
                        </div>
                    </div>
                    <div class="col">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Pendaftar Bulan Ini</div>
                        <div class="stat-card-value">{{ App\Models\Siswa::whereMonth('created_at', date('m'))->count() }}</div>
                        <div class="stat-card-info mt-2">
                            <i class="fas fa-calendar-alt me-1"></i> Periode {{ date('F Y') }}
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('admin.siswa.index') }}?month={{ date('m') }}" class="btn btn-sm btn-success d-block">
                        Lihat Detail <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Pendaftar Hari Ini Card -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card card-stats border-left-warning shadow h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col-auto me-3">
                        <div class="icon-box bg-gradient-warning text-white">
                            <i class="fas fa-user-clock"></i>
                        </div>
                    </div>
                    <div class="col">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Pendaftar Hari Ini</div>
                        <div class="stat-card-value">{{ App\Models\Siswa::whereDate('created_at', date('Y-m-d'))->count() }}</div>
                        <div class="stat-card-info mt-2">
                            <i class="fas fa-clock me-1"></i> {{ date('d F Y') }}
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('admin.siswa.index') }}?day={{ date('Y-m-d') }}" class="btn btn-sm btn-warning d-block">
                        Lihat Detail <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Students -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Data Siswa Terbaru</h6>
                <a href="{{ route('admin.siswa.index') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-list fa-sm"></i> Lihat Semua
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-recent">
                        <thead>
                            <tr>
                                <th>Siswa</th>
                                <th>NISN</th>
                                <th>Email</th>
                                <th>Nomor HP</th>
                                <th>Pendaftaran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(App\Models\Siswa::latest()->take(5)->get() as $siswa)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($siswa->nama_lengkap) }}&background=4e73df&color=ffffff" class="me-2" alt="{{ $siswa->nama_lengkap }}">
                                        <div>
                                            <div class="fw-bold">{{ $siswa->nama_lengkap }}</div>
                                            <small class="text-muted">{{ Str::limit($siswa->nik, 8) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $siswa->nisn }}</td>
                                <td>{{ $siswa->email }}</td>
                                <td>{{ $siswa->nomor_hp }}</td>
                                <td>{{ $siswa->created_at->format('d M Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('admin.siswa.edit', $siswa->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center">
                                        <img src="https://cdn-icons-png.flaticon.com/512/7486/7486754.png" alt="No Data" style="width: 100px; height: 100px; opacity: 0.5" class="mb-3">
                                        <h5>Data Siswa Kosong</h5>
                                        <p class="text-muted">Belum ada data siswa yang terdaftar</p>
                                        <a href="{{ route('admin.siswa.create') }}" class="btn btn-primary mt-2">
                                            <i class="fas fa-plus"></i> Tambah Siswa Baru
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 