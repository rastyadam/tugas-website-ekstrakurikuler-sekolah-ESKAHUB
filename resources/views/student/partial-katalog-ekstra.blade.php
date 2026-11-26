<section id="ekstra" class="scroll-mt-20 min-h-screen bg-white px-4 py-16 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-7xl space-y-8">

        {{-- JUDUL --}}
        <div class="ekstra-header space-y-3 text-center">
            <span class="inline-block rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-amber-600">
                KATALOG LENGKAP
            </span>

            <h2 class="text-2xl font-extrabold text-[#182635] sm:text-3xl md:text-4xl">
                Jelajahi Ekstrakurikuler
            </h2>

            <p class="text-xs text-gray-500 sm:text-sm">
                Temukan kegiatan yang sesuai dengan minat dan bakatmu.
            </p>

            <div class="mx-auto h-1 w-16 rounded-full bg-[#f6bd24]"></div>
        </div>

        {{-- GRID CARD --}}
        <div id="ekstra-grid" class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($ekskuls as $ekskul)
                @include('student.layouts.partials.ekstra-card', ['ekskuls' => collect([$ekskul])])
            @empty
                <div class="col-span-full py-12 text-center">
                    <div class="mb-4 inline-flex h-20 w-20 items-center justify-center rounded-full bg-amber-50 text-amber-500">
                        <i class="fa-solid fa-folder-open text-3xl"></i>
                    </div>

                    <h3 class="text-lg font-bold text-gray-700">
                        Belum Ada Ekstrakurikuler
                    </h3>

                    <p class="text-sm text-gray-500">
                        Saat ini belum ada data ekstrakurikuler yang tersedia.
                    </p>
                </div>
            @endforelse
        </div>

     @if($hasMore)
    <div id="load-more-container" class="flex justify-center pt-8">
        <button
            type="button"
            id="load-more-ekstra"
            class="group inline-flex items-center gap-3.5 rounded-xl bg-[#182635] px-8 py-4 text-sm font-semibold tracking-wide text-white shadow-sm transition-all duration-300 ease-out hover:bg-[#22354a] hover:shadow-lg active:scale-[0.99]"
        >
            <span>Lihat Semuanya</span>
            <i class="fa-solid fa-arrow-down text-xs text-[#f6bd24] transition-transform duration-300 group-hover:translate-y-1"></i>
        </button>
    </div>
@endif

    </div>
</section>

{{-- ANIMASI --}}
<style>
    .ekstra-header {
        animation: ekstraFadeDown 0.7s ease both;
    }

    .ekstra-card:not(.hidden) {
        animation: ekstraFadeUp 0.7s ease forwards;
        animation-delay: var(--delay, 0ms);
    }

    @keyframes ekstraFadeDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes ekstraFadeUp {
        from {
            opacity: 0;
            transform: translateY(25px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .ekstra-header,
        .ekstra-card {
            opacity: 1;
            animation: none;
        }
    }
</style>

{{-- JAVASCRIPT LOAD MORE --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const button = document.getElementById('load-more-ekstra');
        const grid = document.getElementById('ekstra-grid');
        const container = document.getElementById('load-more-container');

        if (!button || !grid || !container) return;

       let nextPage = {{ $ekskuls->currentPage() + 1 }};
        let loading = false;

        button.addEventListener('click', async function () {
            if (loading) return;

            loading = true;
            button.disabled = true;

            const originalContent = button.innerHTML;

            button.innerHTML = `
                <i class="fa-solid fa-spinner fa-spin"></i>
                <span>Memuat...</span>
            `;

            try {
                const url = new URL(@json(route('student.ekstra.load-more')), window.location.origin);
                url.searchParams.set('page', nextPage);

                // Pertahankan pencarian jika ada
                const search = new URLSearchParams(window.location.search).get('search');
                if (search) {
                    url.searchParams.set('search', search);
                }

                const response = await fetch(url, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) {
                    throw new Error('Gagal mengambil data ekstrakurikuler.');
                }

                const result = await response.json();

                // Tambahkan card baru ke bawah
                grid.insertAdjacentHTML('beforeend', result.html);
                nextPage = result.nextPage;

                // Jika data sudah habis, hilangkan tombol
                if (!result.hasMore) {
                    container.remove();
                } else {
                    button.innerHTML = originalContent;
                }
            } catch (error) {
                console.error(error);
                button.innerHTML = 'Coba Lagi';
            } finally {
                loading = false;
                if (document.body.contains(button)) {
                    button.disabled = false;
                }
            }
        });
    });
</script>