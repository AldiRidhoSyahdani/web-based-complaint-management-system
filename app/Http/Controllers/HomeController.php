<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // Statistik umum
        $total = Pengaduan::count();
        $diproses = Pengaduan::whereIn('status', ['Sedang Diproses', 'diproses', 'Diproses'])->count();
        $ditangani = Pengaduan::where('status', 'Selesai')->count();

        // Pengaduan milik user login
        $pengaduanSaya = Pengaduan::where('user_id', Auth::id())
            ->latest()
            ->with('user')
            ->paginate(10);

        return view('home', compact('total', 'diproses', 'ditangani', 'pengaduanSaya'));
    }
}
