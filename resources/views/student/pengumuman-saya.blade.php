@extends('student.layouts.app')

@section('title', 'Pengumuman Saya - EskaHub')

@section('content')
<div class="bg-slate-50 min-h-screen p-4 md:p-8 text-slate-800 font-sans">
    <div class="max-w-4xl mx-auto">
        
        {{-- Tombol Kembali --}}
        <a href="{{ route('student.beranda') }}" class="inline-flex items-center gap-2 text-slate-700 font-medium text-sm mb-6 hover:text-slate-900 transition">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda
        </a>

        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-slate-900">Pengumuman & Jadwal</h1>
                <p class="text-sm text-slate-500 mt-1">Informasi penting, jadwal seleksi, dan jadwal latihan Anda.</p>
            </div>
        </div>

        {{-- ========================================== --}}
        {{-- 1. JADWAL SELEKSI (Kalau ada) --}}
        {{-- ========================================== --}}
        @if(isset($jadwalSeleksis) && $jadwalSeleksis->isNotEmpty())
            <div class="mb-8">
                <h2 class="text-lg font-bold text-slate-900 mb-4"><i class="fa-solid fa-clipboard-list text-amber-500 mr-2"></i> Jadwal Seleksi</h2>
                <div class="space-y-3">
                    @foreach($jadwalSeleksis as $seleksi)
                        @if($seleksi->pendaftaran->status == 'pending')
                        <div class="bg-amber-50 rounded-2xl border border-amber-200 p-5 shadow-sm flex items-start gap-4">
                            <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-600 flex flex-col items-center justify-center shrink-0">
                                <span class="text-xs font-bold uppercase">{{ \Carbon\Carbon::parse($seleksi->tanggal)->format('d') }}</span>
                                <span class="text-[10px] font-bold uppercase">{{ \Carbon\Carbon::parse($seleksi->tanggal)->format('M') }}</span>
                            </div>
                            <div>
                                <p class="text-[11px] font-bold text-amber-600 uppercase tracking-wider">{{ $seleksi->pendaftaran->ekstrakurikuler->nama }}</p>
                                <h3 class="text-sm font-bold text-slate-800 mt-0.5">{{ $seleksi->tahap_seleksi }}</h3>
                                <p class="text-xs text-slate-600 mt-1">
                                    {{ $seleksi->jam_mulai }} - {{ $seleksi->jam_selesai }} WIB <br>
                                    <i class="fa-solid fa-location-dot text-slate-400 mr-1"></i> {{ $seleksi->tempat }}
                                </p>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif

        {{-- ========================================== --}}
        {{-- 2. DAFTAR PENGUMUMAN --}}
        {{-- ========================================== --}}
        <div class="mb-8">
            <h2 class="text-lg font-bold text-slate-900 mb-4"><i class="fa-solid fa-bullhorn text-amber-500 mr-2"></i> Pengumuman</h2>
            <div class="space-y-4">
                @forelse($pengumumans as $p)
                    @php
                        $isHasilSeleksi = $p->status == 'Lulus' || $p->status == 'Tidak Lulus';
                        $isLulus = $p->status == 'Lulus';
                        
                        if ($isHasilSeleksi && $isLulus) {
                            $borderColor = 'border-l-emerald-400';
                            $iconBg = 'bg-emerald-100 text-emerald-600';
                            $badgeBg = 'bg-emerald-100 text-emerald-800';
                            $badgeText = 'DITERIMA';
                            $icon = 'fa-circle-check';
                        } elseif ($isHasilSeleksi && !$isLulus) {
                            $borderColor = 'border-l-rose-400';
                            $iconBg = 'bg-rose-100 text-rose-600';
                            $badgeBg = 'bg-rose-100 text-rose-800';
                            $badgeText = 'TIDAK LOLOS';
                            $icon = 'fa-circle-xmark';
                        } else {
                            $borderColor = 'border-l-amber-400';
                            $iconBg = 'bg-amber-100 text-amber-600';
                            $badgeBg = 'bg-slate-100 text-slate-700';
                            $badgeText = 'INFO';
                            $icon = 'fa-bullhorn';
                        }
                    @endphp

                    <div class="bg-white rounded-2xl border-l-4 {{ $borderColor }} border-y border-r border-slate-200 p-5 shadow-sm hover:border-slate-300 transition">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex items-start gap-3.5">
                                <div class="w-10 h-10 rounded-xl {{ $iconBg }} flex items-center justify-center shrink-0 mt-0.5">
                                    <i class="fa-solid {{ $icon }} text-lg"></i>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2 flex-wrap mb-1">
                                        <span class="px-2 py-0.5 rounded-md text-[10px] font-bold {{ $badgeBg }}">{{ $badgeText }}</span>
                                        <span class="text-xs text-slate-400">•</span>
                                        <span class="text-xs font-semibold text-slate-500">
                                            {{ $p->ekstrakurikuler->nama ?? 'Umum' }}
                                        </span>
                                    </div>
                                    <h3 class="text-base font-bold text-slate-900">{{ $p->judul ?? 'Pengumuman' }}</h3>
                                    <p class="text-xs text-slate-600 mt-1.5 line-clamp-3 leading-relaxed">
                                        {{ $p->isi }}
                                    </p>
                                    <span class="inline-block text-[11px] text-slate-400 mt-3">
                                        {{ \Carbon\Carbon::parse($p->created_at)->format('d M Y, H:i') }} WIB
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-2xl border border-slate-200 p-10 text-center shadow-sm">
                        <div class="inline-flex h-20 w-20 items-center justify-center rounded-full bg-slate-100 text-slate-400 mb-4">
                            <i class="fa-solid fa-bell-slash text-3xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-slate-700">Belum Ada Pengumuman</h3>
                        <p class="text-sm text-slate-500">Saat ini belum ada informasi atau pengumuman untuk Anda.</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- ========================================== --}}
        {{-- 3. JADWAL LATIHAN RUTIN (Khusus yang diterima) --}}
        {{-- ========================================== --}}
        @if(isset($jadwalLatihans) && $jadwalLatihans->isNotEmpty())
            <div class="mt-8">
                <h2 class="text-lg font-bold text-slate-900 mb-4"><i class="fa-solid fa-calendar-days text-amber-500 mr-2"></i> Jadwal Latihan Rutin</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($jadwalLatihans as $jadwal)
                    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-indigo-100 text-indigo-600 flex flex-col items-center justify-center shrink-0">
                            <span class="text-xs font-bold uppercase">{{ substr($jadwal->hari, 0, 3) }}</span>
                        </div>
                        <div>
                            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">{{ $jadwal->ekstrakurikuler->nama }}</p>
                            <h3 class="text-sm font-bold text-slate-800 mt-0.5">{{ $jadwal->jenis_latihan }}</h3>
                            <p class="text-xs text-slate-600 mt-1">
                                {{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }} WIB <br>
                                <i class="fa-solid fa-location-dot text-slate-400 mr-1"></i> {{ $jadwal->tempat }}
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</div>
@endsection