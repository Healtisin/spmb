<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - SPMB 2025</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #858796;
            --success-color: #1cc88a;
            --danger-color: #e74a3b;
            --warning-color: #f6c23e;
            --sidebar-bg: #4e73df;
            --sidebar-dark: #3a5cd0;
            --sidebar-width: 250px;
            --sidebar-collapsed-width: 100px;
        }
        
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8f9fc;
            overflow-x: hidden;
            position: relative;
        }
        
        /* Sidebar */
        .sidebar {
            min-height: 100vh;
            width: var(--sidebar-width);
            position: fixed;
            top: 0;
            left: 0;
            background: linear-gradient(180deg, var(--sidebar-bg) 10%, var(--sidebar-dark) 100%);
            z-index: 100;
            transition: all 0.3s ease;
            overflow-y: auto;
        }
        
        .sidebar-brand {
            height: 70px;
            display: flex;
            align-items: center;
            padding: 0 1rem;
        }
        
        .sidebar-brand-icon {
            font-size: 1.8rem;
            color: white;
            margin-right: 0.8rem;
            transition: all 0.3s ease;
        }
        
        .sidebar-brand-text {
            color: white;
            font-size: 1.2rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05rem;
        }
        
        .sidebar-divider {
            border-top: 1px solid rgba(255, 255, 255, 0.15);
            margin: 0.5rem 1rem;
        }
        
        .nav-item {
            margin: 0.2rem 0;
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.7rem 1rem;
            color: rgba(255, 255, 255, 0.8);
            transition: all 0.2s;
        }
        
        .nav-link:hover {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        .nav-link.active {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.2);
            font-weight: 600;
        }
        
        .nav-icon {
            width: 1.25rem;
            text-align: center;
            margin-right: 0.75rem;
            font-size: 0.85rem;
        }
        
        .nav-text {
            white-space: nowrap;
        }
        
        .sidebar-heading {
            color: rgba(255, 255, 255, 0.4);
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05rem;
            padding: 0.5rem 1rem;
            margin-top: 0.5rem;
        }
        
        /* Content area */
        .content-wrapper {
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            min-height: 100vh;
            transition: all 0.3s ease;
        }
        
        /* Topbar */
        .topbar {
            height: 70px;
            background-color: #fff;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            padding: 0 1rem;
        }
        
        .topbar-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 100%;
            width: 100%;
        }
        
        /* Toggle button */
        #sidebarToggle {
            position: absolute;
            bottom: 1rem;
            right: 1rem;
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.6);
            text-align: center;
            line-height: 2.5rem;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        #sidebarToggle:hover {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
        }
        
        #sidebarToggleTop {
            background: transparent;
            border: none;
            color: var(--primary-color);
            font-size: 1.5rem;
            display: none;
        }
        
        /* Card styling */
        .card {
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
            border: none;
            border-radius: 0.5rem;
        }
        
        .card-header {
            background-color: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
        }
        
        /* Collapsed sidebar */
        .sidebar-collapsed .sidebar {
            width: var(--sidebar-collapsed-width);
        }
        
        .sidebar-collapsed .content-wrapper {
            margin-left: var(--sidebar-collapsed-width);
            width: calc(100% - var(--sidebar-collapsed-width));
        }
        
        .sidebar-collapsed .sidebar-brand-text,
        .sidebar-collapsed .nav-text,
        .sidebar-collapsed .sidebar-heading {
            display: none;
        }
        
        .sidebar-collapsed .sidebar-brand {
            justify-content: center;
        }
        
        .sidebar-collapsed .sidebar-brand-icon {
            margin-right: 0;
            text-align: center;
        }
        
        .sidebar-collapsed .nav-icon {
            margin-right: 0;
            font-size: 1.1rem;
            width: 100%;
            text-align: center;
        }
        
        .sidebar-collapsed .nav-link {
            justify-content: center;
            padding: 0.75rem;
        }
        
        /* User dropdown */
        .user-profile {
            display: flex;
            align-items: center;
            cursor: pointer;
        }
        
        .img-profile {
            height: 40px;
            width: 40px;
            border-radius: 50%;
            margin-left: 0.5rem;
        }
        
        .user-name {
            color: #5a5c69;
            font-weight: 600;
        }
        
        .dropdown-menu {
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
            margin-top: 0.5rem;
            border: none;
        }
        
        .dropdown-item {
            padding: 0.5rem 1rem;
        }
        
        .dropdown-item:hover {
            background-color: #f8f9fc;
        }
        
        /* Search box */
        .search-box {
            position: relative;
            width: 300px;
        }
        
        .search-box input {
            width: 100%;
            padding: 0.5rem 1rem 0.5rem 2.5rem;
            border-radius: 20px;
            border: 1px solid #d1d3e2;
            background-color: #f8f9fc;
            transition: all 0.2s;
        }
        
        .search-box input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
            outline: none;
        }
        
        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #858796;
        }
        
        /* Alerts */
        .alert {
            border-radius: 0.5rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
        }
        
        /* Footer */
        .footer {
            background-color: #fff;
            border-top: 1px solid #e3e6f0;
            padding: 1rem;
            color: #858796;
            font-size: 0.85rem;
        }
        
        /* Pagination styling */
        .pagination {
            margin-bottom: 0;
        }
        
        .pagination .page-item .page-link {
            color: var(--primary-color);
            border: 1px solid #dddfeb;
            font-size: 0.85rem;
            line-height: 1;
            padding: 0.75rem 1rem;
        }
        
        .pagination .page-item.active .page-link {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }
        
        .pagination .page-item.disabled .page-link {
            color: #b7b9cc;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 0;
            }
            
            .content-wrapper {
                margin-left: 0;
                width: 100%;
            }
            
            #sidebarToggleTop {
                display: block;
            }
            
            .sidebar-collapsed .sidebar {
                width: 100%;
                z-index: 1050;
            }
            
            .sidebar-collapsed .content-wrapper {
                margin-left: 0;
                width: 100%;
            }
            
            .sidebar-collapsed .sidebar-brand-text,
            .sidebar-collapsed .nav-text,
            .sidebar-collapsed .sidebar-heading {
                display: block;
            }
            
            .sidebar-collapsed .nav-link {
                justify-content: flex-start;
                padding: 0.75rem 1rem;
            }
            
            .sidebar-collapsed .nav-icon {
                margin-right: 0.75rem;
                width: auto;
                text-align: left;
            }
            
            .search-box {
                width: 100%;
                margin: 0.5rem 0;
            }
            
            .topbar-content {
                flex-direction: column;
                padding: 0.5rem 0;
                height: auto;
            }
        }
    </style>
    @yield('styles')
