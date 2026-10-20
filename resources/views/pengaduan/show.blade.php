@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center">
                    <h3 class="mb-0">Detail Pengaduan Anda</h3>
                </div>
                <div class="card-body p-4">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">No. Pengaduan</th>
                            <td><strong>#{{ str_pad($pengaduan->id, 5, '0', STR_PAD_LEFT) }}</strong></td>
                        </tr>
                        <tr>
                            <th>Nama Pengadu</th>
                            <td>{{ $pengaduan->nama }}</td>
                        </tr>
                        <tr>
                            <th>Kategori</th>
                            <td>{{ ucfirst($pengaduan->kategori) }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Pengaduan</th>
                            <td>{{ $pengaduan->created_at->format('d F Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($pengaduan->status == 'Selesai')
                                    <span class="badge bg-success fs-6">Selesai</span>
                                @elseif($pengaduan->status == 'Menunggu Tindakan')
                                    <span class="badge bg-secondary fs-6">Menunggu</span>
                                @else
                                    <span class="badge bg-warning text-dark fs-6">Diproses</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Isi Pengaduan</th>
                            <td>{!! nl2br(e($pengaduan->isi_pengaduan)) !!}</td>
                        </tr>
                        @if($pengaduan->foto)
                        <tr>
                            <th>Foto Bukti</th>
                            <td>
                                <img src="{{ asset('storage/' . $pengaduan->foto) }}" 
                                     class="img-fluid rounded" style="max-height:400px;">
                            </td>
                        </tr>
                        @endif
                    </table>

                    <div class="text-center mt-4">
                        <a href="{{ route('home') }}" class="btn btn-secondary btn-lg">
                            Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection