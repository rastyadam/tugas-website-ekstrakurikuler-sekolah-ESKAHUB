@extends('student.layouts.app')

@section('title', 'Beranda - EskaHub')

@section('content')
{{-- <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}

{{-- SECTION BERANDA --}}
<section id="beranda" class=" scroll-smooth overflow-hidden bg-white py-10 sm:py-12 lg:py-20">
    <div class="mx-auto grid max-w-7xl grid-cols-1 items-center gap-10 px-4 sm:px-6 lg:grid-cols-2 lg:gap-12 lg:px-8">

        {{-- Kolom Teks --}}
        <div class="text-center lg:text-left">
            <h1 class="text-3xl font-extrabold leading-[1.2] tracking-tight text-[#111827] sm:text-4xl md:text-5xl lg:text-6xl">
                Temukan Apa yang<br class="hidden sm:block">
                Kamu Suka.<br>
                Kembangkan<br>
                Potensimu.
            </h1>

            <p class="mx-auto mt-5 max-w-lg text-sm leading-relaxed text-gray-500 sm:mt-6 sm:text-base lg:mx-0">
                Jelajahi berbagai ekstrakurikuler di sekolahmu, temukan kegiatan
                yang sesuai dengan minatmu, dan mulai perjalanan untuk
                mengembangkan potensi bersama EskaHub.
            </p>

            <div class="mt-7 flex flex-wrap items-center justify-center gap-4 sm:mt-8 lg:justify-start">
                <a
    href="#ekstra"
    onclick="event.preventDefault(); document.getElementById('ekstra').scrollIntoView({ behavior: 'smooth', block: 'start' });"
    class="inline-flex w-full items-center justify-center gap-2 rounded-full bg-[#f6bd24] px-6 py-3.5 text-sm font-semibold text-[#182635] shadow-sm transition hover:bg-[#e0ab1d] active:scale-[0.98] sm:w-auto sm:px-7"
>
    Jelajahi Ekstrakurikuler
    <i class="fa-solid fa-arrow-right text-xs"></i>
</a>
            </div>
        </div>

        {{-- Kolom Gambar --}}
        <div class="relative mx-auto w-full max-w-md sm:max-w-lg">
            <div class="relative rounded-2xl border-2 border-[#f6bd24] bg-white p-1.5 shadow-md sm:p-2">
                <div class="overflow-hidden rounded-xl border border-gray-900/10">
                    <img
                        src="{{ asset('assets/hero-photo.webp') }}"
                        alt="Siswa-siswi SMKN 1 Purwosari"
                        loading="lazy"
                        class="aspect-[4/5] w-full object-cover sm:aspect-[5/6] lg:aspect-auto lg:h-[480px]"
                    >
                </div>
            </div>
        </div>

    </div>
</section>

{{-- SECTION EKSTRA --}}
@include('student.partial-katalog-ekstra')
@include('student.pendaftaran')
@include('student.pengumuman')

@endsection