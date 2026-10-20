{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="page-title">
    Dashboard Administrator
</div>

{{-- CARD HORIZONTAL GRADIENT --}}
<div class="row g-4 mb-5">
    <div class="col-lg-4 col-md-6">
        <div class="d-flex align-items-center p-4 rounded-4 shadow-sm text-white"
             style="background: linear-gradient(135deg, #005b9f, #0077cc); height: 150px;">
            <div class="me-4">
                <div class="d-flex align-items-center justify-content-center rounded-circle"
                     style="width: 80px; height: 80px; background: rgba(255,255,255,0.25);">
                    <i class="bi bi-envelope-paper-heart fs-1"></i>
                </div>
            </div>
            <div>
                <h5 class="mb-2 opacity-90 fw-medium">Total Pengaduan</h5>
                <h1 class="mb-0 fw-bold display-5">{{ $total_pengaduan }}</h1>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6">
        <div class="d-flex align-items-center p-4 rounded-4 shadow-sm text-white"
             style="background: linear-gradient(135deg, #0d8b54, #16a085); height: 150px;">
            <div class="me-4">
                <div class="d-flex align-items-center justify-content-center rounded-circle"
                     style="width: 80px; height: 80px; background: rgba(255,255,255,0.25);">
                    <i class="bi bi-check2-all fs-1"></i>
                </div>
            </div>
            <div>
                <h5 class="mb-2 opacity-90 fw-medium">Selesai Diproses</h5>
                <h1 class="mb-0 fw-bold display-5">{{ $selesai }}</h1>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-12">
        <div class="d-flex align-items-center p-4 rounded-4 shadow-sm text-white"
             style="background: linear-gradient(135deg, #f59e0b, #facc15); height: 150px;">
            <div class="me-4">
                <div class="d-flex align-items-center justify-content-center rounded-circle text-dark"
                     style="width: 80px; height: 80px; background: rgba(255,255,255,0.35);">
                    <i class="bi bi-hourglass-split fs-1"></i>
                </div>
            </div>
            <div>
                <h5 class="mb-2 opacity-90 fw-medium">Sedang Diproses</h5>
                <h1 class="mb-0 fw-bold display-5">{{ $diproses }}</h1>
            </div>
        </div>
    </div>
</div>

{{-- TABEL PENGADUAN TERBARU --}}
<div class="table-container">
    <div class="table-header">
        Pengaduan Terbaru
    </div>

    <div class="p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%">#</th>
                        <th>Nama Pelapor</th>
                        <th>Kategori</th> <!-- DIUBAH DARI "Judul Pengaduan" -->
                        <th>Tanggal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengaduans as $i => $p)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="fw-semibold">{{ $p->nama }}</td>
                            <td>
                                <span class="badge bg-primary">
                                    {{ $p->kategori }}
                                </span>
                            </td>
                            <td>{{ $p->created_at->format('d M Y') }}</td>
                            <td>
                                @if($p->status == 'Selesai')
                                    <span class="badge bg-success px-3 py-2">Selesai</span>
                                @elseif($p->status == 'Sedang Diproses')
                                    <span class="badge bg-info px-3 py-2">Diproses</span>
                                @else
                                    <span class="badge bg-warning px-3 py-2 text-dark">Menunggu</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <strong>Belum ada pengaduan masuk</strong>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection