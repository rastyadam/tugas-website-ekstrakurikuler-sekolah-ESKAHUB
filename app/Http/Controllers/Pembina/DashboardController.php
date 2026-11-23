<?php

namespace App\Http\Controllers\Pembina;

use App\Http\Controllers\Controller;
use App\Models\Ekstrakurikuler;
use App\Models\Pendaftaran;
use App\Models\JadwalSeleksi;
use App\Models\Pengumuman;
use App\Models\JadwalLatihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; 

class DashboardController extends Controller
{
    // 1. Halaman Dashboard Pembina
   public function index(Request $request)
{
    $user = Auth::user();
    $pembina = $user->pembina;

    if (!$pembina) {
        return redirect('/')->withErrors(['msg' => 'Profil pembina tidak ditemukan.']);
    }

    $ekskuls = Ekstrakurikuler::where('pembina_id', $pembina->id)->get();
    $ekskulIds = $ekskuls->pluck('id');

    $totalPendaftar = Pendaftaran::whereIn('ekstrakurikuler_id', $ekskulIds)->count();
    $pendingPendaftar = Pendaftaran::whereIn('ekstrakurikuler_id', $ekskulIds)
        ->where('status', 'pending')
        ->count();

    // ===== TREN PENDAFTARAN PER MINGGU =====
    $periode = $request->get('periode', 'bulan_ini');
    $bulan = $periode === 'bulan_lalu'
        ? \Carbon\Carbon::now()->subMonth()
        : \Carbon\Carbon::now();

    $startOfMonth = $bulan->copy()->startOfMonth();
    $endOfMonth   = $bulan->copy()->endOfMonth();

    $jumlahMinggu = ceil($endOfMonth->day / 7);
    $labelsMinggu = [];
    $dataMinggu   = [];

    for ($i = 1; $i <= $jumlahMinggu; $i++) {
        $start = $startOfMonth->copy()->addDays(($i - 1) * 7);
        $end   = $start->copy()->addDays(6);
        if ($end->gt($endOfMonth)) {
            $end = $endOfMonth->copy();
        }

        $labelsMinggu[] = 'Minggu ' . $i;
        $dataMinggu[] = Pendaftaran::whereIn('ekstrakurikuler_id', $ekskulIds)
            ->whereBetween('tanggal_daftar', [$start->startOfDay(), $end->endOfDay()])
            ->count();
    }

    // ===== AKTIVITAS TERKINI =====
    $aktivitasTerkini = Pendaftaran::with(['member', 'ekstrakurikuler'])
        ->whereIn('ekstrakurikuler_id', $ekskulIds)
        ->orderByDesc('tanggal_daftar')
        ->orderByDesc('created_at')
        ->limit(5)
        ->get()
        ->map(function ($p) {
            return [
                'judul'  => 'Pendaftar baru: ' . ($p->member->nama ?? $p->nisn ?? '-')
                          . ' — ' . ($p->ekstrakurikuler->nama ?? '-'),
                'waktu'  => $p->tanggal_daftar ?? $p->created_at,
                'status' => $p->status,
            ];
        });

    return view('pembina.dashboard-pembina', compact(
        'ekskuls',
        'totalPendaftar',
        'pendingPendaftar',
        'labelsMinggu',
        'dataMinggu',
        'aktivitasTerkini',
        'periode',
    ));
}

    // 2. Halaman Daftar Pendaftar
    public function pendaftar(Request $request)
    {
        $user = Auth::user();
        $pembina = $user->pembina;
        $ekskulIds = Ekstrakurikuler::where('pembina_id', $pembina->id)->pluck('id');

        $pendaftarans = Pendaftaran::with(['ekstrakurikuler', 'member'])
            ->whereIn('ekstrakurikuler_id', $ekskulIds)
            ->latest()
            ->paginate(10);

        return view('pembina.pendaftar', compact('pendaftarans'));
    }

    // 3. Simpan Jadwal Seleksi (Untuk Ekskul yang butuh seleksi)
    public function simpanJadwalSeleksi(Request $request, $id)
    {
        $request->validate([
            'tahap_seleksi' => 'required|string|max:100',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'tempat' => 'required|string',
        ]);

        $pendaftaran = Pendaftaran::findOrFail($id);

        JadwalSeleksi::create([
            'pendaftaran_id' => $pendaftaran->id,
            'tahap_seleksi' => $request->tahap_seleksi,
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'tempat' => $request->tempat,
            'metode' => 'offline',
            'keterangan' => $request->keterangan,
        ]);

        return back()->with('success', 'Jadwal seleksi berhasil dibuat.');
    }

