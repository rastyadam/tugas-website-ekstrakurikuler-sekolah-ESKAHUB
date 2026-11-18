@extends('student.layouts.app')

@section('title', 'Beranda - EskaHub')

@section('content')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

{{-- SECTION BERANDA --}}
<section class="overflow-hidden bg-white py-12 lg:py-20">

    <div class="mx-auto grid max-w-7xl grid-cols-1 items-center gap-12 px-6 lg:grid-cols-2 lg:px-8">

        <div>
            <h1 class="text-4xl font-extrabold leading-[1.15] tracking-tight text-[#111827] sm:text-5xl lg:text-6xl">
                Temukan Apa yang<br>
                Kamu Suka.<br>
                Kembangkan<br>
                Potensimu.
            </h1>

            <p class="mt-6 max-w-lg text-sm leading-relaxed text-gray-500 sm:text-base">
                Jelajahi berbagai ekstrakurikuler di sekolahmu, temukan kegiatan
                yang sesuai dengan minatmu, dan mulai perjalanan untuk
                mengembangkan potensi bersama EskaHub.
            </p>

            <div class="mt-8 flex flex-wrap items-center gap-4">
                <a
                    href="#ekstra"
                    class="inline-flex items-center gap-2 rounded-full bg-[#f6bd24] px-7 py-3.5 text-sm font-semibold text-[#182635] shadow-sm transition hover:bg-[#e0ab1d]"
                >
                    Jelajahi Ekstrakurikuler
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>

        <div class="relative mx-auto w-full max-w-lg">

            <div class="relative rounded-2xl border-2 border-[#f6bd24] bg-white p-2 shadow-md">

                <div class="overflow-hidden rounded-xl border border-gray-900/10">

                    <img
                        src="{{ asset('img/hero-students.jpg') }}"
                        alt="Siswa-siswi SMKN 1 Purwosari"
                        class="h-[380px] w-full object-cover sm:h-[450px] lg:h-[480px]"
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