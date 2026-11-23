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

<div class="w-full">

    {{-- SEARCH BAR --}}
    <div class="mb-8 no-print">
        <form action="{{ route('pembina.laporan') }}" method="GET" class="relative max-w-md">
            {{-- Pertahankan semua filter saat mencari --}}
            <input type="hidden" name="start_date" value="{{ request('start_date') }}">
            <input type="hidden" name="end_date" value="{{ request('end_date') }}">
            <input type="hidden" name="status" value="{{ request('status') }}">
            <input type="hidden" name="ekstrakurikuler_id" value="{{ request('ekstrakurikuler_id') }}">

            <div class="flex items-center border border-gray-300 bg-white px-3.5 py-2.5 focus-within:border-gray-500 transition">
                <svg class="w-4 h-4 text-gray-500 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 103.5 10.5a7.5 7.5 0 0013.15 6.15z"/>
                </svg>

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari nama siswa, NISN, atau ekskul..."
                    class="w-full text-sm text-gray-700 placeholder-gray-400 focus:outline-none bg-transparent"
                >
            </div>
        </form>
    </div>

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Laporan</h1>
            <p class="text-xs text-gray-500 mt-1.5">
                Hasilkan dan ekspor laporan partisipasi kegiatan ekstrakurikuler.
            </p>
        </div>

        <button
            type="button"
            onclick="window.print()"
            class="no-print inline-flex items-center gap-2 bg-[#F5B800] hover:bg-[#e0a800] text-white text-xs font-semibold px-4 py-2.5 rounded shadow-xs transition w-fit"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <span>PRINT PDF</span>
        </button>
    </div>

    {{-- FILTER BOX --}}
    <div class="border border-gray-200 rounded-md p-5 mb-6 bg-white no-print">
        <form action="{{ route('pembina.laporan') }}" method="GET"
              class="flex flex-col lg:flex-row lg:items-end justify-between gap-4">

            {{-- Pertahankan pencarian --}}
            <input type="hidden" name="search" value="{{ request('search') }}">

            <div class="flex flex-col md:flex-row items-start md:items-end gap-4 flex-1">

                {{-- TANGGAL --}}
                <div class="w-full md:w-auto">
                    <label class="block text-xs font-semibold text-gray-800 mb-2">Rentang Tanggal</label>
                    <div class="flex items-center gap-2.5">
                        <input type="date" name="start_date" value="{{ request('start_date') }}"
                            class="w-full sm:w-40 border border-gray-300 rounded px-3 py-2 text-xs text-gray-600 focus:outline-none focus:border-gray-500">
                        <span class="text-xs text-gray-400">sampai</span>
                        <input type="date" name="end_date" value="{{ request('end_date') }}"
                            class="w-full sm:w-40 border border-gray-300 rounded px-3 py-2 text-xs text-gray-600 focus:outline-none focus:border-gray-500">
                    </div>
                </div>

                {{-- EKSKUL --}}
                <div class="w-full md:w-56">
                    <label for="ekstrakurikuler_id" class="block text-xs font-semibold text-gray-800 mb-2">
                        Ekstrakurikuler
                    </label>
                    <select id="ekstrakurikuler_id" name="ekstrakurikuler_id"
                        class="w-full border border-gray-300 rounded px-3 py-2 text-xs text-gray-600 bg-white focus:outline-none focus:border-gray-500">
                        <option value="">Semua Ekskul</option>
                        @foreach($daftarEkstrakurikuler as $ekskul)
                            <option value="{{ $ekskul->id }}"
                                {{ request('ekstrakurikuler_id') == $ekskul->id ? 'selected' : '' }}>
                                {{ $ekskul->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- STATUS --}}
                <div class="w-full md:w-56">
                    <label for="status" class="block text-xs font-semibold text-gray-800 mb-2">Status</label>
                    <select id="status" name="status"
                        class="w-full border border-gray-300 rounded px-3 py-2 text-xs text-gray-600 bg-white focus:outline-none focus:border-gray-500">
                        <option value="">Semua Status</option>
                        <option value="pending"  {{ request('status') == 'pending'  ? 'selected' : '' }}>PENDING</option>
                        <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>DITERIMA</option>
                        <option value="ditolak"  {{ request('status') == 'ditolak'  ? 'selected' : '' }}>DITOLAK</option>
                    </select>
                </div>

            </div>

            {{-- BUTTON FILTER --}}
            <div class="flex gap-2">
                <button type="submit"
                    class="w-full lg:w-auto bg-[#0F172A] hover:bg-slate-800 text-white text-xs font-medium px-6 py-2.5 rounded transition cursor-pointer">
                    Apply Filters
                </button>
                <a href="{{ route('pembina.laporan') }}"
                    class="inline-flex items-center justify-center border border-gray-300 hover:bg-gray-50 text-gray-600 text-xs px-4 py-2.5 rounded transition">
                    Reset
                </a>
            </div>

        </form>
    </div>

    {{-- SUMMARY CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-6">
        <div class="border border-gray-200 rounded-md p-6 bg-white">
            <p class="text-xs font-semibold text-gray-700 uppercase tracking-wide">TOTAL PENDAFTAR</p>
            <p class="text-2xl font-bold text-gray-600 mt-2">{{ $totalPendaftar ?? 0 }}</p>
            <p class="text-[11px] text-gray-400 mt-1">Berdasarkan filter yang diterapkan</p>
        </div>

        <div class="border border-gray-200 rounded-md p-6 bg-white">
            <p class="text-xs font-semibold text-gray-700 uppercase tracking-wide">TOTAL ANGGOTA AKTIF</p>
            <p class="text-2xl font-bold text-gray-600 mt-2">{{ $totalAnggotaAktif ?? 0 }}</p>
            <p class="text-[11px] text-gray-400 mt-1">Pendaftar dengan status diterima</p>
        </div>
    </div>

    {{-- TABLE LAPORAN --}}
    <div class="w-full border border-gray-200 rounded-md overflow-hidden bg-white print-area">

        {{-- TABLE HEADER --}}
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-200">
            <div>
                <h2 class="text-xs font-bold text-gray-800 uppercase tracking-wider">PENDAFTAR REPORT</h2>
                <p class="text-[11px] text-gray-400 mt-1">Data pendaftaran ekstrakurikuler</p>
            </div>
            <svg class="w-5 h-5 text-gray-700 no-print" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                      d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
            </svg>
        </div>

        {{-- TABLE --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#88929B] text-white text-[11px] font-semibold uppercase tracking-wider">
                        <th class="py-3 px-5">NO</th>
                        <th class="py-3 px-5">NAME</th>
                        <th class="py-3 px-5">EKSTRAKURIKULER</th>
                        <th class="py-3 px-5">DATE</th>
                        <th class="py-3 px-5">STATUS</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200 text-xs text-gray-700">
                    @forelse ($pendaftars as $index => $item)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-3.5 px-5 text-gray-500">
                                {{ $pendaftars->firstItem() + $index }}
                            </td>

                            <td class="py-3.5 px-5 font-medium text-gray-800">
                                {{ $item->member?->nama ?? 'Nama tidak tersedia' }}
                            </td>

                            <td class="py-3.5 px-5 text-gray-600">
                                {{ $item->ekstrakurikuler?->nama ?? '-' }}
                            </td>

                            <td class="py-3.5 px-5 text-gray-600">
                                {{ $item->created_at ? $item->created_at->format('d M Y') : '-' }}
                            </td>

                            <td class="py-3.5 px-5 font-semibold">
                                @if ($item->status === 'diterima')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-green-50 text-green-600">
                                        DITERIMA
                                    </span>
                                @elseif ($item->status === 'ditolak')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-red-50 text-red-600">
                                        DITOLAK
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-yellow-50 text-yellow-600">
                                        PENDING
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 px-5 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="w-10 h-10 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <p class="text-sm font-medium text-gray-500">Belum ada data pendaftaran</p>
                                    <p class="text-xs text-gray-400 mt-1">Data tidak ditemukan atau belum tersedia.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        @if ($pendaftars->hasPages())
            <div class="px-5 py-4 border-t border-gray-200 no-print">
                {{ $pendaftars->links() }}
            </div>
        @endif

    </div>

</div>

@endsection