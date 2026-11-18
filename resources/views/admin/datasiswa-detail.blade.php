@extends('admin.layout')

@section('content')
<div class="max-w-4xl mx-auto p-6 space-y-6">

    {{-- Tombol Kembali --}}
    <div>
        <a href="{{ route('admin.datasiswa.index') }}" class="inline-flex items-center text-sm font-semibold text-slate-600 hover:text-slate-900 transition">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke Data Siswa
        </a>
    </div>

    {{-- Header Profil Siswa --}}
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm flex flex-col md:flex-row items-start md:items-center gap-6">
        <div class="w-20 h-20 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center text-2xl font-bold shrink-0">
            {{ strtoupper(substr($siswa->nama, 0, 2)) }}
        </div>
        <div class="space-y-1">
            <h1 class="text-2xl font-bold text-slate-800">{{ $siswa->nama }}</h1>
            <p class="text-sm font-medium text-slate-500 font-mono">NISN: {{ $siswa->nisn }}</p>
            <div class="flex items-center gap-2 mt-2">
                <span class="px-2.5 py-1 rounded-md text-xs font-bold bg-emerald-100 text-emerald-700">SISWA AKTIF</span>
                <span class="px-2.5 py-1 rounded-md text-xs font-bold bg-slate-100 text-slate-700">{{ $siswa->kelas }}</span>
            </div>
        </div>
    </div>

    {{-- Grid Info Detail --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        {{-- Card 1: Informasi Akademik --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm space-y-4">
            <h2 class="text-lg font-bold text-slate-800 border-b border-slate-100 pb-2">Informasi Akademik</h2>
            
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-slate-500">Jurusan</span>
                    <span class="font-semibold text-slate-800 text-right">{{ $siswa->jurusan ?? '-' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Kelas</span>
                    <span class="font-semibold text-slate-800">{{ $siswa->kelas ?? '-' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Jenis Kelamin</span>
                    <span class="font-semibold text-slate-800">
                        @if($siswa->jenis_kelamin == 'L') Laki-laki
                        @elseif($siswa->jenis_kelamin == 'P') Perempuan
                        @else - @endif
                    </span>
                </div>
            </div>
        </div>

        {{-- Card 2: Kontak & Akun --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm space-y-4">
            <h2 class="text-lg font-bold text-slate-800 border-b border-slate-100 pb-2">Kontak & Akun</h2>
            
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-slate-500">Email</span>
                    <span class="font-semibold text-slate-800 text-right">{{ $siswa->email ?? '-' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">No. HP</span>
                    <span class="font-semibold text-slate-800">{{ $siswa->no_hp ?? '-' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Alamat</span>
                    <span class="font-semibold text-slate-800 text-right">{{ $siswa->alamat ?? '-' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Username Login</span>
                    <span class="font-semibold text-slate-800">{{ $siswa->pengguna->username ?? '-' }}</span>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection