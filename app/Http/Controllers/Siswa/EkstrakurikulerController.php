<?php

namespace App\Http\Controllers\Siswa; // ✅ SUDAH DIPERBAIKI

use App\Http\Controllers\Controller;
use App\Models\Ekstrakurikuler;
use App\Models\PesertaPendaftaran;
use App\Models\Pendaftaran;
use App\Models\GelombangPendaftaran;
use App\Models\DetailPersyaratanSiswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class EkstrakurikulerController extends Controller
{
   public function index(Request $request)
{
    $query = Ekstrakurikuler::where('status', 'aktif');

    // Filter Search
    if ($request->filled('search')) {
        $query->where('nama', 'like', '%' . $request->search . '%');
    }

    $ekskuls = $query->latest()->paginate(6)->withQueryString();
    
    return view('student.ekstra', compact('ekskuls'));
}

   public function show($id)
{
    // Ambil data ekskul beserta relasi pembina-nya
    $ekskul = \App\Models\Ekstrakurikuler::with('pembina')->findOrFail($id);
    
    // ✅ Hitung kuota terisi (status: pending atau diterima)
    $terisi = \App\Models\Pendaftaran::where('ekstrakurikuler_id', $ekskul->id)
        ->whereIn('status', ['pending', 'diterima'])
        ->count();

    // ✅ Hitung sisa kuota (jangan sampai minus)
    $sisaKuota = max(0, $ekskul->kuota - $terisi);
    
    return view('student.ekstra-detail', compact('ekskul', 'sisaKuota', 'terisi'));
}

        public function daftar(Request $request, $id)
    {
        $ekskul = Ekstrakurikuler::findOrFail($id);
        $user = Auth::user();
        $siswa = $user->memberSiswa;

        // 1. Validasi Dasar
        if (!$siswa) {
            return back()->withErrors(['msg' => 'Profil siswa tidak ditemukan.']);
        }

        if ($ekskul->status !== 'aktif') {
            return back()->withErrors(['msg' => 'Pendaftaran ditutup.']);
        }

        // 2. Validasi Input
        $request->validate([
            'tanggal_lahir' => 'required|date',
            'alokasi' => 'nullable|string|max:100',
            'berkas' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048', // Maks 2MB
        ]);

        // 3. Cek apakah sudah pernah daftar
        $sudahDaftar = Pendaftaran::where('member_id', $siswa->id)
            ->where('ekstrakurikuler_id', $ekskul->id)
            ->exists();

        if ($sudahDaftar) {
            return back()->withErrors(['msg' => 'Kamu sudah mendaftar di ekstrakurikuler ini.']);
        }

        // 4. Ambil Gelombang Aktif (Dinamis)
        $gelombangAktif = GelombangPendaftaran::where('status', 'aktif')->first();
        if (!$gelombangAktif) {
            return back()->withErrors(['msg' => 'Belum ada gelombang pendaftaran yang dibuka.']);
        }

        DB::transaction(function () use ($request, $ekskul, $siswa, $gelombangAktif) {
            // A. Simpan ke peserta_pendaftaran
            $peserta = PesertaPendaftaran::create([
                'gelombang_id' => $gelombangAktif->id, // ✅ Dinamis
                'nisn' => $siswa->nisn,
                'nama' => $siswa->nama,
                'tanggal_lahir' => $request->tanggal_lahir,
                'tanggal_daftar' => now(),
                'alokasi' => $request->alokasi,
            ]);

            // B. Simpan ke pendaftaran
            $pendaftaran = Pendaftaran::create([
                'nisn' => $siswa->nisn,
                'member_id' => $siswa->id,
                'peserta_id' => $peserta->id,
                'ekstrakurikuler_id' => $ekskul->id,
                'status' => 'pending',
                'nomor_pendaftaran' => 'REG-' . time() . '-' . $siswa->id,
                'tanggal_daftar' => now(),
            ]);

            // C. Handle Upload Berkas Persyaratan
            if ($request->hasFile('berkas')) {
                // Simpan file ke storage/app/public/berkas
                $path = $request->file('berkas')->store('berkas_siswa', 'public');

                // Simpan ke detail_persyaratan_siswa
                DetailPersyaratanSiswa::create([
                    'persyaratan_id' => 1, // Asumsi ID 1 = Kartu Pelajar/Ijazah
                    'peserta_id' => $peserta->id,
                    'member_id' => $siswa->id,
                    'berkas' => $path, // ⚠️ Pastikan kolom 'berkas' ada di tabel ini!
                ]);
            }
        });

        return redirect()->route('student.pendaftaran-saya')->with('success', 'Berhasil mendaftar!');
    }

        public function showFormDaftar($id)
    {
        $ekskul = Ekstrakurikuler::findOrFail($id);
        $user = Auth::user();
        $siswa = $user->memberSiswa;

        // Cek sudah daftar apa belum
        $sudahDaftar = Pendaftaran::where('member_id', $siswa->id)
            ->where('ekstrakurikuler_id', $ekskul->id)
            ->exists();

        if ($sudahDaftar) {
            return redirect()->route('student.pendaftaran-saya')->with('info', 'Kamu sudah mendaftar di ekskul ini.');
        }

        return view('student.daftar-pendaftaran', compact('ekskul', 'siswa'));
    }

}