<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\Tanggapan; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class AdminPengaduanController extends Controller
{
    /**
     * Dashboard Admin
     */
    public function dashboard()
    {
        $total_pengaduan = Pengaduan::count();
        $selesai         = Pengaduan::where('status', 'Selesai')->count();
        $diproses        = Pengaduan::where('status', 'Sedang Diproses')->count();
        $pengaduans      = Pengaduan::latest()->take(10)->get();

        return view('admin.dashboard', compact(
            'total_pengaduan',
            'selesai',
            'diproses',
            'pengaduans'
        ));
    }

    /**
     * Daftar semua pengaduan
     */
    public function index()
    {
        $pengaduans = Pengaduan::latest()->get();
        return view('admin.pengaduan.index', compact('pengaduans'));
    }

    /**
     * Detail pengaduan
     */
    public function show($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        return view('admin.pengaduan.show', compact('pengaduan'));
    }

    /**
     * Update Status Pengaduan
     */
    public function updateStatus(Request $request, Pengaduan $pengaduan)
    {
        $request->validate([
            'status' => 'required|in:Menunggu Tindakan,Sedang Diproses,Selesai'
        ]);

        // Update status pengaduan
        $pengaduan->update([
            'status' => $request->status
        ]);

        // Simpan riwayat tanggapan
        Tanggapan::create([
            'pengaduan_id' => $pengaduan->id,
            'admin_id'     => auth('admin')->id(),
            'status'       => $request->status ?? 'Sedang Diproses',
        ]);

        return redirect()
            ->route('admin.pengaduan.show', $pengaduan->id)
            ->with('success', 'Status pengaduan berhasil diperbarui dan riwayat tanggapan tersimpan!');
    }

    /**
     * Export Laporan ke PDF dengan filter tanggal (opsional)
     */
    public function exportPdf(Request $request)
{
    $start = $request->query('start');
    $end   = $request->query('end');

    $query = Pengaduan::query();

    if ($start && $end) {
        try {
            $startDate = Carbon::parse($start)->startOfDay();
            $endDate   = Carbon::parse($end)->endOfDay();
            $query->whereBetween('created_at', [$startDate, $endDate]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Format tanggal tidak valid.');
        }
    }

    $pengaduans = $query->latest()->get();

    // ✅ Ambil nama admin yang sedang login
    $admin = Auth::guard('admin')->user();
    $namaAdmin = $admin ? $admin->name : 'Admin';

    $pdf = Pdf::loadView('admin.pengaduan.pdf', [
        'pengaduans' => $pengaduans,
        'start'      => $start,
        'end'        => $end,
        'namaAdmin'  => $namaAdmin,
    ])->setPaper('a4', 'landscape');

    $fileName = 'Laporan_Pengaduan_Dishub';
    if ($start && $end) {
        $fileName .= '_' . Carbon::parse($start)->format('d-m-Y')
                  . '_sd_' . Carbon::parse($end)->format('d-m-Y');
    } else {
        $fileName .= '_' . now()->format('d-m-Y');
    }
    $fileName .= '.pdf';

    return $pdf->stream($fileName);
}



}
