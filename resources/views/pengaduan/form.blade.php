@extends('layouts.app')

@section('title', 'Pengaduan Masyarakat • Dishub Cirebon')

@section('content')
<div class="min-vh-100 bg-light py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">

                <!-- Header -->
                <div class="text-center mb-5">
                    <h2 class="display-6 fw-bold text-primary mb-2">Pengaduan Masyarakat</h2>
                    <p class="text-muted lead">Dinas Perhubungan Kota Cirebon</p>
                </div>

                <!-- Card Form -->
                <div class="card border-0 shadow rounded-4 overflow-hidden">
                    <div class="card-header bg-primary text-white text-center py-4">
                        <h4 class="mb-0 fw-bold">Form Pengaduan Online</h4>
                    </div>

                    <div class="card-body p-4 p-md-5">

                        <!-- Success -->
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show rounded-4">
                                <strong>Berhasil!</strong> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <!-- Errors -->
                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show rounded-4">
                                <strong>Perbaiki data berikut:</strong>
                                <ul class="mt-2 mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf

                            <!-- Nama & Email -->
                            <!-- Nama & Email -->
<div class="row g-4 mb-3">
    @auth
        <!-- JIKA SUDAH LOGIN → OTOMATIS ISI DARI DATABASE, DISABLED -->
        <div class="col-md-6">
            <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
            <input type="text" class="form-control form-control-lg rounded-3 bg-light" 
                   value="{{ Auth::user()->name }}" readonly>
            <input type="hidden" name="nama" value="{{ Auth::user()->name }}">
        </div>
        <div class="col-md-6">
            <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
            <input type="email" class="form-control form-control-lg rounded-3 bg-light" 
                   value="{{ Auth::user()->email }}" readonly>
            <input type="hidden" name="email" value="{{ Auth::user()->email }}">
        </div>
    @else
        <!-- JIKA BELUM LOGIN → ISI MANUAL (seperti sebelumnya) -->
        <div class="col-md-6">
            <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
            <input type="text" name="nama" class="form-control form-control-lg rounded-3" 
                   value="{{ old('nama') }}" required placeholder="Masukkan nama lengkap">
            <div class="invalid-feedback">Nama wajib diisi</div>
        </div>
        <div class="col-md-6">
            <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
            <input type="email" name="email" class="form-control form-control-lg rounded-3" 
                   value="{{ old('email') }}" required placeholder="contoh@gmail.com">
            <div class="invalid-feedback">Email tidak valid</div>
        </div>
    @endauth
</div>

                            <!-- Kategori -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Kategori Pengaduan <span class="text-danger">*</span></label>
                                <select name="kategori" id="kategoriSelect" class="form-select form-select-lg rounded-3" required>
                                    <option value="" disabled {{ old('kategori') ? '' : 'selected' }}>
                                        -- Pilih Kategori --
                                    </option>
                                    @foreach(\App\Models\Pengaduan::KATEGORI as $kat)
                                        <option value="{{ $kat }}" {{ old('kategori') == $kat ? 'selected' : '' }}>
                                            {{ $kat }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Isi Pengaduan -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Isi Pengaduan <span class="text-danger">*</span></label>
                                <textarea name="isi_pengaduan" id="isiPengaduan" class="form-control rounded-3" rows="8" required 
                                          placeholder="Pilih kategori terlebih dahulu kategori pengaduan di atas...">{{ old('isi_pengaduan') }}</textarea>
                                <div class="invalid-feedback">Wajib diisi</div>
                            </div>

                            <!-- Upload Foto — SEKARANG WAJIB -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Foto Pendukung <span class="text-danger">*</span></label>
                                <input type="file" name="foto" class="form-control form-control-lg rounded-3" 
                                       accept="image/*" required>
                                <div class="form-text">Maksimal 5MB • JPG/PNG • Wajib diunggah</div>
                                <div class="invalid-feedback">Foto wajib diunggah</div>
                            </div>

                            <!-- Tombol Kirim -->
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-lg px-5 py-3 rounded-pill shadow">
                                    Kirim Pengaduan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="text-center mt-4 text-muted small">
                    Data Anda aman dan hanya digunakan untuk penanganan pengaduan
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Placeholder resmi & formal
    const placeholders = {
        'Penerangan Jalan Umum (PJU)': 
            'Mengadukan kerusakan lampu PJU (mati, berkedip, menyala siang hari), kerusakan tiang, atau usulan pemasangan PJU di area rawan.(Tambahkan nama jalan, kecamatan)',

        'Rambu dan Marka Jalan': 
            'Melaporkan rambu yang rusak/hilang/tertutup, marka jalan yang pudar, ketidaksesuaian rambu dengan kondisi lapangan, atau usulan rambu baru di titik rawan kecelakaan.(Tambahkan nama jalan, kecamatan)',

        'Lalu Lintas': 
            'Melaporkan kerusakan lampu merah (APILL), ketidakseimbangan waktu sinyal, kemacetan parah, pelanggaran lalin (lawan arah/parkir liar), atau usulan perubahan arus jalan.(Tambahkan nama jalan, kecamatan)',

        'Angkutan Umum dan Terminal': 
            'Mengadukan perilaku sopir (ugal-ugalan/ngetem), kondisi kendaraan tidak layak jalan, fasilitas terminal yang rusak, atau ketidaksesuaian tarif angkutan umum.(Tambahkan nama jalan, kecamatan)',

        'Parkir dan Fasilitas Pejalan Kaki': 
            'Melaporkan juru parkir liar, parkir sembarangan penyebab macet, trotoar yang rusak, atau fasilitas halte bus yang tidak terawat.(Tambahkan nama jalan, kecamatan)'
    };

    const select = document.getElementById('kategoriSelect');
    const textarea = document.getElementById('isiPengaduan');

    select.addEventListener('change', function() {
        const value = this.value;
        textarea.placeholder = placeholders[value] || 'Pilih kategori terlebih dahulu...';
        textarea.focus();
    });

    document.addEventListener('DOMContentLoaded', function() {
        if (select.value && placeholders[select.value]) {
            textarea.placeholder = placeholders[select.value];
        }
    });

    // Validasi Bootstrap 5
    (() => {
        'use strict'
        const forms = document.querySelectorAll('.needs-validation')
        forms.forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
    })();
</script>
@endsection