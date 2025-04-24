@extends('layouts.admin')

@section('title', 'Data Siswa')

@section('styles')
<style>
    .search-container {
        position: relative;
        width: 100%;
        max-width: 400px;
    }
    
    .search-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #aaa;
    }
    
    .search-input {
        width: 100%;
        padding: 10px 15px 10px 40px;
        border-radius: 50px;
        border: 1px solid #e3e6f0;
        transition: all 0.3s;
        background-color: #f8f9fc;
    }
    
    .search-input:focus {
        box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
        border-color: #bac8f3;
        outline: none;
    }
    
    .table-avatar {
        height: 36px;
        width: 36px;
        border-radius: 50%;
        margin-right: 10px;
    }
    
    .badge-nisn {
        font-size: 0.8rem;
        font-weight: 500;
        background-color: #f8f9fc;
        color: #5a5c69;
        border: 1px solid #eaecf4;
        padding: 5px 10px;
        border-radius: 20px;
    }
    
    .action-buttons .btn {
        margin-right: 5px;
        width: 36px;
        height: 36px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    .table-responsive {
        border-radius: 0.5rem;
        overflow: hidden;
    }
    
    .pagination-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        background-color: #fff;
        border-top: 1px solid #e3e6f0;
    }
    
    .pagination-info {
        color: #858796;
        font-size: 0.875rem;
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
    }
    
    .modal-confirm .modal-header.bg-danger {
        background-color: #ff6b6b !important;
    }
    
    .modal-confirm .modal-header.bg-warning {
        background-color: #feca57 !important;
    }
    
    .modal-confirm h4 {
        color: white;
        text-align: center;
        font-size: 26px;
        margin: 0;
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
        padding: 15px;
        text-align: center;
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);
    }
    
    .modal-confirm .icon-box i {
        font-size: 24px;
        margin-top: 6px;
    }
    
    .modal-confirm .icon-box.bg-danger {
        background: #ff4757;
    }
    
    .modal-confirm .icon-box.bg-warning {
        background: #feca57;
    }
    
    .modal-confirm .btn {
        color: #fff;
        border-radius: 4px;
        background: #82ce34;
        text-decoration: none;
        transition: all 0.4s;
        border: none;
        min-width: 120px;
    }
    
    .modal-confirm .btn-secondary {
        background: #c1c1c1;
    }
    
    .modal-confirm .btn-danger {
        background: #ff4757;
    }
    
    .modal-confirm .btn-warning {
        background: #feca57;
    }
    
    .modal-confirm .btn:hover {
        opacity: 0.8;
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                // Hanya submit form jika nilai input telah berubah
                // dan telah beberapa waktu sejak pengguna terakhir mengetik
                clearTimeout(this.timer);
                this.timer = setTimeout(() => {
                    document.getElementById('searchForm').submit();
                }, 500);
            });
            
            // Auto focus pada field search saat halaman dimuat
            if (!searchInput.value) {
                searchInput.focus();
            }
        }
        
        // Setup delete confirmation
        const deleteButtons = document.querySelectorAll('.btn-delete');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const siswaId = this.getAttribute('data-id');
                const siswaName = this.getAttribute('data-name');
                
                // Populate modal with data
                document.getElementById('delete-siswa-name').textContent = siswaName;
                
                // Setup form action dengan URL yang benar
                const deleteForm = document.getElementById('deleteForm');
                deleteForm.setAttribute('action', `/admin/siswa/${siswaId}`);
                
                // Show modal
                const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
                deleteModal.show();
            });
        });
        
        // Setup edit confirmation
        const editButtons = document.querySelectorAll('.btn-edit');
        editButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const siswaId = this.getAttribute('data-id');
                const siswaName = this.getAttribute('data-name');
                
                // Populate modal with data
                document.getElementById('edit-siswa-name').textContent = siswaName;
                
                // Setup link dengan URL yang benar
                document.getElementById('editConfirmButton').href = `/admin/siswa/${siswaId}/edit`;
                
                // Show modal
                const editModal = new bootstrap.Modal(document.getElementById('editModal'));
                editModal.show();
            });
        });
    });
</script>
@endsection

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Siswa</h1>
    <a href="{{ route('admin.siswa.create') }}" class="btn btn-primary">
        <i class="fas fa-plus fa-sm"></i> Tambah Siswa
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Siswa</h6>
        <form id="searchForm" action="{{ route('admin.siswa.index') }}" method="GET" class="search-container">
            <i class="fas fa-search search-icon"></i>
            <input type="text" id="searchInput" name="search" class="search-input" 
                   placeholder="Cari NISN, nama, atau email..." 
                   value="{{ request('search') }}" autocomplete="off">
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover m-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4 py-3" width="5%">#</th>
                        <th class="px-4 py-3">Siswa</th>
                        <th class="px-4 py-3">NISN</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Nomor HP</th>
                        <th class="px-4 py-3">Tanggal Daftar</th>
                        <th class="px-4 py-3" width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswas as $index => $siswa)
                    <tr>
                        <td class="px-4 py-3">{{ $siswas->firstItem() + $index }}</td>
                        <td class="px-4 py-3">
                            <div class="d-flex align-items-center">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($siswa->nama_lengkap) }}&background=4e73df&color=ffffff" class="table-avatar" alt="{{ $siswa->nama_lengkap }}">
                                <div>
                                    <div class="fw-bold">{{ $siswa->nama_lengkap }}</div>
                                    <small class="text-muted">NIK: {{ Str::limit($siswa->nik, 8) }}...</small>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3"><span class="badge-nisn">{{ $siswa->nisn }}</span></td>
                        <td class="px-4 py-3">{{ $siswa->email }}</td>
                        <td class="px-4 py-3">{{ $siswa->nomor_hp }}</td>
                        <td class="px-4 py-3">{{ $siswa->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-3">
                            <div class="action-buttons d-flex">
                                <button class="btn btn-sm btn-warning btn-edit" 
                                        data-id="{{ $siswa->id }}" 
                                        data-name="{{ $siswa->nama_lengkap }}" 
                                        title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger btn-delete" 
                                        data-id="{{ $siswa->id }}" 
                                        data-name="{{ $siswa->nama_lengkap }}" 
                                        title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
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
            
            @if($siswas->count() > 0)
            <div class="pagination-container">
                <div class="pagination-info">
                    Menampilkan {{ $siswas->firstItem() }} sampai {{ $siswas->lastItem() }} dari {{ $siswas->total() }} data
                </div>
                <div>
                    {{ $siswas->withQueryString()->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-confirm">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <div class="icon-box bg-danger">
                    <i class="fas fa-trash text-white"></i>
                </div>
                <h4 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-center">Apakah Anda yakin ingin menghapus data siswa:<br><strong id="delete-siswa-name"></strong>?</p>
                <p class="text-center text-muted small">Data yang dihapus tidak dapat dikembalikan!</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Confirmation Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-confirm">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <div class="icon-box bg-warning">
                    <i class="fas fa-edit text-white"></i>
                </div>
                <h4 class="modal-title" id="editModalLabel">Konfirmasi Edit</h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-center">Anda akan mengedit data siswa:<br><strong id="edit-siswa-name"></strong></p>
                <p class="text-center text-muted small">Pastikan data yang akan diubah sudah benar</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a id="editConfirmButton" href="#" class="btn btn-warning">Edit</a>
            </div>
        </div>
    </div>
</div>
@endsection 