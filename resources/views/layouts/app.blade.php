<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bug Priority Analyzer') - Penentuan Prioritas Bug</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Meta SEO -->
    <meta name="description" content="Bug Priority Analyzer adalah aplikasi web pembanding metode Fuzzy Mamdani, Sugeno, dan Tsukamoto untuk menentukan prioritas perbaikan bug software.">
    <meta name="author" content="Tim AI TRPL">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script>
        // Inisialisasi tema sebelum halaman dirender untuk menghindari flicker
        if (localStorage.getItem('theme') === 'light') {
            document.documentElement.classList.remove('dark');
        } else {
            document.documentElement.classList.add('dark');
        }
    </script>
</head>
<body class="bg-bg-light text-text-light dark:bg-bg-dark dark:text-text-dark min-h-screen flex flex-col transition-colors duration-300 font-sans">

    <!-- Sticky Navbar -->
    @include('layouts.navbar')

    <!-- Main Content -->
    <main class="flex-grow container mx-auto px-4 py-8 max-w-7xl">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('layouts.footer')

    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom Page Script -->
    @yield('scripts')
</body>
</html>
