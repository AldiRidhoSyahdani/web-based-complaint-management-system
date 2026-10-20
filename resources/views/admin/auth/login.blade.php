<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Dishub Kota Cirebon</title>

    <!-- Bootstrap 5.3 + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Google Font: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }

        .login-container {
            max-width: 420px;
            width: 100%;
        }

        .login-card {
            background: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .card-header {
            background: linear-gradient(135deg, #2c3e50, #34495e);
            color: white;
            padding: 2rem 1.5rem;
            text-align: center;
        }

        .card-header i {
            font-size: 3.5rem;
            margin-bottom: 1rem;
            opacity: 0.9;
        }

        .warning-box {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 1rem;
            border-radius: 12px;
            text-align: center;
            font-weight: 600;
            margin: 1.5rem 1.5rem 0;
            font-size: 0.95rem;
        }

        .form-control {
            border-radius: 12px;
            padding: 0.75rem 1rem;
            border: 1px solid #ced4da;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .btn-login {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            border-radius: 12px;
            padding: 0.85rem;
            font-weight: 600;
            font-size: 1.05rem;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .footer-text {
            font-size: 0.85rem;
            color: #6c757d;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-card">

            <!-- Header dengan ikon shield -->
            <div class="card-header">
                <i class="bi bi-shield-lock-fill"></i>
                <h4 class="mb-0 fw-bold">ADMINISTRATOR</h4>
                <p class="mb-0 opacity-75 mt-2">Dinas Perhubungan Kota Cirebon</p>
            </div>

            <div class="card-body p-4">

                <!-- PERINGATAN BESAR -->
                <div class="warning-box">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong>AKSES KHUSUS ADMIN</strong><br>
                    Halaman ini hanya untuk petugas berwenang. Akses tanpa izin dapat dikenakan sanksi.
                </div>

                <!-- Flash Error -->
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mt-4" role="alert">
                        <i class="bi bi-x-circle-fill me-2"></i>
                        {{ $errors->first() }}
                        <button type="button" class="btn-close btn-close-sm" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Form Login -->
                <form action="{{ route('admin.login.post') }}" method="POST" class="mt-4">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-envelope-fill me-2"></i>Email
                        </label>
                        <input type="email" name="email" class="form-control" 
                               placeholder="masukkan email admin" required autofocus>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-shield-lock-fill me-2"></i>Password
                        </label>
                        <input type="password" name="password" class="form-control" 
                               placeholder="••••••••" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 btn-login text-white">
                        <i class="bi bi-box-arrow-in-right me-2"></i>
                        MASUK SEBAGAI ADMIN
                    </button>
                </form>

                <div class="text-center mt-4 footer-text">
                    © {{ date('Y') }} Dinas Perhubungan Kota Cirebon<br>
                    <small>Sistem Informasi Internal • Akses Terbatas</small>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>