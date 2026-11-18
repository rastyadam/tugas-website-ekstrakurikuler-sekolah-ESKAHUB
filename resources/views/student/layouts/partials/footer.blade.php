<footer class="bg-[#182635] text-white">
    <div class="mx-auto grid max-w-7xl grid-cols-1 gap-10 px-6 py-12 sm:grid-cols-2 lg:grid-cols-4 lg:px-8">

        {{-- BRAND --}}
        <div>
            <div class="flex items-start gap-4">
                <div class="h-14 w-14 shrink-0">
                    <img src="{{ asset('assets/logo sekolah.webp') }}" alt="Logo SMKN 1 Purwosari" class="h-full w-full object-contain">
                </div>
                <div>
                    <p class="text-sm font-semibold text-white">
                        Siap Mengembangkan Potensimu?
                    </p>
                    <p class="mt-1 text-xs leading-5 text-gray-300">
                        Bergabunglah Bersama Ekstrakurikuler
                    </p>
                    <p class="text-xs leading-5 text-gray-300">
                        SMK NEGERI 1 PURWOSARI Hari Ini!
                    </p>
                </div>
            </div>
        </div>

        {{-- SERVICES --}}
        <div>
            <h4 class="mb-4 text-sm font-semibold">Services</h4>
            <ul class="space-y-3 text-sm text-gray-400">
                <li><a href="{{ route('student.beranda') }}" class="transition hover:text-white">Beranda</a></li>
                <li><a href="#" class="transition hover:text-white">Ekstrakurikuler</a></li>
                <li><a href="#" class="transition hover:text-white">Pendaftaran</a></li>
                <li><a href="#" class="transition hover:text-white">Pengumuman</a></li>
                <li><a href="#" class="transition hover:text-white">Pengguna</a></li>
            </ul>
        </div>

        {{-- IKUTI KAMI --}}
        <div>
            <h4 class="mb-4 text-sm font-semibold">Ikuti Kami</h4>
            <ul class="space-y-3 text-sm text-gray-400">
                <li><a href="#" target="_blank" class="transition hover:text-white">Tiktok</a></li>
                <li><a href="#" target="_blank" class="transition hover:text-white">Twitter</a></li>
                <li><a href="#" target="_blank" class="transition hover:text-white">Instagram</a></li>
                <li><a href="#" target="_blank" class="transition hover:text-white">Youtube</a></li>
                <li><a href="#" target="_blank" class="transition hover:text-white">Facebook</a></li>
            </ul>
        </div>

        {{-- HUBUNGI KAMI --}}
        <div>
            <h4 class="mb-4 text-sm font-semibold">Hubungi Kami</h4>
            <ul class="space-y-4 text-sm text-gray-400">
                <li class="flex items-start gap-3">
                    <i class="fa-regular fa-envelope mt-0.5 w-4"></i>
                    <span>informasi@smkn1purwosari.sch.id</span>
                </li>
                <li class="flex items-start gap-3">
                    <i class="fa-solid fa-globe mt-0.5 w-4"></i>
                    <a href="https://www.smkn1purwosari.sch.id" target="_blank" class="transition hover:text-white">
                        smkn1purwosari.sch.id
                    </a>
                </li>
                <li class="flex items-start gap-3">
                    <i class="fa-solid fa-phone mt-0.5 w-4"></i>
                    <span>(0343) 613747</span>
                </li>
            </ul>
        </div>

    </div>
    
</footer>
