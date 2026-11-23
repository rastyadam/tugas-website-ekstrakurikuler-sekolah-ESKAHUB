@extends('admin.layout')

@section('title', 'Dashboard Admin - EskaHub')

@section('header-title')
    <div>
        <h1 class="text-2xl font-bold tracking-tight text-slate-900">
            Dashboard Ekstrakurikuler
        </h1>
        <p class="mt-1 text-sm text-slate-500">
            Ringkasan data & aktivitas ekstrakurikuler
        </p>
    </div>
@endsection

@section('content')
<div class="space-y-6">

    {{-- ===== STATISTIK KARTU ===== --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
        {{-- TOTAL SISWA --}}
        <div class="rounded-xl border border-slate-200 bg-white p-5">
            <div class="flex items-center justify-between">
                <span class="text-sm font-medium text-slate-500">Total Siswa</span>
                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-50">
                    <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
            <h2 class="mt-3 text-2xl font-bold text-slate-900">{{ number_format($totalSiswa, 0, ',', '.') }}</h2>
        </div>

        {{-- UNIT EKSKUL --}}
        <div class="rounded-xl border border-slate-200 bg-white p-5">
            <div class="flex items-center justify-between">
                <span class="text-sm font-medium text-slate-500">Unit Ekstrakurikuler</span>
                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-emerald-50">
                    <svg class="h-5 w-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
            </div>
            <h2 class="mt-3 text-2xl font-bold text-slate-900">{{ $totalEkskul }}</h2>
        </div>

        {{-- PENDAFTARAN TERTUNDA --}}
        <div class="rounded-xl border border-slate-200 bg-white p-5">
            <div class="flex items-center justify-between">
                <span class="text-sm font-medium text-slate-500">Pendaftaran Tertunda</span>
                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-amber-50">
                    <svg class="h-5 w-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <h2 class="mt-3 text-2xl font-bold text-slate-900">{{ $pendaftaranTertunda }}</h2>
        </div>

        {{-- RATA-RATA PRESENSI --}}
        <div class="rounded-xl border border-slate-200 bg-white p-5">
            <div class="flex items-center justify-between">
                <span class="text-sm font-medium text-slate-500">Rata-rata Presensi</span>
                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-violet-50">
                    <svg class="h-5 w-5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <h2 class="mt-3 text-2xl font-bold text-slate-900">{{ $rataPresensi }}%</h2>
            <p class="mt-1 text-xs text-slate-400">Rasio pendaftaran diterima</p>
        </div>
    </div>

    {{-- ===== CHART SECTION ===== --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">

        {{-- CHART TREN PENDAFTARAN --}}
        <div class="rounded-xl border border-slate-200 bg-white p-6 lg:col-span-7">
            <div class="flex items-center justify-between pb-4">
                <div>
                    <h2 class="text-base font-semibold text-slate-900">Tren Pendaftaran</h2>
                    <p class="mt-0.5 text-xs text-slate-400">7 hari terakhir</p>
                </div>
                <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600">
                    {{ array_sum($pendaftaranMingguan) }} pendaftar
                </span>
            </div>
            <div class="h-64">
                <canvas id="weeklyChart"></canvas>
            </div>
        </div>

        {{-- CHART DISTRIBUSI --}}
        <div class="rounded-xl border border-slate-200 bg-white p-6 lg:col-span-5">
            <div class="flex items-center justify-between pb-4">
                <div>
                    <h2 class="text-base font-semibold text-slate-900">Pendaftar per Ekstrakurikuler</h2>
                    <p class="mt-0.5 text-xs text-slate-400">Top 6 terpopuler</p>
                </div>
            </div>

            <div class="relative my-6 flex justify-center">
                <div class="h-40 w-40">
                    <canvas id="categoryChart"></canvas>
                </div>
                <div class="pointer-events-none absolute inset-0 flex flex-col items-center justify-center">
                    <span class="text-xl font-bold text-slate-900">{{ array_sum($distribusiKategori) }}</span>
                    <span class="text-[10px] font-medium uppercase tracking-wider text-slate-400">Total Pendaftar</span>
                </div>
            </div>

            @php
                $legendColors = ['#3B82F6', '#10B981', '#F59E0B', '#8B5CF6', '#EF4444', '#64748B'];
                $totalDistribusi = array_sum($distribusiKategori);
            @endphp

            <div class="mt-4 space-y-2.5">
                @forelse ($distribusiKategori as $namaEkskul => $jumlah)
                    @php
                        $dotColor = $legendColors[$loop->index % count($legendColors)];
                        $persentase = $totalDistribusi > 0 ? round(($jumlah / $totalDistribusi) * 100) : 0;
                    @endphp
                    <div class="flex items-center justify-between text-sm">
                        <div class="flex items-center gap-2.5">
                            <span class="h-2 w-2 rounded-full" style="background-color: {{ $dotColor }}"></span>
                            <span class="text-slate-600">{{ $namaEkskul }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-slate-400">{{ $jumlah }}</span>
                            <span class="font-semibold text-slate-900">{{ $persentase }}%</span>
                        </div>
                    </div>
                @empty
                    <p class="py-4 text-center text-sm text-slate-400">Belum ada data pendaftaran</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- ===== STATUS PENDAFTARAN ===== --}}
    @if(isset($statusPendaftaran) && count($statusPendaftaran) > 0)
    <div class="rounded-xl border border-slate-200 bg-white p-6">
        <div class="flex items-center justify-between pb-4">
            <div>
                <h2 class="text-base font-semibold text-slate-900">Status Pendaftaran</h2>
                <p class="mt-0.5 text-xs text-slate-400">Ringkasan berdasarkan status</p>
            </div>
        </div>

        @php
            $statusConfig = [
                'pending' => ['label' => 'Tertunda', 'color' => '#F59E0B'],
                'diterima' => ['label' => 'Diterima', 'color' => '#10B981'],
                'ditolak' => ['label' => 'Ditolak', 'color' => '#EF4444'],
            ];
            $totalStatus = array_sum($statusPendaftaran);
        @endphp

        <div class="space-y-4">
            @foreach ($statusConfig as $key => $config)
                @php
                    $jumlah = $statusPendaftaran[$key] ?? 0;
                    $persen = $totalStatus > 0 ? round(($jumlah / $totalStatus) * 100) : 0;
                @endphp
                <div>
                    <div class="mb-1.5 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="h-2 w-2 rounded-full" style="background-color: {{ $config['color'] }}"></span>
                            <span class="text-sm font-medium text-slate-700">{{ $config['label'] }}</span>
                        </div>
                        <span class="text-sm font-semibold text-slate-900">
                            {{ $jumlah }} <span class="text-xs font-normal text-slate-400">({{ $persen }}%)</span>
                        </span>
                    </div>
                    <div class="h-1.5 w-full overflow-hidden rounded-full bg-slate-100">
                        <div class="h-full rounded-full" style="width: {{ $persen }}%; background-color: {{ $config['color'] }}"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // CHART TREN
        const weeklyLabels = @json($labelsMingguan);
        const weeklyData = @json($pendaftaranMingguan);

        new Chart(document.getElementById('weeklyChart'), {
            type: 'bar',
            data: {
                labels: weeklyLabels,
                datasets: [{
                    data: weeklyData,
                    backgroundColor: '#3B82F6',
                    borderRadius: 6,
                    borderSkipped: 'bottom',
                    categoryPercentage: 0.6,
                    barPercentage: 0.7
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
                        displayColors: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0, color: '#94A3B8', font: { size: 11 } },
                        grid: { color: '#F1F5F9' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#64748B', font: { size: 11 } }
                    }
                }
            }
        });

        // CHART DISTRIBUSI
        new Chart(document.getElementById('categoryChart'), {
            type: 'doughnut',
            data: {
                labels: @json(array_keys($distribusiKategori)),
                datasets: [{
                    data: @json(array_values($distribusiKategori)),
                    backgroundColor: ['#3B82F6', '#10B981', '#F59E0B', '#8B5CF6', '#EF4444', '#64748B'],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '72%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0F172A',
                        padding: 10,
                        cornerRadius: 8
                    }
                }
            }
        });
    });
</script>
@endsection