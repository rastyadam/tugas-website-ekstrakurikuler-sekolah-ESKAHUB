@extends('pembina.layouts.app')

@section('title', 'Profil Pembina - EskaHub')

@section('content')
<div class="min-h-screen bg-slate-50/70 text-gray-800">
    <main class="max-w-5xl mx-auto px-4 sm:px-6 py-6 sm:py-8 space-y-6">

        <!-- Header -->
        <div class="border-b border-gray-200 pb-4">
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Profil Pembina</h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-0.5">Kelola informasi pribadi dan data akun Anda.</p>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-md text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-md text-sm">
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Kartu Identitas Singkat -->
        <section class="bg-white border border-gray-200 rounded-lg p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-4 min-w-0">
                <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-lg bg-amber-600 text-white font-bold text-lg sm:text-xl flex items-center justify-center shrink-0 overflow-hidden">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->nama) }}&background=d97706&color=fff&size=256"
                         alt="{{ $user->nama }}"
                         class="w-full h-full object-cover">
                </div>

                <div class="min-w-0">
                    <h2 class="text-base sm:text-lg font-bold text-gray-900 truncate">{{ $user->nama }}</h2>
                    <div class="flex flex-wrap items-center gap-2 mt-1">
                        <span class="text-xs font-medium bg-amber-100/80 text-amber-900 px-2.5 py-0.5 rounded">
                            Pembina Ekstrakurikuler
                        </span>
                        <span class="text-xs text-gray-400 truncate">{{ $user->email }}</span>
                    </div>
                </div>
            </div>

            <div class="text-xs text-gray-500 sm:text-right shrink-0">
                <span class="font-semibold text-gray-800 tabular-nums">{{ $ekskuls->count() }}</span> ekskul diampu
            </div>
        </section>

        <!-- Form Informasi Personal -->
        <section class="bg-white border border-gray-200 rounded-lg overflow-hidden">
            <div class="px-4 sm:px-6 py-3.5 bg-gray-50 border-b border-gray-200 flex items-center justify-between gap-2">
                <h3 class="text-xs sm:text-sm font-bold text-gray-900">Informasi Personal</h3>

                <button type="button"
                        onclick="toggleEdit()"
                        id="btnEdit"
                        class="text-xs font-semibold text-amber-700 hover:text-amber-800 px-2.5 py-1 rounded hover:bg-amber-50 transition cursor-pointer">
                    Edit Profil
                </button>
            </div>

            <div class="p-4 sm:p-6">
                <form id="formProfil" action="{{ route('pembina.profil.update') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Nama Lengkap</label>
                            <input type="text"
                                   name="nama"
                                   value="{{ old('nama', $user->nama) }}"
                                   disabled
                                   class="input-profil w-full px-3.5 py-2 bg-gray-50 border border-gray-300 rounded-md text-xs sm:text-sm text-gray-900 focus:outline-none focus:border-amber-600 disabled:text-gray-600 disabled:cursor-not-allowed">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Email</label>
                            <input type="email"
                                   name="email"
                                   value="{{ old('email', $user->email) }}"
                                   disabled
                                   class="input-profil w-full px-3.5 py-2 bg-gray-50 border border-gray-300 rounded-md text-xs sm:text-sm text-gray-900 focus:outline-none focus:border-amber-600 disabled:text-gray-600 disabled:cursor-not-allowed">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Nomor Telepon</label>
                            <input type="text"
                                   name="no_hp"
                                   value="{{ old('no_hp', $user->pembina->no_hp ?? '') }}"
                                   disabled
                                   class="input-profil w-full px-3.5 py-2 bg-gray-50 border border-gray-300 rounded-md text-xs sm:text-sm text-gray-900 focus:outline-none focus:border-amber-600 disabled:text-gray-600 disabled:cursor-not-allowed">
                        </div>
                    </div>

                    <div id="actionButtons" class="hidden flex-col-reverse sm:flex-row justify-end gap-2 pt-3 border-t border-gray-100">
                        <button type="button"
                                onclick="toggleEdit()"
                                class="w-full sm:w-auto px-4 py-2 text-xs font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 rounded-md transition cursor-pointer">
                            Batal
                        </button>
                        <button type="submit"
                                class="w-full sm:w-auto px-4 py-2 text-xs font-semibold text-white bg-amber-600 hover:bg-amber-700 rounded-md transition cursor-pointer">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </section>

        <!-- Daftar Ekskul Diampu -->
        <section class="bg-white border border-gray-200 rounded-lg p-4 sm:p-6">
            <div class="flex items-center justify-between pb-3 mb-4 border-b border-gray-100">
                <h3 class="text-xs sm:text-sm font-bold text-gray-900">Ekstrakurikuler yang Diampu</h3>
                <span class="text-xs text-gray-400 tabular-nums">{{ $ekskuls->count() }} ekskul</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                @forelse($ekskuls as $ekskul)
                    <div class="p-3.5 border border-gray-200 rounded-md bg-gray-50/40 flex items-center justify-between gap-2">
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-gray-900 truncate">{{ $ekskul->nama }}</p>
                            <p class="text-xs text-gray-500 mt-0.5 tabular-nums">{{ $ekskul->kuota }} Anggota</p>
                        </div>
                        <span class="w-2 h-2 rounded-full bg-amber-600 shrink-0"></span>
                    </div>
                @empty
                    <p class="text-xs text-gray-400 col-span-full py-3 text-center">
                        Belum ada ekstrakurikuler yang diampu.
                    </p>
                @endforelse
            </div>
        </section>

    </main>
</div>

<script>
    function toggleEdit() {
        const inputs = document.querySelectorAll('.input-profil');
        const btnEdit = document.getElementById('btnEdit');
        const actionButtons = document.getElementById('actionButtons');

        const isDisabled = inputs[0].disabled;

        inputs.forEach(input => {
            input.disabled = !isDisabled;
            if (isDisabled) {
                input.classList.remove('bg-gray-50');
                input.classList.add('bg-white');
            } else {
                input.classList.add('bg-gray-50');
                input.classList.remove('bg-white');
            }
        });

        if (isDisabled) {
            btnEdit.classList.add('hidden');
            actionButtons.classList.remove('hidden');
            actionButtons.classList.add('flex');
        } else {
            btnEdit.classList.remove('hidden');
            actionButtons.classList.add('hidden');
            actionButtons.classList.remove('flex');
        }
    }
</script>
@endsection