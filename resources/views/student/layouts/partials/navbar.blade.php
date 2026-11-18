<nav class="sticky top-0 z-50 border-b border-white/10 bg-[#182635] shadow-sm" x-data="{ mobileMenuOpen: false }">
    <div class="mx-auto flex h-20 max-w-7xl items-center justify-between px-6 lg:px-8">

        {{-- BRAND / LOGO --}}
        <a href="{{ route('student.beranda') }}" class="flex items-center gap-3">
            <div class="h-10 w-10">
                <img src="{{ asset('assets/logo sekolah.webp') }}" alt="Logo EskaHub" class="h-full w-full object-contain">
            </div>
            <span class="text-xl font-bold tracking-wide text-white">
                EskaHub
            </span>
        </a>

        {{-- MENU NAVIGASI DESKTOP --}}
        <ul class="hidden items-center gap-8 md:flex">
            {{-- BERANDA --}}
            <li>
                <a href="{{ route('student.beranda') }}"
                    class="text-sm font-medium transition {{ request()->routeIs('student.beranda') ? 'text-amber-500 font-semibold' : 'text-gray-300 hover:text-white' }}">
                    Beranda
                </a>
            </li>

            {{-- EKSTRAKURIKULER --}}
            <li>
                <a href="{{ route('student.ekstra') }}"
                    class="text-sm font-medium transition {{ request()->routeIs('student.ekstra*') ? 'text-amber-500 font-semibold' : 'text-gray-300 hover:text-white' }}">
                    Ekstrakurikuler
                </a>
            </li>

            {{-- PENDAFTARAN --}}
            <li>
                <a href="{{ route('student.pendaftaran-saya') }}"
                    class="text-sm font-medium transition {{ request()->routeIs('student.pendaftaran-saya*') ? 'text-amber-500 font-semibold' : 'text-gray-300 hover:text-white' }}">
                    Pendaftaran
                </a>
            </li>

            {{-- PENGUMUMAN --}}
            <li>
                <a href="{{ route('student.pengumuman-saya') }}"
                    class="text-sm font-medium transition {{ request()->routeIs('student.pengumuman-saya*') ? 'text-amber-500 font-semibold' : 'text-gray-300 hover:text-white' }}">
                    Pengumuman
                </a>
            </li>
        </ul>

        {{-- AKSI KANAN (IKON) --}}
        <div class="hidden items-center gap-6 md:flex">

            {{-- SEARCH --}}
            <div class="relative" x-data="{ searchOpen: false }">
                <button type="button" aria-label="Cari" @click="searchOpen = !searchOpen" class="text-gray-300 transition hover:text-white focus:outline-none">
                    <i class="fa-solid fa-magnifying-glass text-lg"></i>
                </button>

                {{-- SEARCH DROPDOWN --}}
                <div x-show="searchOpen" @click.outside="searchOpen = false" x-transition class="absolute right-0 top-full z-[100] mt-4 w-[380px] overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-xl" style="display: none;">
                    <div class="border-b border-gray-100 px-5 py-4">
                        <h3 class="text-sm font-bold text-[#182635]">Cari di EskaHub</h3>
                        <p class="mt-1 text-xs text-gray-400">Temukan ekstrakurikuler yang kamu minati</p>
                    </div>

                    {{-- FORM SEARCH --}}
                    <form action="{{ route('student.ekstra') }}" method="GET" class="p-4">
                        <div class="relative">
                            <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-sm text-gray-400"></i>
                            <input type="text" name="search" placeholder="Cari ekstrakurikuler..." class="w-full rounded-xl border border-gray-200 bg-gray-50 py-3 pl-11 pr-4 text-sm text-gray-700 outline-none transition placeholder:text-gray-400 focus:border-[#f6bd24] focus:bg-white focus:ring-2 focus:ring-[#f6bd24]/20">
                        </div>
                    </form>

                    <div class="px-5 pb-5">
                        <p class="mb-3 text-xs font-bold uppercase tracking-wider text-gray-400">Pencarian Populer</p>
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('student.ekstra', ['search' => 'Basket']) }}" class="rounded-full border border-gray-200 px-3 py-1.5 text-xs font-medium text-gray-600 transition hover:border-[#f6bd24] hover:bg-[#f6bd24]/10 hover:text-[#182635]">Basket</a>
                            <a href="{{ route('student.ekstra', ['search' => 'Futsal']) }}" class="rounded-full border border-gray-200 px-3 py-1.5 text-xs font-medium text-gray-600 transition hover:border-[#f6bd24] hover:bg-[#f6bd24]/10 hover:text-[#182635]">Futsal</a>
                            <a href="{{ route('student.ekstra', ['search' => 'Robotika']) }}" class="rounded-full border border-gray-200 px-3 py-1.5 text-xs font-medium text-gray-600 transition hover:border-[#f6bd24] hover:bg-[#f6bd24]/10 hover:text-[#182635]">Robotika</a>
                            <a href="{{ route('student.ekstra', ['search' => 'PMR']) }}" class="rounded-full border border-gray-200 px-3 py-1.5 text-xs font-medium text-gray-600 transition hover:border-[#f6bd24] hover:bg-[#f6bd24]/10 hover:text-[#182635]">PMR</a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- PROFILE --}}
            <a href="{{ route('student.profil') }}" aria-label="Profil" class="inline-flex items-center text-gray-300 transition hover:text-white">
                <i class="fa-regular fa-user text-lg"></i>
            </a>

            {{-- NOTIFICATION --}}
            <div class="relative" x-data="{ open: false }">
                <button type="button" aria-label="Notifikasi" @click="open = !open" class="relative text-gray-300 transition hover:text-white focus:outline-none">
                    <i class="fa-regular fa-bell text-lg"></i>
                    {{-- Badge Notif --}}
                    @if(isset($notifikasis) && $notifikasis->count() > 0)
                        <span class="absolute -right-1 -top-1 flex h-4 w-4 items-center justify-center rounded-full bg-amber-500 text-[10px] font-bold text-white">
                            {{ $notifikasis->count() }}
                        </span>
                    @endif
                </button>

                {{-- DROPDOWN NOTIFIKASI --}}
                <div x-show="open" @click.outside="open = false" x-transition class="absolute right-0 top-full z-[100] mt-3 w-[380px] overflow-hidden rounded-2xl border border-slate-200 bg-white text-slate-800 shadow-2xl sm:w-[420px]" style="display: none;">
                    <div class="border-b border-slate-100 p-5">
                        <div class="mb-4 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <h2 class="text-lg font-extrabold text-slate-900">Notifikasi</h2>
                                @if(isset($notifikasis) && $notifikasis->count() > 0)
                                    <span class="rounded-full bg-amber-400 px-2.5 py-0.5 text-xs font-bold text-slate-900">{{ $notifikasis->count() }} Baru</span>
                                @endif
                            </div>
                            <button type="button" class="flex items-center gap-1 text-xs font-semibold text-slate-400 transition hover:text-slate-600">
                                <i class="fa-solid fa-check text-[10px]"></i> Tandai dibaca
                            </button>
                        </div>
                    </div>

                   {{-- LIST NOTIFIKASI DINAMIS --}}
