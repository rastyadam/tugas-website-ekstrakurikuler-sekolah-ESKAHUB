
@extends('pembina.layouts.app')

@section('title', 'Dashboard Pembina')

@section('content')
<div class="w-full max-w-7xl mx-auto space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="text-xl font-bold text-[#182635]">
                Overview
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                Pantau perkembangan dan pendaftaran ekstrakurikuler yang Anda ampu.
            </p>
        </div>

        <a href="{{ route('pembina.pendaftar') }}"
           class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg bg-[#182635] text-white text-xs font-semibold hover:bg-[#263d52] transition">
            <i class="fa-solid fa-users"></i>
            Lihat Pendaftar
        </a>
    </div>


    {{-- STATISTIK --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">

        {{-- Total Ekstrakurikuler --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">
                        Ekstrakurikuler Diampu
                    </p>
                    <h2 class="text-3xl font-bold text-[#182635] mt-3">
                        {{ $ekskuls->count() }}
                    </h2>
                    <p class="text-xs text-gray-400 mt-1">
                        Total kegiatan yang Anda ampu
                    </p>
                </div>
            </div>
        </div>

        {{-- Total Pendaftar --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">
                        Total Pendaftar
                    </p>
                    <h2 class="text-3xl font-bold text-[#182635] mt-3">
                        {{ $totalPendaftar }}
                    </h2>
                    <p class="text-xs text-gray-400 mt-1">
                        Seluruh pendaftar ekstrakurikuler
                    </p>
                </div>
            </div>
        </div>

        {{-- Menunggu Verifikasi --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">
                        Menunggu Verifikasi
                    </p>
                    <h2 class="text-3xl font-bold text-amber-600 mt-3">
                        {{ $pendingPendaftar }}
                    </h2>
                    <p class="text-xs text-gray-400 mt-1">
                        Pendaftar yang perlu diperiksa
                    </p>
                </div>
            </div>
        </div>

    </div>


    {{-- GRAFIK DAN AKTIVITAS --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        {{-- GRAFIK PENDAFTARAN --}}
        <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">

            <div class="px-5 py-4 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h3 class="text-sm font-bold text-[#182635]">
                        Tren Pendaftaran
                    </h3>
                    <p class="text-xs text-gray-400 mt-1">
                        Perkembangan jumlah pendaftar berdasarkan periode
                    </p>
                </div>

                <form method="GET" action="{{ url()->current() }}">
                    <select name="periode"
                            onchange="this.form.submit()"
                            class="text-xs font-semibold text-[#182635] bg-white border border-gray-200 rounded-lg px-3 py-2 focus:ring-amber-400 focus:border-amber-400">
                        <option value="bulan_ini" {{ $periode == 'bulan_ini' ? 'selected' : '' }}>
                            Bulan ini
                        </option>
                        <option value="bulan_lalu" {{ $periode == 'bulan_lalu' ? 'selected' : '' }}>
                            Bulan lalu
                        </option>
                    </select>
                </form>
            </div>

            <div class="p-5">
                <div class="relative h-[260px] w-full">
                    <canvas id="registrationTrendChart"></canvas>
                </div>
            </div>

        </div>


        {{-- AKTIVITAS TERKINI --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">

            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-bold text-[#182635]">
                        Aktivitas Terkini
                    </h3>
                    <p class="text-xs text-gray-400 mt-1">
                        Pembaruan pendaftaran siswa
                    </p>
                </div>

                <a href="{{ route('pembina.pendaftar') }}"
                   class="text-xs font-semibold text-amber-700 hover:text-amber-800">
                    Lihat semua
                </a>
            </div>

            <div class="p-5 space-y-5">

                @forelse ($aktivitasTerkini as $aktivitas)
                    <div class="flex gap-3">

                        <div class="w-9 h-9 shrink-0 rounded-full bg-amber-50 flex items-center justify-center">
                            <i class="fa-solid fa-user-plus text-amber-600 text-xs"></i>
                        </div>

                        <div class="min-w-0 flex-1">
                            <p class="text-xs font-semibold text-[#182635] leading-relaxed">
                                {{ $aktivitas['judul'] }}
                            </p>

                            <div class="flex flex-wrap items-center gap-2 mt-1.5">
                                <span class="text-[10px] text-gray-400">
                                    {{ \Carbon\Carbon::parse($aktivitas['waktu'])->diffForHumans() }}
                                </span>

                                @if($aktivitas['status'] === 'pending')
                                    <span class="text-[10px] font-semibold text-amber-700 bg-amber-50 px-2 py-1 rounded-full">
                                        Menunggu
                                    </span>
                                @elseif($aktivitas['status'] === 'diterima')
                                    <span class="text-[10px] font-semibold text-green-700 bg-green-50 px-2 py-1 rounded-full">
                                        Diterima
                                    </span>
                                @elseif($aktivitas['status'] === 'ditolak')
                                    <span class="text-[10px] font-semibold text-red-700 bg-red-50 px-2 py-1 rounded-full">
                                        Ditolak
                                    </span>
                                @endif
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="py-10 text-center">
                        <div class="w-12 h-12 rounded-full bg-gray-50 flex items-center justify-center mx-auto mb-3">
                            <i class="fa-solid fa-inbox text-gray-300 text-xl"></i>
                        </div>

                        <p class="text-xs font-semibold text-gray-500">
                            Belum ada aktivitas
                        </p>
                        <p class="text-[11px] text-gray-400 mt-1">
                            Pendaftaran siswa akan muncul di sini.
                        </p>
                    </div>
                @endforelse

            </div>
        </div>

    </div>


    {{-- DAFTAR EKSTRAKURIKULER YANG DIAMPU --}}
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">

        <div class="px-5 py-4 border-b border-gray-100">
            <h3 class="text-sm font-bold text-[#182635]">
                Ekstrakurikuler yang Diampu
            </h3>
            <p class="text-xs text-gray-400 mt-1">
                Daftar kegiatan yang berada di bawah tanggung jawab Anda
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-5 py-3 text-[10px] font-bold text-gray-500 uppercase">Nama Ekstrakurikuler</th>
                        <th class="px-5 py-3 text-[10px] font-bold text-gray-500 uppercase">Kuota</th>
                        <th class="px-5 py-3 text-[10px] font-bold text-gray-500 uppercase">Status</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse($ekskuls as $ekskul)
                        <tr class="hover:bg-gray-50/70 transition">
                            <td class="px-5 py-4">
                                <p class="text-xs font-semibold text-[#182635]">
                                    {{ $ekskul->nama }}
                                </p>
                            </td>

                            <td class="px-5 py-4 text-xs text-gray-600">
                                {{ $ekskul->kuota ?? 0 }} siswa
                            </td>

                            <td class="px-5 py-4">
                                @if($ekskul->status === 'aktif')
                                    <span class="inline-flex px-2.5 py-1 rounded-full bg-green-50 text-green-700 text-[10px] font-semibold">
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex px-2.5 py-1 rounded-full bg-gray-100 text-gray-600 text-[10px] font-semibold">
                                        {{ ucfirst($ekskul->status ?? 'Tidak diketahui') }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-5 py-8 text-center text-xs text-gray-400">
                                Belum ada ekstrakurikuler yang diampu.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</div>


{{-- CHART JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('registrationTrendChart');

    if (!canvas || typeof Chart === 'undefined') {
        return;
    }

    const labels = @json($labelsMinggu);
    const data = @json($dataMinggu);

    const ctx = canvas.getContext('2d');

    const gradient = ctx.createLinearGradient(0, 0, 0, 260);
    gradient.addColorStop(0, 'rgba(246, 189, 36, 0.25)');
    gradient.addColorStop(1, 'rgba(246, 189, 36, 0.01)');

    new Chart(ctx, {
        type: 'line',

        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Pendaftar',
                data: data,
                borderColor: '#D9A512',
                backgroundColor: gradient,
                borderWidth: 2.5,
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                pointHoverRadius: 6,
                pointBackgroundColor: '#D9A512',
                pointBorderColor: '#FFFFFF',
                pointBorderWidth: 2
            }]
        },

        options: {
            responsive: true,
            maintainAspectRatio: false,

            interaction: {
                intersect: false,
                mode: 'index'
            },

            plugins: {
                legend: {
                    display: false
                },

                tooltip: {
                    backgroundColor: '#182635',
                    padding: 10,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return context.parsed.y + ' pendaftar';
                        }
                    }
                }
            },

            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#9CA3AF',
                        font: {
                            size: 10
                        }
                    }
                },

                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0,
                        stepSize: 1,
                        color: '#9CA3AF',
                        font: {
                            size: 10
                        }
                    },
                    grid: {
                        color: '#F3F4F6'
                    }
                }
            }
        }
    });
});
</script>

@endsection
