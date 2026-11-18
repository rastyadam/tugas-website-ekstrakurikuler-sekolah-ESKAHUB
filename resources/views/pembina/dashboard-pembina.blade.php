@extends('pembina.layouts.app')

@section('title', 'Dashboard Pembina')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    <!-- Top Bar Input Search -->
    <div class="flex items-center">
        <div class="relative w-full max-w-xs">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </span>
            <input type="text" placeholder="Search..." 
                   class="w-full pl-9 pr-4 py-1.5 text-sm bg-transparent border-none focus:outline-none focus:ring-0 text-gray-700 placeholder-gray-400">
        </div>
    </div>

    <!-- Header Section -->
    <div>
        <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Overview</h1>
        <p class="text-xs text-gray-500 mt-1">Kelola kegiatan ekstrakurikuler Anda secara efisien.</p>
    </div>

    <!-- Stats Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Card 1: Total Pendaftar -->
        <div class="bg-white p-5 rounded-xl border border-gray-200/80 shadow-sm">
            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-2">TOTAL PENDAFTAR</p>
            <h2 class="text-3xl font-extrabold text-slate-900">124</h2>
        </div>

        <!-- Card 2: Menunggu Seleksi -->
        <div class="bg-white p-5 rounded-xl border border-gray-200/80 shadow-sm">
            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-2">MENUNGGU SELEKSI</p>
            <h2 class="text-3xl font-extrabold text-slate-900">45</h2>
        </div>

        <!-- Card 3: Anggota Aktif -->
        <div class="bg-white p-5 rounded-xl border border-gray-200/80 shadow-sm">
            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-2">ANGGOTA AKTIF</p>
            <h2 class="text-3xl font-extrabold text-slate-900">88</h2>
        </div>

        <!-- Card 4: Kuota Tersedia -->
        <div class="bg-white p-5 rounded-xl border border-gray-200/80 shadow-sm">
            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-2">KUOTA TERSEDIA</p>
            <h2 class="text-3xl font-extrabold text-slate-900">12</h2>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
        <h3 class="text-sm font-bold text-slate-500 uppercase">Total Ekskul Diampu</h3>
        <p class="text-3xl font-extrabold text-slate-800 mt-2">{{ $ekskuls->count() }}</p>
    </div>
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
        <h3 class="text-sm font-bold text-slate-500 uppercase">Total Pendaftar</h3>
        <p class="text-3xl font-extrabold text-slate-800 mt-2">{{ $totalPendaftar }}</p>
    </div>
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
        <h3 class="text-sm font-bold text-slate-500 uppercase">Menunggu Verifikasi</h3>
        <p class="text-3xl font-extrabold text-amber-600 mt-2">{{ $pendingPendaftar }}</p>
    </div>
</div>

    <!-- Main Content Grid (Chart + Activity) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Chart Section (Tren Pendaftaran) -->
        <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200/80 shadow-sm overflow-hidden flex flex-col">
            <!-- Card Header -->
            <div class="px-6 py-4 flex items-center justify-between border-b border-gray-100">
                <h3 class="text-sm font-bold text-slate-900">Tren Pendaftaran</h3>
                <div class="relative">
                    <select class="text-xs text-amber-800 font-medium bg-transparent border-none focus:outline-none focus:ring-0 cursor-pointer pr-4">
                        <option value="bulan_ini">Bulan ini</option>
                        <option value="bulan_lalu">Bulan lalu</option>
                    </select>
                </div>
            </div>

            <!-- Chart Container -->
            <div class="p-6 flex-1 min-h-[260px] relative bg-slate-50/30">
                <canvas id="registrationTrendChart" class="w-full h-full"></canvas>
            </div>
        </div>

        <!-- Activity Feed Section (Aktivitas Terkini) -->
        <div class="bg-white rounded-xl border border-gray-200/80 shadow-sm overflow-hidden flex flex-col">
            <!-- Card Header -->
            <div class="px-6 py-4 flex items-center justify-between border-b border-gray-100">
                <h3 class="text-sm font-bold text-slate-900">Aktivitas Terkini</h3>
                <a href="#" class="text-xs font-semibold text-amber-700 hover:text-amber-800 transition-colors">Lihat semua</a>
            </div>

            <!-- Activity List -->
            <div class="p-6 space-y-6 flex-1">
                <!-- Activity Item 1 -->
                <div>
                    <h4 class="text-xs font-bold text-slate-900 leading-snug">Pendaftar baru dari Budi Santoso</h4>
                    <p class="text-[11px] text-gray-400 mt-1">2 menit yang lalu</p>
                </div>

                <!-- Activity Item 2 -->
                <div>
                    <h4 class="text-xs font-bold text-slate-900 leading-snug">Jadwal updated untuk latihan basket</h4>
                    <p class="text-[11px] text-gray-400 mt-1">1 jam yang lalu</p>
                </div>

                <!-- Activity Item 3 -->
                <div>
                    <h4 class="text-xs font-bold text-slate-900 leading-snug">Proses seleksi untuk paduan suara telah selesai.</h4>
                    <p class="text-[11px] text-gray-400 mt-1">Kemarin, 14:30</p>
                </div>
            </div>
        </div>

    </div>

</div>

<!-- Library Chart.js (Untuk Render Grafik) -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('registrationTrendChart').getContext('2d');
        
        // Gradient Fill Color
        const gradient = ctx.createLinearGradient(0, 0, 0, 200);
        gradient.addColorStop(0, 'rgba(180, 130, 20, 0.15)');
        gradient.addColorStop(1, 'rgba(180, 130, 20, 0.0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'],
                datasets: [{
                    label: 'Pendaftaran',
                    data: [15, 35, 65, 95],
                    borderColor: '#9A6B00',
                    borderWidth: 4,
                    fill: true,
                    backgroundColor: gradient,
                    tension: 0.35, // Smooth curves
                    pointBackgroundColor: '#9A6B00',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: [0, 4, 0, 0], // Marker titik hanya di area tertentu
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: { enabled: true }
                },
                scales: {
                    x: {
                        display: false // Sembunyikan garis X sesuai mock-up
                    },
                    y: {
                        grid: {
                            color: '#E5E7EB',
                            drawBorder: false
                        },
                        ticks: {
                            display: false // Sembunyikan angka y-axis sesuai mock-up
                        }
                    }
                }
            }
        });
    });
</script>
@endsection