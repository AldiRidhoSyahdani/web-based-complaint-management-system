@extends('layouts.admin')

@section('title', 'Daftar Pengaduan')

@section('content')
<div class="page-title">
    Daftar Pengaduan Masyarakat
</div>

{{-- Filter Tanggal + Tombol Cetak PDF --}}
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div class="fw-bold text-primary">
        Total Pengaduan: {{ $pengaduans->count() }}
    </div>

    <div class="d-flex gap-2 align-items-center flex-wrap">
        <input type="date" id="start_date" class="form-control" style="width: 170px;">
        <span class="text-muted fw-medium">s/d</span>
        <input type="date" id="end_date" class="form-control" style="width: 170px;">

        <button onclick="exportPdfWithDate()" class="btn btn-danger d-flex align-items-center gap-2 shadow-sm">
            <i class="bi bi-file-earmark-pdf-fill"></i>
            Cetak PDF
        </button>
    </div>
</div>

<div class="table-responsive d-none d-md-block">
    <table class="table table-hover align-middle text-center">
        <thead class="table-light">
            <tr>
                <th width="5%">No</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Foto</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengaduans as $p)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td class="text-start fw-semibold">{{ $p->nama }}</td>
                <td>
                    <span class="badge bg-primary px-3 py-2">{{ $p->kategori }}</span>
                </td>
                <td>
                    @if($p->foto)
                        <a href="{{ asset('storage/' . $p->foto) }}" target="_blank">
                            <img src="{{ asset('storage/' . $p->foto) }}" class="img-thumbnail rounded" style="width:80px;height:80px;object-fit:cover;">
                        </a>
                    @else
                        <span class="text-muted small">Tidak ada</span>
                    @endif
                </td>
                <td>{{ $p->created_at->format('d M Y') }}</td>
                <td>
                    <span class="badge
                        @if($p->status == 'Selesai') bg-success
                        @elseif($p->status == 'Sedang Diproses') bg-info
                        @else bg-warning text-dark @endif px-3 py-2">
                        {{ $p->status == 'Menunggu Tindakan' ? 'Menunggu' : $p->status }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('admin.pengaduan.show', $p->id) }}" class="btn btn-primary btn-sm rounded-pill px-4">
                        Lihat
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center py-5 text-muted">Belum ada pengaduan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Mobile: card list for small screens --}}
<div class="d-block d-md-none">
    @forelse($pengaduans as $p)
    <div class="card mb-3 shadow-sm">
        <div class="row g-0 align-items-center">
            <div class="col-4">
                @if($p->foto)
                    <a href="{{ asset('storage/' . $p->foto) }}" target="_blank">
                        <img src="{{ asset('storage/' . $p->foto) }}" class="img-fluid rounded-start" style="height:100%;object-fit:cover;min-height:120px;">
                    </a>
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center" style="min-height:120px;">
                        <span class="text-muted small">Tidak ada foto</span>
                    </div>
                @endif
            </div>
            <div class="col-8">
                <div class="card-body py-2">
                    <h6 class="card-title mb-1 fw-semibold">{{ $p->nama }}</h6>
                    <p class="mb-1 small text-muted">{{ $p->kategori }} • {{ $p->created_at->format('d M Y') }}</p>
                    <div class="mb-2">
                        <span class="badge
                            @if($p->status == 'Selesai') bg-success
                            @elseif($p->status == 'Sedang Diproses') bg-info
                            @else bg-warning text-dark @endif px-2 py-1">
                            {{ $p->status == 'Menunggu Tindakan' ? 'Menunggu' : $p->status }}
                        </span>
                    </div>
                    <a href="{{ route('admin.pengaduan.show', $p->id) }}" class="btn btn-primary btn-sm">Lihat</a>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="text-center py-4 text-muted">Belum ada pengaduan.</div>
    @endforelse
</div>

{{-- SweetAlert2 CDN (Ringan & Cantik) --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function exportPdfWithDate() {
    const start = document.getElementById('start_date').value;
    const end   = document.getElementById('end_date').value;

    // Validasi tanggal kosong
    if (!start || !end) {
        Swal.fire({
            icon: 'warning',
            title: 'Pilih Tanggal Dulu',
            text: 'Harap pilih tanggal mulai dan tanggal akhir sebelum mencetak PDF.',
            confirmButtonText: 'OK',
            confirmButtonColor: '#d33'
        });
        return;
    }

    // Validasi urutan tanggal
    if (new Date(start) > new Date(end)) {
        Swal.fire({
            icon: 'error',
            title: 'Urutan Tanggal Salah',
            text: 'Tanggal mulai tidak boleh lebih besar dari tanggal akhir.',
            confirmButtonText: 'OK',
            confirmButtonColor: '#d33'
        });
        return;
    }

    // Jika valid → buka PDF
    const url = `{{ route('admin.pengaduan.exportPdf') }}?start=${start}&end=${end}`;
    window.open(url, '_blank');
}
</script>
@endsection