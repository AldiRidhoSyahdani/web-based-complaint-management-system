@extends('layouts.app')

@section('content')
@php
    use Illuminate\Support\Str;
@endphp

<style>
    :root {
        --primary: #0055A4;
        --success: #28a745;
        --warning: #ffc107;
        --dark: #2d3748;
    }

    .dashboard-container {
        background: #f5f7fa;
        min-height: 100vh;
        padding: 50px 0;
    }

    .header-card {
        background: linear-gradient(120deg, var(--primary), #004085);
        color: white;
        border-radius: 14px;
        padding: 45px 30px;
        text-align: center;
        box-shadow: 0 6px 25px rgba(0, 85, 164, 0.3);
    }

    .header-card h1 {
        font-size: 2.1rem;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .header-card p {
        font-size: 1.05rem;
        opacity: 0.95;
    }

    .stat-card {
        background: white;
        border-radius: 14px;
        padding: 30px 20px;
        text-align: center;
        box-shadow: 0 4px 18px rgba(0,0,0,0.09);
        transition: all 0.3s ease;
        border-top: 6px solid var(--primary);
    }

    .stat-card.proses { border-top-color: var(--warning); }
    .stat-card.selesai { border-top-color: var(--success); }

    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.14);
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--dark);
        margin: 10px 0;
    }

    .stat-label {
        font-size: 0.95rem;
        color: #555;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .btn-dishub {
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 50px;
        padding: 14px 40px;
        font-size: 1.1rem;
        font-weight: 600;
        box-shadow: 0 6px 20px rgba(0,85,164,0.35);
        transition: all 0.3s ease;
    }

    .btn-dishub:hover {
        background: #004085;
        transform: translateY(-4px);
    }
</style>

<div class="dashboard-container">
    <div class="container">

        <!-- HEADER DASHBOARD -->
        <div class="header-card">
            <div class="mb-4">
                <img src="{{ asset('images/logo-dishub.png') }}" height="85"
                     onerror="this.style.display='none'" alt="Logo Dishub">
            </div>

            <h1>Dashboard Dishub</h1>
            <p>Dinas Perhubungan Kota Cirebon</p>
            <p class="mt-2">Sistem Pengaduan Masyarakat</p>

            @auth
                <div class="mt-4">
                    <h5>Selamat datang, <strong>{{ Auth::user()->name }}</strong></h5>
                </div>
            @else
                <div class="mt-4">
                    <h5><strong>Silakan login untuk mengajukan pengaduan</strong></h5>
                </div>
            @endauth
        </div>

        <!-- STATISTIK -->
        <div class="row g-4 justify-content-center mt-5">
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-number">{{ $total }}</div>
                    <div class="stat-label">Total Pengaduan</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card proses">
                    <div class="stat-number">{{ $diproses }}</div>
                    <div class="stat-label">Sedang Diproses</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card selesai">
                    <div class="stat-number">{{ $ditangani }}</div>
                    <div class="stat-label">Sudah Ditangani</div>
                </div>
            </div>
        </div>

        <!-- TOMBOL AJUKAN -->
        <div class="text-center mt-5">
            @auth
                <a href="{{ route('form') }}" class="btn btn-dishub">
                    Ajukan Pengaduan Baru
                </a>
            @else
                <button class="btn btn-dishub" id="btnAjukanPengaduan">
                    Ajukan Pengaduan Baru
                </button>
            @endauth
        </div>

        <!-- RIWAYAT PENGADUAN USER -->
        @auth
        <div class="mt-5">
            <h4 class="text-center mb-4 text-primary fw-bold">
                Riwayat Pengaduan Anda
            </h4>

            @if($pengaduanSaya->count())
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-primary text-center">
                            <tr>
                                <th>No</th>
                                <th>Kategori</th>
                                <th>Isi Pengaduan</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pengaduanSaya as $p)
                                <tr>
                                    <td class="text-center">
                                        {{ $loop->iteration + ($pengaduanSaya->currentPage() - 1) * $pengaduanSaya->perPage() }}
                                    </td>
                                    <td class="fw-semibold text-primary">{{ $p->kategori }}</td>
                                    <td>{{ Str::limit(strip_tags($p->isi_pengaduan), 100) }}</td>
                                    <td class="text-center">{{ $p->created_at->format('d/m/Y') }}</td>
                                    <td class="text-center">
                                        @switch(strtolower($p->status))
                                            @case('selesai')
                                                <span class="badge bg-success">Selesai</span>
                                                @break
                                            @case('sedang diproses')
                                            @case('diproses')
                                                <span class="badge bg-warning text-dark">Diproses</span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary">Menunggu</span>
                                        @endswitch
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('pengaduan.show', $p->id) }}"
                                           class="btn btn-sm btn-primary">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-center">
                        {{ $pengaduanSaya->links() }}
                    </div>
                </div>
            @else
                <div class="alert alert-info text-center">
                    Anda belum memiliki pengaduan.
                </div>
            @endif
        </div>
        @endauth

    </div>
</div>

<!-- SWEETALERT LOGIN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const btn = document.getElementById('btnAjukanPengaduan');
    if (btn) {
        btn.addEventListener('click', () => {
            Swal.fire({
                icon: 'info',
                title: 'Login Diperlukan',
                text: 'Silakan login terlebih dahulu untuk mengajukan pengaduan.',
                confirmButtonText: 'Login',
                showCancelButton: true
            }).then(res => {
                if (res.isConfirmed) {
                    window.location.href = "{{ route('login') }}";
                }
            });
        });
    }
</script>
@endsection