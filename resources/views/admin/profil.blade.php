@extends('admin.layout')

@section('title', 'Profil Management - EskaHub')

@section('content')
<div class="min-h-screen bg-white px-6 py-8 md:px-10">
    <div class="mx-auto max-w-6xl space-y-7">

        {{-- HEADER SECTION --}}
        <div class="flex flex-col justify-between gap-4 md:flex-row md:items-end">
            <div>
                <h1 class="text-[28px] font-bold tracking-tight text-[#14212E] leading-tight">
                    Profil Management
                </h1>
                <p class="mt-1.5 text-sm text-[#475361]">
                    Manage your administrative details and security credentials.
                </p>
            </div>

            <div class="flex items-center gap-3">
                <button type="button" onclick="openActivityModal()" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3.5 py-2 text-xs font-semibold text-[#14212E] shadow-2xs hover:bg-slate-50 transition cursor-pointer">
                    <i class="fa-solid fa-clock-rotate-left text-slate-500"></i>
                    Riwayat Aktivitas Log
                </button>
                <button form="formProfil" type="submit" class="inline-flex items-center gap-2 rounded-lg bg-[#14212E] px-4 py-2 text-xs font-bold text-white shadow-2xs hover:bg-[#1E2F40] transition active:scale-95 cursor-pointer">
                    <i class="fa-solid fa-check text-[11px]"></i>
                    Simpan Perubahan
                </button>
            </div>
        </div>

        {{-- ALERTS --}}
        @if(session('success'))
            <div class="flex items-center justify-between rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">&times;</button>
            </div>
        @endif

        @if($errors->any())
            <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-xs font-medium text-rose-700">
                <ul class="list-disc pl-4 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- MAIN GRID --}}
        <div class="grid grid-cols-1 items-start gap-7 lg:grid-cols-12">

            {{-- KOLOM KIRI: PROFILE SUMMARY CARD (4 Kolom) --}}
            <div class="rounded-2xl border border-slate-200/80 bg-white p-7 shadow-[0_2px_10px_-3px_rgba(20,33,46,0.03)] lg:col-span-4">
                <div class="flex flex-col items-center text-center">
                    {{-- Avatar dengan Tombol Kamera di Sudut Kanan Bawah --}}
                    <div class="relative mb-5">
                        <div class="h-28 w-28 overflow-hidden rounded-2xl bg-slate-100 ring-1 ring-slate-200/80">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->nama) }}&background=14212E&color=fff&size=256&bold=true"
                                 alt="{{ $user->nama }}"
                                 class="h-full w-full object-cover">
                        </div>
                       
                    </div>

                    <h2 class="text-lg font-bold tracking-tight text-[#14212E]">
                        {{ $user->nama }}
                    </h2>
                    <p class="mt-0.5 text-xs font-medium text-slate-400">
                        Chief Administrator
                    </p>

                    {{-- Pill Status Kuning --}}
                    <span class="mt-3.5 inline-flex items-center rounded-full bg-[#F7B500] px-4 py-1 text-[11px] font-bold text-[#14212E]">
                        Active Status
                    </span>
                </div>

                {{-- Divider --}}
                <div class="my-6 border-t border-slate-100"></div>

                {{-- Bottom Stats --}}
                <div class="grid grid-cols-2 text-center">
                    <div>
                        <p class="text-xl font-extrabold text-[#14212E]">12</p>
                        <p class="mt-0.5 text-[11px] font-medium text-slate-400">Years Active</p>
                    </div>
                    <div>
                        <p class="text-xl font-extrabold text-[#14212E]">4,592</p>
                        <p class="mt-0.5 text-[11px] font-medium text-slate-400">Logins</p>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: INFORMASI PRIBADI & KEAMANAN (8 Kolom) --}}
            <div class="space-y-7 lg:col-span-8">

                {{-- CARD 1: INFORMASI PRIBADI --}}
                <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-[0_2px_10px_-3px_rgba(20,33,46,0.03)]">
                    {{-- Header Abu-Abu Lembut seperti Desain --}}
                    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-200/70 bg-[#E5E7EB]/70 px-6 py-4">
                        <div>
                            <h3 class="text-base font-bold text-[#14212E]">Informasi Pribadi</h3>
                            <p class="mt-0.5 text-xs text-[#475361]">
                                Kelola informasi data diri administratif dan kontak resmi sekolah.
                            </p>
                        </div>
                        <span class="rounded-md bg-[#14212E] px-3 py-1 text-[10px] font-bold tracking-wide text-white">
                            Data Terverifikasi
                        </span>
                    </div>

                    <form id="formProfil" action="{{ route('admin.profil.update') }}" method="POST" class="p-6 space-y-5">
                        @csrf
                        @method('PUT')

                        {{-- Baris 1: Nama Lengkap & Jabatan (2 Kolom) --}}
                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                            <div>
                                <label class="mb-1.5 block text-xs font-bold text-[#14212E]">Nama Lengkap</label>
                                <input type="text"
                                       name="nama"
                                       value="{{ old('nama', $user->nama) }}"
                                       required
                                       class="w-full rounded-lg border border-slate-200 bg-white px-3.5 py-2.5 text-sm font-medium text-[#14212E] focus:border-[#14212E] focus:outline-none transition">
                            </div>
                            <div>
                                <label class="mb-1.5 block text-xs font-bold text-[#14212E]">Gelar Profesional / Jabatan</label>
                                <input type="text"
                                       value="Chief Administrator"
                                       readonly
                                       class="w-full cursor-not-allowed rounded-lg border border-slate-200 bg-slate-50/70 px-3.5 py-2.5 text-sm font-medium text-slate-600">
                            </div>
                        </div>

                        {{-- Baris 2: Alamat Email (Full Width seperti Referensi) --}}
                        <div>
                            <label class="mb-1.5 block text-xs font-bold text-[#14212E]">Alamat Email</label>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                    <i class="fa-regular fa-envelope text-sm"></i>
                                </span>
                                <input type="email"
                                       name="email"
                                       value="{{ old('email', $user->email) }}"
                                       required
                                       class="w-full rounded-lg border border-slate-200 bg-white py-2.5 pl-10 pr-4 text-sm font-medium text-[#14212E] focus:border-[#14212E] focus:outline-none transition">
                            </div>
                            <p class="mt-1.5 text-[11px] text-slate-400">
                                Alamat email ini digunakan untuk login sistem dan notifikasi kedinasan resmi.
                            </p>
                        </div>

                        {{-- Baris 3: Nomor Telepon / Username (Full Width seperti Referensi) --}

                        {{-- Action Buttons --}}
                        <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-5">
                            <button type="reset" class="rounded-lg bg-[#F7B500] px-4 py-2 text-xs font-bold text-[#14212E] hover:bg-[#E5A700] transition cursor-pointer">
                                Batal
                            </button>
                            <button type="submit" class="rounded-lg bg-[#14212E] px-5 py-2 text-xs font-bold text-white hover:bg-[#1E2F40] transition cursor-pointer">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>

                {{-- CARD 2: PENGATURAN KEAMANAN --}}
                
                <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-[0_2px_10px_-3px_rgba(20,33,46,0.03)]">
                    {{-- Header Abu-Abu Lembut --}}
                    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-200/70 bg-[#E5E7EB]/70 px-6 py-4">
                        <div>
                            <h3 class="text-base font-bold text-[#14212E]">Pengaturan Keamanan</h3>
                            <p class="mt-0.5 text-xs text-[#475361]">
                                Perbarui kata sandi dan amankan otoritas kredensial Anda.
                            </p>
                        </div>
                        <span class="inline-flex items-center gap-1.5 rounded-md bg-emerald-100 px-2.5 py-1 text-[10px] font-bold text-emerald-700">
                            <i class="fa-solid fa-circle-check text-[10px]"></i> 2FA Aktif
                        </span>
                    </div>

                    {{-- Form Update Password --}}
                    <form action="{{ route('admin.profil.password') }}" method="POST" class="p-6 space-y-5">
                        @csrf
                        @method('PUT')

                        {{-- Kata Sandi Saat Ini (Terisi & Tidak Bisa Diubah) --}}
                        <div>
                            <label class="mb-1.5 block text-xs font-bold text-[#14212E]">Kata Sandi Saat Ini</label>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                    <i class="fa-solid fa-lock text-xs"></i>
                                </span>
                                <input type="password"
                                       id="password_saat_ini"
                                       value="••••••••••••"
                                       readonly
                                       disabled
                                       class="w-full cursor-not-allowed rounded-lg border border-slate-200 bg-slate-50/80 py-2.5 pl-10 pr-10 text-sm font-medium text-slate-500 select-none">
                                <button type="button"
                                        onclick="togglePassword('password_saat_ini', this)"
                                        class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-[#14212E] transition cursor-pointer">
                                    <i class="fa-regular fa-eye text-xs"></i>
                                </button>
                            </div>
                        </div>

                        {{-- Kata Sandi Baru & Konfirmasi --}}
                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                            <div>
                                <label class="mb-1.5 block text-xs font-bold text-[#14212E]">Kata Sandi Baru</label>
                                <div class="relative">
                                    <input type="password"
                                           id="kata_sandi"
                                           name="kata_sandi"
                                           required
                                           placeholder="Masukkan kata sandi baru"
                                           class="w-full rounded-lg border border-slate-200 bg-white py-2.5 pl-3.5 pr-10 text-sm text-[#14212E] placeholder:text-slate-400 focus:border-[#14212E] focus:outline-none transition">
                                    <button type="button"
                                            onclick="togglePassword('kata_sandi', this)"
                                            class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-[#14212E] transition cursor-pointer">
                                        <i class="fa-regular fa-eye text-xs"></i>
                                    </button>
                                </div>
                            </div>

                            <div>
                                <label class="mb-1.5 block text-xs font-bold text-[#14212E]">Konfirmasi Kata Sandi Baru</label>
                                <div class="relative">
                                    <input type="password"
                                           id="kata_sandi_confirmation"
                                           name="kata_sandi_confirmation"
                                           required
                                           placeholder="Ulangi kata sandi baru"
                                           class="w-full rounded-lg border border-slate-200 bg-white py-2.5 pl-3.5 pr-10 text-sm text-[#14212E] placeholder:text-slate-400 focus:border-[#14212E] focus:outline-none transition">
                                    <button type="button"
                                            onclick="togglePassword('kata_sandi_confirmation', this)"
                                            class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-[#14212E] transition cursor-pointer">
                                        <i class="fa-regular fa-eye text-xs"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- Info Box --}}
                        <div class="flex items-start gap-3 rounded-xl bg-[#E5E7EB]/60 p-3.5 text-xs leading-relaxed text-[#475361]">
                            <i class="fa-solid fa-circle-info mt-0.5 text-blue-600"></i>
                            <p>Password must be at least 8 characters long and contain a combination of letters, numbers, and symbols for better security.</p>
                        </div>

                        <div class="flex justify-end pt-1">
                            <button type="submit" class="rounded-lg bg-[#14212E] px-5 py-2.5 text-xs font-bold text-white hover:bg-[#1E2F40] transition cursor-pointer">
                                Perbarui Kata Sandi
                            </button>
                        </div>
                    </form>
                </div>


            </div>
        </div>
    </div>
</div>

{{-- SCRIPT TOGGLE SHOW/HIDE PASSWORD (Taruh di bagian bawah sebelum @endsection) --}}
<script>
    function togglePassword(inputId, btn) {
        const input = document.getElementById(inputId);
        const icon = btn.querySelector('i');

        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
@endsection