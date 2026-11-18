<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login Admin - EskaHub</title>

    {{-- Tailwind CSS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Font Inter --}}
    <link
        rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
    >

    {{-- Lucide Icons --}}
    <script src="https://unpkg.com/lucide@latest"></script>
</head>


<body class="m-0 min-h-screen bg-white text-[#12181f] font-['Inter',sans-serif]">

    {{-- =========================
         LOGIN CONTAINER
    ========================== --}}
    <div class="min-h-screen flex items-center justify-center p-5">


        {{-- =========================
             LOGIN CARD
        ========================== --}}
        <div
            class="w-full max-w-[380px] bg-white border border-[#d9dee5] rounded-[5px] border-t-4 border-t-[#1c3044] px-[27px] pt-[25px] pb-5 max-[480px]:px-5"
        >


            {{-- =========================
                 HEADER
            ========================== --}}
            <div class="text-center mb-[22px]">

                <h1 class="text-[15px] font-bold text-[#12181f] mb-2">
                    Login sebagai admin
                </h1>

                <p class="text-[8px] leading-[1.6] text-[#6b7280] max-w-[250px] mx-auto">
                    Masuk ke panel administrasi untuk mengelola sistem
                    ekstrakurikuler.
                </p>

            </div>


            {{-- =========================
                 ERROR MESSAGE
            ========================== --}}
           @error('email')
    <p class="text-red-500 text-xs mb-3">
        {{ $message }}
    </p>
@enderror


            {{-- =========================
                 FORM
            ========================== --}}
            <form action="{{ route('admin.login.process') }}" method="POST">

                @csrf


                {{-- =========================
                     USERNAME
                ========================== --}}
                <div class="mb-[15px]">

                    <label
                        for="username"
                        class="block text-[9px] font-medium text-[#333b45] mb-[6px]"
                    >
                        Username
                    </label>


                    <div class="relative flex items-center">

                        {{-- Username Icon --}}
                        <i
                            data-lucide="user"
                            class="absolute left-2 w-3 h-3 text-[#7b8490] pointer-events-none"
                        ></i>


                        <input
                            type="text"
                            id="email"
                            name="email"
                            placeholder="Email Admin"
                            value="{{ old('email') }}"
                            required
                            class="w-full h-[31px] border border-[#d9dee5] rounded-[3px] pl-[30px] pr-2 text-[9px] text-[#12181f] outline-none transition-colors focus:border-[#1c3044] placeholder:text-[#9ca3af]"
                        >

                    </div>

                </div>


                {{-- =========================
                     PASSWORD
                ========================== --}}
                <div class="mb-[15px]">

                    <label
                        for="password"
                        class="block text-[9px] font-medium text-[#333b45] mb-[6px]"
                    >
                        Password
                    </label>


                    <div class="relative flex items-center">

                        {{-- Password Icon --}}
                        <i
                            data-lucide="lock"
                            class="absolute left-2 w-3 h-3 text-[#7b8490] pointer-events-none"
                        ></i>


                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="••••••••"
                            required
                            class="w-full h-[31px] border border-[#d9dee5] rounded-[3px] pl-[30px] pr-[30px] text-[9px] text-[#12181f] outline-none transition-colors focus:border-[#1c3044] placeholder:text-[#9ca3af]"
                        >


                        {{-- Toggle Password --}}
                        <button
                            type="button"
                            onclick="togglePassword()"
                            aria-label="Tampilkan password"
                            class="absolute right-2 flex items-center border-0 bg-transparent cursor-pointer text-[#7b8490]"
                        >

                            <i
                                data-lucide="eye"
                                id="eye-icon"
                                class="w-3 h-3"
                            ></i>

                        </button>

                    </div>

                </div>


                {{-- =========================
                     REMEMBER & FORGOT
                ========================== --}}
                <div class="flex items-center justify-between mt-1 mb-4">


                    {{-- Remember Me --}}
                    <label
                        class="flex items-center gap-[5px] text-[8px] text-[#6b7280] cursor-pointer"
                    >

                        <input
                            type="checkbox"
                            name="remember"
                            class="w-[10px] h-[10px] accent-[#1c3044] cursor-pointer"
                        >

                        <span>
                            Ingat saya
                        </span>

                    </label>


                    {{-- Forgot Password --}}
                    <a
                        href="#"
                        class="text-[8px] font-semibold text-[#12181f] no-underline hover:underline"
                    >
                        Lupa password?
                    </a>

                </div>


                {{-- =========================
                     SUBMIT
                ========================== --}}
                <button
                    type="submit"
                    class="w-full h-8 flex items-center justify-center gap-[7px] border-0 rounded-[3px] bg-[#12181f] text-white text-[9px] font-semibold cursor-pointer transition-colors hover:bg-[#263544]"
                >

                    Masuk ke Dashboard Admin

                    <i
                        data-lucide="arrow-right"
                        class="w-3 h-3"
                    ></i>

                </button>

            </form>


            {{-- =========================
                 DIVIDER
            ========================== --}}
            <div class="w-full h-px bg-[#e5e7eb] my-[17px]"></div>


            {{-- =========================
                 BACK LOGIN
            ========================== --}}
            <a
                href="#"
                class="flex items-center justify-center gap-[5px] text-[8px] text-[#4b5563] no-underline hover:text-[#12181f]"
            >

                <i
                    data-lucide="arrow-left"
                    class="w-[10px] h-[10px]"
                ></i>

                Kembali ke Login Umum

            </a>


        </div>

    </div>


    {{-- =========================
         SCRIPTS
    ========================== --}}
    <script>

        lucide.createIcons();


        function togglePassword() {

            const passwordInput =
                document.getElementById('password');

            const eyeIcon =
                document.getElementById('eye-icon');


            if (passwordInput.type === 'password') {

                passwordInput.type = 'text';

                eyeIcon.setAttribute(
                    'data-lucide',
                    'eye-off'
                );

            } else {

                passwordInput.type = 'password';

                eyeIcon.setAttribute(
                    'data-lucide',
                    'eye'
                );

            }


            lucide.createIcons();

        }

    </script>

</body>

</html>

