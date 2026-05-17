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
<body class="theme-playful antialiased bg-[#ebe6dc] text-slate-800">

    @include('layout.partials.navbar')

    <main class="min-h-screen bg-[linear-gradient(180deg,#ebe6dc_0%,#efe9dd_48%,#e6eee5_100%)]">
        @yield('konten')
    </main>

</body>
</html>
