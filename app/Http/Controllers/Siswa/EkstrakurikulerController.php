<?php

namespace App\Http\Controllers\Siswa; 

use App\Http\Controllers\Controller;
use App\Models\Ekstrakurikuler;
use App\Models\PesertaPendaftaran;
use App\Models\Pendaftaran;
use App\Models\GelombangPendaftaran;
use App\Models\DetailPersyaratanSiswa;
use App\Models\Persyaratan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class EkstrakurikulerController extends Controller
{
  
public function index(Request $request)
{
    $query = Ekstrakurikuler::query()
        ->select([
            'id',
            'nama',
            'foto',
            'logo',
            'deskripsi',
            'kuota',
            'status',
            'pembina_id',
            'hari',
            'tanggal_mulai',
            'jam_mulai',
            'jam_selesai',
        ])
        ->where('status', 'aktif');

    if ($request->filled('search')) {
        $query->where('nama', 'like', '%' . $request->search . '%');
    }

    $ekskuls = $query->latest()->paginate(6)->withQueryString();

    // Cek apakah masih ada halaman berikutnya
    $hasMore = $ekskuls->hasMorePages();

    return view('student.ekstra', compact('ekskuls', 'hasMore'));
}

public function loadMore(Request $request)
{
    $query = Ekstrakurikuler::query()
        ->select([
            'id',
            'nama',
            'foto',
            'logo',
            'deskripsi',
            'kuota',
            'status',
            'pembina_id',
            'hari',
            'tanggal_mulai',
            'jam_mulai',
            'jam_selesai',
        ])
        ->where('status', 'aktif');

    // Filter pencarian
    if ($request->filled('search')) {
        $query->where('nama', 'like', '%' . $request->search . '%');
    }

    // Ambil 6 data sesuai halaman yang diminta
    $ekskuls = $query->latest()->paginate(6);

    return response()->json([
        'html' => view(
            'student.layouts.partials.ekstra-card',
            ['ekskuls' => $ekskuls]
        )->render(),

        'hasMore' => $ekskuls->hasMorePages(),

        'nextPage' => $ekskuls->currentPage() + 1,
    ]);
}
  
public function show($id)
{
  
    $ekskul = Ekstrakurikuler::with('pembina')->findOrFail($id);

    $terisi = Pendaftaran::where('ekstrakurikuler_id', $ekskul->id)
        ->whereIn('status', ['pending', 'diterima'])
        ->count();

    $sisaKuota = max(0, $ekskul->kuota - $terisi);

    $persyaratans = Persyaratan::where(function ($query) use ($ekskul) {
        $query->whereNull('ekstrakurikuler_id')
            ->orWhere('ekstrakurikuler_id', $ekskul->id);
    })->orderBy('id')->get();

    return view('student.ekstra-detail', compact(
        'ekskul',
        'sisaKuota',
        'terisi',
        'persyaratans'
    ));
      dd([
    'id_ekstrakurikuler' => $ekstrakurikuler->id,
    'nama_ekstrakurikuler' => $ekstrakurikuler->nama,
    'persyaratan' => $persyaratans->toArray(),
]);
}


       

public function daftar(Request $request, $id)
{
    $ekskul = Ekstrakurikuler::findOrFail($id);

    $user = Auth::user();
    $siswa = $user->memberSiswa;

    if (!$siswa) {
        return back()->withErrors([
            'msg' => 'Profil siswa tidak ditemukan.'
        ]);
    }

    if ($ekskul->status !== 'aktif') {
        return back()->withErrors([
            'msg' => 'Pendaftaran ekstrakurikuler ini sudah ditutup.'
        ]);
    }

    // Cek apakah siswa sudah pernah mendaftar
    $sudahDaftar = Pendaftaran::where('member_id', $siswa->id)
        ->where('ekstrakurikuler_id', $ekskul->id)
        ->exists();

    if ($sudahDaftar) {
        return back()->withErrors([
            'msg' => 'Kamu sudah mendaftar di ekstrakurikuler ini.'
        ]);
    }

    // Ambil persyaratan umum dan persyaratan khusus ekstrakurikuler
    $persyaratans = Persyaratan::where(function ($query) use ($ekskul) {
        $query->whereNull('ekstrakurikuler_id')
            ->orWhere('ekstrakurikuler_id', $ekskul->id);
    })->orderBy('id')->get();

    // Validasi data tambahan siswa
    $rules = [
        'tanggal_lahir' => 'required|date',
        'alokasi' => 'nullable|string|max:100',
    ];

    // Validasi hanya untuk persyaratan yang membutuhkan unggahan
    foreach ($persyaratans as $persyaratan) {
        $idPersyaratan = $persyaratan->id;
        $tipe = strtolower(trim($persyaratan->tipe_persyaratan ?? ''));
        $wajib = strtolower(trim($persyaratan->status)) === 'wajib';

        if ($tipe === 'teks') {
            // Persyaratan teks hanya informasi.
            // Siswa tidak perlu mengisi jawaban.
            continue;
        }

        if ($tipe === 'dokumen') {
            $rules["berkas.$idPersyaratan"] = $wajib
                ? 'required|file|mimes:pdf|max:5120'
                : 'nullable|file|mimes:pdf|max:5120';
        } elseif ($tipe === 'gambar') {
            $rules["berkas.$idPersyaratan"] = $wajib
                ? 'required|image|mimes:jpg,jpeg,png|max:5120'
                : 'nullable|image|mimes:jpg,jpeg,png|max:5120';
        } else {
            return back()->withErrors([
                'msg' => "Tipe persyaratan {$persyaratan->nama} belum didukung."
            ])->withInput();
        }
    }

    // Jalankan validasi
    $request->validate($rules, [
        'required' => 'Persyaratan wajib harus diunggah.',
        'file' => 'File yang diunggah tidak valid.',
        'image' => 'File harus berupa gambar.',
        'mimes' => 'Format file tidak sesuai dengan persyaratan.',
        'max' => 'Ukuran file maksimal 2 MB.',
    ]);

    $fileTersimpan = [];

    try {
        DB::transaction(function () use (
            $request,
            $ekskul,
            $siswa,
            $persyaratans,
            &$fileTersimpan
        ) {
            // Kunci data ekstrakurikuler saat memeriksa kuota
            $ekskulTerkunci = Ekstrakurikuler::whereKey($ekskul->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($ekskulTerkunci->status !== 'aktif') {
                throw new \RuntimeException(
                    'Pendaftaran ekstrakurikuler sudah ditutup.'
                );
            }

            // Cek ulang pendaftaran ganda
            $sudahDaftar = Pendaftaran::where('member_id', $siswa->id)
                ->where('ekstrakurikuler_id', $ekskul->id)
                ->exists();

            if ($sudahDaftar) {
                throw new \RuntimeException(
                    'Kamu sudah mendaftar di ekstrakurikuler ini.'
                );
            }

            // Hitung kuota yang sudah terisi
            $terisi = Pendaftaran::where(
                'ekstrakurikuler_id',
                $ekskul->id
            )
                ->whereIn('status', ['pending', 'diterima'])
                ->count();

            if ($terisi >= $ekskulTerkunci->kuota) {
                throw new \RuntimeException(
                    'Maaf, kuota ekstrakurikuler sudah penuh.'
                );
            }

            // Cari gelombang pendaftaran yang sedang berlangsung
            $gelombangAktif = GelombangPendaftaran::where('status', 'aktif')
                ->where(function ($query) {
                    $query->whereNull('tanggal_mulai')
                        ->orWhereDate('tanggal_mulai', '<=', today());
                })
                ->where(function ($query) {
                    $query->whereNull('tanggal_selesai')
                        ->orWhereDate('tanggal_selesai', '>=', today());
                })
                ->first();

            if (!$gelombangAktif) {
                throw new \RuntimeException(
                    'Belum ada gelombang pendaftaran yang dibuka.'
                );
            }

            // Buat data peserta
            $peserta = PesertaPendaftaran::create([
                'gelombang_id' => $gelombangAktif->id,
                'nisn' => $siswa->nisn,
                'nama' => $siswa->nama,
                'tanggal_lahir' => $request->tanggal_lahir,
                'tanggal_daftar' => now(),
                'alokasi' => $request->alokasi,
            ]);

            // Buat data pendaftaran
            Pendaftaran::create([
                'nisn' => $siswa->nisn,
                'member_id' => $siswa->id,
                'peserta_id' => $peserta->id,
                'ekstrakurikuler_id' => $ekskul->id,
                'status' => 'pending',
                'nomor_pendaftaran' => 'REG-' . now()->format('YmdHis')
                    . '-' . $siswa->id,
                'tanggal_daftar' => now(),
            ]);

            // Simpan hanya persyaratan yang membutuhkan unggahan file
            foreach ($persyaratans as $persyaratan) {
                $idPersyaratan = $persyaratan->id;
                $tipe = strtolower(trim(
                    $persyaratan->tipe_persyaratan ?? ''
                ));

                // Persyaratan teks hanya informasi.
                // Tidak membuat detail jawaban siswa.
                if ($tipe === 'teks') {
                    continue;
                }

                // Ambil file berdasarkan ID persyaratan
                $file = $request->file("berkas.$idPersyaratan");

                // Persyaratan opsional boleh tidak diunggah
                if (!$file) {
                    continue;
                }

                // Simpan file ke storage/app/public/berkas_siswa
                $path = $file->store('berkas_siswa', 'public');

                $fileTersimpan[] = $path;

                // Simpan detail unggahan siswa
                DetailPersyaratanSiswa::create([
                    'persyaratan_id' => $idPersyaratan,
                    'peserta_id' => $peserta->id,
                    'member_id' => $siswa->id,
                    'berkas_siswa' => $path,
                    'status_verifikasi' => 'menunggu',
                ]);
            }
        });
    } catch (\Throwable $e) {
        // Hapus file jika transaksi database gagal
        foreach ($fileTersimpan as $path) {
            Storage::disk('public')->delete($path);
        }

        return back()->withErrors([
            'msg' => $e instanceof \RuntimeException
                ? $e->getMessage()
                : 'Pendaftaran gagal disimpan. Silakan coba kembali.'
        ])->withInput();
    }

    return redirect()->route('student.pendaftaran-saya')
        ->with(
            'success',
            'Berhasil mendaftar! Silakan pantau proses verifikasi persyaratanmu.'
        );
}


      
public function showFormDaftar($id)
{
    $ekskul = Ekstrakurikuler::findOrFail($id);

    $user = Auth::user();
    $siswa = $user->memberSiswa;

    if (!$siswa) {
        return redirect()->back()->withErrors([
            'msg' => 'Profil siswa tidak ditemukan.'
        ]);
    }

    $sudahDaftar = Pendaftaran::where('member_id', $siswa->id)
        ->where('ekstrakurikuler_id', $ekskul->id)
        ->exists();

    if ($sudahDaftar) {
        return redirect()->route('student.pendaftaran-saya')
            ->with('info', 'Kamu sudah mendaftar di ekstrakurikuler ini.');
    }

    $persyaratans = Persyaratan::where(function ($query) use ($ekskul) {
        $query->whereNull('ekstrakurikuler_id')
            ->orWhere('ekstrakurikuler_id', $ekskul->id);
    })->orderBy('id')->get();

    return view('student.daftar-pendaftaran', compact(
        'ekskul',
        'siswa',
        'persyaratans'
    ));
}

}