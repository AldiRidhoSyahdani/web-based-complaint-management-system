<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;

class AdminStatistikController extends Controller
{
    public function index()
    {
        // Total semua pengaduan
        $total = Pengaduan::count();

        // Selesai
        $selesai = Pengaduan::where('status', 'Selesai')->count();

        // SEDANG DIPROSES = "Sedang Diproses" + "Menunggu Tindakan"
        // INI YANG HARUS SAMA PERSIS DENGAN DASHBOARD!
        $diproses = Pengaduan::whereIn('status', ['Sedang Diproses', 'Menunggu Tindakan'])->count();

        // Menunggu Tindakan saja (untuk ditampilkan terpisah)
        $menunggu = Pengaduan::where('status', 'Menunggu Tindakan')->count();

        // Untuk Chart Doughnut (langsung kirim angka mentah)
        $chartSelesai  = $selesai;
        $chartDiproses = Pengaduan::where('status', 'Sedang Diproses')->count(); // hanya yang benar-benar sedang diproses
        $chartMenunggu = $menunggu;

        return view('admin.statistik.index', compact(
            'total',
            'selesai',
            'diproses',
            'menunggu',
            'chartSelesai',
            'chartDiproses',
            'chartMenunggu'
        ));
    }
}