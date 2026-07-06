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
    
    <!-- Override Browser Favicon Cache -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'%3E%3Cpath fill='%233b82f6' d='M256 0c-74.4 0-135 60.6-135 135v11c-32.3 8-57 37-57 73v22c0 30 18.5 55.7 45 66.5V368c0 48.6 39.4 88 88 88h118c48.6 0 88-39.4 88-88v-60.5c26.5-10.8 45-36.5 45-66.5v-22c0-36-24.7-65-57-73v-11c0-74.4-60.6-135-135-135zm0 40c52.4 0 95 42.6 95 95v11.8c-29.3-5-61-5-95-5s-65.7 0-95 5V135c0-52.4 42.6-95 95-95z'/%3E%3C/svg%3E">
    
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