</head>

<body>
    <div id="wrapper">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-brand d-flex justify-content-center">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="sidebar-brand-text ms-2">SPMB 2025</div>
            </div>
            
            <hr class="sidebar-divider">
            
            <ul class="nav flex-column">
                <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt nav-icon"></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>
                
                <div class="sidebar-heading">
                    Manajemen
                </div>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.siswa.*') ? 'active' : '' }}" href="{{ route('admin.siswa.index') }}">
                        <i class="fas fa-users nav-icon"></i>
                        <span class="nav-text">Data Siswa</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-chart-bar nav-icon"></i>
                        <span class="nav-text">Statistik</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-university nav-icon"></i>
                        <span class="nav-text">Data Sekolah</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-calendar nav-icon"></i>
                        <span class="nav-text">Jadwal</span>
                    </a>
                </li>
                
                <hr class="sidebar-divider">
                
                <div class="sidebar-heading">
                    Pengaturan
                </div>
                
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-cog nav-icon"></i>
                        <span class="nav-text">Konfigurasi</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-user-shield nav-icon"></i>
                        <span class="nav-text">Admin</span>
                    </a>
                </li>
            </ul>
            
            <!-- Sidebar Toggle Button -->
            <button id="sidebarToggle">
                <i class="fas fa-angle-left"></i>
            </button>
        </div>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light topbar mb-4">
                <div class="topbar-content">
                    <div class="d-flex align-items-center">
                        <!-- Sidebar Toggle (Topbar) -->
                        <button id="sidebarToggleTop" class="mr-3">
                            <i class="fa fa-bars"></i>
                        </button>
                        
                        <!-- Global Search -->
                        <div class="search-box d-none d-md-block">
                            <form action="#" method="GET">
                                <i class="fas fa-search search-icon"></i>
                                <input type="text" name="search" placeholder="Cari di seluruh aplikasi..." class="form-control bg-light border-0 small">
                            </form>
                        </div>
                    </div>
                    
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav">
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="user-profile">
                                    <span class="user-name d-none d-lg-inline mr-2">{{ Auth::user()->name }}</span>
                                    <img class="img-profile" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=4e73df&color=ffffff">
                                </div>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400 me-1"></i>
                                    Profil
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400 me-1"></i>
                                    Pengaturan
                                </a>
                                <div class="dropdown-divider"></div>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400 me-1"></i>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- End of Topbar -->

            <!-- Page Content -->
            <div class="container-fluid px-4">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-1"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @yield('content')
            </div>
            <!-- End of Page Content -->

            <!-- Footer -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="text-center">
                        <span>&copy; {{ date('Y') }} SPMB 2025. Hak Cipta Dilindungi.</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->
        </div>
        <!-- End of Content Wrapper -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle Sidebar
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebarToggleTop = document.getElementById('sidebarToggleTop');
            const wrapper = document.getElementById('wrapper');
            
            // Check for saved sidebar state
            if (localStorage.getItem('sidebarCollapsed') === 'true') {
                wrapper.classList.add('sidebar-collapsed');
                const icon = sidebarToggle.querySelector('i');
                if (icon) {
                    icon.classList.remove('fa-angle-left');
                    icon.classList.add('fa-angle-right');
                }
            }
            
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    wrapper.classList.toggle('sidebar-collapsed');
                    
                    // Save state to localStorage
                    localStorage.setItem('sidebarCollapsed', wrapper.classList.contains('sidebar-collapsed'));
                    
                    const icon = this.querySelector('i');
                    if (icon) {
                        if (wrapper.classList.contains('sidebar-collapsed')) {
                            icon.classList.remove('fa-angle-left');
                            icon.classList.add('fa-angle-right');
                        } else {
                            icon.classList.remove('fa-angle-right');
                            icon.classList.add('fa-angle-left');
                        }
                    }
                });
            }
            
            if (sidebarToggleTop) {
                sidebarToggleTop.addEventListener('click', function(e) {
                    e.preventDefault();
                    wrapper.classList.toggle('sidebar-collapsed');
                    
                    // Save state to localStorage
                    localStorage.setItem('sidebarCollapsed', wrapper.classList.contains('sidebar-collapsed'));
                });
            }
            
            // Auto close alerts after 5 seconds
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    const closeBtn = new bootstrap.Alert(alert);
                    closeBtn.close();
                }, 5000);
            });
        });
    </script>
    @yield('scripts')
</body>

</html> 