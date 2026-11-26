@extends('pembina.layouts.app')

@section('title', 'Kelola Persyaratan - EskaHub')
@section('header_title', 'Kelola Persyaratan')

@section('content')

{{-- Otomatis buka modal jika terjadi error validasi setelah submit --}}
<div class="max-w-6xl mx-auto space-y-6" x-data="{ openModal: {{ $errors->any() ? 'true' : 'false' }} }">

    {{-- HEADER & TOMBOL TAMBAH --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-gray-800">
                Persyaratan Ekstrakurikuler
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                Atur persyaratan khusus untuk siswa yang mendaftar.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <span class="text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200/60 px-3 py-2.5 rounded-lg">
                <i class="fa-solid fa-clipboard-list mr-1"></i>
                {{ $persyaratans->count() }} Persyaratan
            </span>

            <button type="button"
                    @click="openModal = true"
                    class="bg-[#182635] hover:bg-[#263b50] text-white text-sm font-medium px-4 py-2.5 rounded-lg shadow-sm transition cursor-pointer flex items-center gap-2">
                <i class="fa-solid fa-plus"></i>
                <span>Tambah Persyaratan</span>
            </button>
        </div>
    </div>

    {{-- ALERT SUKSES --}}
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl p-4 text-sm flex items-center">
            <i class="fa-solid fa-circle-check mr-2"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- MODAL FORM TAMBAH PERSYARATAN --}}
    <div x-show="openModal"
         x-transition.opacity
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
         style="display: none;">

        {{-- Kontainer Modal --}}
        <div @click.outside="openModal = false"
             x-transition.scale.95
             class="w-full max-w-lg rounded-2xl bg-white shadow-xl border border-gray-100 overflow-hidden">

            {{-- Header Modal --}}
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <div>
                    <h2 class="text-lg font-bold text-[#182635]">
                        Tambah Persyaratan
                    </h2>
                    <p class="text-xs text-gray-500 mt-0.5">
                        Tambahkan ketentuan yang harus dipenuhi siswa.
                    </p>
                </div>

                <button type="button"
                        @click="openModal = false"
                        class="text-gray-400 hover:text-gray-600 p-1.5 rounded-lg hover:bg-gray-100 transition cursor-pointer">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            {{-- Body Form --}}
            <form action="{{ route('pembina.persyaratan.store') }}" method="POST" class="p-6 space-y-4">
                @csrf

                {{-- Alert Error Validasi di dalam Modal --}}
                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl p-3.5 text-xs">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Nama / Instruksi Persyaratan
                    </label>
                    <input type="text" name="nama" required
                        placeholder="Contoh: Mempunyai sepatu olahraga"
                        value="{{ old('nama') }}"
                        class="w-full border border-gray-300 rounded-lg px-3.5 py-2 text-sm focus:border-[#182635] focus:outline-none">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Bentuk Persyaratan
                    </label>
                    <select name="tipe_persyaratan" required
                        class="w-full border border-gray-300 rounded-lg px-3.5 py-2 text-sm focus:border-[#182635] focus:outline-none">
                        <option value="">Pilih bentuk persyaratan</option>
                        <option value="teks" {{ old('tipe_persyaratan') == 'teks' ? 'selected' : '' }}>Teks / Pernyataan</option>
                        <option value="dokumen" {{ old('tipe_persyaratan') == 'dokumen' ? 'selected' : '' }}>Dokumen</option>
                        <option value="gambar" {{ old('tipe_persyaratan') == 'gambar' ? 'selected' : '' }}>Foto / Gambar</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Status Persyaratan
                    </label>
                    <select name="status" required
                        class="w-full border border-gray-300 rounded-lg px-3.5 py-2 text-sm focus:border-[#182635] focus:outline-none">
                        <option value="wajib" {{ old('status') == 'wajib' ? 'selected' : '' }}>Wajib</option>
                        <option value="opsional" {{ old('status') == 'opsional' ? 'selected' : '' }}>Opsional</option>
                    </select>
                </div>

                {{-- Footer Modal --}}
                <div class="flex items-center justify-end gap-2 pt-4 border-t border-gray-100">
                    <button type="button"
                            @click="openModal = false"
                            class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 text-sm font-medium transition cursor-pointer">
                        Batal
                    </button>

                    <button type="submit"
                            class="bg-[#182635] hover:bg-[#263b50] text-white px-5 py-2 rounded-lg text-sm font-medium transition cursor-pointer">
                        <i class="fa-solid fa-save mr-1.5"></i>
                        Simpan Persyaratan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- DAFTAR PERSYARATAN --}}
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">

        <div class="p-5 border-b border-gray-100">
            <h2 class="font-bold text-gray-800">
                Daftar Persyaratan Khusus
            </h2>
            <p class="text-xs text-gray-500 mt-1">
                Persyaratan yang kamu buat untuk ekstrakurikulermu.
            </p>
        </div>

        @forelse($persyaratans as $item)

            <div class="p-5 border-b border-gray-100 last:border-0">

                <form action="{{ route('pembina.persyaratan.update', $item->id) }}"
                      method="POST"
                      class="space-y-3">

                    @csrf
                    @method('PUT')

                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">

                        <div>
                            <h3 class="font-bold text-gray-800">
                                {{ $item->nama }}
                            </h3>

                            <p class="text-xs text-gray-500 mt-1">
                                <i class="fa-solid fa-graduation-cap mr-1"></i>
                                {{ $item->ekstrakurikuler->nama ?? '-' }}
                            </p>
                        </div>

                        <div class="flex gap-2">
                            <span class="text-xs px-3 py-1 rounded-full bg-blue-50 text-blue-700 font-semibold">
                                {{ ucfirst($item->tipe_persyaratan) }}
                            </span>

                            <span class="text-xs px-3 py-1 rounded-full
                                {{ $item->status == 'wajib'
                                    ? 'bg-red-50 text-red-600'
                                    : 'bg-gray-100 text-gray-600' }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </div>

                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">

                        <div class="sm:col-span-1">
                            <label class="text-xs font-semibold text-gray-600 mb-1 block">
                                Nama Persyaratan
                            </label>

                            <input type="text"
                                   name="nama"
                                   value="{{ $item->nama }}"
                                   required
                                   class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                        </div>

                        <div>
                            <label class="text-xs font-semibold text-gray-600 mb-1 block">
                                Tipe
                            </label>

                            <select name="tipe_persyaratan"
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">

                                <option value="teks" {{ strtolower($item->tipe_persyaratan) == 'teks' ? 'selected' : '' }}>
                                    Teks
                                </option>

                                <option value="dokumen" {{ strtolower($item->tipe_persyaratan) == 'dokumen' ? 'selected' : '' }}>
                                    Dokumen
                                </option>

                                <option value="gambar" {{ strtolower($item->tipe_persyaratan) == 'gambar' ? 'selected' : '' }}>
                                    Gambar
                                </option>

                            </select>
                        </div>

                        <div>
                            <label class="text-xs font-semibold text-gray-600 mb-1 block">
                                Status
                            </label>

                            <select name="status"
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">

                                <option value="wajib" {{ $item->status == 'wajib' ? 'selected' : '' }}>
                                    Wajib
                                </option>

                                <option value="opsional" {{ $item->status == 'opsional' ? 'selected' : '' }}>
                                    Opsional
                                </option>

                            </select>
                        </div>

                    </div>

                    <div class="flex flex-wrap justify-end gap-2">

                        <button type="submit"
                                class="px-4 py-2 rounded-lg bg-[#182635] hover:bg-[#263b50] text-white text-xs font-bold cursor-pointer">
                            <i class="fa-solid fa-save mr-1"></i>
                            Simpan Perubahan
                        </button>

                    </div>

                </form>

                <form action="{{ route('pembina.persyaratan.destroy', $item->id) }}"
                      method="POST"
                      class="flex justify-end mt-2"
                      onsubmit="return confirm('Yakin ingin menghapus persyaratan ini?')">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            class="px-4 py-2 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 text-xs font-bold cursor-pointer">
                        <i class="fa-solid fa-trash mr-1"></i>
                        Hapus
                    </button>

                </form>

            </div>

        @empty

            <div class="p-10 text-center">
                <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-3 text-gray-400">
                    <i class="fa-solid fa-clipboard-list text-xl"></i>
                </div>

                <h3 class="font-bold text-gray-700">
                    Belum Ada Persyaratan Khusus
                </h3>

                <p class="text-sm text-gray-500 mt-1 mb-4">
                    Klik tombol di bawah untuk mulai menambahkan persyaratan.
                </p>

                <button type="button"
                        @click="openModal = true"
                        class="inline-flex items-center gap-2 bg-[#182635] hover:bg-[#263b50] text-white text-xs font-semibold px-4 py-2.5 rounded-lg transition cursor-pointer">
                    <i class="fa-solid fa-plus"></i>
                    Tambah Persyaratan Pertama
                </button>
            </div>

        @endforelse

    </div>

</div>

@endsection