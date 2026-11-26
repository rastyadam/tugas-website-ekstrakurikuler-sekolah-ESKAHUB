@extends('landing.layouts.app')

@section('title', 'EskaHub — Temukan Minat dan Potensimu')

@section('content')

{{-- HERO --}}
<section class="border-b border-[#E5E5E5] bg-white">
    <div class="mx-auto grid max-w-6xl items-center gap-12 px-6 py-16 lg:grid-cols-2 lg:gap-16 lg:py-24 lg:px-8">

        <div>
            <p class="text-sm font-semibold text-[#D9A512]">Platform Ekstrakurikuler Sekolah</p>

            <h1 class="mt-4 max-w-xl text-4xl font-bold leading-[1.2] tracking-tight text-[#1A2530] sm:text-5xl">
                Temukan minatmu,<br>
                kembangkan potensimu.
            </h1>

            <p class="mt-5 max-w-md text-base leading-7 text-[#666666]">
                Setiap siswa punya potensi yang berbeda. EskaHub membantu kamu
                menemukan, mengenal, dan bergabung dengan kegiatan ekstrakurikuler
                yang sesuai minat dan bakatmu.
            </p>

            <div class="mt-8 flex flex-wrap items-center gap-3">
                <a href="{{ route('student.register') }}"
                   class="inline-flex items-center gap-2 rounded-md bg-[#1A2530] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#2C3E50]">
                    Mulai sekarang
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
                <a href="#ekstrakurikuler"
                   class="inline-flex items-center gap-2 rounded-md border border-[#CCCCCC] px-5 py-3 text-sm font-semibold text-[#1A2530] transition hover:bg-[#FAFAFA]">
                    Jelajahi kegiatan
                </a>
            </div>

            <p class="mt-8 text-sm text-[#999999]">
                Ruang untuk belajar, berkarya, dan berkembang.
            </p>
        </div>

        <div class="relative">
            <img
                src="{{ asset('assets/hero-photo.webp') }}"
                alt="Siswa-siswi SMKN 1 Purwosari"
                class="h-[360px] w-full rounded-xl border border-[#E5E5E5] object-cover sm:h-[440px]"
            >
        </div>

    </div>
</section>


{{-- TENTANG --}}
<section id="tentang" class="border-b border-[#E5E5E5] bg-[#FAFAFA]">
    <div class="mx-auto grid max-w-6xl gap-10 px-6 py-16 lg:grid-cols-12 lg:px-8">

        <div class="lg:col-span-5">
            <p class="text-sm font-semibold text-[#D9A512]">Tentang EskaHub</p>
            <h2 class="mt-3 text-3xl font-bold leading-tight text-[#1A2530] sm:text-4xl">
                Lebih dari sekadar kegiatan di luar kelas.
            </h2>
        </div>

        <div class="lg:col-span-7 lg:pt-10">
            <p class="leading-7 text-[#666666]">
                EskaHub adalah platform digital yang dirancang untuk mempermudah siswa
                memperoleh informasi dan melakukan pendaftaran ekstrakurikuler.
                Seluruh informasi kegiatan dapat diakses dengan lebih mudah dan terorganisir
                dalam satu tempat.
            </p>

            <a href="#cara-kerja"
               class="mt-5 inline-flex items-center gap-2 text-sm font-semibold text-[#1A2530] hover:text-[#D9A512]">
                Kenali cara kerjanya
                <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>
    </div>
</section>


{{-- KEUNGGULAN --}}
<section class="border-b border-[#E5E5E5] bg-white">
    <div class="mx-auto max-w-6xl px-6 py-16 lg:px-8">

        <div class="max-w-xl">
            <p class="text-sm font-semibold text-[#D9A512]">Mengapa EskaHub</p>
            <h2 class="mt-3 text-3xl font-bold text-[#1A2530] sm:text-4xl">
                Semua informasi dalam satu tempat.
            </h2>
        </div>

        <div class="mt-12 grid gap-10 md:grid-cols-3 md:gap-8">

            <div>
                <div class="flex h-10 w-10 items-center justify-center rounded-md bg-[#FAFAFA] text-[#1A2530] border border-[#E5E5E5]">
                    <i class="fa-solid fa-compass"></i>
                </div>
                <h3 class="mt-5 text-base font-bold text-[#1A2530]">Informasi terpusat</h3>
                <p class="mt-2 text-sm leading-6 text-[#666666]">
                    Temukan informasi ekstrakurikuler, jadwal, pembina, dan persyaratan dalam satu tempat.
                </p>
            </div>

            <div>
                <div class="flex h-10 w-10 items-center justify-center rounded-md bg-[#FAFAFA] text-[#1A2530] border border-[#E5E5E5]">
                    <i class="fa-solid fa-file-signature"></i>
                </div>
                <h3 class="mt-5 text-base font-bold text-[#1A2530]">Pendaftaran praktis</h3>
                <p class="mt-2 text-sm leading-6 text-[#666666]">
                    Lakukan pendaftaran secara online tanpa proses administrasi yang rumit.
                </p>
            </div>

            <div>
                <div class="flex h-10 w-10 items-center justify-center rounded-md bg-[#FAFAFA] text-[#1A2530] border border-[#E5E5E5]">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
                <h3 class="mt-5 text-base font-bold text-[#1A2530]">Pantau pendaftaran</h3>
                <p class="mt-2 text-sm leading-6 text-[#666666]">
                    Lihat perkembangan dan status pendaftaran melalui akun siswa masing-masing.
                </p>
            </div>

        </div>
    </div>
