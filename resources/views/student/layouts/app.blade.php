<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'EskaHub - Siswa')</title>

    {{-- TAILWIND & VITE --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- FONT AWESOME --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- STYLE TAMBAHAN KHUSUS HALAMAN --}}
    @stack('styles')
</head>

<body class="flex min-h-screen flex-col justify-between bg-white text-gray-800">

    <div>
        {{-- NAVBAR PARTIAL --}}
        @include('student.layouts.partials.navbar')

        {{-- KONTEN UTAMA --}}
        <main>
            @yield('content')
        </main>
    </div>

    {{-- FOOTER PARTIAL --}}
    @include('student.layouts.partials.footer')

    {{-- SCRIPT TAMBAHAN --}}
    @stack('scripts')

</body>

</html>