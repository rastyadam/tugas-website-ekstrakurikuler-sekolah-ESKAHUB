@extends('student.layouts.app') 
@section('content')
 @include('student.partial-katalog-ekstra')
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
            <div class="flex flex-col overflow-hidden rounded-2xl border border-gray-100 bg-white p-4 shadow-sm transition hover:shadow-md">
                {{-- Banner/Thumbnail Image --}}
                <div class="h-44 w-full overflow-hidden rounded-xl bg-gray-100">
                    @if($ekskul->foto)
                        <img src="{{ asset('storage/' . $ekskul->foto) }}" alt="{{ $ekskul->nama }}" class="h-full w-full object-cover">
                    @else
                        {{-- Gambar default jika admin belum upload foto --}}
                        <img src="{{ asset('images/default-ekskul.jpg') }}" alt="Default" class="h-full w-full object-cover">
                    @endif
                </div>

                {{-- Content --}}
                <div class="mt-4 flex flex-1 flex-col justify-between space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            {{-- Logo default --}}
                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-amber-100 text-amber-600">
                                <i class="fa-solid fa-trophy text-sm"></i>
                            </div>
                            <h3 class="text-base font-bold text-slate-900">{{ $ekskul->nama }}</h3>
                        </div>
                        
                        {{-- Tombol Panah (Kirim ID ke detail) --}}
                        <a href="{{ route('student.ekstra.detail', $ekskul->id) }}" class="text-amber-500 hover:text-amber-600 transition-transform hover:translate-x-1">
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                    <p class="text-xs leading-relaxed text-gray-400 line-clamp-3">
                        {{ $ekskul->deskripsi ?? 'Belum ada deskripsi untuk ekstrakurikuler ini.' }}
                    </p>
                </div>
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
@endsection