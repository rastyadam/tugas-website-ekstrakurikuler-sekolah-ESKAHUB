
@foreach($ekskuls as $ekskul)

    <div
        class="ekstra-card group flex flex-col overflow-hidden rounded-2xl border border-gray-100 bg-white p-4 shadow-sm transition-all duration-300 hover:-translate-y-2 hover:border-amber-200 hover:shadow-lg"
    >

        {{-- BANNER --}}
        <div class="h-44 w-full overflow-hidden rounded-xl bg-gray-100 sm:h-48">

            @if($ekskul->foto)
                <img
                    src="{{ asset('storage/' . $ekskul->foto) }}"
                    alt="{{ $ekskul->nama }}"
                    loading="lazy"
                    class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110"
                >
            @else
                <div class="flex h-full items-center justify-center text-gray-400">
                    <i class="fa-solid fa-image text-3xl"></i>
                </div>
            @endif

        </div>

        {{-- KONTEN --}}
        <div class="mt-4 flex flex-1 flex-col justify-between">

            {{-- LOGO DAN NAMA --}}
            <div class="flex items-center justify-between gap-3">

                <div class="flex min-w-0 items-center gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center overflow-hidden rounded-full border border-gray-100 bg-amber-50">

                        @if($ekskul->logo)
                            <img
                                src="{{ asset('storage/' . $ekskul->logo) }}"
                                alt="Logo {{ $ekskul->nama }}"
                                class="h-full w-full object-cover"
                            >
                        @else
                            <span class="font-bold text-amber-600">
                                {{ strtoupper(substr($ekskul->nama, 0, 1)) }}
                            </span>
                        @endif

                    </div>

                    <h3 class="truncate text-base font-bold text-[#182635]">
                        {{ $ekskul->nama }}
                    </h3>

                </div>

                <a
                    href="{{ route('student.ekstra.detail', $ekskul->id) }}"
                    aria-label="Detail {{ $ekskul->nama }}"
                    class="shrink-0 text-amber-500 transition hover:translate-x-1 hover:text-amber-600"
                >
                    <i class="fa-solid fa-arrow-right"></i>
                </a>

            </div>

            {{-- DESKRIPSI --}}
            <p class="mt-3 line-clamp-3 text-xs leading-relaxed text-gray-400">
                {{ $ekskul->deskripsi ?? 'Belum ada deskripsi untuk ekstrakurikuler ini.' }}
            </p>

            {{-- HARI DAN JAM --}}
            @if($ekskul->hari || $ekskul->jam_mulai || $ekskul->jam_selesai)

                <div class="mt-4 flex flex-wrap items-center gap-x-4 gap-y-2 border-t border-gray-100 pt-3">

                    @if($ekskul->hari)
                        <span class="flex items-center gap-1.5 text-xs font-medium text-gray-500">
                            <i class="fa-regular fa-calendar text-amber-500"></i>
                            {{ $ekskul->hari }}
                        </span>
                    @endif

                    @if($ekskul->jam_mulai && $ekskul->jam_selesai)
                        <span class="flex items-center gap-1.5 text-xs font-medium text-gray-500">
                            <i class="fa-regular fa-clock text-amber-500"></i>
                            {{ \Carbon\Carbon::parse($ekskul->jam_mulai)->format('H:i') }}
                            -
                            {{ \Carbon\Carbon::parse($ekskul->jam_selesai)->format('H:i') }}
                        </span>
                    @endif

                </div>

            @endif

        </div>

    </div>

@endforeach
