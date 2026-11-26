{{-- SECTION PENDAFTARAN --}}
<section id="pendaftaran" class="scroll-mt-20 bg-white px-6 py-16 lg:px-8">

    <div class="mx-auto max-w-7xl">

        {{-- Heading --}}
        <div class="mb-8">
            <span class="text-xs font-bold uppercase tracking-[0.2em] text-[#d9a512]">
                Pendaftaran
            </span>

            <h2 class="mt-2 text-3xl font-extrabold tracking-tight text-[#182635] sm:text-4xl">
                Saatnya Pilih Ekstrakurikulermu
            </h2>

            <p class="mt-3 max-w-xl text-sm leading-relaxed text-gray-500">
                Temukan kegiatan yang sesuai dengan minatmu dan
                daftarkan dirimu sebelum periode pendaftaran berakhir.
            </p>
        </div>


        {{-- Main Card --}}
        <div class="relative overflow-hidden rounded-3xl bg-[#182635] p-7 shadow-sm sm:p-9">

            {{-- Decorative --}}
            <div class="absolute -right-16 -top-16 h-40 w-40 rounded-full bg-[#f6bd24]/10"></div>
            <div class="absolute -bottom-20 right-20 h-48 w-48 rounded-full bg-[#f6bd24]/5"></div>

            <div class="relative flex flex-col gap-8 lg:flex-row lg:items-center lg:justify-between">

                {{-- Left --}}
                <div class="max-w-2xl">

                    <div class="flex items-center gap-3">

                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#f6bd24]">
                            <i class="fa-solid fa-pen-to-square text-sm text-[#182635]"></i>
                        </span>

                        <span class="rounded-full bg-green-500/15 px-3 py-1.5 text-xs font-semibold text-green-300">
                            Pendaftaran Dibuka
                        </span>

                    </div>

                    <h3 class="mt-5 text-2xl font-bold text-white sm:text-3xl">
                        Ekstrakurikuler TA 2026/2027
                    </h3>

                    <p class="mt-3 max-w-lg text-sm leading-relaxed text-slate-300">
                        Pilih satu atau beberapa kegiatan yang ingin kamu ikuti
                        dan kembangkan potensimu bersama teman-temanmu.
                    </p>

                </div>


                {{-- Right --}}
                <div class="relative shrink-0 lg:w-[260px]">

                    <div class="rounded-2xl border border-white/10 bg-white/5 p-5">

                        <p class="text-xs font-medium text-slate-400">
                            Periode Pendaftaran
                        </p>

                        <p class="mt-2 text-lg font-bold text-white">
                            1 – 15 Juli 2026
                        </p>

                       <a href="#ekstra"
   onclick="event.preventDefault(); document.getElementById('ekstra').scrollIntoView({ behavior: 'smooth', block: 'start' });"
   class="inline-flex w-full sm:w-auto items-center justify-center gap-2 rounded-xl bg-[#ffb703] px-6 py-3.5 text-sm font-semibold text-slate-950 shadow-lg hover:bg-amber-400 transition-all duration-200">

    <span>Daftar Sekarang</span>

    <svg xmlns="http://www.w3.org/2000/svg"
         class="h-4 w-4"
         fill="none"
         viewBox="0 0 24 24"
         stroke="currentColor"
         stroke-width="2.5">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
    </svg>
</a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>