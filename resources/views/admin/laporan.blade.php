@extends('admin.layout')

@section('title', 'Laporan Admin - EskaHub')

@section('header-title')
    <h1 class="text-[28px] font-bold tracking-tight text-[#14212E] leading-tight">
        Laporan Aktivitas & Ekstrakurikuler
    </h1>
    <p class="mt-1 text-sm font-normal text-[#475361]">
        Rekapitulasi terpadu pendaftaran siswa dan kehadiran ekstrakurikuler.
    </p>
@endsection

@section('content')
<div class="mt-4 space-y-6">

    {{-- 4 KARTU STATISTIK DINAMIS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">TOTAL SISWA</p>
            <h2 class="text-3xl font-extrabold text-[#1a2b4c]">{{ number_format($totalSiswa, 0, ',', '.') }}</h2>
        </div>

        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">PROGRAM AKTIF</p>
            <h2 class="text-3xl font-extrabold text-[#1a2b4c]">{{ $programAktif }}</h2>
        </div>

        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">PENDAFTARAN BARU (BULAN INI)</p>
            <h2 class="text-3xl font-extrabold text-[#1a2b4c]">{{ $pendaftaranBaru }}</h2>
        </div>

        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">RATA-RATA KEHADIRAN</p>
            <h2 class="text-3xl font-extrabold text-[#1a2b4c]">{{ $rataKehadiran }}%</h2>
        </div>
    </div>

    {{-- SECTION TABEL DATA & LAPORAN --}}
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        
        {{-- Header Tabel --}}
        <div class="p-5 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center">
                    <i class="fa-solid fa-chart-simple text-lg"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-[#1a2b4c]">Data & Laporan Ekstrakurikuler</h2>
                    <p class="text-xs text-slate-500">Periode Aktif {{ date('Y') }}/{{ date('Y') + 1 }}</p>
                </div>
            </div>
            
            <div class="flex items-center gap-2">
                <button onclick="window.print()" class="flex items-center gap-1.5 px-3 py-1.5 border border-red-200 text-red-600 bg-red-50 hover:bg-red-100 rounded-md text-xs font-bold transition">
                    <i class="fa-regular fa-file-pdf"></i> PDF
                </button>
                <a href="{{ route('admin.laporan.export') }}" class="flex items-center gap-1.5 px-3 py-1.5 border border-emerald-200 text-emerald-600 bg-emerald-50 hover:bg-emerald-100 rounded-md text-xs font-bold transition">
                    <i class="fa-regular fa-file-excel"></i> CSV
                </a>
                <a href="{{ route('admin.laporan') }}" class="flex items-center gap-1.5 px-3 py-1.5 bg-[#1a2b4c] hover:bg-[#0f1c33] text-white rounded-md text-xs font-bold transition shadow-sm">
                    <i class="fa-solid fa-rotate"></i> Perbarui
                </a>
            </div>
        </div>

        {{-- Tabel Data Dinamis --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-gray-200 text-[11px] font-bold tracking-wider text-slate-500 uppercase">
                        <th class="py-3 px-5">ID</th>
                        <th class="py-3 px-5">KEGIATAN</th>
                        <th class="py-3 px-5">PEMBINA</th>
                        <th class="py-3 px-5">PESERTA</th>
                        <th class="py-3 px-5">KEHADIRAN</th>
                        <th class="py-3 px-5">STATUS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    
                    @forelse($ekskuls as $index => $ekskul)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="py-4 px-5 text-xs font-semibold text-gray-500">
                            RPT-<br>{{ str_pad($ekskuls->firstItem() + $index, 2, '0', STR_PAD_LEFT) }}
                        </td>
                        <td class="py-4 px-5">
                            <div class="flex items-center gap-2">
                                <span class="h-2 w-2 rounded-full {{ $ekskul->status == 'aktif' ? 'bg-emerald-500' : 'bg-gray-400' }}"></span>
                                <span class="font-bold text-slate-800">{{ $ekskul->nama }}</span>
                            </div>
                        </td>
                        <td class="py-4 px-5 text-gray-600">{{ $ekskul->pembina->nama ?? 'Belum ada' }}</td>
                        <td class="py-4 px-5 font-semibold text-slate-800">{{ $ekskul->total_peserta ?? 0 }}</td>
                        <td class="py-4 px-5">
                            <div class="flex items-center gap-3">
                                <div class="w-24 h-1.5 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="h-full bg-[#1a2b4c] rounded-full" style="width: {{ $ekskul->persentase_kehadiran }}%;"></div>
                                </div>
                                <span class="text-xs font-bold text-slate-700">{{ $ekskul->persentase_kehadiran }}%</span>
                            </div>
                        </td>
                        <td class="py-4 px-5">
                            @if($ekskul->status == 'aktif')
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-100 text-blue-700">Aktif</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-gray-100 text-gray-600">Nonaktif</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-10 text-center text-gray-500">
                            Belum ada data ekstrakurikuler untuk dilaporkan.
                        </td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        {{-- Pagination Dinamis --}}
        <div class="p-4 border-t border-gray-100 flex items-center justify-end">
            {{ $ekskuls->links() }}
        </div>

    </div>
</div>
@endsection