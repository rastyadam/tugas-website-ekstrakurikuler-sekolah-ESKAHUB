<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MemberSiswa;
use App\Exports\SiswaExport;
use App\Imports\SiswaImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class DataSiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = MemberSiswa::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kelas')) {
            $query->where('kelas', $request->kelas);
        }

        $siswas = $query->orderBy('nama')->paginate(15)->withQueryString();

        $daftarKelas = MemberSiswa::query()
            ->select('kelas')
            ->whereNotNull('kelas')
            ->distinct()
            ->orderBy('kelas')
            ->pluck('kelas');

        return view('admin.datasiswa.index', compact('siswas', 'daftarKelas'));
    }

    public function export(Request $request)
    {
        $namaFile = 'data-siswa-' . now()->format('Y-m-d-His') . '.xlsx';

        return Excel::download(
            new SiswaExport($request->search, $request->kelas),
            $namaFile
        );
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:5120',
        ]);

        try {
            Excel::import(new SiswaImport, $request->file('file'));
            return redirect()
                ->route('admin.datasiswa.index')
                ->with('success', 'Data siswa berhasil diimport.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withErrors(['file' => 'Gagal import: ' . $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $siswa = MemberSiswa::findOrFail($id);
        return view('admin.datasiswa.show', compact('siswa'));
    }
}