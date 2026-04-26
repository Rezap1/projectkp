<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz SDN 2 Cibinong - Modern Education</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; scroll-behavior: smooth; }
    </style>
</head>
{{-- PERBAIKAN: Gunakan bg-[#0f172a] (Slate 900) agar seluruh halaman punya dasar gelap --}}
<body class="antialiased bg-[#0f172a]">

    @include('layout.partials.navbar')

    {{-- PERBAIKAN: Hapus bg-inherit dan pastikan main menggunakan warna gelap yang sama --}}
    <main class="min-h-screen bg-[#0f172a]">
        @yield('konten')
    </main>

    @include('layout.partials.footer')

</body>
</html>
