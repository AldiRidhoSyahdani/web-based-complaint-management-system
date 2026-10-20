<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengaduanController extends Controller
{
    // === BAGIAN MASYARAKAT ===

    // Halaman form pengaduan
    public function form()
    {
        return view('pengaduan.form');
    }

    // Simpan pengaduan baru — VERSI FINAL
    public function store(Request $request)
    {
        // Aturan validasi dasar (selalu wajib)
        $rules = [
            'kategori'      => 'required|in:' . implode(',', Pengaduan::KATEGORI),
            'isi_pengaduan' => 'required|string',
            'foto'          => 'required|image|mimes:jpg,jpeg,png|max:5120', // FOTO WAJIB!
        ];

        // Jika user BELUM login → wajib isi nama & email manual
        if (!Auth::check()) {
            $rules['nama']  = 'required|string|max:100';
            $rules['email'] = 'required|email|max:100';
        }

        // Validasi sesuai kondisi
        $request->validate($rules);

        // Upload foto (wajib, jadi pasti ada)
        $foto = $request->file('foto')->store('foto_pengaduan', 'public');

        // Simpan ke database
        Pengaduan::create([
            'nama'          => Auth::check() ? Auth::user()->name : $request->nama,
            'email'         => Auth::check() ? Auth::user()->email : $request->email,
            'kategori'      => $request->kategori,
            'isi_pengaduan' => $request->isi_pengaduan,
            'foto'          => $foto,
            'status'        => 'Menunggu Tindakan',
            'user_id'       => Auth::id(), // null jika belum login → tetap aman
        ]);

        return redirect()->route('home')->with('success', 'Pengaduan berhasil dikirim!');
    }

    // Detail pengaduan — hanya pemilik yang boleh lihat
    public function show(Pengaduan $pengaduan)
    {
        // Cek kepemilikan (jika user_id null = pengaduan anonim, tetap boleh lihat jika cocok nama/email?)
        if ($pengaduan->user_id && Auth::id() !== $pengaduan->user_id) {
            abort(403, 'Anda tidak diizinkan melihat pengaduan ini.');
        }

        return view('pengaduan.show', compact('pengaduan'));
    }

    // === BAGIAN ADMIN (TETAP SEPERTI SEMULA) ===

    public function index()
    {
        $pengaduans = Pengaduan::latest()->get();
        return view('admin.pengaduan.index', compact('pengaduans'));
    }

    public function dashboard()
    {
        $total      = Pengaduan::count();
        $ditangani  = Pengaduan::where('status', 'Selesai')->count();
        $menunggu   = Pengaduan::where('status', 'Menunggu Tindakan')->count();
        $pengaduans = Pengaduan::latest()->take(5)->get();

        return view('admin.index', compact('total', 'ditangani', 'menunggu', 'pengaduans'));
    }

    public function detail($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        return view('admin.pengaduan.detail', compact('pengaduan'));
    }

    public function statistik() 
    {
        $total    = Pengaduan::count();
        $selesai  = Pengaduan::where('status', 'Selesai')->count();
        $menunggu = Pengaduan::where('status', 'Menunggu Tindakan')->count();

        return view('admin.statistik.index', compact('total', 'selesai', 'menunggu'));
    }

    public function akun()
    {
        return view('admin.akun.index');
    }
}