@extends('student.layouts.app')

@section('title', 'Detail Pendaftaran - EskaHub')

@section('content')
<div class="min-h-screen bg-slate-50/50 px-4 py-8 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-6xl space-y-6">

        {{-- Tombol Kembali --}}
        <div>
            <a href="{{ route('student.pendaftaran-saya') }}" class="inline-flex items-center text-xs font-semibold text-slate-500 transition hover:text-slate-800">
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
                    <div class="mb-2 flex items-center gap-2">
                        @if($pendaftaran->status == 'pending')
                            <span class="inline-block h-2.5 w-2.5 rounded-full bg-amber-400"></span>
                        @elseif($pendaftaran->status == 'diterima')
                            <span class="inline-block h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                        @else
                            <span class="inline-block h-2.5 w-2.5 rounded-full bg-rose-500"></span>
                        @endif
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">
                            ID: {{ $pendaftaran->nomor_pendaftaran ?? 'REG-XXX' }}
                        </span>
                    </div>

                    <h1 class="text-2xl font-extrabold tracking-tight text-slate-900 sm:text-3xl">
                        Detail Pendaftaran: {{ $pendaftaran->ekstrakurikuler->nama ?? 'Ekstrakurikuler' }}
                    </h1>

                    <p class="mt-2 text-xs font-normal text-slate-500 sm:text-sm">
                        Ringkasan formulir registrasi dan status verifikasi siswa.
                    </p>
                </div>

                {{-- Status Badge --}}
                <div class="shrink-0 self-start md:self-center">
                    @if($pendaftaran->status == 'pending')
                        <span class="rounded-full bg-amber-100 px-4 py-2 text-xs font-bold uppercase tracking-wider text-amber-800">MENUNGGU SELEKSI</span>
                    @elseif($pendaftaran->status == 'diterima')
                        <span class="rounded-full bg-emerald-100 px-4 py-2 text-xs font-bold uppercase tracking-wider text-emerald-800">DITERIMA</span>
                    @else
                        <span class="rounded-full bg-rose-100 px-4 py-2 text-xs font-bold uppercase tracking-wider text-rose-600">TIDAK LOLOS</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Info Grid --}}
        <div class="rounded-2xl bg-blue-50/50 p-6 sm:p-8">
            <div class="grid gap-y-6 gap-x-8 sm:grid-cols-2 lg:grid-cols-3">
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-wider text-slate-500">NAMA EKSTRAKURIKULER</p>
                    <p class="mt-1 text-sm font-extrabold text-slate-900">{{ $pendaftaran->ekstrakurikuler->nama ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-wider text-slate-500">TANGGAL REGISTRASI</p>
                    <p class="mt-1 text-sm font-extrabold text-slate-900">
                        {{ \Carbon\Carbon::parse($pendaftaran->tanggal_daftar)->format('d M Y') }}
                    </p>
                </div>
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-wider text-slate-500">PEMBINA / PENGUJI</p>
                    <p class="mt-1 text-sm font-extrabold text-slate-900">{{ $pendaftaran->ekstrakurikuler->pembina->nama ?? 'Belum ditentukan' }}</p>
                </div>
                {{-- ✅ JADWAL SELEKSI --}}
<div>
    <p class="text-[11px] font-bold uppercase tracking-wider text-slate-500">JADWAL SELEKSI</p>
    
    @if($pendaftaran->jadwalSeleksi->isNotEmpty())
        @foreach($pendaftaran->jadwalSeleksi as $jadwal)
            <p class="mt-1 text-sm font-extrabold text-amber-600">
                {{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d M Y') }}
                ({{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }})
            </p>
            <p class="text-xs text-slate-500">{{ $jadwal->tempat }} - {{ $jadwal->tahap_seleksi }}</p>
        @endforeach
    @else
        <p class="mt-1 text-sm font-extrabold text-emerald-600">
            Tanpa Seleksi
        </p>
    @endif
</div>
            </div>
        </div>

        {{-- Banner Bawah (Dinamis sesuai status) --}}
        {{-- Banner Info Seleksi (Kalau ada) --}}
@if($pendaftaran->jadwalSeleksi->isNotEmpty() && $pendaftaran->status == 'pending')
    <div class="rounded-2xl bg-amber-50 border border-amber-200 p-5">
        <div class="flex items-start gap-3">
            <div class="shrink-0 text-amber-500">
                <i class="fa-solid fa-triangle-exclamation text-xl"></i>
            </div>
            <div>
                <h3 class="text-xs font-bold text-slate-900">Wajib Mengikuti Seleksi</h3>
                <p class="mt-1 text-xs leading-relaxed text-slate-600">
                    Kamu dijadwalkan untuk mengikuti seleksi pada tanggal 
                    <strong>{{ \Carbon\Carbon::parse($pendaftaran->jadwalSeleksi->first()->tanggal)->format('d M Y') }}</strong> 
                    pukul <strong>{{ $pendaftaran->jadwalSeleksi->first()->jam_mulai }}</strong> 
                    di <strong>{{ $pendaftaran->jadwalSeleksi->first()->tempat }}</strong>. 
                    Harap hadir tepat waktu.
                </p>
            </div>
        </div>
    </div>
@endif
        @if($pendaftaran->status == 'diterima')
            <div class="rounded-2xl bg-blue-50/50 p-5">
                <div class="flex items-start gap-3">
                    <div class="shrink-0 text-emerald-500">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7m-11 6l2.5 2.5L17 9"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-xs font-bold text-slate-900">Pengumuman Kelulusan</h3>
                        <p class="mt-1 text-xs leading-relaxed text-slate-600">
                            Selamat! Peserta telah dinyatakan <strong>Diterima</strong>. Silakan hubungi pembina untuk info lebih lanjut.
                        </p>
                    </div>
                </div>
            </div>
        @elseif($pendaftaran->status == 'pending')
            <div class="rounded-2xl bg-blue-50/50 p-5">
                <div class="flex items-start gap-3">
                    <div class="shrink-0 text-amber-500">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-xs font-bold text-slate-900">Status Pendaftaran</h3>
                        <p class="mt-1 text-xs leading-relaxed text-slate-600">
                            Pendaftaran Anda sedang dalam proses verifikasi oleh pembina. Silakan cek secara berkala.
                        </p>
                    </div>
                </div>
            </div>
        @else
            <div class="rounded-2xl bg-blue-50/50 p-5">
                <div class="flex items-start gap-3">
                    <div class="shrink-0 text-rose-500">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-xs font-bold text-slate-900">Catatan Penolakan</h3>
                        <p class="mt-1 text-xs leading-relaxed text-slate-600">
                            Maaf, pendaftaran Anda belum dapat diterima. {{ $pendaftaran->alasan_penolakan ?? '' }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>
@endsection