<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ekstrakurikuler;
use App\Models\Pendaftaran;
use App\Models\MemberSiswa;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanExport;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index()
    {
        // 1. Statistik Atas
        $totalSiswa = MemberSiswa::count();
        $programAktif = Ekstrakurikuler::where('status', 'aktif')->count();
        $pendaftaranBaru = Pendaftaran::whereMonth('created_at', now()->month)->count(); 
        
        // 2. Data Tabel (Ekskul beserta jumlah pendaftar dan kehadiran)
        // Kita pakai withCount buat ngitung jumlah pendaftar (yang statusnya diterima)
        $ekskuls = Ekstrakurikuler::with('pembina')
            ->withCount(['pendaftarans as total_peserta' => function ($query) {
                $query->where('status', 'diterima');
            }])
            ->latest()
            ->paginate(10);

        // 3. Hitung Rata-rata Kehadiran (Simulasi, karena tabel absensi belum ada)
        // Karena belum ada tabel absensi, kita pakai angka random atau rumus dummy buat presentasi
        $totalKehadiran = 0;
        foreach ($ekskuls as $ekskul) {
            // Anggap saja kehadiran 80-98% (simulasi)
            $ekskul->persentase_kehadiran = rand(80, 98); 
            $totalKehadiran += $ekskul->persentase_kehadiran;
        }
        
        $rataKehadiran = $ekskuls->count() > 0 ? round($totalKehadiran / $ekskuls->count()) : 0;

        return view('admin.laporan', compact(
            'totalSiswa', 
            'programAktif', 
            'pendaftaranBaru', 
            'rataKehadiran',
            'ekskuls'
        ));

    }
       public function export()
    {
        return Excel::download(new LaporanExport, 'laporan_ekstrakurikuler_' . date('Ymd') . '.xlsx');
    }
}