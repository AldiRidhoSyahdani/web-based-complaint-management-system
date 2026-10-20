<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dinas Perhubungan Kota Cirebon</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/a2e0cf7a44.js" crossorigin="anonymous"></script>

    <!-- Google Font: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { 
            background-color: #f5f8fb; 
            font-family: 'Inter', sans-serif; 
        }
        .navbar {
            background: linear-gradient(90deg, #0d6efd, #0b5ed7);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .brand-logo {
            width: 48px;
            height: 48px;
            object-fit: contain;
            transition: transform .3s ease;
        }
        .brand-logo:hover { transform: scale(1.12); }

        /* Dropdown user */
        .dropdown-toggle::after { margin-left: 0.5rem; }
        .dropdown-menu {
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            border: none;
            min-width: 200px;
        }
        .user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #fff;
            border: 2px solid #ffc107;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 15px;
            color: #0d6efd;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">

            <!-- Logo + Nama Instansi -->
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <img src="{{ asset('dishub-logo.png') }}" class="brand-logo me-2" alt="Logo Dishub">
                <span class="fw-bold">Dishub Kota Cirebon</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">

                   @guest
    <li class="nav-item">
        <a href="{{ route('login') }}" class="btn btn-outline-light rounded-pill px-4">
            Masuk / Daftar
        </a>
    </li>
@else
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-white d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
            <div class="user-avatar me-2">{{ Str::upper(Str::substr(Auth::user()->name, 0, 2)) }}</div>
            <span class="d-none d-lg-inline">{{ Auth::user()->name }}</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="{{ route('form') }}">Buat Pengaduan</a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger">Keluar</button>
                </form>
            </li>
        </ul>
    </li>
    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-5">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-primary text-white text-center py-4 mt-5">
        <div>
            © {{ date('Y') }} Dinas Perhubungan Kota Cirebon<br>
            <small>
                Sistem Informasi Pengaduan Masyarakat |
                <a href="https://dishub.cirebonkota.go.id/" target="_blank" class="text-warning">
                    dishub.cirebonkota.go.id
                </a>
            </small>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @yield('scripts')
</body>
</html>