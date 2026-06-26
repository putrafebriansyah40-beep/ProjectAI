@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<!-- Hero Section -->
<section class="relative py-20 overflow-hidden flex flex-col items-center justify-center text-center">
    <div class="absolute inset-0 bg-gradient-to-b from-blue-500/10 to-transparent dark:from-cyan-900/20 dark:to-transparent pointer-events-none rounded-3xl"></div>
    
    <div class="relative z-10 max-w-4xl px-4">
        <div class="inline-block px-4 py-1.5 rounded-full bg-blue-100 text-blue-700 dark:bg-cyan-900/30 dark:text-cyan-300 text-sm font-semibold mb-6 animate-fade-in-up">
            <i class="fas fa-microchip mr-2"></i> Artificial Intelligence
        </div>
        
        <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight mb-6">
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500 dark:from-cyan-400 dark:to-blue-500">Bug Priority</span> Analyzer
        </h1>
        
        <p class="text-lg md:text-xl text-gray-600 dark:text-gray-300 mb-10 max-w-3xl mx-auto leading-relaxed">
            Sistem cerdas penentuan prioritas perbaikan bug software menggunakan metode komparatif 
            <strong class="text-blue-600 dark:text-cyan-400">Fuzzy Mamdani, Sugeno, dan Tsukamoto</strong>.
        </p>
        
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('simulasi') }}" class="w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white rounded-xl font-bold text-lg shadow-lg shadow-blue-500/30 transition-all hover:-translate-y-1">
                <i class="fas fa-play mr-2"></i> Mulai Simulasi
            </a>
            <a href="{{ route('materi') }}" class="w-full sm:w-auto px-8 py-4 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 border-2 border-gray-200 dark:border-gray-700 hover:border-cyan-500 dark:hover:border-cyan-400 hover:text-cyan-600 dark:hover:text-cyan-400 rounded-xl font-bold text-lg shadow-sm transition-all hover:-translate-y-1">
                <i class="fas fa-book-open mr-2"></i> Pelajari Fuzzy
            </a>
        </div>
    </div>
</section>

<!-- Apa itu Fuzzy Logic -->
<section class="py-16">
    <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 md:p-12 shadow-xl border border-gray-100 dark:border-gray-700/50 relative overflow-hidden">
        <div class="absolute top-0 right-0 p-8 opacity-5 dark:opacity-10 pointer-events-none">
            <i class="fas fa-brain text-9xl text-cyan-500"></i>
        </div>
        <div class="relative z-10 max-w-3xl">
            <h2 class="text-3xl font-bold mb-4 flex items-center text-gray-800 dark:text-gray-100">
                <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-cyan-400 flex items-center justify-center mr-4">
                    <i class="fas fa-network-wired"></i>
                </div>
                Definisi Fuzzy Logic
            </h2>
            <p class="text-gray-600 dark:text-gray-300 text-lg leading-relaxed mb-4">
                Logika Fuzzy adalah sebuah pendekatan komputasi yang berbasis pada "derajat kebenaran" (degrees of truth) alih-alih logika Boolean "benar atau salah" (1 atau 0) pada komputer modern.
            </p>
            <p class="text-gray-600 dark:text-gray-300 text-lg leading-relaxed">
                Dalam konteks sistem ini, Fuzzy Logic digunakan untuk mengatasi ambiguitas parameter pengukuran kualitas software seperti <em>Severity</em> (keparahan) dan <em>Impact</em> (dampak) untuk menghasilkan label prioritas secara objektif.
            </p>
        </div>
    </div>
</section>

<!-- Metode Section -->
<section class="py-16">
    <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-4">Metode Inferensi</h2>
        <p class="text-gray-500 dark:text-gray-400">Tiga pendekatan kalkulasi yang digunakan dalam aplikasi ini</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Mamdani -->
        <div class="group bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 dark:border-gray-700/50 hover:border-blue-500/50 dark:hover:border-cyan-500/50 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-400 to-blue-600 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></div>
            <div class="w-14 h-14 bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-cyan-400 rounded-xl flex items-center justify-center text-2xl mb-6">
                <i class="fas fa-chart-area"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 dark:text-white mb-3">Mamdani</h3>
            <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                Metode konvensional dengan intuitif tertinggi. Output dari aturan Fuzzy berupa himpunan fuzzy (area), yang kemudian didefuzzifikasi menggunakan teknik titik berat (Centroid).
            </p>
        </div>

        <!-- Sugeno -->
        <div class="group bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 dark:border-gray-700/50 hover:border-cyan-500/50 dark:hover:border-blue-500/50 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-cyan-400 to-blue-500 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></div>
            <div class="w-14 h-14 bg-cyan-50 dark:bg-cyan-900/20 text-cyan-600 dark:text-cyan-400 rounded-xl flex items-center justify-center text-2xl mb-6">
                <i class="fas fa-chart-line"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 dark:text-white mb-3">Sugeno</h3>
            <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                Dikenal dengan Zero-Order. Konsekuen dari rule tidak berupa himpunan fuzzy, melainkan nilai konstan skalar matematis. Sangat efisien dalam komputasi linier.
            </p>
        </div>

        <!-- Tsukamoto -->
        <div class="group bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 dark:border-gray-700/50 hover:border-teal-500/50 dark:hover:border-teal-400/50 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-teal-400 to-cyan-500 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></div>
            <div class="w-14 h-14 bg-teal-50 dark:bg-teal-900/20 text-teal-600 dark:text-cyan-400 rounded-xl flex items-center justify-center text-2xl mb-6">
                <i class="fas fa-wave-square"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 dark:text-white mb-3">Tsukamoto</h3>
            <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                Menggunakan representasi himpunan fuzzy yang monoton secara tegas pada bagian konsekuennya. Hasil inferensi merupakan gabungan himpunan dengan Weighted Average.
            </p>
        </div>
    </div>
