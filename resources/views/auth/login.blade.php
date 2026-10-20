{{-- resources/views/auth/login.blade.php --}}
{{-- LOGIN MASYARAKAT — BAHASA INDONESIA 100% --}}

@extends('layouts.app')

@section('title', ' | Masuk ke Akun')

@section('content')
<style>
    .login-wrapper {
        min-height: 100vh;
        background: linear-gradient(135deg, #f8fbff 0%, #e3f2fd 100%);
        display: flex;
        align-items: center;
        padding: 30px 15px;
    }
    .card-login {
        max-width: 440px;
        width: 100%;
        margin: 0 auto;
        border-radius: 22px;
        overflow: hidden;
        box-shadow: 0 15px 40px rgba(13, 110, 253, 0.18);
    }
    .login-header {
        background: linear-gradient(135deg, #0d6efd, #0b5ed7);
        color: white;
        text-align: center;
        padding: 45px 30px;
    }
    .login-header h3 { margin: 0 0 10px 0; font-weight: 700; font-size: 28px; }
    .login-header p { margin: 0; opacity: 0.95; font-size: 15px; }
    .card-body { padding: 40px 35px; background: #fff; }
    .form-control-lg { border-radius: 12px; padding: 12px 16px; }
    .btn-login { background: #0d6efd; border: none; border-radius: 14px; padding: 14px; font-weight: 600; font-size: 16px; }
    .btn-login:hover { background: #0b5ed7; }
    .logo-img { width: 90px; height: 90px; object-fit: contain; border-radius: 50%; border: 5px solid rgba(255,255,255,0.3); margin-bottom: 15px; }

    /* Alert error umum (email/password salah) */
    .alert-danger {
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 20px;
        font-size: 0.95rem;
    }
</style>

<div class="login-wrapper">
    <div class="card-login">
        <div class="login-header">
            <img src="{{ asset('dishub-logo.png') }}" alt="Logo Dishub" class="logo-img">
            <h3>Selamat Datang!</h3>
            <p>Lapor & pantau pengaduan transportasi dengan mudah</p>
        </div>

        <div class="card-body">

            <!-- PESAN ERROR UMUM (email atau password salah) -->
            @if ($errors->has('email') || $errors->has('password'))
                <div class="alert alert-danger text-center">
                    <strong>Email atau kata sandi yang Anda masukkan salah.</strong><br>
                    Silakan coba lagi.
                </div>
            @endif

            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show rounded-3 text-center mb-4" role="alert">
                    <strong>Berhasil!</strong><br>
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Jika ada pesan dari session (misal logout) -->
            @if (session('status'))
                <div class="alert alert-success text-center">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror"
                           value="{{ old('email') }}" required autofocus placeholder="contoh@email.com">

                    <!-- Error khusus email (format salah, dll) -->
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message === 'These credentials do not match our records.' ? '' : $message }}
                            {{-- Sembunyikan pesan bahasa Inggris bawaan Laravel --}}
                        </div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Kata Sandi</label>
                    <input type="password" name="password" class="form-control form-control-lg @error('password') is-invalid @enderror"
                           required autocomplete="current-password" placeholder="••••••••">

                    @error('password')
                        <div class="invalid-feedback">
                            Kata sandi tidak boleh kosong.
                        </div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">Ingat saya</label>
                    </div>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="small text-primary">Lupa kata sandi?</a>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary btn-login w-100 shadow-sm">
                    Masuk ke Akun Saya
                </button>
            </form>

            <hr class="my-4">

            <div class="text-center">
                <p class="text-muted mb-2">Belum punya akun?</p>
                <a href="{{ route('register') }}" class="btn btn-success rounded-pill px-5 py-3 fw-bold shadow-sm">
                    Daftar Akun Sekarang
                </a>
            </div>

            <div class="text-center mt-4 pt-3 border-top">
                <small class="text-muted">Petugas / Admin Dishub?</small><br>
                <a href="{{ route('admin.login') }}" class="btn btn-sm btn-outline-danger mt-2">
                    Masuk sebagai Admin
                </a>
            </div>
        </div>
    </div>
</div>
@endsection