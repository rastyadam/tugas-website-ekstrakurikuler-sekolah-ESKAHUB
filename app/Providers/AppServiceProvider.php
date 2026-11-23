<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengumuman;
use App\Models\JadwalLatihan;
use App\Models\Pendaftaran;
use App\Models\Ekstrakurikuler; // ✅ Ditambahkan biar rapi

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // ==========================================
        // 1. NOTIFIKASI UNTUK LAYOUT SISWA
        // ==========================================
        View::composer('student.layouts.app', function ($view) {
            if (Auth::check() && Auth::user()->peran === 'siswa') {
                $siswa = Auth::user()->memberSiswa;
                
                if ($siswa) {
                    $ekskulIds = Pendaftaran::where('member_id', $siswa->id)->pluck('ekstrakurikuler_id');

                    // Ambil Pengumuman
                    $pengumumans = Pengumuman::with('ekstrakurikuler')
                        ->whereIn('ekstrakurikuler_id', $ekskulIds)
                        ->latest()
                        ->take(5)
                        ->get();

                    // Ambil Jadwal Latihan
                    $jadwals = JadwalLatihan::with('ekstrakurikuler')
                        ->whereIn('ekstrakurikuler_id', $ekskulIds)
                        ->latest()
                        ->take(5)
                        ->get();

                    // Gabungkan dan Urutkan berdasarkan created_at terbaru
                    $notifikasis = $pengumumans->concat($jadwals)->sortByDesc('created_at')->take(5);

                    $view->with('notifikasis', $notifikasis);
                }
            }
        });


        // ==========================================
        // 2. NOTIFIKASI UNTUK LAYOUT PEMBINA
        // ==========================================
        View::composer('pembina.layouts.app', function ($view) {
            if (Auth::check() && Auth::user()->peran === 'pembina') {
                $pembina = Auth::user()->pembina;
                
                if ($pembina) {
                    $ekskulIds = Ekstrakurikuler::where('pembina_id', $pembina->id)->pluck('id');
                    
                    // Ambil 5 pendaftar baru (status pending) di ekskul yang diampu
                    $notifikasiPembinas = Pendaftaran::with(['member', 'ekstrakurikuler'])
                        ->whereIn('ekstrakurikuler_id', $ekskulIds)
                        ->where('status', 'pending')
                        ->latest()
                        ->take(5)
                        ->get();

                    $view->with('notifikasiPembinas', $notifikasiPembinas);
                }
            }
        });
    }
}