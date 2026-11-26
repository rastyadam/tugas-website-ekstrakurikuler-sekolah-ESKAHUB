<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Ekstrakurikuler;
use App\Models\Pendaftaran;

class BerandaController extends Controller
{
    public function index()
    {
        // Ambil 6 ekstrakurikuler aktif pertama
        $ekskuls = Ekstrakurikuler::where('status', 'aktif')
            ->latest()
            ->paginate(6);

        // Cek apakah masih ada data berikutnya
        $hasMore = $ekskuls->hasMorePages();

        return view('student.beranda', compact('ekskuls', 'hasMore'));
    }

    public function pendaftaranSaya()
    {
        $user = auth()->user();
        $siswa = $user->memberSiswa;

        // Ambil data pendaftaran milik siswa yang login
        $pendaftarans = Pendaftaran::with(['ekstrakurikuler'])
            ->where('member_id', $siswa->id)
            ->latest()
            ->get();

        return view('student.pendaftaran-saya', compact('pendaftarans'));
    }

    public function profil()
    {
        $user = auth()->user();
        $siswa = $user->memberSiswa;

        if (!$siswa) {
            return redirect()->route('student.beranda')
                ->withErrors(['msg' => 'Profil siswa tidak ditemukan.']);
        }

        return view('student.profil', compact('siswa'));
    }

    public function pengumumanSaya()
    {
        $user = auth()->user();
        $siswa = $user->memberSiswa;

        if (!$siswa) {
            return redirect()->route('student.beranda')
                ->withErrors(['msg' => 'Profil siswa tidak ditemukan.']);
        }

        // 1. Ambil ID ekskul yang diikuti siswa ini
        $pendaftarans = \App\Models\Pendaftaran::where('member_id', $siswa->id)->get();

        $ekskulIds = $pendaftarans->pluck('ekstrakurikuler_id');

        // 2. Ambil ID ekskul yang statusnya DITERIMA
        $diterimaEkskulIds = $pendaftarans
            ->where('status', 'diterima')
            ->pluck('ekstrakurikuler_id');

        // 3. Ambil pengumuman
        $pengumumans = \App\Models\Pengumuman::with('ekstrakurikuler')
            ->where(function ($query) use ($siswa, $ekskulIds) {
                $query->whereHas('peserta', function ($q) use ($siswa) {
                    $q->where('nisn', $siswa->nisn);
                })->orWhereIn('ekstrakurikuler_id', $ekskulIds);
            })
            ->latest()
            ->get();

        // 4. Ambil jadwal latihan khusus ekskul yang diterima
        $jadwalLatihans = \App\Models\JadwalLatihan::with('ekstrakurikuler')
            ->whereIn('ekstrakurikuler_id', $diterimaEkskulIds)
            ->get();

        return view('student.pengumuman-saya', compact(
            'pengumumans',
            'jadwalLatihans'
        ));
    }
}
