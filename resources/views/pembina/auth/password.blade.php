@extends('pembina.layouts.app') {{-- Sesuaikan dengan layout yang dipakai --}}

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-10">
    <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-lg border border-gray-200">
        <h2 class="text-2xl font-bold text-slate-800 mb-2">Wajib Ganti Password</h2>
        <p class="text-sm text-gray-500 mb-6">Demi keamanan akun, silakan buat password baru Anda.</p>

        <form action="{{ route('password.update') }}" method="POST">
            @csrf
            
            {{-- Input Password Baru --}}
            <div class="mb-4">
                <label class="block text-sm font-bold text-gray-700 mb-1">Password Baru</label>
                <div class="relative">
                    <input type="password" id="password" name="password" required minlength="8" 
                        class="w-full rounded-xl border border-gray-300 px-4 py-3 pr-10 text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all outline-none">
                    
                    <button type="button" class="toggle-password absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none">
                        <i class="fa-regular fa-eye"></i>
                    </button>
                </div>
                @error('password') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- Input Konfirmasi Password --}}
            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-1">Konfirmasi Password Baru</label>
                <div class="relative">
                    <input type="password" id="password_confirmation" name="password_confirmation" required minlength="8" 
                        class="w-full rounded-xl border border-gray-300 px-4 py-3 pr-10 text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all outline-none">
                    
                    <button type="button" class="toggle-password absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none">
                        <i class="fa-regular fa-eye"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-white font-bold py-3 rounded-xl shadow-sm transition">
                Simpan Password Baru
            </button>
        </form>
    </div>
</div>

{{-- SCRIPT TOGGLE PASSWORD --}}
<script>
    document.querySelectorAll('.toggle-password').forEach(function(button) {
        button.addEventListener('click', function() {
            const input = this.parentElement.querySelector('input');
            const icon = this.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });
</script>
@endsection