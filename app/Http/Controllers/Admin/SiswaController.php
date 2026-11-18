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
    public function index()
    {
        $siswas = MemberSiswa::with('pengguna')->latest()->paginate(10);
        return view('admin.datasiswa', compact('siswas'));
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
}