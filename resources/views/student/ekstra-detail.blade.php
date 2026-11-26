@extends('student.layouts.app')

@section('title', 'Detail Ekstrakurikuler - EskaHub')

@section('content')

{{-- Alert Error --}}
@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 mx-4 sm:mx-6 lg:mx-8 mt-4" role="alert">
        <strong class="font-bold">Oops! Ada yang salah:</strong>
        <ul class="mt-2 list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="min-h-screen bg-white px-4 py-8 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-6xl space-y-6">

        {{-- Tombol Kembali --}}
        <div>
            <a href="{{ route('student.beranda') }}#ekstra" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-800 transition hover:text-slate-600">
                <i class="fa-solid fa-arrow-left text-sm"></i>
                Kembali
            </a>
        </div>

        {{-- Grid Container Utama (2 Kolom) --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

            {{-- Kolom Kiri (Lebar 2/3) --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Hero / Image Banner --}}
                <div class="relative h-[320px] w-full overflow-hidden rounded-2xl bg-slate-100 sm:h-[420px]">
                    @if($ekskul->foto)
                        <img src="{{ asset('storage/' . $ekskul->foto) }}" alt="{{ $ekskul->nama }}" class="h-full w-full object-cover" />
                    @else
                        <img src="https://images.unsplash.com/photo-1546519638-68e109498ffc?q=80&w=1200&auto=format&fit=crop" alt="Default" class="h-full w-full object-cover" />
                    @endif

                    {{-- Badge Status --}}
                    <div class="absolute right-4 top-4">
                        @if($ekskul->status == 'aktif' && $sisaKuota > 0)
                            <span class="rounded-full bg-emerald-200/90 px-3 py-1.5 text-[10px] font-bold uppercase tracking-wider text-emerald-800 backdrop-blur-md sm:text-xs">
                                PENDAFTARAN TERBUKA
                            </span>
                        @elseif($ekskul->status == 'aktif' && $sisaKuota <= 0)
                            <span class="rounded-full bg-rose-200/90 px-3 py-1.5 text-[10px] font-bold uppercase tracking-wider text-rose-800 backdrop-blur-md sm:text-xs">
                                KUOTA PENUH
                            </span>
                        @else
                            <span class="rounded-full bg-rose-200/90 px-3 py-1.5 text-[10px] font-bold uppercase tracking-wider text-rose-800 backdrop-blur-md sm:text-xs">
                                PENDAFTARAN DITUTUP
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Header Judul & Kuota --}}
                <div class="flex items-start justify-between pt-2 gap-4">
                    <div>
                        <h1 class="text-2xl font-extrabold tracking-tight text-slate-900 sm:text-3xl">
                            {{ $ekskul->nama }}
                        </h1>
                        <p class="mt-1 text-sm font-medium text-slate-500">
                            Ekstrakurikuler Sekolah
                        </p>
                    </div>

                    {{-- Kuota Dinamis --}}
                    <div class="text-right w-32 shrink-0">
                        <span class="block text-[11px] font-bold uppercase tracking-wider text-slate-700">
                            KUOTA TERSEDIA
                        </span>
                        <div class="flex items-baseline justify-end gap-1 mt-1">
                            <span class="text-xl font-extrabold {{ $sisaKuota > 0 ? 'text-emerald-600' : 'text-rose-500' }}">
                                {{ $sisaKuota }}
                            </span>
                            <span class="text-xs font-semibold text-slate-500">/ {{ $ekskul->kuota }}</span>
                        </div>
                        {{-- Progress Bar --}}
                        <div class="mt-2 h-1.5 w-full rounded-full bg-slate-200 overflow-hidden">
                            <div class="h-full rounded-full {{ $sisaKuota > 0 ? 'bg-emerald-500' : 'bg-rose-500' }}" style="width: {{ ($terisi / $ekskul->kuota) * 100 }}%;"></div>
                        </div>
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div class="space-y-4 text-xs leading-relaxed text-slate-600 sm:text-sm">
                    <p>
                        {{ $ekskul->deskripsi ?? 'Belum ada deskripsi untuk ekstrakurikuler ini.' }}
                    </p>
                </div>

                {{-- Pengumuman --}}
               <div class="pt-4">
                    <div class="flex w-full items-center justify-between gap-3 rounded-2xl border border-slate-200/80 bg-white p-4 shadow-sm sm:p-5">
                        <div class="flex items-center gap-3">
                            <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-amber-50 text-amber-500">
                                <i class="fa-solid fa-volume-high text-sm"></i>
                            </div>
                            <h2 class="text-sm font-bold text-slate-900 sm:text-base">
                                Pengumuman Terbaru
                            </h2>
                        </div>
                        <a href="#" class="rounded-lg bg-amber-400 hover:bg-amber-500 px-3.5 py-1.5 text-xs font-bold text-slate-900 transition-colors shadow-sm">
                            Lihat Detail
                        </a>
                    </div>
                </div>

            </div>

            {{-- Kolom Kanan / Sidebar Informasi (Lebar 1/3) --}}
            <div class="space-y-6">

                {{-- Card 1: Informasi Utama --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm space-y-6">
                    <div class="border-b border-slate-100 pb-3">
                        <h3 class="text-base font-bold text-slate-900">Informasi Utama</h3>
                    </div>

                    <div class="space-y-5">
                        {{-- Pembina --}}
                        <div class="flex items-start gap-3.5">
                            <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-slate-100 text-slate-700">
                                <i class="fa-regular fa-user text-base"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-500">PEMBINA</p>
                                <p class="text-xs font-semibold text-slate-800 mt-0.5">{{ $ekskul->pembina->nama ?? 'Belum ditentukan' }}</p>
                                <p class="text-xs text-slate-500">{{ $ekskul->pembina->jenis_pembina ?? '' }}</p>
                            </div>
                        </div>

                        {{-- Status --}}
                        <div class="flex items-start gap-3.5">
                            <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-slate-100 text-slate-700">
                                <i class="fa-solid fa-circle-info text-base"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-500">STATUS</p>
                                <p class="text-xs font-semibold text-slate-800 mt-0.5 capitalize">{{ $ekskul->status }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Tombol Daftar (Dinamis) --}}
                    <div class="pt-2">
                        @if($ekskul->status == 'aktif' && $sisaKuota > 0)
                            <a href="{{ route('student.ekstra.form-daftar', $ekskul->id) }}" class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-amber-400 hover:bg-amber-500 px-4 py-3 text-xs font-bold text-slate-900 shadow-sm transition">
                                <i class="fa-solid fa-pen-to-square text-sm"></i>
                                Daftar Ekstrakurikuler
                            </a>
                        @elseif($ekskul->status == 'aktif' && $sisaKuota <= 0)
                            <button disabled class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-rose-100 text-rose-600 px-4 py-3 text-xs font-bold cursor-not-allowed">
                                <i class="fa-solid fa-ban text-sm"></i>
                                Kuota Penuh
                            </button>
                        @else
                            <button disabled class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-slate-200 text-slate-500 px-4 py-3 text-xs font-bold cursor-not-allowed">
                                Pendaftaran Ditutup
                            </button>
                        @endif
                    </div>
                </div>

              
<div class="space-y-3">
    @forelse ($persyaratans as $persyaratan)
        <div class="flex items-start gap-3">
            <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                <i class="fa-solid fa-clipboard-check"></i>
            </div>

            <div class="flex-1">
                <p class="text-sm font-semibold text-gray-800">
                    {{ $persyaratan->nama }}
                </p>

                <p class="text-xs text-gray-500">
                    {{ ucfirst(strtolower($persyaratan->tipe_persyaratan)) }}
                    ·
                    {{ ucfirst($persyaratan->status) }}
                </p>
            </div>
        </div>
    @empty
        <p class="text-sm text-gray-500">
            Belum ada persyaratan yang tersedia.
        </p>
    @endforelse
</div>


            </div>

        </div>

    </div>
</div>
@endsection