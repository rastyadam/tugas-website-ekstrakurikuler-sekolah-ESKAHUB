@extends('student.layouts.app')

@section('title', 'Detail Pendaftaran - EskaHub')

@section('content')

<div class="min-h-screen bg-slate-50/50 px-4 py-8 sm:px-6 lg:px-8">

    <div class="mx-auto max-w-6xl space-y-6">

        {{-- Tombol Kembali --}}
        <div>
            <a href="{{ route('student.pendaftaran-saya') }}"
                class="inline-flex items-center text-xs font-semibold text-slate-500 transition hover:text-slate-800">
                <svg class="mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>
        </div>

        {{-- Header Card --}}
        <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm sm:p-8">
            <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
                <div>
                    {{-- ID Registrasi --}}
                    <div class="mb-2 flex items-center gap-2">
                        <span class="inline-block h-2.5 w-2.5 rounded-full bg-amber-400"></span>
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">
                            ID: REG-BSK-2023-089
                        </span>
                    </div>

                    {{-- Judul --}}
                    <h1 class="text-2xl font-extrabold tracking-tight text-slate-900 sm:text-3xl">
                        Detail Pendaftaran: Bola Basket
                    </h1>

                    <p class="mt-2 text-xs font-normal text-slate-500 sm:text-sm">
                        Informasi lengkap formulir registrasi, jadwal seleksi lapangan, dan status verifikasi siswa.
                    </p>
                </div>

                {{-- Status --}}
                <div class="shrink-0 self-start md:self-center">
                    <span class="rounded-full bg-amber-100 px-4 py-2 text-xs font-bold uppercase tracking-wider text-amber-800">
                        MENUNGGU SELEKSI
                    </span>
                </div>
            </div>
        </div>

        {{-- Section Heading --}}
        <div class="pt-2">
            <h2 class="text-base font-bold text-slate-900">
                Jadwal & Informasi Ekstrakurikuler
            </h2>
            <p class="mt-0.5 text-xs text-slate-500">
                Detail sesi uji kelayakan dan penanggung jawab kegiatan
            </p>
        </div>

        {{-- Card Information Grid (Soft Blue Background) --}}
        <div class="rounded-2xl bg-blue-50/50 p-6 sm:p-8">
            <div class="grid gap-y-6 gap-x-8 sm:grid-cols-2 lg:grid-cols-3">
                
                {{-- Nama Ekstrakurikuler --}}
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-wider text-slate-500">
                        NAMA EKSTRAKURIKULER
                    </p>
                    <p class="mt-1 text-sm font-extrabold text-slate-900">
                        Bola Basket Putra
                    </p>
                </div>

                {{-- Kategori Minat --}}
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-wider text-slate-500">
                        KATEGORI MINAT
                    </p>
                    <p class="mt-1 text-sm font-extrabold text-slate-900">
                        Olahraga & Atletik
                    </p>
                </div>

                {{-- Tanggal Registrasi --}}
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-wider text-slate-500">
                        TANGGAL REGISTRASI
                    </p>
                    <p class="mt-1 text-sm font-extrabold text-slate-900">
                        12 Okt 2023, 14:20 WIB
                    </p>
                </div>

                {{-- Jadwal Seleksi --}}
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-wider text-slate-500">
                        JADWAL SELEKSI
                    </p>
                    <p class="mt-1 text-sm font-extrabold text-amber-600">
                        Senin, 15 Juli 2024 (15:00 - 17:00)
                    </p>
                </div>

                {{-- Lokasi Lapangan --}}
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-wider text-slate-500">
                        LOKASI LAPANGAN
                    </p>
                    <p class="mt-1 text-sm font-extrabold text-slate-900 leading-snug">
                        Lapangan Basket Utama (Outdoor Hall A)
                    </p>
                </div>

                {{-- Penguji / Pelatih --}}
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-wider text-slate-500">
                        PENGUJI / PELATIH
                    </p>
                    <p class="mt-1 text-sm font-extrabold text-slate-900">
                        Budi Santoso, S.Pd.
                    </p>
                </div>

            </div>
        </div>

        {{-- Petunjuk & Perlengkapan Seleksi Alert --}}
        <div class="rounded-2xl bg-blue-50/50 p-5">
            <div class="flex items-start gap-3">
                <div class="shrink-0 text-amber-500">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-xs font-bold text-slate-900">
                        Petunjuk & Perlengkapan Seleksi
                    </h3>
                    <p class="mt-1 text-xs leading-relaxed text-slate-600">
                        Siswa pendaftar diwajibkan mengenakan pakaian olahraga resmi sekolah, membawa air minum pribadi, dan menggunakan sepatu basket standar indoor/outdoor. Harap hadir 15 menit sebelum waktu dimulai.
                    </p>
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex justify-end pt-4 pb-8">
            <button type="button"
                class="rounded-lg bg-rose-50 px-4 py-2.5 text-xs font-bold text-rose-600 transition hover:bg-rose-100">
                Batalkan Pendaftaran
            </button>
        </div>

    </div>

</div>

@endsection