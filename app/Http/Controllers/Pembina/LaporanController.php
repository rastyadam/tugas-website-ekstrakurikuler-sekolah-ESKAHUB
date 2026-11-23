<?php

namespace App\Http\Controllers\Pembina;

use App\Http\Controllers\Controller;
use App\Models\Ekstrakurikuler;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
   public function index(Request $request)
{
    $user = Auth::user();
    $pembina = $user->pembina;

    if (!$pembina) {
        return redirect('/')->withErrors(['msg' => 'Profil pembina tidak ditemukan.']);
    }

    // ✅ Ambil ekskul yang diampu
    $daftarEkstrakurikuler = Ekstrakurikuler::where('pembina_id', $pembina->id)->get();
    $ekskulIds = $daftarEkstrakurikuler->pluck('id');

    $query = Pendaftaran::with(['member', 'ekstrakurikuler'])
        ->whereIn('ekstrakurikuler_id', $ekskulIds);

    // Pencarian
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('nomor_pendaftaran', 'like', "%{$search}%")
                ->orWhere('nisn', 'like', "%{$search}%")
                ->orWhereHas('member', fn($m) => $m->where('nama', 'like', "%{$search}%"))
                ->orWhereHas('ekstrakurikuler', fn($e) => $e->where('nama', 'like', "%{$search}%"));
        });
    }

    // ✅ Filter ekskul (opsional)
    if ($request->filled('ekstrakurikuler_id')) {
        $query->where('ekstrakurikuler_id', $request->ekstrakurikuler_id);
    }

    // Filter tanggal
    if ($request->filled('start_date')) {
        $query->whereDate('tanggal_daftar', '>=', $request->start_date);
    }
    if ($request->filled('end_date')) {
        $query->whereDate('tanggal_daftar', '<=', $request->end_date);
    }

    // Filter status
    if ($request->filled('status')) {
        $query->where('status', strtolower($request->status));
    }

    $totalPendaftar = (clone $query)->count();

    $totalAnggotaAktif = (clone $query)
        ->where('status', 'diterima')
        ->distinct('member_id')
        ->count('member_id');

    $pendaftars = (clone $query)
        ->orderByDesc('tanggal_daftar')
        ->orderByDesc('created_at')
        ->paginate(10)
        ->withQueryString();

    return view('pembina.laporan', compact(
        'pendaftars',
        'totalPendaftar',
        'totalAnggotaAktif',
        'daftarEkstrakurikuler', // ✅ kirim ke view
    ));
}
}