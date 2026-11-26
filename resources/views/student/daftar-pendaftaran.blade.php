
@extends('student.layouts.app')

@section('title', 'Form Pendaftaran - ' . $ekskul->nama)

@section('content')
<div class="min-h-screen bg-gray-50 px-4 py-10 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-3xl space-y-6">

        {{-- KEMBALI --}}
        <a href="{{ route('student.ekstra.detail', $ekskul->id) }}"
           class="inline-flex items-center gap-2 text-sm font-semibold text-slate-800 transition hover:text-slate-600">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali ke Detail
        </a>

        {{-- ERROR VALIDASI --}}
        @if ($errors->any())
            <div class="rounded-xl border border-red-300 bg-red-100 px-4 py-3 text-red-700">
                <ul class="list-inside list-disc space-y-1 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FLASH INFO --}}
        @if (session('info'))
            <div class="rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800">
                {{ session('info') }}
            </div>
        @endif

        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

            {{-- HEADER --}}
            <div class="bg-slate-900 p-6 text-white">
                <h1 class="text-2xl font-bold">
                    Form Pendaftaran Ekstrakurikuler
                </h1>

                <p class="mt-1 text-sm text-slate-300">
                    Lengkapi data diri untuk mendaftar di
                    <strong class="text-white">{{ $ekskul->nama }}</strong>.
                </p>
            </div>

            <form action="{{ route('student.ekstra.daftar', $ekskul->id) }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="space-y-6 p-6">

                @csrf

                {{-- DATA SISWA --}}
                <div class="space-y-4">
                    <h2 class="font-bold text-slate-800">
                        Data Siswa
                    </h2>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                        <div>
                            <label for="nisn" class="mb-1 block text-xs font-bold text-gray-700">
                                NISN
                            </label>

                            <input id="nisn"
                                   type="text"
                                   value="{{ $siswa->nisn }}"
                                   readonly
                                   class="w-full cursor-not-allowed rounded-xl border border-gray-300 bg-gray-100 px-3 py-2 text-sm text-gray-600">
                        </div>

                        <div>
                            <label for="nama" class="mb-1 block text-xs font-bold text-gray-700">
                                Nama Lengkap
                            </label>

                            <input id="nama"
                                   type="text"
                                   value="{{ $siswa->nama }}"
                                   readonly
                                   class="w-full cursor-not-allowed rounded-xl border border-gray-300 bg-gray-100 px-3 py-2 text-sm text-gray-600">
                        </div>

                        <div>
                            <label for="kelas" class="mb-1 block text-xs font-bold text-gray-700">
                                Kelas
                            </label>

                            <input id="kelas"
                                   type="text"
                                   value="{{ $siswa->kelas }}"
                                   readonly
                                   class="w-full cursor-not-allowed rounded-xl border border-gray-300 bg-gray-100 px-3 py-2 text-sm text-gray-600">
                        </div>

                        <div>
                            <label for="jurusan" class="mb-1 block text-xs font-bold text-gray-700">
                                Jurusan
                            </label>

                            <input id="jurusan"
                                   type="text"
                                   value="{{ $siswa->jurusan }}"
                                   readonly
                                   class="w-full cursor-not-allowed rounded-xl border border-gray-300 bg-gray-100 px-3 py-2 text-sm text-gray-600">
                        </div>

                    </div>
                </div>

                <hr class="border-gray-100">

                {{-- DATA TAMBAHAN --}}
                <div class="space-y-4">
                    <h2 class="font-bold text-slate-800">
                        Data Tambahan
                    </h2>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                        <div>
                            <label for="tanggal_lahir" class="mb-1 block text-xs font-bold text-gray-700">
                                Tanggal Lahir <span class="text-rose-500">*</span>
                            </label>

                            <input id="tanggal_lahir"
                                   type="date"
                                   name="tanggal_lahir"
                                   value="{{ old('tanggal_lahir') }}"
                                   required
                                   class="w-full rounded-xl border border-gray-300 px-3 py-2 text-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-500">
                        </div>

                        <div>
                            <label for="alokasi" class="mb-1 block text-xs font-bold text-gray-700">
                                Alokasi (Opsional)
                            </label>

                            <input id="alokasi"
                                   type="text"
                                   name="alokasi"
                                   value="{{ old('alokasi') }}"
                                   placeholder="Misal: Kelas X RPL 1"
                                   class="w-full rounded-xl border border-gray-300 px-3 py-2 text-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-500">
                        </div>

                    </div>
                </div>

                <hr class="border-gray-100">

                {{-- PERSYARATAN PENDAFTARAN --}}
                <div class="space-y-4">

                    <div>
                        <h2 class="font-bold text-slate-800">
                            Persyaratan Pendaftaran
                        </h2>

                        <p class="mt-1 text-xs text-gray-500">
                            Perhatikan persyaratan umum dan persyaratan khusus
                            {{ $ekskul->nama }} berikut.
                        </p>
                    </div>

                    @forelse ($persyaratans as $persyaratan)

                        @php
                            $tipe = strtolower(trim($persyaratan->tipe_persyaratan ?? ''));
                            $isWajib = strtolower(trim($persyaratan->status)) === 'wajib';
                            $inputId = 'berkas_' . $persyaratan->id;
                        @endphp

                        <div class="rounded-xl border border-gray-200 p-4">

                            {{-- NAMA DAN STATUS --}}
                            <div class="mb-3 flex items-start justify-between gap-3">

                                <h3 class="font-semibold text-gray-900">
                                    {{ $persyaratan->nama }}

                                    @if ($isWajib && $tipe !== 'teks')
                                        <span class="text-rose-500">*</span>
                                    @endif
                                </h3>

                                <span class="shrink-0 rounded-full px-2.5 py-0.5 text-[11px] font-semibold uppercase
                                    {{ $isWajib
                                        ? 'bg-rose-50 text-rose-600'
                                        : 'bg-gray-100 text-gray-600' }}">
                                    {{ $persyaratan->status }}
                                </span>

                            </div>

                            {{-- JENIS TEKS: INFORMASI SAJA --}}
                            @if ($tipe === 'teks')

                                <p class="text-sm text-gray-600">
                                    {{ $persyaratan->nama }}
                                </p>

                            {{-- JENIS DOKUMEN: UPLOAD PDF --}}
                            @elseif ($tipe === 'dokumen')

                                <input id="{{ $inputId }}"
                                       type="file"
                                       name="berkas[{{ $persyaratan->id }}]"
                                       accept=".pdf,application/pdf"
                                       @required($isWajib)
                                       class="w-full rounded-xl border border-gray-300 px-3 py-2 text-sm
                                       file:mr-3 file:rounded-lg file:border-0
                                       file:bg-amber-50 file:px-3 file:py-1.5
                                       file:text-xs file:font-semibold file:text-amber-700
                                       hover:file:bg-amber-100">

                                <p class="mt-2 text-xs text-gray-400">
                                    Format PDF. Maksimal 2 MB.
                                </p>

                            {{-- JENIS GAMBAR: UPLOAD FOTO --}}
                            @elseif ($tipe === 'gambar')

                                <input id="{{ $inputId }}"
                                       type="file"
                                       name="berkas[{{ $persyaratan->id }}]"
                                       accept=".jpg,.jpeg,.png,image/jpeg,image/png"
                                       @required($isWajib)
                                       class="w-full rounded-xl border border-gray-300 px-3 py-2 text-sm
                                       file:mr-3 file:rounded-lg file:border-0
                                       file:bg-amber-50 file:px-3 file:py-1.5
                                       file:text-xs file:font-semibold file:text-amber-700
                                       hover:file:bg-amber-100">

                                <p class="mt-2 text-xs text-gray-400">
                                    Format JPG, JPEG, atau PNG. Maksimal 2 MB.
                                </p>

                            @else

                                <p class="text-sm text-red-500">
                                    Jenis persyaratan belum didukung.
                                </p>

                            @endif

                        </div>

                    @empty

                        <div class="rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-800">
                            Belum ada persyaratan yang ditambahkan untuk ekstrakurikuler ini.
                        </div>

                    @endforelse

                </div>

                <hr class="border-gray-100">

                {{-- PERSETUJUAN --}}
                <div class="flex items-start gap-3 rounded-xl bg-amber-50 p-4">

                    <input id="setuju"
                           type="checkbox"
                           required
                           class="mt-1 h-4 w-4 rounded border-gray-300 text-amber-500 focus:ring-amber-500">

                    <label for="setuju" class="text-xs text-gray-700">
                        Saya menyatakan bahwa data yang saya isi adalah benar
                        dan saya bersedia mengikuti seluruh peraturan ekstrakurikuler.
                    </label>

                </div>

                {{-- AKSI --}}
                <div class="flex justify-end gap-3 border-t border-gray-100 pt-4">

                    <a href="{{ route('student.ekstra.detail', $ekskul->id) }}"
                       class="rounded-xl px-5 py-2.5 text-sm font-semibold text-gray-600 transition hover:bg-gray-100">
                        Batal
                    </a>

                    <button type="submit"
                            class="rounded-xl bg-amber-500 px-5 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-amber-600">
                        Kirim Pendaftaran
                    </button>

                </div>

            </form>
        </div>
    </div>
</div>
@endsection