</section>

<!-- System Flow Section -->
<section class="py-16 mb-8">
    <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-4">Alur Sistem</h2>
        <p class="text-gray-500 dark:text-gray-400">Bagaimana proses penentuan prioritas bug dilakukan</p>
    </div>

    <div class="flex flex-col md:flex-row items-center justify-between gap-4 md:gap-0">
        <!-- Step 1 -->
        <div class="flex flex-col items-center w-full md:w-1/5 relative">
            <div class="w-20 h-20 rounded-full bg-white dark:bg-gray-800 shadow-lg border-2 border-blue-500 dark:border-cyan-500 flex items-center justify-center text-2xl text-blue-600 dark:text-cyan-400 z-10 mb-4">
                <i class="fas fa-keyboard"></i>
            </div>
            <h4 class="font-bold text-gray-800 dark:text-white text-center">Input Bug</h4>
            <p class="text-sm text-gray-500 dark:text-gray-400 text-center mt-2">Data Crisp (0-100)</p>
            <div class="hidden md:block absolute top-10 left-1/2 w-full h-0.5 bg-gray-200 dark:bg-gray-700 -z-10"></div>
        </div>

        <!-- Step 2 -->
        <div class="flex flex-col items-center w-full md:w-1/5 relative">
            <div class="w-20 h-20 rounded-full bg-white dark:bg-gray-800 shadow-lg border-2 border-blue-500 dark:border-cyan-500 flex items-center justify-center text-2xl text-blue-600 dark:text-cyan-400 z-10 mb-4">
                <i class="fas fa-filter"></i>
            </div>
            <h4 class="font-bold text-gray-800 dark:text-white text-center">Fuzzifikasi</h4>
            <p class="text-sm text-gray-500 dark:text-gray-400 text-center mt-2">Ubah ke nilai Linguistik</p>
            <div class="hidden md:block absolute top-10 left-1/2 w-full h-0.5 bg-gray-200 dark:bg-gray-700 -z-10"></div>
        </div>

        <!-- Step 3 -->
        <div class="flex flex-col items-center w-full md:w-1/5 relative">
            <div class="w-20 h-20 rounded-full bg-white dark:bg-gray-800 shadow-lg border-2 border-blue-500 dark:border-cyan-500 flex items-center justify-center text-2xl text-blue-600 dark:text-cyan-400 z-10 mb-4">
                <i class="fas fa-cogs"></i>
            </div>
            <h4 class="font-bold text-gray-800 dark:text-white text-center">Inferensi</h4>
            <p class="text-sm text-gray-500 dark:text-gray-400 text-center mt-2">Evaluasi 27 Rule (MIN/MAX)</p>
            <div class="hidden md:block absolute top-10 left-1/2 w-full h-0.5 bg-gray-200 dark:bg-gray-700 -z-10"></div>
        </div>

        <!-- Step 4 -->
        <div class="flex flex-col items-center w-full md:w-1/5 relative">
            <div class="w-20 h-20 rounded-full bg-white dark:bg-gray-800 shadow-lg border-2 border-blue-500 dark:border-cyan-500 flex items-center justify-center text-2xl text-blue-600 dark:text-cyan-400 z-10 mb-4">
                <i class="fas fa-compress-arrows-alt"></i>
            </div>
            <h4 class="font-bold text-gray-800 dark:text-white text-center">Defuzzifikasi</h4>
            <p class="text-sm text-gray-500 dark:text-gray-400 text-center mt-2">Ubah kembali ke Crisp</p>
            <div class="hidden md:block absolute top-10 left-1/2 w-full h-0.5 bg-gray-200 dark:bg-gray-700 -z-10"></div>
        </div>

        <!-- Step 5 -->
        <div class="flex flex-col items-center w-full md:w-1/5 relative">
            <div class="w-20 h-20 rounded-full bg-gradient-to-r from-blue-600 to-cyan-500 shadow-lg shadow-cyan-500/40 flex items-center justify-center text-2xl text-white z-10 mb-4 transform scale-110">
                <i class="fas fa-flag"></i>
            </div>
            <h4 class="font-bold text-blue-600 dark:text-cyan-400 text-center">Prioritas</h4>
            <p class="text-sm text-gray-500 dark:text-gray-400 text-center mt-2">Label: Critical, High, dll.</p>
        </div>
    </div>
</section>

@endsection
