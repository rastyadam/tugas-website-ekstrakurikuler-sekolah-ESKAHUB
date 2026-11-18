<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengumuman;
use App\Models\JadwalLatihan;
use App\Models\Pendaftaran;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Share notifikasi ke layout 'student.layouts.app'
        View::composer('student.layouts.app', function ($view) {
            if (Auth::check() && Auth::user()->peran === 'siswa') {
                $siswa = Auth::user()->memberSiswa;
                
                if ($siswa) {
                    $ekskulIds = Pendaftaran::where('member_id', $siswa->id)->pluck('ekstrakurikuler_id');

                    // 1. Ambil Pengumuman
                    $pengumumans = Pengumuman::with('ekstrakurikuler')
                        ->whereIn('ekstrakurikuler_id', $ekskulIds)
                        ->latest()
                        ->take(5)
                        ->get();

                    // 2. Ambil Jadwal Latihan
                    $jadwals = JadwalLatihan::with('ekstrakurikuler')
                        ->whereIn('ekstrakurikuler_id', $ekskulIds)
                        ->latest()
                        ->take(5)
                        ->get();

                    // 3. Gabungkan dan Urutkan berdasarkan created_at terbaru
                    $notifikasis = $pengumumans->concat($jadwals)->sortByDesc('created_at')->take(5);

                    $view->with('notifikasis', $notifikasis);
                }
            }
        });
    }
}