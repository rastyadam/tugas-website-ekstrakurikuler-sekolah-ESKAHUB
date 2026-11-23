
@extends('pembina.layouts.app')

@section('title', 'Dashboard Pembina')

@section('content')

<div class="w-full max-w-7xl mx-auto space-y-5">

    <!-- TOP BAR SEARCH -->
    <div class="flex items-center justify-between">
        <div class="relative w-full max-w-xs">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </span>

            <input type="text"
                placeholder="Search..."
                class="w-full pl-9 pr-4 py-2 text-xs bg-transparent border-none focus:outline-none focus:ring-0 text-gray-700 placeholder-gray-400">
        </div>
    </div>


    <!-- HEADER OVERVIEW -->
    <div>
        <h1 class="text-base font-bold text-slate-900 tracking-tight">
            Overview
        </h1>

        <p class="text-[10px] text-gray-500 mt-0.5">
            Kelola kegiatan ekstrakurikuler Anda secara efisien.
        </p>
    </div>


    <!-- STATISTIK DASHBOARD -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">

        <!-- Total Pendaftar -->
        <div class="bg-white px-3 py-3 rounded-sm border border-gray-200 shadow-sm">
            <p class="text-[8px] font-semibold text-gray-500 uppercase tracking-wide mb-1">
                TOTAL PENDAFTAR
            </p>

            <h2 class="text-base font-extrabold text-slate-900">
                124
            </h2>
        </div>


        <!-- Menunggu Seleksi -->
        <div class="bg-white px-3 py-3 rounded-sm border border-gray-200 shadow-sm">
            <p class="text-[8px] font-semibold text-gray-500 uppercase tracking-wide mb-1">
                MENUNGGU SELEKSI
            </p>

            <h2 class="text-base font-extrabold text-slate-900">
                45
            </h2>
        </div>


        <!-- Anggota Aktif -->
        <div class="bg-white px-3 py-3 rounded-sm border border-gray-200 shadow-sm">
            <p class="text-[8px] font-semibold text-gray-500 uppercase tracking-wide mb-1">
                ANGGOTA AKTIF
            </p>

            <h2 class="text-base font-extrabold text-slate-900">
                88
            </h2>
        </div>


        <!-- Kuota Tersedia -->
        <div class="bg-white px-3 py-3 rounded-sm border border-gray-200 shadow-sm">
            <p class="text-[8px] font-semibold text-gray-500 uppercase tracking-wide mb-1">
                KUOTA TERSEDIA
            </p>

            <h2 class="text-base font-extrabold text-slate-900">
                12
            </h2>
        </div>

    </div>


    <!-- MAIN CONTENT: CHART & ACTIVITY -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">


        <!-- GRAFIK TREN PENDAFTARAN -->
        <div class="lg:col-span-2 bg-white rounded-sm border border-gray-200 shadow-sm overflow-hidden flex flex-col">

            <!-- Header Grafik -->
            <div class="px-4 py-3 flex items-center justify-between border-b border-gray-100">

                <h3 class="text-[11px] font-bold text-slate-900">
                    Tren Pendaftaran
                </h3>

                <select
                    class="text-[9px] text-amber-800 font-medium bg-transparent border-none focus:outline-none focus:ring-0 cursor-pointer">
                    <option value="bulan_ini">Bulan ini</option>
                    <option value="bulan_lalu">Bulan lalu</option>
                </select>

            </div>


            <!-- Chart -->
            <div class="p-3 flex-1 min-h-[200px] sm:min-h-[220px] relative bg-slate-50/30">

                <canvas id="registrationTrendChart" class="w-full h-full"></canvas>

            </div>

        </div>



        <!-- AKTIVITAS TERKINI -->
        <div class="bg-white rounded-sm border border-gray-200 shadow-sm overflow-hidden flex flex-col">

            <!-- Header Aktivitas -->
            <div class="px-4 py-3 flex items-center justify-between border-b border-gray-100">

                <h3 class="text-[11px] font-bold text-slate-900">
                    Aktivitas Terkini
                </h3>

                <a href="#"
                    class="text-[9px] font-semibold text-amber-700 hover:text-amber-800 transition-colors">
                    Lihat semua
                </a>

            </div>


            <!-- Daftar Aktivitas -->
            <div class="p-4 space-y-5 flex-1">

                <!-- Aktivitas 1 -->
                <div>
                    <h4 class="text-[10px] font-bold text-slate-900 leading-snug">
                        Pendaftar baru dari Budi Santoso
                    </h4>

                    <p class="text-[9px] text-gray-400 mt-1">
                        2 menit yang lalu
                    </p>
                </div>


                <!-- Aktivitas 2 -->
                <div>
                    <h4 class="text-[10px] font-bold text-slate-900 leading-snug">
                        Jadwal updated untuk latihan basket
                    </h4>

                    <p class="text-[9px] text-gray-400 mt-1">
                        1 jam yang lalu
                    </p>
                </div>


                <!-- Aktivitas 3 -->
                <div>
                    <h4 class="text-[10px] font-bold text-slate-900 leading-snug">
                        Proses seleksi untuk paduan suara telah selesai.
                    </h4>

                    <p class="text-[9px] text-gray-400 mt-1">
                        Kemarin, 14:30
                    </p>
                </div>

            </div>

        </div>

    </div>

</div>


<!-- CHART JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const canvas = document.getElementById('registrationTrendChart');

    if (!canvas || typeof Chart === 'undefined') {
        return;
    }

    const ctx = canvas.getContext('2d');

    // Gradient grafik
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
                borderWidth: 3,

                fill: true,
                backgroundColor: gradient,

                tension: 0.35,

                pointBackgroundColor: '#9A6B00',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,

                pointRadius: [0, 3, 0, 0],
                pointHoverRadius: 5
            }]
        },


        options: {
            responsive: true,
            maintainAspectRatio: false,

            plugins: {
                legend: {
                    display: false
                },

                tooltip: {
                    enabled: true
                }
            },

            scales: {

                x: {
                    display: false
                },

                y: {
                    grid: {
                        color: '#E5E7EB',
                        drawBorder: false
                    },

                    ticks: {
                        display: false
                    }
                }

            }
        }

    });

});
</script>

@endsection