    // 4. Update Status (Terima/Tolak Setelah Seleksi)
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,diterima,ditolak',
            'alasan_penolakan' => 'nullable|string',
        ]);

        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->update(['status' => $request->status]);

        // Bikin Pengumuman Otomatis
        if ($request->status == 'ditolak') {
            Pengumuman::create([
                'peserta_id' => $pendaftaran->peserta_id,
                'ekstrakurikuler_id' => $pendaftaran->ekstrakurikuler_id,
                'judul' => 'Hasil Seleksi: ' . $pendaftaran->ekstrakurikuler->nama,
                'isi' => 'Maaf, kamu belum lolos seleksi. Alasan: ' . $request->alasan_penolakan,
                'alasan_penolakan' => $request->alasan_penolakan,
                'status' => 'Tidak Lulus',
                'tanggal_daftar' => now(),
            ]);
        } elseif ($request->status == 'diterima') {
            Pengumuman::create([
                'peserta_id' => $pendaftaran->peserta_id,
                'ekstrakurikuler_id' => $pendaftaran->ekstrakurikuler_id,
                'judul' => 'Hasil Seleksi: ' . $pendaftaran->ekstrakurikuler->nama,
                'isi' => 'Selamat! Kamu dinyatakan LULUS seleksi.',
                'status' => 'Lulus',
                'tanggal_daftar' => now(),
            ]);
        }

        return back()->with('success', 'Status pendaftaran diperbarui & pengumuman dibuat.');
    }

    // 5. Terima Langsung (Tanpa Seleksi)
    public function terimaLangsung($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        
        // Update Status
        $pendaftaran->update(['status' => 'diterima']);

        // Bikin Pengumuman Otomatis
        Pengumuman::create([
            'peserta_id' => $pendaftaran->peserta_id,
            'ekstrakurikuler_id' => $pendaftaran->ekstrakurikuler_id,
            'judul' => 'Hasil Seleksi: ' . $pendaftaran->ekstrakurikuler->nama,
            'isi' => 'Selamat! Kamu dinyatakan DITERIMA di ekstrakurikuler ini tanpa seleksi.',
            'status' => 'Lulus',
            'tanggal_daftar' => now(),
        ]);

        return back()->with('success', 'Siswa diterima tanpa seleksi & pengumuman dibuat.');
    }

    // 6. Simpan Pengumuman Umum (Info Libur, Jadwal Latihan, dll)
    public function simpanPengumuman(Request $request)
    {
        $request->validate([
            'ekstrakurikuler_id' => 'required|exists:ekstrakurikuler,id',
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
        ]);

        Pengumuman::create([
            'ekstrakurikuler_id' => $request->ekstrakurikuler_id,
            'judul' => $request->judul,
            'isi' => $request->isi,
            'status' => 'Lulus', // Bebas, nggak ngaruh
            'tanggal_daftar' => now(),
        ]);

        return back()->with('success', 'Pengumuman berhasil dibuat.');
    }

        // 7. Halaman Pengaturan Jadwal Latihan
    public function jadwalLatihan()
    {
        $user = Auth::user();
        $pembina = $user->pembina;
        
        // Ambil ekskul yang diampu beserta jadwal latihannya
        $ekskuls = Ekstrakurikuler::with('jadwalLatihan')
            ->where('pembina_id', $pembina->id)
            ->get();

        return view('pembina.jadwal-latihan', compact('ekskuls'));
    }

    // 8. Simpan Jadwal Latihan
    public function simpanJadwalLatihan(Request $request, $ekstrakurikuler_id)
    {
        $request->validate([
            'jenis_latihan' => 'required|string|max:100',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'tempat' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        JadwalLatihan::create([
            'ekstrakurikuler_id' => $ekstrakurikuler_id,
            'jenis_latihan' => $request->jenis_latihan,
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'tempat' => $request->tempat,
            'keterangan' => $request->keterangan,
        ]);

        return back()->with('success', 'Jadwal latihan berhasil ditambahkan.');
    }

public function anggota(Request $request)
{
    $user = Auth::user();
    $pembina = $user->pembina;
    $ekskulIds = Ekstrakurikuler::where('pembina_id', $pembina->id)->pluck('id');

    // Query dasar: Ambil pendaftaran yang DITERIMA di ekskul yang diampu
    $query = Pendaftaran::with(['member', 'ekstrakurikuler'])
        ->whereIn('ekstrakurikuler_id', $ekskulIds)
        ->where('status', 'diterima');

    // Fitur Search (berdasarkan nama atau NISN)
    if ($request->filled('search')) {
        $search = $request->search;
        $query->whereHas('member', function($q) use ($search) {
            $q->where('nama', 'like', "%{$search}%")
              ->orWhere('nisn', 'like', "%{$search}%");
        });
    }

    // Fitur Filter Kelas
    if ($request->filled('kelas')) {
        $query->whereHas('member', function($q) use ($request) {
            $q->where('kelas', $request->kelas);
        });
    }

    $members = $query->latest()->paginate(10);

    return view('pembina.anggota', compact('members'));
}


public function exportAnggota()
{
    $user = Auth::user();
    $pembina = $user->pembina;
    $ekskulIds = Ekstrakurikuler::where('pembina_id', $pembina->id)->pluck('id');

    $members = Pendaftaran::with(['member', 'ekstrakurikuler'])
        ->whereIn('ekstrakurikuler_id', $ekskulIds)
        ->where('status', 'diterima')
        ->get();

    $filename = 'anggota_ekskul_' . date('Ymd_His') . '.csv';
    $handle = fopen('php://output', 'w');
    
    // Header CSV
    fputcsv($handle, ['Nama', 'NISN', 'Email', 'Kelas', 'Jurusan', 'Ekstrakurikuler', 'Tanggal Bergabung']);

    // Isi CSV
    foreach ($members as $m) {
        fputcsv($handle, [
            $m->member->nama ?? '-',
            $m->member->nisn ?? '-',
            $m->member->email ?? '-',
            $m->member->kelas ?? '-',
            $m->member->jurusan ?? '-',
            $m->ekstrakurikuler->nama ?? '-',
            \Carbon\Carbon::parse($m->tanggal_daftar)->format('d M Y'),
        ]);
    }
    fclose($handle);

    return response()->streamDownload(function () use ($handle) {
        // Konten udah di-generate di atas
    }, $filename, [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => 'attachment; filename="' . $filename . '"',
    ]);
}

        // 9. Halaman Kelola Pengumuman
    public function pengumuman()
    {
        $user = Auth::user();
        $pembina = $user->pembina;
        
        // Ambil ekskul yang diampu
        $ekskuls = Ekstrakurikuler::where('pembina_id', $pembina->id)->get();
        $ekskulIds = $ekskuls->pluck('id');

        // Ambil pengumuman yang dibuat untuk ekskul-ekskul tersebut
        $pengumumans = Pengumuman::with('ekstrakurikuler')
            ->whereIn('ekstrakurikuler_id', $ekskulIds)
            ->latest()
            ->get();

        return view('pembina.pengumuman', compact('ekskuls', 'pengumumans'));
    }

    public function profil()
    {
        $user = Auth::user();
        // Ambil ekskul yang diampu pembina ini (buat list di sidebar)
        $ekskuls = Ekstrakurikuler::where('pembina_id', $user->pembina->id ?? 0)->get();
        
        return view('pembina.profil', compact('user', 'ekskuls'));
    }

    // 12. Update Profil (Nama, Email, No HP)
    public function updateProfil(Request $request)
    {
        $user = Auth::user();
        $pembina = $user->pembina;

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pengguna,email,' . $user->id,
            'no_hp' => 'nullable|string|max:20',
        ]);

        $user->update([
            'nama' => $request->nama,
            'email' => $request->email,
        ]);

        if ($pembina) {
            $pembina->update([
                'nama' => $request->nama,
                'no_hp' => $request->no_hp,
            ]);
        }

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    // 13. Update Password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'kata_sandi_lama' => 'required',
            'kata_sandi' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->kata_sandi_lama, $user->kata_sandi)) {
            return back()->withErrors(['kata_sandi_lama' => 'Password lama tidak cocok.']);
        }

        $user->update([
            'kata_sandi' => Hash::make($request->kata_sandi),
        ]);

        return back()->with('success', 'Password berhasil diperbarui!');
    }

    
}