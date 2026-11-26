@extends('student.layouts.app')

@section('title', 'Profil Siswa - EskaHub')

@section('content')
<div class="min-h-screen bg-slate-50 px-4 py-6 font-sans text-slate-800 sm:px-6 md:px-8 md:py-10">
    <div class="mx-auto max-w-5xl">

        {{-- Tombol Kembali --}}
        <div class="mb-4">
            <a href="{{ route('student.beranda') }}#ekstra" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-700 transition hover:text-slate-950">
                <i class="fa-solid fa-arrow-left text-xs"></i>
                <span>Kembali</span>
            </a>
        </div>

        {{-- Alert Error --}}
        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-400 bg-red-100 px-4 py-3 text-red-700">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Header Profil + Tombol Keluar (Sejajar & Responsif) --}}
        <div class="mb-6 flex flex-col gap-4 border-b border-slate-200/80 pb-5 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 md:text-3xl">Profil Siswa</h1>
                <p class="mt-1 text-sm text-slate-500">Kelola informasi pribadi dan keamanan akun Anda.</p>
            </div>

            {{-- Tombol Keluar Tanpa Card --}}
            <form
                action="{{ route('logout') }}"
                method="POST"
                onsubmit="return confirm('Apakah kamu yakin ingin keluar dari akun EskaHub?')"
                class="self-start sm:self-auto"
            >
                @csrf
                <button
                    type="submit"
                    class="group inline-flex items-center gap-2.5 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-xs transition-all duration-200 hover:border-red-200 hover:bg-red-50 hover:text-red-600 active:scale-[0.98]"
                >
                    <span>Keluar Akun</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400 transition-transform duration-200 group-hover:translate-x-0.5 group-hover:text-red-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                        <polyline points="16 17 21 12 16 7" />
                        <line x1="21" y1="12" x2="9" y2="12" />
                    </svg>
                </button>
            </form>
        </div>

        {{-- Grid Layout 2 Kolom --}}
        <div class="grid grid-cols-1 items-start gap-6 lg:grid-cols-12">

            {{-- KOLOM KIRI: Foto Profil & Pintasan Menu --}}
            <div class="space-y-6 lg:col-span-5">

                {{-- Kartu Profil --}}
                <div class="overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm">
                    <div class="relative h-28 bg-slate-400">
                        <div class="absolute -bottom-10 left-1/2 -translate-x-1/2">
                            <div class="flex h-20 w-20 items-center justify-center overflow-hidden rounded-full border-4 border-white bg-slate-300 text-2xl font-bold text-slate-500 shadow-sm">
                                {{ strtoupper(substr($siswa->nama, 0, 2)) }}
                            </div>
                        </div>
                    </div>

                    <div class="px-4 pt-12 pb-5 text-center">
                        <h2 class="text-lg font-bold text-slate-900">{{ $siswa->nama }}</h2>
                        <p class="mt-1 text-xs font-medium text-slate-500">NISN: {{ $siswa->nisn }}</p>

                        <div class="mt-3">
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-3 py-1 text-[11px] font-semibold text-emerald-700">
                                <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                SISWA AKTIF
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Pintasan Menu --}}
                <div class="space-y-3 rounded-2xl border border-slate-100 bg-white p-4 shadow-sm">
                    <div class="flex items-center justify-between pb-1">
                        <div class="flex items-center gap-1.5 text-xs font-bold tracking-wider text-slate-600">
                            <i class="fa-solid fa-star text-amber-500"></i>
                            <span>PINTASAN MENU SISWA</span>
                        </div>
                        <span class="rounded bg-slate-100 px-2 py-0.5 text-[10px] font-medium text-slate-500">
                            Akses Cepat
                        </span>
                    </div>

                    {{-- Kartu Pendaftaran Saya --}}
                    <div class="overflow-hidden rounded-xl border border-amber-300 bg-amber-50/20">
                        <div class="flex items-center justify-between border-b border-amber-100/60 p-3.5">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-amber-400 text-white shadow-sm">
                                    <i class="fa-solid fa-file-lines"></i>
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-slate-800">Pendaftaran Saya</h3>
                                    <p class="mt-0.5 text-[11px] text-slate-500">Lihat status pendaftaran ekskul</p>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('student.pendaftaran-saya') }}" class="flex items-center justify-between px-3.5 py-2.5 text-xs font-semibold text-amber-900 transition hover:bg-amber-100/40">
                            <span>Buka Pendaftaran Saya</span>
                            <span class="flex h-5 w-5 items-center justify-center rounded-full bg-amber-200 text-amber-900">
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </span>
                        </a>
                    </div>

                    {{-- Kartu Pengumuman Saya --}}
                    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">
                        <div class="flex items-center justify-between border-b border-slate-100 p-3.5">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-slate-800 text-white shadow-sm">
                                    <i class="fa-solid fa-bullhorn"></i>
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-slate-800">Pengumuman Saya</h3>
                                    <p class="mt-0.5 text-[11px] text-slate-500">Info jadwal seleksi & latihan</p>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('student.pengumuman-saya') }}" class="flex items-center justify-between px-3.5 py-2.5 text-xs font-semibold text-slate-700 transition hover:bg-slate-50">
                            <span>Buka Semua Pengumuman</span>
                            <span class="flex h-5 w-5 items-center justify-center rounded-full bg-slate-200 text-slate-600">
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </span>
                        </a>
                    </div>
                </div>

            </div>

            {{-- KOLOM KANAN: Informasi Akademik & Kontak --}}
            <div class="space-y-6 lg:col-span-7">

                {{-- Informasi Akademik --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-3.5 shadow-sm">
                    <div class="rounded-xl border-x border-b border-t-4 border-amber-400 bg-white p-5 md:p-6">
                        <h2 class="mb-6 text-base font-bold text-slate-900">Informasi Akademik</h2>

                        <div class="space-y-5">
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                <div>
                                    <label class="mb-2 block text-xs font-bold text-slate-800">Kelas</label>
                                    <input
                                        type="text"
                                        value="{{ $siswa->kelas ?? '-' }}"
                                        readonly
                                        class="w-full cursor-not-allowed rounded-xl border border-slate-300 bg-gray-50 px-3.5 py-2.5 text-sm font-medium text-slate-600 focus:outline-none"
                                    >
                                </div>

                                <div>
                                    <label class="mb-2 block text-xs font-bold text-slate-800">Jurusan</label>
                                    <input
                                        type="text"
                                        value="{{ $siswa->jurusan ?? '-' }}"
                                        readonly
                                        class="w-full cursor-not-allowed rounded-xl border border-slate-300 bg-gray-50 px-3.5 py-2.5 text-sm font-medium text-slate-600 focus:outline-none"
                                    >
                                </div>
                            </div>

                            <div>
                                <label class="mb-2 block text-xs font-bold text-slate-800">
                                    Email Sekolah <span class="font-normal text-slate-400">(Read-only)</span>
                                </label>
                                <input
                                    type="text"
                                    value="{{ $siswa->email ?? '-' }}"
                                    readonly
                                    class="w-full cursor-not-allowed rounded-xl border border-slate-300 bg-gray-50 px-3.5 py-2.5 text-sm font-medium text-slate-600 focus:outline-none"
                                >
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kontak & Keamanan --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm md:p-6">
                    <h2 class="mb-6 text-base font-bold text-slate-900">Kontak & Keamanan</h2>

                    <form action="#" method="POST" class="space-y-5">
                        @csrf
                        <div>
                            <label class="mb-2 block text-xs font-bold text-slate-800">
                                Nomor HP / WhatsApp <span class="text-rose-500">*</span>
                            </label>
                            <input
                                type="text"
                                name="phone_number"
                                value="{{ $siswa->no_hp ?? '-' }}"
                                class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm font-medium text-slate-800 transition focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500"
                            >
                            <p class="mt-1.5 text-[11px] text-slate-400">
                                Gunakan format yang valid agar mudah dihubungi oleh pembina ekskul.
                            </p>
                        </div>

                        <div class="border-b border-slate-200 pt-2"></div>

                        {{-- Tombol Aksi Form (Responsif di Mobile & Desktop) --}}
                        <div class="flex flex-col-reverse gap-3 pt-1 sm:flex-row sm:items-center sm:justify-between">
                            <a href="{{ route('password.force') }}" class="w-full rounded-xl bg-slate-900 px-4 py-2.5 text-center text-xs font-bold text-white transition hover:bg-slate-800 sm:w-auto">
                                Ganti Password
                            </a>
                            <button type="submit" class="w-full rounded-xl bg-amber-500 px-5 py-2.5 text-xs font-bold text-white transition hover:bg-amber-600 sm:w-auto">
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