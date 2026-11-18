<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\Pengumuman;
use App\Models\JadwalLatihan;
use App\Models\JadwalSeleksi;
use Illuminate\Support\Facades\Auth;

class PendaftaranController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $siswa = $user->memberSiswa;

        $pendaftarans = Pendaftaran::with(['ekstrakurikuler'])
            ->where('member_id', $siswa->id)
            ->latest()
            ->get();

        return view('student.pendaftaran-saya', compact('pendaftarans'));
    }

    public function show($id)
    {
        $pendaftaran = Pendaftaran::with(['ekstrakurikuler', 'member'])
            ->where('member_id', auth()->user()->memberSiswa->id)
            ->findOrFail($id);

        return view('student.pendaftaran-saya-detail', compact('pendaftaran'));
    }

    // ✅ Cuma ada satu fungsi pengumumanSaya
    public function pengumumanSaya()
    {
        $user = auth()->user();
        $siswa = $user->memberSiswa;

        if (!$siswa) {
            return redirect()->route('student.beranda')->withErrors(['msg' => 'Profil siswa tidak ditemukan.']);
        }

        // 1. Ambil Pendaftaran
        $pendaftarans = Pendaftaran::where('member_id', $siswa->id)->get();
        $ekskulIds = $pendaftarans->pluck('ekstrakurikuler_id');
        $diterimaEkskulIds = $pendaftarans->where('status', 'diterima')->pluck('ekstrakurikuler_id');

        // 2. Ambil Pengumuman
        $pengumumans = Pengumuman::with('ekstrakurikuler')
            ->where(function ($query) use ($siswa, $ekskulIds) {
                $query->whereHas('peserta', function($q) use ($siswa) {
                    $q->where('nisn', $siswa->nisn);
                })->orWhereIn('ekstrakurikuler_id', $ekskulIds);
            })
            ->latest()
            ->get();

        // 3. Ambil Jadwal Latihan (Khusus yang diterima)
        $jadwalLatihans = JadwalLatihan::with('ekstrakurikuler')
            ->whereIn('ekstrakurikuler_id', $diterimaEkskulIds)
            ->get();

        // 4. Ambil Jadwal Seleksi (Dari pendaftaran siswa ini)
        $pendaftaranIds = $pendaftarans->pluck('id');
        $jadwalSeleksis = JadwalSeleksi::with(['pendaftaran.ekstrakurikuler'])
            ->whereIn('pendaftaran_id', $pendaftaranIds)
            ->get();

        return view('student.pengumuman-saya', compact('pengumumans', 'jadwalLatihans', 'jadwalSeleksis'));
    }
}