<div class="max-h-[360px] divide-y divide-slate-100 overflow-y-auto">
    @forelse($notifikasis ?? [] as $notif)
        <div class="relative p-4 transition hover:bg-slate-50">
            <span class="absolute left-4 top-6 h-2 w-2 rounded-full bg-amber-400"></span>
            <div class="pl-4">
                <div class="flex items-start justify-between gap-3">
                    
                    {{-- LOGIKA: Cek apakah ini Pengumuman atau Jadwal Latihan --}}
                    <h3 class="text-sm font-bold leading-snug text-slate-900">
                        @if($notif instanceof \App\Models\Pengumuman)
                            {{-- TAMPILAN PENGUMUMAN --}}
                            {{ $notif->judul }}
                            <span class="font-bold text-xs text-amber-500 block mt-0.5">
                                {{ $notif->ekstrakurikuler->nama ?? '' }}
                            </span>
                        @else
                            {{-- TAMPILAN JADWAL LATIHAN --}}
                            Jadwal Latihan Baru: {{ $notif->jenis_latihan }}
                            <span class="font-bold text-xs text-emerald-500 block mt-0.5">
                                {{ $notif->ekstrakurikuler->nama ?? '' }} - {{ $notif->hari }}, {{ $notif->jam_mulai }}
                            </span>
                        @endif
                    </h3>

                    <span class="shrink-0 text-[11px] font-semibold text-slate-400">
                        {{ $notif->created_at->diffForHumans() }}
                    </span>
                </div>

                <p class="mt-1 text-xs leading-relaxed text-slate-600 line-clamp-2">
                    @if($notif instanceof \App\Models\Pengumuman)
                        {{ $notif->isi }}
                    @else
                        Latihan akan dilaksanakan di {{ $notif->tempat }}.
                    @endif
                </p>

                <div class="mt-3 flex items-center justify-between">
                    <a href="{{ route('student.pengumuman-saya') }}" class="text-xs font-bold text-slate-900 hover:underline">
                        Lihat Detail →
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="p-6 text-center text-sm text-slate-500">
            Belum ada notifikasi baru.
        </div>
    @endforelse
</div>
                    <div class="flex items-center justify-between border-t border-slate-100 bg-slate-50/80 p-3">
                        <span class="pl-2 text-[11px] font-medium text-slate-400">
                            Sinkronisasi: <span class="font-semibold text-slate-600">Aktif</span>
                        </span>
                        <a href="{{ route('student.pengumuman-saya') }}" class="rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-xs font-bold text-slate-900 shadow-sm transition hover:bg-slate-100">
                            Lihat Semua →
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- MOBILE MENU BUTTON --}}
        <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="text-gray-300 hover:text-white md:hidden" aria-label="Menu">
            <i class="fa-solid fa-bars text-2xl"></i>
        </button>

    </div>

    {{-- MOBILE MENU DROPDOWN (Opsional, kalau mau navigasi mobile jalan) --}}
    <div x-show="mobileMenuOpen" @click.outside="mobileMenuOpen = false" class="border-t border-white/10 bg-[#182635] px-6 py-4 md:hidden" style="display: none;">
        <ul class="space-y-3">
            <li><a href="{{ route('student.beranda') }}" class="block text-sm font-medium text-gray-300 hover:text-white">Beranda</a></li>
            <li><a href="{{ route('student.ekstra') }}" class="block text-sm font-medium text-gray-300 hover:text-white">Ekstrakurikuler</a></li>
            <li><a href="{{ route('student.pendaftaran-saya') }}" class="block text-sm font-medium text-gray-300 hover:text-white">Pendaftaran</a></li>
            <li><a href="{{ route('student.pengumuman-saya') }}" class="block text-sm font-medium text-gray-300 hover:text-white">Pengumuman</a></li>
            <li><a href="{{ route('student.profil') }}" class="block text-sm font-medium text-gray-300 hover:text-white">Profil Saya</a></li>
        </ul>
    </div>
</nav>