@extends('pembina.layouts.app')

@section('title', 'Dashboard Pembina')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    {{-- HEADER --}}
    <div>
        <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Overview</h1>
        <p class="text-xs text-gray-500 mt-1">Kelola kegiatan ekstrakurikuler Anda secara efisien.</p>
    </div>

    {{-- STATISTIK --}}
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

    {{-- CHART + AKTIVITAS --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- CHART TREN PENDAFTARAN --}}
        <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200/80 shadow-sm overflow-hidden flex flex-col">
            <div class="px-6 py-4 flex items-center justify-between border-b border-gray-100">
                <h3 class="text-sm font-bold text-slate-900">Tren Pendaftaran</h3>

                {{-- FILTER BULAN (berfungsi) --}}
                <form method="GET" action="{{ url()->current() }}">
                    <select name="periode" onchange="this.form.submit()"
                            class="text-xs text-amber-800 font-medium bg-transparent border-none focus:outline-none focus:ring-0 cursor-pointer pr-4">
                        <option value="bulan_ini" {{ $periode == 'bulan_ini' ? 'selected' : '' }}>Bulan ini</option>
                        <option value="bulan_lalu" {{ $periode == 'bulan_lalu' ? 'selected' : '' }}>Bulan lalu</option>
                    </select>
                </form>
            </div>

            <div class="p-6 flex-1 min-h-[260px] relative bg-slate-50/30">
                <canvas id="registrationTrendChart" class="w-full h-full"></canvas>
            </div>
        </div>

        {{-- AKTIVITAS TERKINI --}}
        <div class="bg-white rounded-xl border border-gray-200/80 shadow-sm overflow-hidden flex flex-col">
            <div class="px-6 py-4 flex items-center justify-between border-b border-gray-100">
                <h3 class="text-sm font-bold text-slate-900">Aktivitas Terkini</h3>
                <a href="{{ route('pembina.pendaftar') ?? '#' }}"
                   class="text-xs font-semibold text-amber-700 hover:text-amber-800 transition-colors">
                    Lihat semua
                </a>
            </div>

            <div class="p-6 space-y-5 flex-1">
                @forelse ($aktivitasTerkini as $aktivitas)
                    <div>
                        <h4 class="text-xs font-bold text-slate-900 leading-snug">
                            {{ $aktivitas['judul'] }}
                        </h4>
                        <div class="flex items-center gap-2 mt-1">
                            <p class="text-[11px] text-gray-400">
                                {{ \Carbon\Carbon::parse($aktivitas['waktu'])->diffForHumans() }}
                            </p>
                            @if($aktivitas['status'] === 'pending')
                                <span class="text-[10px] font-semibold text-amber-600 bg-amber-50 px-1.5 py-0.5 rounded">
                                    Pending
                                </span>
                            @elseif($aktivitas['status'] === 'diterima')
                                <span class="text-[10px] font-semibold text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded">
                                    Diterima
                                </span>
                            @elseif($aktivitas['status'] === 'ditolak')
                                <span class="text-[10px] font-semibold text-rose-600 bg-rose-50 px-1.5 py-0.5 rounded">
                                    Ditolak
                                </span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center py-8 text-center">
                        <i class="fa-solid fa-inbox text-2xl text-slate-300 mb-2"></i>
                        <p class="text-xs font-semibold text-slate-500">Belum ada aktivitas</p>
                        <p class="text-[11px] text-gray-400 mt-1">Pendaftaran baru akan muncul di sini.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>

{{-- CHART.JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const ctx = document.getElementById('registrationTrendChart').getContext('2d');

        // Gradient Fill
        const gradient = ctx.createLinearGradient(0, 0, 0, 200);
        gradient.addColorStop(0, 'rgba(154, 107, 0, 0.25)');
        gradient.addColorStop(1, 'rgba(154, 107, 0, 0.0)');

        // Data dari controller
        const labels = @json($labelsMinggu);
        const data   = @json($dataMinggu);

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Pendaftaran',
                    data: data,
                    borderColor: '#9A6B00',
                    borderWidth: 3,
                    fill: true,
                    backgroundColor: gradient,
                    tension: 0.35,
                    pointBackgroundColor: '#9A6B00',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0F172A',
                        padding: 10,
                        cornerRadius: 8,
                        displayColors: false,
                        callbacks: {
                            label: function (context) {
                                return context.parsed.y + ' pendaftar';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: '#64748B', font: { size: 11 } }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: '#E5E7EB', drawBorder: false },
                        ticks: {
                            precision: 0,
                            color: '#94A3B8',
                            font: { size: 11 }
                        }
                    }
                }
            }
        });
    });
</script>
@endsection