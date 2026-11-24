@extends('pembina.layouts.app')

@section('content')
<div class="min-h-screen bg-amber-50/25 text-gray-800">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">

        @if(session('success'))
            <div class="mb-5 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Header Halaman -->
        <div class="mb-6">
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Pengumuman</h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-0.5">
                Kelola informasi dan pengumuman untuk anggota ekstrakurikuler.
            </p>
        </div>

        <!-- Layout 2 Kolom di Desktop, 1 Kolom di HP -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start">

            <!-- Kolom Kiri: Form Buat Pengumuman -->
            <section class="lg:col-span-5 bg-white border border-amber-200/80 rounded-lg p-4 sm:p-5">
                <div class="pb-3 mb-4 border-b border-amber-100">
                    <h2 class="text-sm font-bold text-gray-900">Buat Pengumuman</h2>
                    <p class="text-xs text-gray-500 mt-0.5">Tulis info baru untuk ditampilkan ke siswa.</p>
                </div>

                <form action="{{ route('pembina.pengumuman.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Judul</label>
                        <input type="text"
                               name="judul"
                               value="{{ old('judul') }}"
                               placeholder="Masukkan judul pengumuman"
                               required
                               class="w-full bg-white border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-amber-500">
                        @error('judul')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Ekstrakurikuler</label>
                        <select name="ekstrakurikuler_id"
                                required
                                class="w-full bg-white border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-800 focus:outline-none focus:border-amber-500">
                            <option value="">-- Pilih Ekskul --</option>
                            @foreach($ekskuls as $ekskul)
                                <option value="{{ $ekskul->id }}" {{ old('ekstrakurikuler_id') == $ekskul->id ? 'selected' : '' }}>
                                    {{ $ekskul->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('ekstrakurikuler_id')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Isi Pengumuman</label>
                        <textarea name="isi"
                                  rows="6"
                                  placeholder="Tulis pengumuman di sini..."
                                  required
                                  class="w-full bg-white border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-amber-500">{{ old('isi') }}</textarea>
                        @error('isi')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-1 flex justify-end">
                        <button type="submit"
                                class="w-full sm:w-auto bg-amber-500 hover:bg-orange-600 text-white text-sm font-medium px-5 py-2 rounded-lg transition cursor-pointer">
                            Kirim Pengumuman
                        </button>
                    </div>
                </form>
            </section>

            <!-- Kolom Kanan: Daftar Pengumuman Sebelumnya -->
            <section class="lg:col-span-7 space-y-4">
                <div class="flex items-center justify-between pb-2.5 border-b border-amber-200/70">
                    <h2 class="text-sm font-bold text-gray-800">Pengumuman Sebelumnya</h2>
                    <span class="text-xs text-gray-500">{{ $pengumumans->count() }} data</span>
                </div>

                @forelse($pengumumans as $p)
                    <article class="bg-white border border-amber-200/80 border-l-4 {{ $loop->odd ? 'border-l-amber-500' : 'border-l-orange-400' }} rounded-lg p-4 sm:p-5 hover:bg-amber-50/30 transition">
                        <span class="inline-block text-xs font-medium px-2.5 py-0.5 rounded mb-2 {{ $loop->odd ? 'bg-amber-100 text-amber-900' : 'bg-orange-100 text-orange-800' }}">
                            {{ $p->ekstrakurikuler->nama ?? 'Umum' }}
                        </span>

                        <h3 class="text-base font-semibold text-gray-900 leading-snug">
                            {{ $p->judul }}
                        </h3>

                        <p class="text-sm text-gray-600 mt-1.5 leading-relaxed">
                            {{ $p->isi }}
                        </p>

                        <div class="mt-3 pt-2.5 border-t border-gray-100 text-xs text-gray-400 flex items-center justify-between gap-2">
                            <span>{{ \Carbon\Carbon::parse($p->created_at)->format('d M Y • H:i') }}</span>
                        </div>
                    </article>
                @empty
                    <div class="bg-white border border-amber-200/80 rounded-lg p-8 text-center">
                        <p class="text-sm font-medium text-gray-700">Belum ada pengumuman yang dibuat.</p>
                        <p class="text-xs text-gray-400 mt-1">Isi form di samping untuk mengirim pengumuman pertama.</p>
                    </div>
                @endforelse
            </section>

        </div>
    </div>
</div>
@endsection