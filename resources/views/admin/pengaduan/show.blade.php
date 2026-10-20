@extends('layouts.admin')

@section('title', 'Detail Pengaduan #{{ $pengaduan->id }}')

@section('content')
<div class="container py-4">

    <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-secondary mb-4">
        ← Kembali ke Daftar
    </a>

    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
        <div class="card-header bg-primary text-white py-4">
            <h4 class="mb-0">
                Detail Pengaduan #{{ $pengaduan->id }}
            </h4>
        </div>

        <div class="card-body p-4 p-lg-5">

            <!-- Kategori (dengan badge cantik) -->
            <div class="mb-4">
                <strong class="text-muted">Kategori Pengaduan:</strong><br>
                <span class="badge bg-primary fs-5 px-4 py-2 mt-2">
                    {{ $pengaduan->kategori }}
                </span>
            </div>

            <hr class="my-4">

            <!-- Informasi Pelapor -->
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <p class="mb-2"><strong>Nama Pelapor:</strong></p>
                    <h5 class="text-primary">{{ $pengaduan->nama }}</h5>
                </div>
                <div class="col-md-6">
                    <p class="mb-2"><strong>Email:</strong></p>
                    <h5>{{ $pengaduan->email }}</h5>
                </div>
            </div>

            <!-- Tanggal Pengaduan -->
            <div class="mb-4">
                <strong class="text-muted">Tanggal Laporan:</strong><br>
                <span class="text-dark fs-5">
                    {{ $pengaduan->created_at->translatedFormat('d F Y, H:i') }} WIB
                </span>
            </div>

            <!-- Status Saat Ini (Tampilkan besar & jelas) -->
            <div class="mb-4">
                <strong class="text-muted">Status Saat Ini:</strong><br>
                <span class="badge 
                    @if($pengaduan->status == 'Selesai') bg-success
                    @elseif($pengaduan->status == 'Sedang Diproses') bg-info
                    @else bg-warning text-dark @endif 
                    fs-4 px-4 py-3 mt-2">
                    {{ $pengaduan->status == 'Menunggu Tindakan' ? 'Menunggu Tindakan' : $pengaduan->status }}
                </span>
            </div>

            <!-- Isi Pengaduan -->
            <div class="mb-4">
                <strong class="text-muted d-block mb-3">Isi Pengaduan:</strong>
                <div class="border-start border-primary border-4 ps-4 py-3 bg-light rounded">
                    <p class="mb-0 text-dark" style="white-space: pre-line; line-height: 1.7;">
                        {{ $pengaduan->isi_pengaduan }}
                    </p>
                </div>
            </div>

            <!-- Foto Bukti -->
            @if($pengaduan->foto)
                <div class="mb-5">
                    <strong class="text-muted d-block mb-3">Foto Bukti:</strong>
                    <a href="{{ asset('storage/' . $pengaduan->foto) }}" target="_blank" class="d-block">
                        <img src="{{ asset('storage/' . $pengaduan->foto) }}"
                             class="img-fluid rounded-4 shadow-sm border hover-zoom"
                             style="max-height: 500px; object-fit: cover; transition: transform 0.3s;">
                    </a>
                    <small class="text-muted d-block mt-2">Klik gambar untuk memperbesar</small>
                </div>
            @else
                <div class="mb-5 text-center py-5 bg-light rounded">
                    <p class="text-muted fs-5">Tidak ada foto bukti</p>
                </div>
            @endif

            <!-- UPDATE STATUS -->
            <div class="bg-light p-4 rounded-4 border border-success mt-5">
                <h5 class="text-success mb-4">
                    Ubah Status Pengaduan
                </h5>

                <form action="{{ route('admin.pengaduan.status', $pengaduan->id) }}" 
                      method="POST" 
                      class="d-flex align-items-end gap-3 flex-wrap">

                    @csrf
                    @method('PATCH')

                    <div>
                        <label class="form-label fw-bold text-dark">Pilih Status Baru</label>
                        <select name="status" class="form-select form-select-lg" required>
                            <option value="" disabled selected>-- Pilih status --</option>
                            <option value="Menunggu Tindakan" 
                                {{ old('status', $pengaduan->status) == 'Menunggu Tindakan' ? 'selected' : '' }}>
                                Menunggu Tindakan
                            </option>
                            <option value="Sedang Diproses" 
                                {{ old('status', $pengaduan->status) == 'Sedang Diproses' ? 'selected' : '' }}>
                                Sedang Diproses
                            </option>
                            <option value="Selesai" 
                                {{ old('status', $pengaduan->status) == 'Selesai' ? 'selected' : '' }}>
                                Selesai
                            </option>
                        </select>
                    </div>

                    <div>
                        <button type="submit" class="btn btn-success btn-lg px-5 shadow-sm">
                            Update Status
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

{{-- Hover zoom untuk foto --}}
<style>
    .hover-zoom {
        transition: transform 0.3s ease;
    }
    .hover-zoom:hover {
        transform: scale(1.02);
    }
</style>
@endsection