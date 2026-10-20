<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengaduan - Dishub Cirebon</title>
    <style>
        body { 
            font-family: DejaVu Sans, sans-serif; 
            font-size: 10px; 
            color: #333; 
            margin: 20px; 
            line-height: 1.5; 
        }

        /* ================= KOP SURAT ================= */
        .kop { 
            width: 100%; 
            margin-bottom: 18px; 
        }
        .kop-table {
            width: 100%;
            border-collapse: collapse;
        }
        .kop-logo {
            width: 90px;
            vertical-align: middle;
        }
        .kop-text {
            text-align: center;
            vertical-align: middle;
        }
        .kop-text h1 {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
            letter-spacing: 0.5px;
        }
        .kop-text h2 {
            margin: 2px 0 4px 0;
            font-size: 20px;
            font-weight: bold;
            letter-spacing: 0.8px;
        }
        .kop-text p {
            margin: 2px 0;
            font-size: 9px;
            line-height: 1.4;
        }
        .kop-line {
            border-top: 3px solid #000;
            margin-top: 8px;
        }

        /* ================= HEADER ================= */
        .header { 
            text-align: center; 
            margin-bottom: 22px; 
        }
        .header h2 {
            margin: 0;
            font-size: 14px;
            font-weight: bold;
            letter-spacing: 0.5px;
        }
        .header p {
            margin: 4px 0;
            font-size: 10px;
        }

        /* ================= TABEL ================= */
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 14px; 
        }
        th { 
            background: #005b9f; 
            color: white; 
            padding: 10px 6px; 
            text-align: center; 
            font-weight: bold; 
            font-size: 9.5px; 
        }
        td { 
            padding: 8px 6px; 
            border-bottom: 1px solid #ddd; 
            vertical-align: top; 
            font-size: 9px; 
        }
        tr:nth-child(even) { 
            background-color: #f8f9fc; 
        }
        .text-left { text-align: left !important; }
        .text-center { text-align: center !important; }

        .kategori { 
            background: #005b9f; 
            color: white; 
            padding: 3px 9px; 
            border-radius: 12px; 
            font-size: 8.5px; 
            display: inline-block; 
        }
        .badge { 
            padding: 4px 10px; 
            border-radius: 20px; 
            color: white; 
            font-size: 8.5px; 
            font-weight: bold; 
            display: inline-block; 
        }
        .bg-success { background: #0d8b54; }
        .bg-info    { background: #0069d9; }
        .bg-warning { background: #f59e0b; color: #000; }

        .foto { 
            width: 55px; 
            height: 55px; 
            object-fit: cover; 
            border-radius: 6px; 
            border: 1px solid #ddd; 
        }
        .isi { 
            line-height: 1.5; 
            max-width: 320px; 
            word-wrap: break-word; 
        }
        .tanggal { white-space: nowrap; }

        /* ================= FOOTER ================= */
        .footer { 
            margin-top: 45px; 
            text-align: center; 
            color: #666; 
            font-size: 8.5px; 
            page-break-inside: avoid; 
        }
    </style>
</head>
<body>

    {{-- KOP SURAT --}}
    <div class="kop">
        <table class="kop-table">
            <tr>
                <td width="14%" class="kop-logo">
                    <img src="{{ public_path('logo_cirebon.png') }}" alt="Logo Cirebon" width="75">
                </td>
                <td width="86%" class="kop-text">
                    <h1>PEMERINTAH KOTA CIREBON</h1>
                    <h2>DINAS PERHUBUNGAN</h2>
                    <p>
                        Jalan Terusan Pemuda Nomor 8, Cirebon 45124 •
                        Telp. (0231) 489717 •
                        Email dishub@cirebonkota.go.id •
                        Website dishub.cirebonkota.go.id
                    </p>
                </td>
            </tr>
        </table>
        <div class="kop-line"></div>
    </div>

    {{-- JUDUL LAPORAN --}}
    <div class="header">
        <h2>LAPORAN PENGADUAN MASYARAKAT</h2>

        @if($start && $end)
            <p style="font-size:11px; color:#005b9f; font-weight:bold; margin:6px 0;">
                Periode: {{ \Carbon\Carbon::parse($start)->translatedFormat('d F Y') }}
                s/d {{ \Carbon\Carbon::parse($end)->translatedFormat('d F Y') }}
            </p>
        @endif

        <p>Dicetak pada: {{ now()->translatedFormat('d F Y H:i') }} WIB</p>
        <p><strong>Dicetak oleh: {{ $namaAdmin }}</strong></p>
    </div>

    {{-- TABEL DATA --}}
    <table>
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="11%">Tanggal & Jam</th>
                <th class="text-left" width="14%">Nama</th>
                <th class="text-left" width="16%">Kategori</th>
                <th class="text-left" width="27%">Isi Pengaduan</th>
                <th width="8%">Foto</th>
                <th width="10%">Email</th>
                <th width="10%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengaduans as $p)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                
                <td class="text-center tanggal">
                    {{ $p->created_at->format('d/m/Y') }}<br>
                    <small style="color:#666;">{{ $p->created_at->format('H:i') }} WIB</small>
                </td>
                
                <td class="text-left"><strong>{{ $p->nama }}</strong></td>
                
                <td class="text-left">
                    <span class="kategori">{{ $p->kategori }}</span>
                </td>
                
                <td class="text-left isi">
                    {{ \Illuminate\Support\Str::limit(strip_tags($p->isi_pengaduan), 180, '...') }}
                </td>
                
                <td class="text-center">
                    @if($p->foto && file_exists(public_path('storage/' . $p->foto)))
                        <img src="{{ public_path('storage/' . $p->foto) }}" alt="Foto Pengaduan" class="foto">
                    @else
                        <small style="color:#999;">Tidak ada</small>
                    @endif
                </td>
                
                <td>{{ $p->email }}</td>
                
                <td class="text-center">
                    @if($p->status == 'Selesai')
                        <span class="badge bg-success">Selesai</span>
                    @elseif($p->status == 'Sedang Diproses')
                        <span class="badge bg-info">Diproses</span>
                    @else
                        <span class="badge bg-warning">Menunggu</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center" style="padding:30px; color:#999;">
                    Tidak ada data pengaduan pada periode ini.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- FOOTER --}}
    <div class="footer">
        <p>© {{ date('Y') }} Dinas Perhubungan Kota Cirebon — Sistem Informasi Pengaduan Masyarakat</p>
        <p>Total Pengaduan pada Laporan Ini: {{ $pengaduans->count() }} pengaduan</p>
    </div>

</body>
</html>
