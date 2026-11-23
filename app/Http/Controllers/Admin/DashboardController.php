<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MemberSiswa;
use App\Models\Ekstrakurikuler;
use App\Models\Pendaftaran;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // ===== 1. STATISTIK ATAS =====
        $totalSiswa = MemberSiswa::count();
        $totalEkskul = Ekstrakurikuler::where('status', 'aktif')->count();
        $pendaftaranTertunda = Pendaftaran::where('status', 'pending')->count();

        // Rata-rata presensi: kalau belum ada tabel presensi,
        // pakai persentase pendaftaran diterima sebagai proxy metric
        $totalPendaftaran = Pendaftaran::count();
        $pendaftaranDiterima = Pendaftaran::where('status', 'diterima')->count();
        $rataPresensi = $totalPendaftaran > 0
            ? round(($pendaftaranDiterima / $totalPendaftaran) * 100, 1)
            : 0;

        // ===== 2. TREN PENDAFTARAN 7 HARI TERAKHIR =====
        $labelsMingguan = [];
        $pendaftaranMingguan = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $labelsMingguan[] = $date->translatedFormat('D'); // Sen, Sel, Rab...
            $pendaftaranMingguan[] = Pendaftaran::whereDate('tanggal_daftar', $date)->count();
        }

        // ===== 3. DISTRIBUSI PENDAFTAR PER EKSTRAKURIKULER =====
        // Ini menggantikan "distribusiKategori" — datanya real dari relasi
        $distribusiKategori = Pendaftaran::query()
            ->join('ekstrakurikuler', 'pendaftaran.ekstrakurikuler_id', '=', 'ekstrakurikuler.id')
            ->select('ekstrakurikuler.nama as nama', DB::raw('count(*) as total'))
            ->groupBy('ekstrakurikuler.id', 'ekstrakurikuler.nama')
            ->orderByDesc('total')
            ->limit(6)
            ->pluck('total', 'nama')
            ->toArray();

        // ===== 4. STATUS PENDAFTARAN (opsional, buat card tambahan) =====
        $statusPendaftaran = Pendaftaran::query()
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        return view('admin.dashboard', compact(
            'totalSiswa',
            'totalEkskul',
            'pendaftaranTertunda',
            'rataPresensi',
            'labelsMingguan',
            'pendaftaranMingguan',
            'distribusiKategori',
            'statusPendaftaran',
            'totalPendaftaran',
            'pendaftaranDiterima',
        ));
    }
}