{{-- resources/views/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') • Dishub Kota Cirebon</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root { --primary: #005b9f; --success: #0d8b54; --light: #f8f9fc; }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--light);
            color: #344767;
            margin: 0;
            transition: all 0.3s ease;
        }

        /* Top Navbar */
        .top-navbar {
            background: white;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            height: 70px;
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 1030;
            padding: 0 1.5rem;
        }

        .logo { font-weight: 700; color: var(--primary); font-size: 1.4rem; }

        /* Sidebar + Collapse */
        .sidebar {
            position: fixed;
            top: 70px;
            left: 0;
            bottom: 0;
            width: 260px;
            background: linear-gradient(180deg, var(--primary), #003d73);
            color: white;
            padding-top: 20px;
            box-shadow: 3px 0 15px rgba(0,0,0,0.1);
            z-index: 1020;
            transition: width 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
        }

        .sidebar.collapsed { width: 78px; }

        .sidebar .nav-link {
            color: rgba(255,255,255,0.85);
            padding: 14px 20px;
            margin: 4px 15px;
            border-radius: 10px;
            font-weight: 500;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.3s;
        }

        .sidebar .nav-link i { width: 28px; font-size: 1.3rem; flex-shrink: 0; }
        .sidebar .nav-link span { opacity: 1; transition: opacity 0.2s 0.1s; }
        .sidebar.collapsed .nav-link span { opacity: 0; width: 0; margin-left: -10px; }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(255,255,255,0.2);
            color: white;
            padding-left: 28px;
        }

        /* Tombol Collapse di KIRI (dekat logo) */
        .toggle-sidebar {
            cursor: pointer;
            padding: 8px;
            border-radius: 8px;
            transition: all 0.3s;
        }
        .toggle-sidebar:hover { background: rgba(0,0,0,0.05); }

        /* Main Content */
        .main-content {
            margin-left: 260px;
            margin-top: 90px;
            padding: 0 30px 60px;
            transition: margin-left 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .main-content.collapsed { margin-left: 78px; }

        .page-title { font-size: 1.8rem; font-weight: 600; color: #1e293b; margin-bottom: 1.5rem; }

        .table-container, .card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.08);
            overflow: hidden;
        }

        .table-header, .card-header {
            background: var(--primary);
            color: white;
            padding: 1.2rem 1.8rem;
            font-weight: 600;
        }

        footer { margin-top: 80px; text-align: center; color: #6c757d; font-size: 0.9rem; }
    </style>
</head>
<body>

    <!-- Top Navbar -->
    <nav class="top-navbar d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-3">
            <!-- TOMBOL COLLAPSE DI SINI (KIRI) -->
            <div class="toggle-sidebar text-dark" onclick="toggleSidebar()" title="Collapse Sidebar">
                <i class="bi bi-list fs-2"></i>
            </div>

            <i class="bi bi-bus-front-fill text-primary fs-2"></i>
            <div>
                <div class="logo">DISHUB CIREBON</div>
                <small class="text-muted">Sistem Informasi Pengaduan Masyarakat</small>
            </div>
        </div>

        <div class="d-flex align-items-center gap-4">
            <div class="text-end">
                <div class="fw-semibold">{{ Auth::guard('admin')->user()->name ?? 'Admin' }}</div>
                <small class="text-muted">Administrator</small>
            </div>
            <div class="dropdown">
                <a href="#" class="text-dark" data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle fs-3"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('admin.akun.index') }}">Profil</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('admin.logout') }}" id="logout-form">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <nav class="nav flex-column px-2">
        <!-- Menu Utama -->
        <a href="{{ route('admin.dashboard') }}"
           class="nav-link {{ request()->is('admin/dashboard') || request()->is('admin') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i><span>Dashboard</span>
        </a>
        <a href="{{ route('admin.pengaduan.index') }}"
           class="nav-link {{ request()->is('admin/pengaduan*') ? 'active' : '' }}">
            <i class="bi bi-envelope-open"></i><span>Pengaduan</span>
        </a>
        <a href="{{ route('admin.statistik.index') }}"
           class="nav-link {{ request()->is('admin/statistik*') ? 'active' : '' }}">
            <i class="bi bi-bar-chart-line"></i><span>Statistik</span>
        </a>

        <!-- GARIS PEMISAH (opsional, biar logout terpisah) -->
        <div class="border-top border-white border-opacity-25 my-3 mx-3"></div>

        <!-- LOGOUT — DI BAWAH SENDIRI -->
        <form method="POST" action="{{ route('admin.logout') }}" id="sidebar-logout-form" class="m-0">
            @csrf
            <button type="submit" class="nav-link text-danger w-100 text-start p-0 m-0 border-0 bg-transparent">
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
            </button>
        </form>
    </nav>
</div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        @yield('content')
    </div>

    <footer>
        © {{ date('Y') }} Dinas Perhubungan Kota Cirebon — Sistem Informasi Internal
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('collapsed');
            document.getElementById('mainContent').classList.toggle('collapsed');
        }

        // Optional: collapse otomatis di layar kecil
        window.addEventListener('resize', () => {
            if (window.innerWidth <= 992) {
                document.getElementById('sidebar').classList.add('collapsed');
                document.getElementById('mainContent').classList.add('collapsed');
            }
        });
    </script>
</body>
</html>