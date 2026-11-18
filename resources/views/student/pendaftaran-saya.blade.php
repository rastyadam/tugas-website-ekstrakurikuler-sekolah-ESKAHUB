@extends('student.layouts.app')

@section('title', 'Pendaftaran Saya - EskaHub')

@section('content')
<div class="min-h-screen bg-slate-50 p-4 md:p-8 text-slate-800 font-sans">
    <div class="max-w-4xl mx-auto">

        {{-- Tombol Kembali --}}
        <a href="{{ route('student.profil') }}" class="inline-flex items-center gap-2 text-slate-700 font-medium text-sm mb-6 hover:text-slate-900 transition">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Profil
        </a>

        {{-- Header --}}
        <div class="mb-6">
            <h1 class="text-2xl md:text-3xl font-bold text-slate-900">Pendaftaran Saya</h1>
            <p class="text-sm text-slate-500 mt-1">Pantau status pendaftaran ekstrakurikuler yang telah Anda ajukan.</p>
        </div>

        {{-- Notifikasi --}}
        @if(session('success'))
            <div class="bg-emerald-100 text-emerald-700 p-4 rounded-xl text-sm font-semibold mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Daftar Pendaftaran --}}
        <div class="space-y-4">
            
            @forelse($pendaftarans as $p)
                @php
                    // Tentukan warna & ikon berdasarkan status
                    if ($p->status == 'pending') {
                        $bgIcon = 'bg-amber-100 text-amber-600';
                        $badge = 'bg-amber-100 text-amber-800';
                        $icon = 'fa-hourglass-half';
                        $label = 'Menunggu Seleksi';
                    } elseif ($p->status == 'diterima') {
                        $bgIcon = 'bg-emerald-100 text-emerald-600';
                        $badge = 'bg-emerald-100 text-emerald-800';
                        $icon = 'fa-circle-check';
                        $label = 'Diterima';
                    } else {
                        $bgIcon = 'bg-rose-100 text-rose-600';
                        $badge = 'bg-rose-100 text-rose-800';
                        $icon = 'fa-circle-xmark';
                        $label = 'Tidak Lolos';
                    }
                @endphp

                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:border-slate-300 transition">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-xl {{ $bgIcon }} flex items-center justify-center shrink-0">
                                <i class="fa-solid {{ $icon }} text-xl"></i>
                            </div>
                            <div>
                                <div class="flex items-center gap-2 flex-wrap">
                                    <h3 class="text-base font-bold text-slate-900">
                                        {{ $p->ekstrakurikuler->nama ?? 'Ekstrakurikuler' }}
                                    </h3>
                                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold {{ $badge }}">
                                        {{ $label }}
                                    </span>
                                </div>
                                <p class="text-xs text-slate-500 mt-1">
                                    Tanggal Daftar: {{ \Carbon\Carbon::parse($p->tanggal_daftar)->format('d M Y') }}
                                    @if($p->status == 'ditolak' && $p->alasan_penolakan)
                                        • Alasan: {{ $p->alasan_penolakan }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="self-end md:self-center">
                            {{-- Tombol Detail ke halaman detail status --}}
                            <a href="{{ route('student.pendaftaran-saya.detail', $p->id) }}" class="px-3.5 py-2 text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-lg transition">
                                Detail
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                {{-- Tampilan jika belum ada pendaftaran --}}
                <div class="bg-white rounded-2xl border border-slate-200 p-10 text-center shadow-sm">
                    <div class="inline-flex h-20 w-20 items-center justify-center rounded-full bg-slate-100 text-slate-400 mb-4">
                        <i class="fa-solid fa-folder-open text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-700">Belum Ada Pendaftaran</h3>
                    <p class="text-sm text-slate-500 mb-6">Kamu belum mendaftar ke ekstrakurikuler apa pun.</p>
                    <a href="{{ route('student.ekstra') }}" class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white font-bold py-2.5 px-6 rounded-xl shadow-sm transition">
                        Jelajahi Ekstrakurikuler
                    </a>
                </div>
            @endforelse

        </div>
    </div>
</div>
@endsection