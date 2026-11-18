@extends('student.layouts.app')

@section('title', 'Profil Siswa - EskaHub')

@section('content')
<div class="bg-slate-50 min-h-screen p-4 md:p-8 text-slate-800 font-sans">
    <div class="max-w-5xl mx-auto">
        
        {{-- Tombol Kembali --}}
        <div class="mb-4">
            <a href="{{ route('student.beranda') }}#ekstra" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-800 transition hover:text-slate-600">
                <i class="fa-solid fa-arrow-left text-sm"></i> Kembali
            </a>
        </div>

        {{-- Alert Error --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-4">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Header Profil --}}
        <div class="mb-6">
            <h1 class="text-2xl md:text-3xl font-bold text-slate-900">Profil Siswa</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola informasi pribadi dan keamanan akun Anda.</p>
        </div>

        {{-- Grid Layout 2 Kolom --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            
            {{-- KOLOM KIRI: Foto Profil & Pintasan Menu --}}
            <div class="lg:col-span-5 space-y-6">
                
                {{-- Kartu Profil --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="h-28 bg-slate-400 relative">
                        <div class="absolute -bottom-10 left-1/2 -translate-x-1/2">
                            <div class="relative">
                                <div class="w-20 h-20 rounded-full border-4 border-white bg-slate-300 overflow-hidden shadow-sm flex items-center justify-center text-2xl font-bold text-slate-500">
                                    {{-- Inisial Nama Siswa --}}
                                    {{ strtoupper(substr($siswa->nama, 0, 2)) }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-12 pb-5 px-4 text-center">
                        {{-- Nama Dinamis --}}
                        <h2 class="text-lg font-bold text-slate-900">{{ $siswa->nama }}</h2>
                        {{-- NISN Dinamis --}}
                        <p class="text-xs text-slate-500 font-medium mt-1">NISN: {{ $siswa->nisn }}</p>
                        
                        <div class="mt-3">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold bg-emerald-100 text-emerald-700">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                SISWA AKTIF
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Pintasan Menu --}}
                <div class="bg-white rounded-2xl border border-slate-100 p-4 shadow-sm space-y-3">
                    <div class="flex items-center justify-between pb-1">
                        <div class="flex items-center gap-1.5 text-xs font-bold text-slate-600 tracking-wider">
                            <i class="fa-solid fa-star text-amber-500"></i> PINTASAN MENU SISWA
                        </div>
                        <span class="text-[10px] font-medium bg-slate-100 text-slate-500 px-2 py-0.5 rounded">Akses Cepat</span>
                    </div>

                    {{-- Kartu Pendaftaran Saya --}}
                    <div class="border border-amber-300 bg-amber-50/20 rounded-xl overflow-hidden">
                        <div class="p-3.5 flex items-center justify-between border-b border-amber-100/60">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-amber-400 flex items-center justify-center text-white shadow-sm">
                                    <i class="fa-solid fa-file-lines"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-slate-800 text-sm">Pendaftaran Saya</h3>
                                    <p class="text-[11px] text-slate-500 mt-0.5">Lihat status pendaftaran ekskul</p>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('student.pendaftaran-saya') }}" class="px-3.5 py-2.5 flex items-center justify-between text-xs font-semibold text-amber-900 hover:bg-amber-100/40 transition">
                            <span>Buka Pendaftaran Saya</span>
                            <span class="w-5 h-5 rounded-full bg-amber-200 flex items-center justify-center text-amber-900">
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </span>
                        </a>
                    </div>
                    
                    {{-- Kartu Pengumuman Saya --}}
                    <div class="border border-slate-200 rounded-xl overflow-hidden bg-white">
                        <div class="p-3.5 flex items-center justify-between border-b border-slate-100">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-slate-800 flex items-center justify-center text-white shadow-sm">
                                    <i class="fa-solid fa-bullhorn"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-slate-800 text-sm">Pengumuman Saya</h3>
                                    <p class="text-[11px] text-slate-500 mt-0.5">Info jadwal seleksi & latihan</p>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('student.pengumuman-saya') }}" class="px-3.5 py-2.5 flex items-center justify-between text-xs font-semibold text-slate-700 hover:bg-slate-50 transition">
                            <span>Buka Semua Pengumuman</span>
                            <span class="w-5 h-5 rounded-full bg-slate-200 flex items-center justify-center text-slate-600">
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </span>
                        </a>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: Informasi Akademik & Kontak --}}
            <div class="lg:col-span-7 space-y-6">
                
                {{-- Informasi Akademik --}}
                <div class="bg-white rounded-2xl border border-slate-200 p-3.5 shadow-sm">
                    <div class="border-t-4 border-x border-b border-amber-400 rounded-xl p-5 md:p-6 bg-white">
                        <h2 class="text-base font-bold text-slate-900 mb-6">Informasi Akademik</h2>

                        <div class="space-y-5">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-800 mb-2">Kelas</label>
                                    {{-- Kelas Dinamis --}}
                                    <input type="text" value="{{ $siswa->kelas ?? '-' }}" readonly class="w-full px-3.5 py-2.5 bg-gray-50 border border-slate-300 rounded-xl text-sm text-slate-600 font-medium focus:outline-none cursor-not-allowed">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-800 mb-2">Jurusan</label>
                                    {{-- Jurusan Dinamis --}}
                                    <input type="text" value="{{ $siswa->jurusan ?? '-' }}" readonly class="w-full px-3.5 py-2.5 bg-gray-50 border border-slate-300 rounded-xl text-sm text-slate-600 font-medium focus:outline-none cursor-not-allowed">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-800 mb-2">Email Sekolah <span class="text-slate-400 font-normal">(Read-only)</span></label>
                                {{-- Email Dinamis --}}
                                <input type="text" value="{{ $siswa->email ?? '-' }}" readonly class="w-full px-3.5 py-2.5 bg-gray-50 border border-slate-300 rounded-xl text-sm text-slate-600 font-medium focus:outline-none cursor-not-allowed">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kontak & Keamanan --}}
                <div class="bg-white rounded-2xl border border-slate-200 p-5 md:p-6 shadow-sm">
                    <h2 class="text-base font-bold text-slate-900 mb-6">Kontak & Keamanan</h2>

                    <form action="#" method="POST" class="space-y-5">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-slate-800 mb-2">Nomor HP / WhatsApp <span class="text-rose-500">*</span></label>
                            {{-- No HP Dinamis --}}
                            <input type="text" name="phone_number" value="{{ $siswa->no_hp ?? '-' }}" class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-sm text-slate-800 font-medium focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition">
                            <p class="text-[11px] text-slate-400 mt-1.5">Gunakan format yang valid agar mudah dihubungi oleh pembina ekskul.</p>
                        </div>

                        <div class="pt-2 border-b border-slate-200"></div>

                        <div class="flex items-center justify-between gap-4 pt-1">
                            <a href="{{ route('password.force') }}" class="px-4 py-2.5 bg-slate-900 text-white rounded-lg text-xs font-bold hover:bg-slate-800 transition">
                                Ganti Password
                            </a>
                            <button type="submit" class="px-5 py-2.5 bg-amber-500 text-white rounded-lg text-xs font-bold hover:bg-amber-600 transition">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection