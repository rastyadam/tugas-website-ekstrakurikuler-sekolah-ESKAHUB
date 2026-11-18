@extends('student.layouts.app')

@section('title', 'Form Pendaftaran - ' . $ekskul->nama)

@section('content')
<div class="min-h-screen bg-gray-50 py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto space-y-6">

        {{-- Tombol Kembali --}}
        <a href="{{ route('student.ekstra.detail', $ekskul->id) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-800 hover:text-slate-600">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Detail
        </a>

        {{-- Alert Error --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Card Form --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            
            {{-- Header --}}
            <div class="bg-slate-900 p-6 text-white">
                <h1 class="text-2xl font-bold">Form Pendaftaran Ekstrakurikuler</h1>
                <p class="text-sm text-slate-300 mt-1">Lengkapi data diri Anda untuk mendaftar di <strong>{{ $ekskul->nama }}</strong>.</p>
            </div>

            {{-- Form --}}
            <form action="{{ route('student.ekstra.daftar', $ekskul->id) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
                @csrf

                {{-- Data Diri (Readonly) --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">NISN</label>
                        <input type="text" value="{{ $siswa->nisn }}" readonly class="w-full rounded-xl border border-gray-300 bg-gray-100 px-3 py-2 text-sm text-gray-600 cursor-not-allowed">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" value="{{ $siswa->nama }}" readonly class="w-full rounded-xl border border-gray-300 bg-gray-100 px-3 py-2 text-sm text-gray-600 cursor-not-allowed">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Kelas</label>
                        <input type="text" value="{{ $siswa->kelas }}" readonly class="w-full rounded-xl border border-gray-300 bg-gray-100 px-3 py-2 text-sm text-gray-600 cursor-not-allowed">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Jurusan</label>
                        <input type="text" value="{{ $siswa->jurusan }}" readonly class="w-full rounded-xl border border-gray-300 bg-gray-100 px-3 py-2 text-sm text-gray-600 cursor-not-allowed">
                    </div>
                </div>

                <hr class="border-gray-100">

                {{-- Input Tambahan --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Tanggal Lahir <span class="text-rose-500">*</span></label>
                        <input type="date" name="tanggal_lahir" required class="w-full rounded-xl border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Alokasi (Opsional)</label>
                        <input type="text" name="alokasi" placeholder="Misal: Kelas X RPL 1" class="w-full rounded-xl border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                    </div>
                </div>

                {{-- Upload Berkas --}}
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Upload Berkas Persyaratan</label>
                    <input type="file" name="berkas" class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100 border border-gray-300 rounded-xl">
                    <p class="text-[10px] text-gray-400 mt-1">Format PDF/JPG/PNG. Maks 2MB.</p>
                </div>

                {{-- Persetujuan --}}
                <div class="flex items-start gap-3 bg-amber-50 p-4 rounded-xl">
                    <input type="checkbox" required id="setuju" class="mt-1 w-4 h-4 text-amber-500 border-gray-300 rounded focus:ring-amber-500">
                    <label for="setuju" class="text-xs text-gray-700">
                        Saya menyatakan bahwa data yang saya isi adalah benar dan saya bersedia mengikuti seluruh peraturan ekstrakurikuler.
                    </label>
                </div>

                {{-- Tombol Submit --}}
                <div class="pt-4 border-t border-gray-100 flex justify-end gap-3">
                    <a href="{{ route('student.ekstra.detail', $ekskul->id) }}" class="px-5 py-2.5 text-sm font-semibold text-gray-600 hover:bg-gray-100 rounded-xl transition">Batal</a>
                    <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-amber-500 hover:bg-amber-600 rounded-xl shadow-sm transition">
                        Kirim Pendaftaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection