@extends('layouts.app')

@section('title', 'Materi Fuzzy')

@section('content')
<div class="max-w-5xl mx-auto">
    <!-- Header -->
    <div class="text-center mb-16">
        <div class="inline-block px-4 py-1.5 rounded-full bg-blue-100 text-blue-700 dark:bg-cyan-900/30 dark:text-cyan-300 text-sm font-semibold mb-4">
            <i class="fas fa-book-reader mr-2"></i> Edukasi
        </div>
        <h1 class="text-4xl md:text-5xl font-extrabold text-gray-800 dark:text-white mb-4">
            Materi Pembelajaran <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500 dark:from-cyan-400 dark:to-blue-500">Logika Fuzzy</span>
        </h1>
        <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
            Pahami dasar-dasar Logika Fuzzy dan perbedaan ketiga metodenya sebelum mulai melakukan simulasi.
        </p>
    </div>

    <!-- 1. Pengertian Fuzzy Logic -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-sm border border-gray-100 dark:border-gray-700/50 mb-8 relative overflow-hidden">
        <div class="absolute -right-4 -top-4 text-gray-50 dark:text-gray-700/20 text-9xl">
            <i class="fas fa-brain"></i>
        </div>
        <div class="relative z-10">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-4 flex items-center">
                <span class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-cyan-400 flex items-center justify-center mr-3 text-sm">1</span>
                Apa itu Fuzzy Logic?
            </h2>
            <p class="text-gray-600 dark:text-gray-300 leading-relaxed mb-4">
                <strong>Logika Fuzzy</strong> diperkenalkan oleh Dr. Lotfi Zadeh pada tahun 1965. Berbeda dengan logika klasik (Boolean) yang hanya mengenal nilai Mutlak Benar (1) atau Mutlak Salah (0), Logika Fuzzy mengizinkan rentang nilai di antara keduanya. Ini merepresentasikan konsep "Derajat Kebenaran" (Degree of Truth).
            </p>
            <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                Dalam kehidupan nyata, bahasa manusia sering mengandung ketidakpastian. Misalnya kata "Panas", "Dingin", atau "Cepat". Fuzzy mentransformasi bahas linguistik ini menjadi representasi matematis menggunakan rentang dari 0 hingga 1.
            </p>
        </div>
    </div>

    <!-- Penjelasan Metode Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        
        <!-- 2. Mamdani -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700/50 hover:border-blue-500 transition-colors">
            <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-3 flex items-center">
                <span class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-cyan-400 flex items-center justify-center mr-3 text-sm">2</span>
                Metode Mamdani
            </h2>
            <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed mb-3">
                Diperkenalkan oleh Ebrahim Mamdani (1975). Sering disebut Metode Max-Min.
            </p>
            <ul class="text-gray-600 dark:text-gray-300 text-sm list-disc list-inside space-y-2">
                <li>Bentuk Aturan (Consequent) berupa Himpunan Fuzzy.</li>
                <li>Paling sesuai dengan intuisi manusia (human-like).</li>
                <li>Defuzzifikasi menggunakan teknik matematis Centroid (Titik Berat).</li>
                <li>Lebih lambat dikomputasi namun luas digunakan.</li>
            </ul>
        </div>

        <!-- 3. Sugeno -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700/50 hover:border-cyan-500 transition-colors">
            <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-3 flex items-center">
                <span class="w-8 h-8 rounded-full bg-cyan-100 dark:bg-cyan-900/40 text-cyan-600 dark:text-cyan-400 flex items-center justify-center mr-3 text-sm">3</span>
                Metode Sugeno
            </h2>
            <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed mb-3">
                Diperkenalkan oleh Takagi-Sugeno-Kang (1985). Sangat efisien di sistem kontrol.
            </p>
            <ul class="text-gray-600 dark:text-gray-300 text-sm list-disc list-inside space-y-2">
                <li>Konsekuen (Output) berupa Konstanta Skalar matematis (orde-nol) atau persamaan linier (orde-satu).</li>
                <li>Tidak memerlukan metode Centroid matematis.</li>
                <li>Defuzzifikasi menggunakan Weighted Average.</li>
                <li>Sangat cepat untuk komputasi terprogram.</li>
            </ul>
        </div>

        <!-- 4. Tsukamoto -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700/50 hover:border-teal-500 transition-colors">
            <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-3 flex items-center">
                <span class="w-8 h-8 rounded-full bg-teal-100 dark:bg-teal-900/40 text-teal-600 dark:text-teal-400 flex items-center justify-center mr-3 text-sm">4</span>
                Metode Tsukamoto
            </h2>
            <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed mb-3">
                Menjadi jalan tengah antara Mamdani dan konsep kepastian logis.
            </p>
            <ul class="text-gray-600 dark:text-gray-300 text-sm list-disc list-inside space-y-2">
                <li>Konsekuen dari setiap aturan direpresentasikan dengan Himpunan Fuzzy Monoton (Tegas).</li>
                <li>Menggunakan variabel *z* yang dihitung dari relasi alpha.</li>
                <li>Defuzzifikasi menggunakan Weighted Average layaknya Sugeno.</li>
                <li>Menghasilkan transisi yang mulus.</li>
            </ul>
        </div>

    </div>

    <!-- 5. Tabel Perbandingan -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-sm border border-gray-100 dark:border-gray-700/50 mb-8 overflow-x-auto">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6 flex items-center">
            <span class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-cyan-400 flex items-center justify-center mr-3 text-sm">5</span>
            Tabel Komparasi Karakteristik
        </h2>
        
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 dark:bg-gray-700/50">
                    <th class="p-4 border-b border-gray-200 dark:border-gray-700 font-semibold text-gray-800 dark:text-gray-200 rounded-tl-lg">Aspek</th>
                    <th class="p-4 border-b border-gray-200 dark:border-gray-700 font-semibold text-gray-800 dark:text-gray-200 text-center">Mamdani</th>
                    <th class="p-4 border-b border-gray-200 dark:border-gray-700 font-semibold text-gray-800 dark:text-gray-200 text-center">Sugeno</th>
                    <th class="p-4 border-b border-gray-200 dark:border-gray-700 font-semibold text-gray-800 dark:text-gray-200 text-center rounded-tr-lg">Tsukamoto</th>
                </tr>
            </thead>
            <tbody>
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/20 transition-colors">
                    <td class="p-4 border-b border-gray-100 dark:border-gray-700/50 text-gray-600 dark:text-gray-300 font-medium">Bentuk Output Rule</td>
                    <td class="p-4 border-b border-gray-100 dark:border-gray-700/50 text-center text-gray-500 dark:text-gray-400">Himpunan Fuzzy Biasa</td>
                    <td class="p-4 border-b border-gray-100 dark:border-gray-700/50 text-center text-gray-500 dark:text-gray-400">Konstanta / Linear</td>
                    <td class="p-4 border-b border-gray-100 dark:border-gray-700/50 text-center text-gray-500 dark:text-gray-400">Himpunan Monoton</td>
                </tr>
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/20 transition-colors">
                    <td class="p-4 border-b border-gray-100 dark:border-gray-700/50 text-gray-600 dark:text-gray-300 font-medium">Proses Agregasi</td>
                    <td class="p-4 border-b border-gray-100 dark:border-gray-700/50 text-center text-gray-500 dark:text-gray-400">Max (Menggabungkan kurva)</td>
                    <td class="p-4 border-b border-gray-100 dark:border-gray-700/50 text-center text-gray-500 dark:text-gray-400">Tidak ada penggabungan area</td>
                    <td class="p-4 border-b border-gray-100 dark:border-gray-700/50 text-center text-gray-500 dark:text-gray-400">Tidak ada penggabungan area</td>
                </tr>
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/20 transition-colors">
                    <td class="p-4 border-b border-gray-100 dark:border-gray-700/50 text-gray-600 dark:text-gray-300 font-medium">Defuzzifikasi</td>
                    <td class="p-4 border-b border-gray-100 dark:border-gray-700/50 text-center text-gray-500 dark:text-gray-400">Centroid (Titik Berat)</td>
                    <td class="p-4 border-b border-gray-100 dark:border-gray-700/50 text-center text-gray-500 dark:text-gray-400">Weighted Average</td>
                    <td class="p-4 border-b border-gray-100 dark:border-gray-700/50 text-center text-gray-500 dark:text-gray-400">Weighted Average</td>
                </tr>
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/20 transition-colors">
                    <td class="p-4 border-b border-gray-100 dark:border-gray-700/50 text-gray-600 dark:text-gray-300 font-medium">Komputasi</td>
                    <td class="p-4 border-b border-gray-100 dark:border-gray-700/50 text-center text-gray-500 dark:text-gray-400"><span class="px-2 py-1 bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 rounded-md text-xs">Rumit / Berat</span></td>
                    <td class="p-4 border-b border-gray-100 dark:border-gray-700/50 text-center text-gray-500 dark:text-gray-400"><span class="px-2 py-1 bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 rounded-md text-xs">Sangat Ringan</span></td>
                    <td class="p-4 border-b border-gray-100 dark:border-gray-700/50 text-center text-gray-500 dark:text-gray-400"><span class="px-2 py-1 bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400 rounded-md text-xs">Sedang</span></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- 6. Contoh Kasus -->
    <div class="bg-gradient-to-br from-blue-600 to-cyan-600 rounded-2xl p-8 shadow-lg mb-8 text-white">
        <h2 class="text-2xl font-bold mb-4 flex items-center">
            <span class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center mr-3 text-sm">6</span>
            Studi Kasus: Penentuan Prioritas Bug
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
            <div>
                <p class="leading-relaxed mb-4 text-blue-50">
                    Sebuah perusahaan perangkat lunak perlu mensortir perbaikan bug agar Developer tidak kebingungan mana yang harus dikerjakan terlebih dahulu.
                </p>
                <p class="leading-relaxed mb-4 text-blue-50">
                    Mereka memutuskan menggunakan AI Logika Fuzzy dengan 3 variabel input:
                </p>
                <ul class="list-disc list-inside space-y-1 text-blue-100 ml-2 mb-4">
                    <li><strong>Severity:</strong> Keparahan bug dari segi teknis (0-100)</li>
                    <li><strong>Impact:</strong> Dampak finansial / fungsional (0-100)</li>
                    <li><strong>Users:</strong> Persentase pengguna yang terdampak (0-100)</li>
                </ul>
                <p class="leading-relaxed font-semibold text-white">
                    Sistem ini kemudian menimbang dan mengeluarkan status: Low, Medium, High, atau Critical Priority.
                </p>
            </div>
            <div class="bg-black/20 rounded-xl p-6 backdrop-blur-sm border border-white/10">
                <h4 class="font-bold text-white mb-3">Contoh Perhitungan:</h4>
                <div class="space-y-3 font-mono text-sm">
                    <div class="flex justify-between border-b border-white/10 pb-2">
                        <span class="text-blue-200">Severity</span>
                        <span class="text-white">85 (Tinggi)</span>
                    </div>
                    <div class="flex justify-between border-b border-white/10 pb-2">
                        <span class="text-blue-200">Impact</span>
                        <span class="text-white">90 (Tinggi)</span>
                    </div>
                    <div class="flex justify-between border-b border-white/10 pb-2">
                        <span class="text-blue-200">Affected Users</span>
                        <span class="text-white">20 (Sedikit)</span>
                    </div>
                    <div class="flex justify-between pt-2">
                        <span class="text-cyan-200 font-bold">Hasil Prioritas AI</span>
                        <span class="bg-red-500 text-white px-2 py-0.5 rounded text-xs font-bold">CRITICAL (82)</span>
                    </div>
                </div>
                <div class="mt-6 text-center">
                    <a href="{{ route('simulasi') }}" class="inline-block px-6 py-2 bg-white text-blue-600 font-bold rounded-lg hover:bg-blue-50 transition-colors shadow-sm">
                        Coba Sendiri Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
