@extends('layouts.admin')

@section('title', 'Statistik Pengaduan')

@section('content')
<div class="page-title">
    Statistik Pengaduan Masyarakat
</div>

<!-- CARD STATISTIK: 4 KARTU -->
<div class="row g-4 mb-5">
    <!-- Total Pengaduan -->
    <div class="col-6 col-md-3">
        <div class="stats-card text-center p-4 rounded-4 shadow-sm border">
            <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3"
                 style="width: 80px; height: 80px; background: linear-gradient(135deg, #005b9f, #0077cc);">
                <i class="bi bi-envelope-paper-heart fs-2 text-white"></i>
            </div>
            <h2 class="fw-bold text-primary mb-1">{{ $total }}</h2>
            <p class="text-muted fw-semibold mb-0">Total Pengaduan</p>
        </div>
    </div>

    <!-- Menunggu Tindakan -->
    <div class="col-6 col-md-3">
        <div class="stats-card text-center p-4 rounded-4 shadow-sm border">
            <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3"
                 style="width: 80px; height: 80px; background: linear-gradient(135deg, #6b7280, #9ca3af);">
                <i class="bi bi-clock-history fs-2 text-white"></i>
            </div>
            <h2 class="fw-bold text-secondary mb-1">{{ $menunggu }}</h2>
            <p class="text-muted fw-semibold mb-0">Menunggu Tindakan</p>
        </div>
    </div>

    <!-- Sedang Diproses -->
    <div class="col-6 col-md-3">
        <div class="stats-card text-center p-4 rounded-4 shadow-sm border">
            <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3"
                 style="width: 80px; height: 80px; background: linear-gradient(135deg, #f59e0b, #fbbf24);">
                <i class="bi bi-hourglass-split fs-2 text-white"></i>
            </div>
            <h2 class="fw-bold text-warning mb-1">{{ $diproses - $menunggu }}</h2>
            <p class="text-muted fw-semibold mb-0">Sedang Diproses</p>
        </div>
    </div>

    <!-- Selesai -->
    <div class="col-6 col-md-3">
        <div class="stats-card text-center p-4 rounded-4 shadow-sm border">
            <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3"
                 style="width: 80px; height: 80px; background: linear-gradient(135deg, #0d8b54, #16a085);">
                <i class="bi bi-check2-all fs-2 text-white"></i>
            </div>
            <h2 class="fw-bold text-success mb-1">{{ $selesai }}</h2>
            <p class="text-muted fw-semibold mb-0">Selesai Diproses</p>
        </div>
    </div>
</div>

<!-- GRAFIK DOUGHNUT: 3 BAGIAN -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 py-4">
        <h5 class="mb-0 text-center fw-bold text-primary">Distribusi Status Pengaduan</h5>
    </div>
    <div class="card-body p-5 bg-light rounded-bottom">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-xl-6">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('statusChart').getContext('2d');

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Selesai Diproses', 'Sedang Diproses', 'Menunggu Tindakan'],
                datasets: [{
                    data: [
                        {{ $selesai }},
                        {{ $diproses - $menunggu }},
                        {{ $menunggu }}
                    ],
                    backgroundColor: [
                        'rgba(22, 163, 74, 0.9)',   // Hijau
                        'rgba(245, 158, 11, 0.9)',  // Oranye
                        'rgba(107, 114, 128, 0.9)'  // Abu-abu
                    ],
                    borderColor: '#fff',
                    borderWidth: 4,
                    hoverOffset: 20
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            font: { size: 14, weight: '600' },
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const value = context.raw;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = total > 0 ? Math.round((value / total) * 100) : 0;
                                return `${context.label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endpush