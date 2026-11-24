@extends('pembina.layouts.app')

@section('title', 'Laporan - EskaHub')

@section('content')

<style>
    @media print {
        body { background: white !important; }
        aside, nav, .no-print, button { display: none !important; }
        main { width: 100% !important; margin: 0 !important; padding: 0 !important; }
        .print-area { width: 100% !important; border: none !important; }
        .print-area table { width: 100% !important; }
    }
</style>

<div class="w-full text-gray-800">

    <!-- Search -->
    <div class="mb-5 no-print">
        <form action="{{ route('pembina.laporan') }}" method="GET" class="w-full sm:max-w-sm">
            <input type="hidden" name="start_date" value="{{ request('start_date') }}">
            <input type="hidden" name="end_date" value="{{ request('end_date') }}">
            <input type="hidden" name="status" value="{{ request('status') }}">
            <input type="hidden" name="ekstrakurikuler_id" value="{{ request('ekstrakurikuler_id') }}">

            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Cari nama siswa atau ekskul..."
                   class="w-full bg-white border border-gray-300 rounded-md px-3 py-2 text-xs sm:text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-amber-600">
        </form>
    </div>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Laporan</h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-0.5">Rekap data pendaftaran ekstrakurikuler.</p>
        </div>

        <button type="button"
                onclick="window.print()"
                class="no-print w-full sm:w-auto bg-amber-600 hover:bg-amber-700 text-white text-xs font-semibold px-4 py-2 rounded-md transition cursor-pointer">
            Print PDF
        </button>
    </div>

    <!-- Filter -->
    <div class="bg-white border border-gray-200 rounded-md p-4 mb-5 no-print">
        <form action="{{ route('pembina.laporan') }}" method="GET" class="space-y-3.5">
            <input type="hidden" name="search" value="{{ request('search') }}">

            <div class="grid grid-cols-1 md:grid-cols-12 gap-3.5 items-end">
                <div class="md:col-span-6">
                    <label class="block text-xs font-medium text-gray-700 mb-1">Tanggal</label>
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                        <input type="date"
                               name="start_date"
                               value="{{ request('start_date') }}"
                               class="w-full bg-white border border-gray-300 rounded-md px-3 py-2 text-xs text-gray-700 focus:outline-none focus:border-amber-600">
                        <span class="text-xs text-gray-400 text-center">s/d</span>
                        <input type="date"
                               name="end_date"
                               value="{{ request('end_date') }}"
                               class="w-full bg-white border border-gray-300 rounded-md px-3 py-2 text-xs text-gray-700 focus:outline-none focus:border-amber-600">
                    </div>
                </div>

                <div class="md:col-span-3">
                    <label for="ekstrakurikuler_id" class="block text-xs font-medium text-gray-700 mb-1">Ekstrakurikuler</label>
                    <select id="ekstrakurikuler_id"
                            name="ekstrakurikuler_id"
                            class="w-full bg-white border border-gray-300 rounded-md px-3 py-2 text-xs text-gray-700 focus:outline-none focus:border-amber-600">
                        <option value="">Semua Ekskul</option>
                        @foreach($daftarEkstrakurikuler as $ekskul)
                            <option value="{{ $ekskul->id }}" {{ request('ekstrakurikuler_id') == $ekskul->id ? 'selected' : '' }}>
                                {{ $ekskul->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-3">
                    <label for="status" class="block text-xs font-medium text-gray-700 mb-1">Status</label>
                    <select id="status"
                            name="status"
                            class="w-full bg-white border border-gray-300 rounded-md px-3 py-2 text-xs text-gray-700 focus:outline-none focus:border-amber-600">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
            </div>

            <div class="pt-3 border-t border-gray-100 flex flex-col sm:flex-row sm:justify-end gap-2">
                <a href="{{ route('pembina.laporan') }}"
                   class="w-full sm:w-auto text-center border border-gray-300 hover:bg-gray-50 text-gray-700 text-xs font-medium px-4 py-2 rounded-md">
                    Reset
                </a>
                <button type="submit"
                        class="w-full sm:w-auto bg-gray-900 hover:bg-gray-800 text-white text-xs font-medium px-4 py-2 rounded-md cursor-pointer">
                    Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Ringkasan -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
        <div class="bg-white border border-gray-200 rounded-md p-4">
            <p class="text-xs font-medium text-gray-500">Total Pendaftar</p>
            <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalPendaftar ?? 0 }}</p>
        </div>

        <div class="bg-white border border-gray-200 rounded-md p-4">
            <p class="text-xs font-medium text-gray-500">Total Anggota Aktif</p>
            <p class="text-2xl font-bold text-amber-700 mt-1">{{ $totalAnggotaAktif ?? 0 }}</p>
        </div>
    </div>

    <!-- Data Laporan -->
    <div class="w-full bg-white border border-gray-200 rounded-md overflow-hidden print-area">
        <div class="flex items-center justify-between px-4 py-3 bg-gray-50 border-b border-gray-200">
            <h2 class="text-xs font-bold text-gray-800">Data Pendaftar</h2>
            <span class="text-xs text-gray-500">{{ $pendaftars->total() }} data</span>
        </div>

        <!-- Mobile -->
        <div class="divide-y divide-gray-200 md:hidden no-print">
            @forelse ($pendaftars as $index => $item)
                <div class="p-4 space-y-1.5">
                    <div class="flex items-center justify-between gap-2">
                        <p class="text-sm font-semibold text-gray-900">
                            {{ $pendaftars->firstItem() + $index }}. {{ $item->member?->nama ?? 'Nama tidak tersedia' }}
                        </p>
                        <span class="text-xs font-medium {{ $item->status === 'diterima' ? 'text-green-700' : ($item->status === 'ditolak' ? 'text-red-700' : 'text-amber-700') }}">
                            {{ ucfirst($item->status ?? 'pending') }}
                        </span>
                    </div>
                    <p class="text-xs text-gray-600">{{ $item->ekstrakurikuler?->nama ?? '-' }}</p>
                    <p class="text-xs text-gray-400">{{ $item->created_at ? $item->created_at->format('d M Y') : '-' }}</p>
                </div>
            @empty
                <div class="p-8 text-center text-xs sm:text-sm text-gray-500">
                    Belum ada data pendaftaran.
                </div>
            @endforelse
        </div>

        <!-- Desktop -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 text-xs font-semibold border-b border-gray-200">
                        <th class="py-2.5 px-4 w-14">No</th>
                        <th class="py-2.5 px-4">Nama</th>
                        <th class="py-2.5 px-4">Ekstrakurikuler</th>
                        <th class="py-2.5 px-4">Tanggal</th>
                        <th class="py-2.5 px-4">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-xs sm:text-sm text-gray-700">
                    @forelse ($pendaftars as $index => $item)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 px-4 text-gray-500">{{ $pendaftars->firstItem() + $index }}</td>
                            <td class="py-3 px-4 font-medium text-gray-900">{{ $item->member?->nama ?? 'Nama tidak tersedia' }}</td>
                            <td class="py-3 px-4 text-gray-600">{{ $item->ekstrakurikuler?->nama ?? '-' }}</td>
                            <td class="py-3 px-4 text-gray-600 whitespace-nowrap">{{ $item->created_at ? $item->created_at->format('d M Y') : '-' }}</td>
                            <td class="py-3 px-4 whitespace-nowrap font-medium {{ $item->status === 'diterima' ? 'text-green-700' : ($item->status === 'ditolak' ? 'text-red-700' : 'text-amber-700') }}">
                                {{ ucfirst($item->status ?? 'pending') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 px-4 text-center text-sm text-gray-500">
                                Belum ada data pendaftaran.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($pendaftars->hasPages())
            <div class="px-4 py-3 border-t border-gray-200 no-print">
                {{ $pendaftars->withQueryString()->links() }}
            </div>
        @endif
    </div>

</div>
@endsection