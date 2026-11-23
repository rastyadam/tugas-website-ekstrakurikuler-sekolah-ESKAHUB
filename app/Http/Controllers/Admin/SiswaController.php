<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SiswaImport;
use App\Models\MemberSiswa;

class SiswaController extends Controller
{
    // 1. Halaman Tampil Data Siswa
   public function index(Request $request)
{
    $query = MemberSiswa::with('pengguna');

    // ✅ Fitur Search
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('nama', 'like', "%{$search}%")
              ->orWhere('nisn', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        });
    }

    // ✅ Fitur Filter Kelas
    if ($request->filled('kelas')) {
        $query->where('kelas', $request->kelas);
    }

    $siswas = $query->latest()->paginate(10)->withQueryString();

    // ✅ Ambil daftar kelas unik buat dropdown filter
    $daftarKelas = MemberSiswa::select('kelas')->distinct()->pluck('kelas');

    return view('admin.datasiswa', compact('siswas', 'daftarKelas'));
}

    // 2. Proses Import Excel
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048'
        ]);

        try {
            Excel::import(new SiswaImport, $request->file('file'));
            return back()->with('success', 'Data siswa berhasil diimport!');
        } catch (\Exception $e) {
            return back()->withErrors(['msg' => 'Gagal import: ' . $e->getMessage()]);
        }
    }

    // ✅ 3. Halaman Detail Siswa (TAMBAHKAN INI)
    public function show($id)
    {
        $siswa = MemberSiswa::with('pengguna')->findOrFail($id);
        return view('admin.datasiswa-detail', compact('siswa'));
    }
    public function export()
{
    // Logic export Excel/CSV (Bisa pakai LaporanExport atau bikin baru)
    // Untuk sementara, kita redirect balik aja
    return back()->with('info', 'Fitur ekspor segera hadir.');
}
}