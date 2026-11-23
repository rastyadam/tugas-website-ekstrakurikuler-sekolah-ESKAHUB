@extends('pembina.layouts.app')

@section('title', 'Profil Pembina - EskaHub')

@section('content')
<div class="max-w-6xl mx-auto p-6 space-y-6">

    {{-- Header --}}
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Profile</h1>
        <p class="text-sm text-slate-500 mt-1">Kelola informasi pribadi dan pengaturan akun Anda.</p>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="bg-emerald-100 text-emerald-700 p-4 rounded-xl text-sm font-semibold shadow-sm">
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded-xl text-sm font-semibold shadow-sm">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- KOLOM KIRI --}}
        <div class="lg:col-span-1 space-y-6">
            
            {{-- Card Foto & Nama --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden text-center">
                <div class="h-24 bg-[#1a2b4c]"></div>
                <div class="relative px-6 pb-6">
                    <div class="absolute -top-12 left-1/2 -translate-x-1/2">
                        <div class="w-24 h-24 rounded-xl border-4 border-white bg-slate-200 overflow-hidden shadow-md">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->nama) }}&background=random&color=fff&size=256" alt="Profile" class="w-full h-full object-cover">
                        </div>
                    </div>
                    <div class="pt-14">
                        <h2 class="text-lg font-bold text-slate-800">{{ $user->nama }}</h2>
                        <div class="mt-2 inline-block bg-[#1a2b4c] text-white text-[11px] font-bold px-4 py-1.5 rounded-full">
                            Pembina Ekstrakurikuler
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card Ekskul yang Diampu --}}
            <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
                <h3 class="text-xs font-bold text-slate-700 mb-4">Kegiatan Ekstrakurikuler yang Dilampirkan</h3>
                
                <div class="space-y-3">
                    @forelse($ekskuls as $ekskul)
                    <div class="flex items-center justify-between p-3 border border-gray-200 rounded-xl hover:bg-slate-50 transition cursor-pointer">
                        <div>
                            <p class="font-bold text-sm text-slate-800">{{ $ekskul->nama }}</p>
                            <p class="text-xs text-slate-500 mt-0.5">{{ $ekskul->kuota }} Anggota</p>
                        </div>
                        <i class="fa-solid fa-chevron-right text-gray-400 text-xs"></i>
                    </div>
                    @empty
                    <p class="text-xs text-slate-400 italic text-center py-4">Belum ada ekskul yang diampu.</p>
                    @endforelse
                </div>
            </div>

        </div>

        {{-- KOLOM KANAN --}}
        <div class="lg:col-span-2 space-y-6">
            
            {{-- Card Informasi Personal --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-base font-bold text-slate-800">Informasi Personal</h3>
                    <button onclick="toggleEdit()" id="btnEdit" class="text-xs font-semibold text-slate-600 hover:text-slate-900 flex items-center gap-1.5">
                        <i class="fa-solid fa-pen text-[10px]"></i> Edit
                    </button>
                </div>

                <div class="p-6">
                    <form id="formProfil" action="{{ route('pembina.profil.update') }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Nama</label>
                            <input type="text" name="nama" value="{{ old('nama', $user->nama) }}" disabled class="input-profil w-full px-4 py-2.5 bg-slate-50 border border-gray-300 rounded-lg text-sm text-slate-800 focus:outline-none focus:border-slate-800 transition disabled:opacity-70 disabled:cursor-not-allowed">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Email</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" disabled class="input-profil w-full px-4 py-2.5 bg-slate-50 border border-gray-300 rounded-lg text-sm text-slate-800 focus:outline-none focus:border-slate-800 transition disabled:opacity-70 disabled:cursor-not-allowed">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Nomor Telepon</label>
                                <input type="text" name="no_hp" value="{{ old('no_hp', $user->pembina->no_hp ?? '') }}" disabled class="input-profil w-full px-4 py-2.5 bg-slate-50 border border-gray-300 rounded-lg text-sm text-slate-800 focus:outline-none focus:border-slate-800 transition disabled:opacity-70 disabled:cursor-not-allowed">
                            </div>
                        </div>

                        <div id="actionButtons" class="hidden justify-end gap-3 pt-2">
                            <button type="button" onclick="toggleEdit()" class="px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-100 rounded-lg transition">Batal</button>
                            <button type="submit" class="px-5 py-2 text-sm font-bold text-white bg-[#1a2b4c] hover:bg-[#0f1c33] rounded-lg shadow-sm transition">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- SCRIPT TOGGLE EDIT --}}
<script>
    function toggleEdit() {
        const inputs = document.querySelectorAll('.input-profil');
        const btnEdit = document.getElementById('btnEdit');
        const actionButtons = document.getElementById('actionButtons');
        
        let isDisabled = inputs[0].disabled;

        inputs.forEach(input => {
            input.disabled = !isDisabled;
            if (isDisabled) {
                input.classList.remove('bg-slate-50', 'disabled:opacity-70');
                input.classList.add('bg-white');
            } else {
                input.classList.add('bg-slate-50', 'disabled:opacity-70');
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