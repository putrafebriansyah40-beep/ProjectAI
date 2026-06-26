@extends('layouts.app')

@section('title', 'Tentang Sistem')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="text-center mb-12">
        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-800 dark:text-white mb-4">
            Tentang <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500">Aplikasi</span>
        </h1>
        <p class="text-gray-600 dark:text-gray-300">
            Informasi pengembang dan detail dari Sistem Pakar Bug Priority Analyzer.
        </p>
    </div>

    <!-- Info Card -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-lg border border-gray-100 dark:border-gray-700 mb-8 relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 text-gray-50 dark:text-gray-700/20 text-[12rem]">
            <i class="fas fa-info-circle"></i>
        </div>
        <div class="relative z-10">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Deskripsi Proyek</h2>
            <p class="text-gray-600 dark:text-gray-300 leading-relaxed mb-4">
                <strong>Bug Priority Analyzer</strong> adalah sebuah purwarupa sistem pakar kecerdasan buatan (AI) yang diciptakan untuk membantu Tim Jaminan Mutu (Quality Assurance) dan Perangkat Lunak (Software Engineering) dalam memutuskan dan mengklasifikasikan tiket laporan Bug.
            </p>
            <p class="text-gray-600 dark:text-gray-300 leading-relaxed mb-8">
                Sistem ini tidak hanya menggunakan satu, melainkan menandingkan tiga arsitektur inferensi sistem Logika Fuzzy yang paling populer (Mamdani, Sugeno, dan Tsukamoto) dalam memproses parameter masukan untuk mencapai konklusi prioritas yang paling masuk akal bagi perusahaan.
            </p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Stack Info -->
                <div class="bg-gray-50 dark:bg-gray-700/50 p-6 rounded-xl border border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4 flex items-center">
                        <i class="fas fa-layer-group text-blue-500 mr-2"></i> Teknologi
                    </h3>
                    <ul class="space-y-3">
                        <li class="flex items-center text-gray-600 dark:text-gray-300"><i class="fab fa-laravel text-red-500 w-6"></i> Laravel 13 Framework</li>
                        <li class="flex items-center text-gray-600 dark:text-gray-300"><i class="fab fa-css3-alt text-blue-500 w-6"></i> Tailwind CSS V4</li>
                        <li class="flex items-center text-gray-600 dark:text-gray-300"><i class="fas fa-database text-gray-500 w-6"></i> SQLite / MySQL Database</li>
                        <li class="flex items-center text-gray-600 dark:text-gray-300"><i class="fab fa-js-square text-yellow-500 w-6"></i> Vanilla JavaScript</li>
                    </ul>
                </div>
                
                <!-- Developer Info -->
                <div class="bg-gray-50 dark:bg-gray-700/50 p-6 rounded-xl border border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4 flex items-center">
                        <i class="fas fa-user-graduate text-cyan-500 mr-2"></i> Pengembang
                    </h3>
                    <div class="flex items-start">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-full flex items-center justify-center text-white font-bold text-xl mr-4 shrink-0 shadow-md">
                            AI
                        </div>
                        <div>
                            <p class="font-bold text-gray-800 dark:text-white text-lg">Project Mahasiswa</p>
                            <p class="text-blue-600 dark:text-cyan-400 text-sm mb-2 font-medium">Mata Kuliah Kecerdasan Buatan (AI)</p>
                            <p class="text-gray-500 dark:text-gray-400 text-sm italic">"Semester 4 - Program Studi TRPL. Membangun fondasi sistem pakar tingkat lanjut yang dapat diandalkan."</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
