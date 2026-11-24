@extends('student.layouts.app') 
@section('content')

{{-- CSS Custom untuk animasi modern, tilt 3D & spotlight kursor --}}
<style>
    @property --angle {
        syntax: '<angle>';
        initial-value: 0deg;
        inherits: false;
    }

    /* Animasi muncul card saat load */
    @keyframes card-enter {
        0% { opacity: 0; transform: translateY(24px) scale(0.97); }
        100% { opacity: 1; transform: translateY(0) scale(1); }
    }

    /* Wrapper perspektif 3D */
    .card-tilt-wrap {
        perspective: 1000px;
        opacity: 0;
        animation: card-enter 0.65s cubic-bezier(.22,1,.36,1) forwards;
        animation-delay: calc(var(--i, 0) * 80ms);
    }

    .card-modern {
        --rx: 0deg; --ry: 0deg; --lift: 0px; --scale: 1;
        --mx: 50%; --my: 50%;

        position: relative;
        isolation: isolate;
        transform-style: preserve-3d;
        transform: translateY(var(--lift)) scale(var(--scale)) rotateX(var(--rx)) rotateY(var(--ry));
        transition: transform 0.35s cubic-bezier(.22,1,.36,1), box-shadow 0.45s ease;
        will-change: transform;
    }

    .card-modern.is-tilting {
        transition: transform 0.08s cubic-bezier(.22,1,.36,1), box-shadow 0.45s ease;
    }

    /* Efek spotlight cahaya mengikuti kursor */
    .spotlight {
        position: absolute; inset: 0; border-radius: inherit; pointer-events: none; z-index: 25;
        opacity: 0;
        background: radial-gradient(260px circle at var(--mx) var(--my), rgba(255, 255, 255, 0.36), rgba(251, 191, 36, 0.16) 38%, transparent 72%);
        mix-blend-mode: plus-lighter;
        transition: opacity 0.35s ease;
    }
    .card-modern:hover .spotlight { opacity: 1; }

    /* Glow border gradient berputar */
    .card-modern::before {
        content: ""; position: absolute; inset: -2px; border-radius: 1.1rem; padding: 2px;
        background: conic-gradient(from var(--angle), #f59e0b, #ec4899, #8b5cf6, #06b6d4, #f59e0b);
        -webkit-mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);
        -webkit-mask-composite: xor; mask-composite: exclude;
        opacity: 0; transition: opacity .4s ease; animation: spin-border 4s linear infinite; animation-play-state: paused;
        z-index: -1;
    }
    .card-modern:hover::before { opacity: 1; animation-play-state: running; }
    @keyframes spin-border { to { --angle: 360deg; } }

    /* Glow aura di belakang card */
    .card-modern::after {
        content: ""; position: absolute; inset: 10%; border-radius: 1.5rem;
        background: radial-gradient(circle, rgba(245,158,11,.35), transparent 70%);
        filter: blur(28px); opacity: 0; transition: opacity .45s ease; z-index: -2;
    }
    .card-modern:hover::after { opacity: 1; }

    .card-modern:hover {
        --lift: -8px; --scale: 1.02;
        box-shadow: 0 25px 50px -12px rgba(245,158,11,.35);
    }

    .card-content-3d {
        position: relative; z-index: 10; transform: translateZ(18px); transform-style: preserve-3d;
    }

    /* Shine sweep */
    .shine {
        position: absolute; inset: 0; overflow: hidden; border-radius: inherit; pointer-events: none; z-index: 30; 
    }
    .shine::before {
        content: ""; position: absolute; top: 0; left: -75%; width: 50%; height: 100%;
        background: linear-gradient(120deg, transparent, rgba(255,255,255,.55), transparent);
        transform: skewX(-20deg); transition: left .8s cubic-bezier(.22,1,.36,1);
    }
    .card-modern:hover .shine::before { left: 125%; }

    /* Logo Melayang (Overlapping) */
    .logo-overlapping {
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        transition: all 0.4s cubic-bezier(.22,1,.36,1);
    }
    .card-modern:hover .logo-overlapping {
        animation: float 1.6s ease-in-out infinite;
        border-color: #f59e0b;
        box-shadow: 0 6px 16px rgba(245,158,11,0.4);
        transform: translateY(-4px); /* sedikit naik */
    }
    @keyframes float {
        0%,100% { transform: translateY(-4px) rotate(0deg); }
        50%     { transform: translateY(-8px) rotate(6deg); }
    }

    /* Judul shimmer saat hover */
    .card-modern:hover .title-shimmer {
        background: linear-gradient(90deg, #f59e0b, #ec4899, #8b5cf6, #f59e0b);
        background-size: 200% auto;
        -webkit-background-clip: text; background-clip: text;
        color: transparent; animation: shimmer 2s linear infinite;
    }
    @keyframes shimmer { to { background-position: 200% center; } }

    /* Animasi Teks Lihat Selengkapnya */
    .btn-read-more {
        position: relative; display: inline-flex; align-items: center; gap: 6px;
        font-weight: 700; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em;
        color: #64748b; transition: color 0.3s ease;
    }
    .btn-read-more .arrow-icon { transition: transform 0.3s cubic-bezier(.22,1,.36,1); }
    .card-modern:hover .btn-read-more { color: #d97706; }
    .card-modern:hover .btn-read-more .arrow-icon { transform: translateX(4px); animation: arrow-bounce .8s ease-in-out infinite; }
    
    @keyframes arrow-bounce {
        0%, 100% { transform: translateX(4px); }
        50%      { transform: translateX(8px); }
    }

    /* Garis bawah animasi */
    .btn-read-more::after {
        content: ''; position: absolute; width: 100%; transform: scaleX(0); height: 2px;
        bottom: -2px; left: 0; background-color: #d97706; transform-origin: bottom right; transition: transform 0.3s ease-out;
    }
    .card-modern:hover .btn-read-more::after { transform: scaleX(1); transform-origin: bottom left; }

    /* Image zoom */
    .img-zoom { transition: transform .6s cubic-bezier(.22,1,.36,1), filter .4s ease; }
    .card-modern:hover .img-zoom { transform: scale(1.15); filter: brightness(.85) saturate(1.15); }

    /* Hormati preferensi reduced motion pengguna */
    @media (prefers-reduced-motion: reduce) {
        .card-tilt-wrap, .card-modern, .card-modern::before, .card-modern::after, .card-content-3d, .spotlight, 
        .shine::before, .logo-overlapping, .title-shimmer, .arrow-bounce, .img-zoom {
            animation: none !important; transition: none !important; opacity: 1 !important; transform: none !important;
        }
        .spotlight { display: none !important; }
    }
</style>

<section id="ekstra" class="min-h-screen bg-white px-4 py-16 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-7xl space-y-8">

        {{-- JUDUL / HEADER --}}
        <div class="space-y-3 text-center">
            <span class="inline-block rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-slate-500">
                KATALOG LENGKAP
            </span>

            <h2 class="text-3xl font-extrabold text-slate-900 sm:text-4xl">
                Jelajahi Ekstrakurikuler
            </h2>

            <p class="text-sm text-gray-500">
                Temukan kegiatan yang sesuai dengan minat dan bakatmu.
            </p>
        </div>

        {{-- GRID CARD DINAMIS --}}
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
            
            @forelse($ekskuls as $ekskul)
            <div style="--i: {{ $loop->index }};" class="card-tilt-wrap">
                <a href="{{ route('student.ekstra.detail', $ekskul->id) }}"
                   data-tilt-card
                   class="card-modern group flex h-full flex-col overflow-hidden rounded-2xl border border-gray-100 bg-white p-4 shadow-sm">
                    
                    <span class="spotlight"></span>
                    <span class="shine"></span>

                    <div class="card-content-3d flex flex-1 flex-col">
                        {{-- Banner/Thumbnail Image --}}
                        <div class="relative h-44 w-full overflow-hidden rounded-xl bg-gray-100">
                            @if($ekskul->foto)
                                <img src="{{ asset('storage/' . $ekskul->foto) }}" alt="{{ $ekskul->nama }}" 
                                     class="img-zoom h-full w-full object-cover">
                            @else
                                <img src="{{ asset('images/default-ekskul.jpg') }}" alt="Default" 
                                     class="img-zoom h-full w-full object-cover">
                            @endif

                            {{-- Overlay gradient --}}
                            <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/60 via-black/0 to-transparent 
                                        opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>

                            {{-- LOGO EKSTRAKURIKULER (Melayang di pojok kiri bawah gambar) --}}
                            <div class="logo-overlapping absolute -bottom-5 left-4 flex h-14 w-14 items-center justify-center overflow-hidden rounded-full border-[3px] border-white bg-white z-20">
                                @if($ekskul->foto)
                                    <img src="{{ asset('storage/' . $ekskul->foto) }}" alt="{{ $ekskul->nama }}" class="h-full w-full object-cover">
                                @else
                                    <span class="text-xl font-bold text-amber-500">
                                        {{ substr($ekskul->nama, 0, 1) }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="mt-7 flex flex-1 flex-col justify-between">
                            <div class="space-y-2">
                                {{-- Judul Ekstrakurikuler --}}
                                <h3 class="title-shimmer text-base font-bold text-slate-900 transition-colors duration-300">
                                    {{ $ekskul->nama }}
                                </h3>
                                <p class="text-xs leading-relaxed text-gray-400 line-clamp-3 transition-colors duration-300 group-hover:text-gray-500">
                                    {{ $ekskul->deskripsi ?? 'Belum ada deskripsi untuk ekstrakurikuler ini.' }}
                                </p>
                            </div>
                            
                            {{-- TOMBOL LIHAT SELENGKAPNYA --}}
                            <div class="mt-5 pt-4 border-t border-gray-100 flex justify-between items-center w-full">
                                <span class="btn-read-more">
                                    Lihat Selengkapnya
                                    <i class="fa-solid fa-arrow-right arrow-icon text-[10px]"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @empty
            {{-- Tampilan jika data kosong --}}
            <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-12">
                <div class="inline-flex h-20 w-20 items-center justify-center rounded-full bg-gray-100 text-gray-400 mb-4">
                    <i class="fa-solid fa-folder-open text-3xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-700">Belum Ada Ekstrakurikuler</h3>
                <p class="text-sm text-gray-500">Saat ini belum ada data ekstrakurikuler yang tersedia.</p>
            </div>
            @endforelse

        </div>

        {{-- PAGINASI --}}
        @if($ekskuls instanceof \Illuminate\Pagination\LengthAwarePaginator)
            @if($ekskuls->hasPages())
            <div class="flex items-center justify-center gap-1.5 pt-6">
                {{ $ekskuls->links() }}
            </div>
            @endif
        @endif

    </div>
</section>

{{-- SCRIPT 3D TILT --}}
<script>
(() => {
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const isTouchDevice = window.matchMedia('(pointer: coarse)').matches;
    if (prefersReducedMotion || isTouchDevice) return;

    const maxTilt = 9;
    const cards = document.querySelectorAll('[data-tilt-card]');

    cards.forEach((card) => {
        let rafId = null;
        let targetRx = 0, targetRy = 0, targetMx = '50%', targetMy = '50%';

        const updateFrame = () => {
            card.style.setProperty('--rx', `${targetRx.toFixed(2)}deg`);
            card.style.setProperty('--ry', `${targetRy.toFixed(2)}deg`);
            card.style.setProperty('--mx', targetMx);
            card.style.setProperty('--my', targetMy);
            rafId = null;
        };

        card.addEventListener('pointerenter', () => {
            card.classList.add('is-tilting');
        });

        card.addEventListener('pointermove', (e) => {
            const rect = card.getBoundingClientRect();
            const offsetX = e.clientX - rect.left;
            const offsetY = e.clientY - rect.top;

            const relX = Math.min(Math.max(offsetX / rect.width, 0), 1);
            const relY = Math.min(Math.max(offsetY / rect.height, 0), 1);

            targetRy = (relX - 0.5) * 2 * maxTilt;
            targetRx = -(relY - 0.5) * 2 * maxTilt;
            targetMx = `${offsetX.toFixed(1)}px`;
            targetMy = `${offsetY.toFixed(1)}px`;

            if (!rafId) rafId = requestAnimationFrame(updateFrame);
        });

        card.addEventListener('pointerleave', () => {
            card.classList.remove('is-tilting');
            targetRx = 0; targetRy = 0; targetMx = '50%'; targetMy = '50%';
            if (!rafId) rafId = requestAnimationFrame(updateFrame);
        });
    });
})();
</script>
@endsection