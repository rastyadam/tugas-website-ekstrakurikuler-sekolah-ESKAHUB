@extends('admin.layout')

@section('title', 'Dashboard Admin - EskaHub')

@section('content')

    {{-- HEADER --}}
  <div class="px-6 pt-6 pb-6">
    {{-- HEADER MED IKONER ØVERST TIL HØYRE --}}
    <div class="flex items-start justify-between  space-x-2">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-[#1B2A38]">
                Dashboard Ekstrakurikuler
            </h1>
            <p class="mt-1 text-sm text-gray-500">
                Ringkasan data & aktivitas ekstrakurikuler semester ini
            </p>
        </div>
    </div>


    {{-- STATISTIKK KORT --}}
    <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-4">

        {{-- TOTAL SISWA --}}
        <div class="flex flex-col justify-between rounded-2xl bg-[#FCE8B3] p-6 shadow-sm">
            <p class="text-xs font-semibold uppercase leading-tight tracking-wide text-gray-500">
                TOTAL SISWA<br>TERDAFTAR
            </p>
            <h2 class="mt-4 text-3xl font-extrabold text-[#1B2A38]">
                1.248
            </h2>
        </div>


        {{-- UNIT EKSTRAKURIKULER --}}
        <div class="flex flex-col justify-between rounded-2xl bg-[#FCE8B3] p-6 shadow-sm">
            <p class="text-xs font-semibold uppercase leading-tight tracking-wide text-gray-500">
                UNIT<br>EKSTRAKURIKULER
            </p>
            <div class="mt-4 flex items-baseline space-x-2">
                <span class="text-3xl font-extrabold text-[#1B2A38]">24</span>
                <span class="text-xs font-medium text-gray-600">Unit Aktif</span>
            </div>
        </div>


        {{-- PENDAFTARAN TERTUNDA --}}
        <div class="flex flex-col justify-between rounded-2xl bg-[#FCE8B3] p-6 shadow-sm">
            <p class="text-xs font-semibold uppercase leading-tight tracking-wide text-gray-500">
                PENDAFTARAN<br>TERTUNDA
            </p>
            <h2 class="mt-4 text-3xl font-extrabold text-[#1B2A38]">
                156
            </h2>
        </div>


        {{-- RATA-RATA PRESENSI --}}
        <div class="flex flex-col justify-between rounded-2xl bg-[#FCE8B3] p-6 shadow-sm">
            <p class="text-xs font-semibold uppercase leading-tight tracking-wide text-gray-500">
                RATA-RATA PRESENSI
            </p>
            <h2 class="mt-4 text-3xl font-extrabold text-[#1B2A38]">
                92.4%
            </h2>
        </div>

    </div>
</div>


    {{-- CHART --}}
 <div class="mt-6 grid grid-cols-1 gap-6 xl:grid-cols-3">

    {{-- CHART PENDAFTARAN --}}
    <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm xl:col-span-2">

        <div class="flex items-center justify-between pb-4">
            <h2 class="text-base font-bold text-[#182635]">
                Tren Pendaftaran Mingguan
            </h2>

            <span class="text-xs font-medium text-gray-400">
                Periode Aktif
            </span>
        </div>

        {{-- CONTAINER BACKGROUND GRAFIK --}}
        <div class="mt-2 rounded-2xl bg-slate-50/80 p-5 h-64">
            <canvas id="weeklyChart"></canvas>
        </div>

    </div>


    {{-- CHART KATEGORI --}}
    <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">

    {{-- HEADER CARD --}}
    <div class="flex items-center justify-between pb-4">
        <h2 class="text-base font-bold text-[#182635]">
            Distribusi Kategori
        </h2>

        <span class="text-xs font-medium text-gray-400">
            24 Unit Total
        </span>
    </div>

    {{-- CHART CONTAINER WITH CENTER TEXT --}}
    <div class="relative my-4 flex justify-center">
        <div class="h-44 w-44">
            <canvas id="categoryChart"></canvas>
        </div>

        {{-- TEKS DI TENGAH DOUGHNUT --}}
        <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
            <span class="text-2xl font-extrabold text-[#182635]">24</span>
            <span class="text-[10px] font-bold tracking-wider text-gray-400 uppercase">TOTAL UNIT</span>
        </div>
    </div>

    {{-- CUSTOM LEGEND LIST --}}
    <div class="mt-6 space-y-3 pt-2">

        {{-- ITEM 1 --}}
        <div class="flex items-center justify-between text-xs">
            <div class="flex items-center space-x-2.5">
                <span class="h-2.5 w-2.5 rounded-full bg-[#182635]"></span>
                <span class="font-medium text-gray-600">Olahraga & Bela Diri</span>
            </div>
            <span class="font-bold text-[#182635]">45%</span>
        </div>

        {{-- ITEM 2 --}}
        <div class="flex items-center justify-between text-xs">
            <div class="flex items-center space-x-2.5">
                <span class="h-2.5 w-2.5 rounded-full bg-[#F2B705]"></span>
                <span class="font-medium text-gray-600">Kesenian & Musik</span>
            </div>
            <span class="font-bold text-[#182635]">28%</span>
        </div>

        {{-- ITEM 3 --}}
        <div class="flex items-center justify-between text-xs">
            <div class="flex items-center space-x-2.5">
                <span class="h-2.5 w-2.5 rounded-full bg-[#B0526D]"></span>
                <span class="font-medium text-gray-600">Sains & Teknologi</span>
            </div>
            <span class="font-bold text-[#182635]">17%</span>
        </div>

        {{-- ITEM 4 --}}
        <div class="flex items-center justify-between text-xs">
            <div class="flex items-center space-x-2.5">
                <span class="h-2.5 w-2.5 rounded-full bg-[#586574]"></span>
                <span class="font-medium text-gray-600">Kepemimpinan & Bahasa</span>
            </div>
            <span class="font-bold text-[#182635]">10%</span>
        </div>

    </div>

</div>
</div>


{{-- CHART.JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // ========================================
    // CHART PENDAFTARAN MINGGUAN
    // ========================================

    new Chart(document.getElementById('weeklyChart'), {
        type: 'bar',

        data: {
            labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],

            datasets: [{
                data: [12, 18, 28, 22, 30, 35, 8],

                backgroundColor: [
                    '#A3A8B1', // Sen
                    '#A3A8B1', // Sel
                    '#182635', // Rab (Navy)
                    '#A3A8B1', // Kam
                    '#A3A8B1', // Jum
                    '#F2B705', // Sab (Kuning/Gold)
                    '#A3A8B1'  // Min
                ],

                borderRadius: {
                    topLeft: 6,
                    topRight: 6
                },
                borderSkipped: false,
                categoryPercentage: 0.7,
                barPercentage: 0.8
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
                y: {
                    display: false,
                    grid: {
                        display: false
                    }
                },

                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        font: {
                            family: 'Hanken Grotesk',
                            size: 12,
                            weight: '600'
                        },
                        // Menyesuaikan warna label teks hari di bawah batang grafik
                        color: function(context) {
                            const label = context.tick.label;
                            if (label === 'Rab') return '#182635';
                            if (label === 'Sab') return '#F2B705';
                            return '#A3A8B1';
                        }
                    }
                }
            }
        }
    });



        // ========================================
        // CHART DISTRIBUSI KATEGORI
        // ========================================

        new Chart(document.getElementById('categoryChart'), {
    type: 'doughnut',

    data: {
        labels: [
            'Olahraga & Bela Diri',
            'Kesenian & Musik',
            'Sains & Teknologi',
            'Kepemimpinan & Bahasa'
        ],

        datasets: [{
            data: [45, 28, 17, 10],

            backgroundColor: [
                '#182635', // Navy
                '#F2B705', // Gold / Yellow
                '#B0526D', // Muted Red / Rose
                '#586574'  // Slate Gray
            ],

            borderWidth: 0,
            hoverOffset: 4
        }]
    },

    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '72%', // Ketebalan lingkar doughnut

        plugins: {
            legend: {
                display: false // Sembunyikan legend bawaan karena memakai custom HTML
            },
            tooltip: {
                enabled: true
            }
        }
    }
});
    </script>

@endsection