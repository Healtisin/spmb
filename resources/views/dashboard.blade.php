<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard SPMB 2025</title>
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
        .btn-primary {
            background-color: #0d6efd;
            border: none;
            padding: 8px 20px;
            border-radius: 5px;
            transition: all 0.3s;
        }
        .btn-primary:hover {
            background-color: #0b5ed7;
            transform: scale(1.05);
        }
        .table thead th {
            position: sticky;
            top: 0;
            background-color: #f8f9fa;
            z-index: 1;
        }
        .table-responsive {
            max-height: 70vh;
        }
        .search-highlight {
            background-color: yellow;
        }
        .badge-counter {
            position: absolute;
            top: -5px;
            right: -10px;
            background-color: #dc3545;
            color: white;
            border-radius: 50%;
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }
        .page-title {
            color: #333;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        .action-btn {
            transition: all 0.2s;
        }
        .action-btn:hover {
            transform: scale(1.1);
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
        <div class="row mb-4 align-items-center">
            <div class="col-md-6">
                <h4 class="page-title mb-0">
                    <i class="fas fa-users me-2 text-primary"></i>Data Siswa
                </h4>
                <p class="text-muted">Mengelola data seluruh siswa SPMB</p>
            </div>
            <div class="col-md-6 text-md-end">
                <div class="position-relative d-inline-block me-2">
                    <i class="fas fa-bell fa-lg text-muted"></i>
                    <span class="badge-counter">3</span>
                </div>
                <span class="text-muted me-3">|</span>
                <span class="text-muted">{{ now()->format('d M Y') }}</span>
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="row mb-4">
            <div class="col-md-6 mb-3 mb-md-0">
                <a href="{{ route('students.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Data Siswa
                </a>
            </div>
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" id="searchInput" class="form-control ps-0 border-start-0" placeholder="Cari berdasarkan NISN, NIK, Nama, atau Email...">
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="studentsTable">
                        <thead>
                            <tr class="bg-light">
                                <th class="px-4 py-3" onclick="sortTable(0)">
                                    NISN <i class="fas fa-sort text-muted ms-1"></i>
                                </th>
                                <th class="px-4 py-3" onclick="sortTable(1)">
                                    NIK <i class="fas fa-sort text-muted ms-1"></i>
                                </th>
                                <th class="px-4 py-3" onclick="sortTable(2)">
                                    Nama <i class="fas fa-sort text-muted ms-1"></i>
                                </th>
                                <th class="px-4 py-3" onclick="sortTable(3)">
                                    Email <i class="fas fa-sort text-muted ms-1"></i>
                                </th>
                                <th class="px-4 py-3" onclick="sortTable(4)">
                                    No. HP <i class="fas fa-sort text-muted ms-1"></i>
                                </th>
                                <th class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $student)
                            <tr>
                                <td class="px-4 py-3">{{ $student->nisn }}</td>
                                <td class="px-4 py-3">{{ $student->nik }}</td>
                                <td class="px-4 py-3">{{ $student->nama_lengkap }}</td>
                                <td class="px-4 py-3">{{ $student->email }}</td>
                                <td class="px-4 py-3">{{ $student->nomor_hp }}</td>
                                <td class="px-4 py-3 text-center">
                                    <a href="{{ route('students.edit', $student->id) }}" class="btn btn-sm btn-warning action-btn me-1" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger action-btn" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="d-flex flex-column align-items-center justify-content-center">
                                        <i class="fas fa-database fa-3x text-muted mb-3"></i>
                                        <h5>Belum ada data siswa</h5>
                                        <p class="text-muted">Silakan tambahkan data siswa baru</p>
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
    <script>
        // Fungsi pencarian realtime
        document.getElementById('searchInput').addEventListener('keyup', function() {
            let searchValue = this.value.toLowerCase();
            let tableRows = document.querySelectorAll('#studentsTable tbody tr');
            let found = false;

            tableRows.forEach(row => {
                let rowText = row.textContent.toLowerCase();
                
                if (rowText.includes(searchValue)) {
                    row.style.display = '';
                    found = true;
                    
                    // Highlight teks yang dicari
                    if (searchValue.length > 0) {
                        let cells = row.querySelectorAll('td:not(:last-child)');
                        cells.forEach(cell => {
                            let originalText = cell.textContent;
                            let lowerText = originalText.toLowerCase();
                            let index = lowerText.indexOf(searchValue);
                            
                            if (index >= 0) {
                                let highlightedText = originalText.substring(0, index) +
                                    '<span class="search-highlight">' + 
                                    originalText.substring(index, index + searchValue.length) + 
                                    '</span>' + 
                                    originalText.substring(index + searchValue.length);
                                cell.innerHTML = highlightedText;
                            }
                        });
                    }
                } else {
                    row.style.display = 'none';
                }
            });
            
            // Jika tidak ada hasil pencarian
            let noResultRow = document.querySelector('#studentsTable tbody .no-result-row');
            
            if (!found && tableRows.length > 0) {
                if (!noResultRow) {
                    let tbody = document.querySelector('#studentsTable tbody');
                    let newRow = document.createElement('tr');
                    newRow.className = 'no-result-row';
                    newRow.innerHTML = `
                        <td colspan="6" class="text-center py-4">
                            <i class="fas fa-search fa-2x text-muted mb-2"></i>
                            <p>Tidak ada hasil untuk pencarian "${searchValue}"</p>
                        </td>
                    `;
                    tbody.appendChild(newRow);
                } else {
                    noResultRow.style.display = '';
                    noResultRow.querySelector('p').textContent = `Tidak ada hasil untuk pencarian "${searchValue}"`;
                }
            } else if (noResultRow) {
                noResultRow.style.display = 'none';
            }
            
            // Reset highlight jika input kosong
            if (searchValue === '') {
                tableRows.forEach(row => {
                    let cells = row.querySelectorAll('td');
                    cells.forEach(cell => {
                        cell.innerHTML = cell.textContent;
                    });
                });
            }
        });
        
        // Fungsi pengurutan tabel
        function sortTable(columnIndex) {
            let table = document.getElementById('studentsTable');
            let switching = true;
            let direction = 'asc';
            let shouldSwitch, rows, x, y;
            let switchCount = 0;
            
            while (switching) {
                switching = false;
                rows = table.rows;
                
                for (let i = 1; i < (rows.length - 1); i++) {
                    shouldSwitch = false;
                    x = rows[i].getElementsByTagName('td')[columnIndex];
                    y = rows[i + 1].getElementsByTagName('td')[columnIndex];
                    
                    if (direction === 'asc') {
                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    } else if (direction === 'desc') {
                        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    }
                }
                
                if (shouldSwitch) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                    switchCount++;
                } else {
                    if (switchCount === 0 && direction === 'asc') {
                        direction = 'desc';
                        switching = true;
                    }
                }
            }
            
            // Update ikon
            let headers = table.querySelectorAll('th');
            headers.forEach(header => {
                header.querySelector('i').className = 'fas fa-sort text-muted ms-1';
            });
            
            let icon = headers[columnIndex].querySelector('i');
            icon.className = direction === 'asc' ? 'fas fa-sort-up text-primary ms-1' : 'fas fa-sort-down text-primary ms-1';
        }
    </script>
</body>

</html>