</section>


{{-- EKSTRAKURIKULER --}}
<section id="ekstrakurikuler" class="border-b border-[#E5E5E5] bg-[#FAFAFA]">
    <div class="mx-auto max-w-6xl px-6 py-16 lg:px-8">

        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
            <div>
                <p class="text-sm font-semibold text-[#D9A512]">Temukan kegiatanmu</p>
                <h2 class="mt-3 text-3xl font-bold text-[#1A2530] sm:text-4xl">
                    Pilih sesuai minatmu.
                </h2>
            </div>

            <a href="{{ route('student.login') }}"
               class="inline-flex items-center gap-2 text-sm font-semibold text-[#1A2530] hover:text-[#D9A512]">
                Lihat semua
                <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>

        <div class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">

            @forelse($ekskuls as $ekskul)
                <article class="overflow-hidden rounded-lg border border-[#E5E5E5] bg-white transition hover:border-[#CCCCCC]">
                    <div class="aspect-[4/3] bg-[#FAFAFA]">
                        @if($ekskul->foto)
                            <img src="{{ asset('storage/' . $ekskul->foto) }}"
                                 alt="{{ $ekskul->nama }}"
                                 class="h-full w-full object-cover">
                        @else
                            <div class="flex h-full items-center justify-center text-[#CCCCCC]">
                                <i class="fa-solid fa-image text-3xl"></i>
                            </div>
                        @endif
                    </div>

                    <div class="p-5">
                        <p class="text-xs font-semibold uppercase tracking-wide text-[#D9A512]">
                            {{ $ekskul->kategori }}
                        </p>
                        <h3 class="mt-1.5 text-lg font-bold text-[#1A2530]">
                            {{ $ekskul->nama }}
                        </h3>

                        <div class="mt-4 space-y-2 text-sm text-[#666666]">
                            <p class="flex items-center gap-2.5">
                                <i class="fa-regular fa-user w-4 text-[#999999]"></i>
                               {{ $ekskul->pembina->nama ?? $ekskul->pembina }}
                            </p>
                            <p class="flex items-center gap-2.5">
                                <i class="fa-regular fa-calendar w-4 text-[#999999]"></i>
                                {{ $ekskul->hari }}
                            </p>
                        </div>

                        <a href="{{ route('student.login') }}"
                           class="mt-5 inline-flex items-center gap-1.5 text-sm font-semibold text-[#1A2530] hover:text-[#D9A512]">
                            Lihat kegiatan
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                </article>
            @empty
                <div class="col-span-full rounded-lg border border-dashed border-[#CCCCCC] bg-white py-14 text-center">
                    <i class="fa-solid fa-folder-open text-2xl text-[#CCCCCC]"></i>
                    <p class="mt-3 text-sm font-bold text-[#1A2530]">Belum ada ekstrakurikuler tersedia.</p>
                    <p class="mt-1 text-sm text-[#666666]">Informasi kegiatan akan ditampilkan di sini.</p>
                </div>
            @endforelse

        </div>
    </div>
</section>


{{-- CARA KERJA --}}
<section id="cara-kerja" class="border-b border-[#E5E5E5] bg-white">
    <div class="mx-auto max-w-6xl px-6 py-16 lg:px-8">

        <div class="max-w-xl">
            <p class="text-sm font-semibold text-[#D9A512]">Langkah mudah</p>
            <h2 class="mt-3 text-3xl font-bold text-[#1A2530] sm:text-4xl">
                Mulai perjalananmu bersama EskaHub.
            </h2>
        </div>

        <div class="mt-12 grid gap-10 sm:grid-cols-2 lg:grid-cols-4 lg:gap-8">

            @foreach([
                ['Buat akun', 'Daftarkan akun menggunakan NISN yang terdaftar di sekolah.'],
                ['Pilih kegiatan', 'Temukan ekstrakurikuler yang sesuai dengan minatmu.'],
                ['Lengkapi syarat', 'Isi formulir dan penuhi persyaratan pendaftaran.'],
                ['Pantau status', 'Periksa perkembangan pendaftaran melalui akunmu.'],
            ] as $i => $step)
                <div>
                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-[#FAFAFA] border border-[#E5E5E5] text-xs font-bold text-[#D9A512]">
                        {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
                    </div>
                    <h3 class="mt-4 text-base font-bold text-[#1A2530]">{{ $step[0] }}</h3>
                    <p class="mt-2 text-sm leading-6 text-[#666666]">{{ $step[1] }}</p>
                </div>
            @endforeach

        </div>
    </div>
</section>


{{-- CTA --}}
<section class="bg-[#1A2530]">
    <div class="mx-auto max-w-6xl px-6 py-16 lg:px-8">
        <div class="flex flex-col items-start justify-between gap-8 md:flex-row md:items-center">

            <div class="max-w-xl">
                <h2 class="text-2xl font-bold leading-tight text-white sm:text-3xl">
                    Setiap potensi punya tempat untuk berkembang.
                </h2>
                <p class="mt-3 text-sm leading-6 text-[#CCCCCC]">
                    Temukan kegiatan yang kamu sukai dan mulai pengalaman baru bersama EskaHub.
                </p>
            </div>

            <a href="{{ route('student.register') }}"
               class="inline-flex shrink-0 items-center gap-2 rounded-md bg-[#F6BD24] px-5 py-3 text-sm font-semibold text-[#1A2530] transition hover:bg-[#D9A512]">
                Daftar sekarang
                <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>

        </div>
    </div>
</section>

@endsection