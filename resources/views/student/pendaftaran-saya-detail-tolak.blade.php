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
                    {{-- ID Registrasi & Indicator --}}
                    <div class="mb-2 flex items-center gap-2">
                        <span class="inline-block h-2.5 w-2.5 rounded-full bg-slate-800"></span>
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">
                            ID: REG-PDS-2023-008
                        </span>
                    </div>

                    {{-- Judul --}}
                    <h1 class="text-2xl font-extrabold tracking-tight text-slate-900 sm:text-3xl">
                        Detail Pendaftaran: Paduan Suara
                    </h1>

                    <p class="mt-2 text-xs font-normal text-slate-500 sm:text-sm">
                        Ringkasan formulir registrasi dan hasil seleksi vokal siswa.
                    </p>
                </div>

                {{-- Status Badge TIDAK LOLOS SELEKSI --}}
                <div class="shrink-0 self-start md:self-center">
                    <span class="rounded-full bg-rose-100/60 px-4 py-2 text-xs font-bold uppercase tracking-wider text-rose-500">
                        TIDAK LOLOS SELEKSI
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
                Jadwal rutin dan pembina kegiatan
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
                        Paduan Suara (Gita Eska)
                    </p>
                </div>

                {{-- Kategori Minat --}}
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-wider text-slate-500">
                        KATEGORI MINAT
                    </p>
                    <p class="mt-1 text-sm font-extrabold text-slate-900">
                        Seni Vokal & Musik
                    </p>
                </div>

                {{-- Tanggal Registrasi --}}
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-wider text-slate-500">
                        TANGGAL REGISTRASI
                    </p>
                    <p class="mt-1 text-sm font-extrabold text-slate-900">
                        01 Okt 2023, 10:15 WIB
                    </p>
                </div>

                {{-- Jadwal Seleksi --}}
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-wider text-slate-500">
                        JADWAL SELEKSI
                    </p>
                    <p class="mt-1 text-sm font-extrabold text-slate-900">
                        Selesai (Audisi: 04 Okt 2023)
                    </p>
                </div>

                {{-- Lokasi / Ruang --}}
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-wider text-slate-500">
                        LOKASI / RUANG
                    </p>
                    <p class="mt-1 text-sm font-extrabold text-slate-900">
                        Ruang Musik & Olah Vokal
                    </p>
                </div>

                {{-- Pembina / Penguji --}}
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-wider text-slate-500">
                        PEMBINA / PENGUJI
                    </p>
                    <p class="mt-1 text-sm font-extrabold text-slate-900">
                        Anita Siregar, S.Sn.
                    </p>
                </div>

            </div>
        </div>

        {{-- Catatan Tim Penilai Banner --}}
        <div class="rounded-2xl bg-blue-50/50 p-5">
            <div class="flex items-start gap-3">
                <div class="shrink-0 text-amber-500">
                    {{-- Info Icon --}}
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-xs font-bold text-slate-900">
                        Catatan Tim Penilai Vokal
                    </h3>
                    <p class="mt-1 text-xs leading-relaxed text-slate-600">
                        Peserta belum memenuhi batas ambang jangkauan nada (vocal range) Alto pada kuota angkatan tahun ini. Siswa disarankan mencoba cabang seni musik instrumen atau pendaftaran periode semester depan.
                    </p>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection