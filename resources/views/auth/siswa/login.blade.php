<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login Siswa - SPMB 2025</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            max-width: 450px;
            width: 100%;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .login-header {
            background-color: #0d6efd;
            color: white;
            padding: 2rem;
            text-align: center;
        }
        .login-body {
            padding: 2rem;
            background-color: white;
        }
        .btn-login {
            padding: 0.6rem 1.5rem;
            font-weight: 600;
            border-radius: 50px;
            background-color: #0d6efd;
            border: none;
            transition: all 0.3s ease;
        }
        .btn-login:hover {
            background-color: #0b5ed7;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(13, 110, 253, 0.2);
        }
        .form-control {
            padding: 0.6rem 1rem;
            border-radius: 8px;
        }
        .login-footer {
            text-align: center;
            padding: 1rem;
            background-color: #f8f9fa;
            border-top: 1px solid #dee2e6;
        }
        .login-logo {
            width: 80px;
            height: 80px;
            margin-bottom: 1rem;
            background-color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: #0d6efd;
            margin: 0 auto 1rem;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="login-logo">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <h4 class="mb-0">Login Siswa</h4>
                <p class="mb-0">Sistem Penerimaan Mahasiswa Baru</p>
            </div>
            <div class="login-body">
                @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    {{ $errors->first() }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <form method="POST" action="{{ route('siswa.login') }}">
                    {{ csrf_field() }}
                    <div class="mb-3">
                        <label for="nik" class="form-label fw-bold">NIK</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-id-card"></i></span>
                            <input type="text" name="nik" id="nik" class="form-control" placeholder="Masukkan NIK Anda" 
                                   value="{{ old('nik') }}" required autofocus>
                        </div>
                        <div class="form-text">NIK adalah Nomor Induk Kependudukan yang tertera pada KTP/KK</div>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label fw-bold">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-lock"></i></span>
                            <input type="password" name="password" id="password" class="form-control" 
                                   placeholder="Masukkan password Anda" required>
                            <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="form-text">Password default sama dengan NIK Anda</div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-login">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </button>
                    </div>
                </form>
            </div>
            <div class="login-footer">
                <p class="mb-0"><a href="{{ route('login') }}" class="text-decoration-none">Login sebagai Admin</a></p>
                <p class="mb-0 text-muted small mt-1">&copy; 2025 SPMB. All rights reserved.</p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // CSRF Token setup for AJAX requests
        let token = document.head.querySelector('meta[name="csrf-token"]');
        if (token) {
            window.axios = window.axios || {};
            window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
        }
        
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    </script>
</body>

</html> 