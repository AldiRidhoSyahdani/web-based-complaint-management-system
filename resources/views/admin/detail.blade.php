@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h3>Detail Pengaduan</h3>
    <hr>
    <p><strong>Nama:</strong> {{ $pengaduan->nama }}</p>
    <p><strong>Email:</strong> {{ $pengaduan->email }}</p>
    <p><strong>Judul:</strong> {{ $pengaduan->judul }}</p>
    <p><strong>Isi:</strong><br>{{ $pengaduan->isi_pengaduan }}</p>

    <form action="{{ route('admin.status', $pengaduan->id) }}" method="POST" class="mt-4">
        @csrf
        <label>Ubah Status:</label>
        <select name="status" class="form-select w-50 d-inline">
            <option value="Menunggu" {{ $pengaduan->status == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
            <option value="Diproses" {{ $pengaduan->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
            <option value="Selesai" {{ $pengaduan->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
        </select>
        <button class="btn btn-success">Update</button>
    </form>

    <a href="{{ route('admin.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection
