@extends('layouts.app')

@section('title', ' | Daftar Akun Masyarakat')

@section('content')
<style>
    .register-wrapper {
        min-height: 100vh;
        background: linear-gradient(135deg, #f8fbff 0%, #e3f2fd 100%);
        display: flex;
        align-items: center;
        padding: 30px 15px;
    }
    .card-register {
        max-width: 480px;
        width: 100%;
        margin: 0 auto;
        border-radius: 22px;
        overflow: hidden;
        box-shadow: 0 15px 40px rgba(13, 110, 253, 0.18);
    }
    .register-header {
        background: linear-gradient(135deg, #0d6efd, #0b5ed7);
        color: white;
        text-align: center;
        padding: 45px 30px;
    }
    .register-header h3 { margin: 0 0 10px 0; font-weight: 700; font-size: 28px; }
    .register-header p { margin: 0; opacity: 0.95; font-size: 15px; }
    .card-body { padding: 40px 35px; background: #ffffff; }
    .form-control-lg { border-radius: 12px; padding: 12px 16px; font-size: 15px; }
    .btn-register { background: #198754; border: none; border-radius: 14px; padding: 14px; font-weight: 600; font-size: 16px; }
    .btn-register:hover { background: #157347; }
    .logo-img { width: 90px; height: 90px; object-fit: contain; border-radius: 50%; border: 5px solid rgba(255,255,255,0.3); margin-bottom: 15px; }
</style>

<div class="register-wrapper">
    <div class="card-register">

        <div class="register-header">
            <img src="{{ asset('dishub-logo.png') }}" alt="Logo Dishub" class="logo-img">
            <h3>Daftar Akun Baru</h3>
            <p>Bikin akun gratis untuk melapor pengaduan kapan saja</p>
        </div>

        <div class="card-body">

            <!-- PESAN SUKSES DARI REGISTER -->
            @if (session('status'))
                <div class="alert alert-success text-center rounded-3 mb-4">
                    <strong>Selamat!</strong><br>
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control form-control-lg @error('name') is-invalid @enderror"
                           value="{{ old('name') }}" required autofocus placeholder="Masukkan nama lengkap">
                    @error('name')
                        <div class="invalid-feedback">Nama wajib diisi.</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror"
                           value="{{ old('email') }}" required placeholder="contoh@email.com">
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message == 'The email has already been taken.' ? 'Email ini sudah digunakan.' : $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Password</label>
                    <input type="password" name="password" class="form-control form-control-lg @error('password') is-invalid @enderror"
                           required placeholder="Minimal 8 karakter">
                    @error('password')
                        <div class="invalid-feedback">
                            @if(str_contains($message, 'minimum')) 
                                Password minimal 8 karakter.
                            @else 
                                Password dan konfirmasi tidak cocok.
                            @endif
                        </div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control form-control-lg" required placeholder="Ketik ulang password">
                </div>

                <button type="submit" class="btn btn-success btn-register w-100 shadow-sm">
                    Daftar Akun
                </button>
            </form>

            <hr class="my-4">

            <div class="text-center">
                <p class="text-muted mb-2">Sudah punya akun?</p>
                <a href="{{ route('login') }}" class="btn btn-outline-primary rounded-pill px-5 fw-bold">
                    Masuk di Sini
                </a>
            </div>

            <div class="text-center mt-4 pt-3 border-top">
                <small class="text-muted">Petugas / Admin Dishub?</small><br>
                <a href="{{ url('admin/login') }}" class="btn btn-sm btn-outline-danger mt-2">
                    Masuk sebagai Admin
                </a>
            </div>
        </div>
    </div>
</div>
@endsection