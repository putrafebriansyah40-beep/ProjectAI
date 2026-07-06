@extends('layouts.app')

@section('title', 'Perbandingan Metode')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="text-center mb-10">
        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-800 dark:text-white mb-4">
            Komparasi <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500">Metode Fuzzy</span>
        </h1>
        <p class="text-gray-600 dark:text-gray-300">
            Bandingkan perbedaan hasil defuzzifikasi dari Mamdani, Sugeno, dan Tsukamoto dengan parameter yang sama.
        </p>
    </div>

    <!-- Alert / Success message -->
    @if(isset($success_message))
    <div class="bg-blue-100 dark:bg-blue-900/30 border-l-4 border-blue-500 text-blue-700 dark:text-blue-400 p-4 mb-8 rounded shadow-sm flex items-center animate-fade-in-up">
        <i class="fas fa-info-circle text-xl mr-3"></i>
        {{ $success_message }}
    </div>
    @endif

    <!-- Form Section (Horizontal) -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md border border-gray-100 dark:border-gray-700/50 p-6 mb-8">
        <form action="{{ route('perbandingan.calculate') }}" method="POST">
            @csrf

            <!-- Quick Sample Data -->
            <div class="mb-5 pb-5 border-b border-gray-100 dark:border-gray-700">
                <p class="text-xs font-bold text-gray-500 dark:text-gray-400 mb-3 uppercase tracking-wider">Contoh Data Cepat:</p>
                <div class="flex flex-wrap gap-2">
                    <button type="button" onclick="fillSampleData(20, 25, 15)" class="px-3 py-1.5 text-xs font-bold bg-green-100 text-green-700 hover:bg-green-200 dark:bg-green-900/30 dark:text-green-400 dark:hover:bg-green-900/50 rounded-full transition-colors"><i class="fas fa-bolt text-[10px] mr-1"></i> Ringan</button>
                    <button type="button" onclick="fillSampleData(50, 45, 40)" class="px-3 py-1.5 text-xs font-bold bg-yellow-100 text-yellow-700 hover:bg-yellow-200 dark:bg-yellow-900/30 dark:text-yellow-400 dark:hover:bg-yellow-900/50 rounded-full transition-colors"><i class="fas fa-exclamation text-[10px] mr-1"></i> Sedang</button>
                    <button type="button" onclick="fillSampleData(75, 80, 70)" class="px-3 py-1.5 text-xs font-bold bg-orange-100 text-orange-700 hover:bg-orange-200 dark:bg-orange-900/30 dark:text-orange-400 dark:hover:bg-orange-900/50 rounded-full transition-colors"><i class="fas fa-exclamation-triangle text-[10px] mr-1"></i> Berat</button>
                    <button type="button" onclick="fillSampleData(95, 95, 90)" class="px-3 py-1.5 text-xs font-bold bg-red-100 text-red-700 hover:bg-red-200 dark:bg-red-900/30 dark:text-red-400 dark:hover:bg-red-900/50 rounded-full transition-colors"><i class="fas fa-fire text-[10px] mr-1"></i> Critical</button>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
                
                <!-- Severity -->
                <div>
                    <label for="severity" class="block text-sm font-bold text-gray-700 dark:text-gray-200 mb-2">Severity (0-100)</label>
                    <input type="number" name="severity" id="severity" value="{{ old('severity', $input['severity'] ?? 50) }}" class="w-full border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" min="0" max="100">
                    @error('severity') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Impact -->
                <div>
                    <label for="impact" class="block text-sm font-bold text-gray-700 dark:text-gray-200 mb-2">Impact (0-100)</label>
                    <input type="number" name="impact" id="impact" value="{{ old('impact', $input['impact'] ?? 50) }}" class="w-full border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" min="0" max="100">
                    @error('impact') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Affected Users -->
                <div>
                    <label for="affected_users" class="block text-sm font-bold text-gray-700 dark:text-gray-200 mb-2">Users (0-100)</label>
                    <input type="number" name="affected_users" id="affected_users" value="{{ old('affected_users', $input['affectedUsers'] ?? 50) }}" class="w-full border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" min="0" max="100">
                    @error('affected_users') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Submit Button -->
                <div class="md:col-span-1">
                    <button type="submit" class="w-full py-2.5 px-4 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white rounded-lg font-bold shadow hover:shadow-lg transition-all transform hover:-translate-y-0.5 group relative overflow-hidden flex items-center justify-center">
                        <span id="btn-text" class="flex items-center"><i class="fas fa-balance-scale mr-2 group-hover:rotate-12 transition-transform duration-300"></i> Bandingkan</span>
                        <span id="btn-loading" class="hidden flex items-center"><i class="fas fa-circle-notch fa-spin mr-2"></i> Memproses...</span>
                        <div class="absolute inset-0 h-full w-full bg-white/20 scale-0 group-active:scale-100 rounded-xl transition-transform duration-300 opacity-0 group-active:opacity-100"></div>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Results Section -->
    @if(isset($mamdaniResult))
    <div class="animate-fade-in-up">    <!-- Section Proses Perhitungan -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 mb-8">
            <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-6 border-b border-gray-100 dark:border-gray-700 pb-3">
                <i class="fas fa-microchip text-blue-500 mr-2"></i> Proses Perhitungan
            </h3>
            <div class="flex items-center justify-between relative px-2 sm:px-12">
                <!-- Garis penghubung -->
                <div class="absolute left-6 right-6 sm:left-16 sm:right-16 top-5 h-1 bg-gray-200 dark:bg-gray-700 z-0"></div>
                <div class="absolute left-6 right-6 sm:left-16 sm:right-16 top-5 h-1 bg-gradient-to-r from-blue-500 to-cyan-400 z-0 animate-pulse"></div>
                
                <!-- Steps -->
                <div class="relative z-10 flex flex-col items-center">
                    <div class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center shadow-lg animate-bounce" style="animation-delay: 0s;">
                        <i class="fas fa-keyboard"></i>
                    </div>
                    <span class="text-[10px] sm:text-xs font-bold text-gray-700 dark:text-gray-300 mt-2 text-center">Input<br>Data</span>
                </div>
                
                <div class="relative z-10 flex flex-col items-center">
                    <div class="w-10 h-10 rounded-full bg-blue-500 text-white flex items-center justify-center shadow-lg animate-bounce" style="animation-delay: 0.1s;">
                        <i class="fas fa-random"></i>
                    </div>
                    <span class="text-[10px] sm:text-xs font-bold text-gray-700 dark:text-gray-300 mt-2 text-center">Fuzzifikasi</span>
                </div>
                
                <div class="relative z-10 flex flex-col items-center">
                    <div class="w-10 h-10 rounded-full bg-cyan-600 text-white flex items-center justify-center shadow-lg animate-bounce" style="animation-delay: 0.2s;">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <span class="text-[10px] sm:text-xs font-bold text-gray-700 dark:text-gray-300 mt-2 text-center">Evaluasi<br>Rule</span>
                </div>
                
                <div class="relative z-10 flex flex-col items-center">
                    <div class="w-10 h-10 rounded-full bg-cyan-500 text-white flex items-center justify-center shadow-lg animate-bounce" style="animation-delay: 0.3s;">
                        <i class="fas fa-filter"></i>
                    </div>
                    <span class="text-[10px] sm:text-xs font-bold text-gray-700 dark:text-gray-300 mt-2 text-center">Defuzzifikasi</span>
                </div>
                
                <div class="relative z-10 flex flex-col items-center">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-cyan-500 text-white flex items-center justify-center shadow-lg animate-bounce" style="animation-delay: 0.4s;">
                        <i class="fas fa-check-double"></i>
                    </div>
                    <span class="text-[10px] sm:text-xs font-bold text-gray-700 dark:text-gray-300 mt-2 text-center">Hasil<br>Prioritas</span>
                </div>
            </div>
        </div>
        @php
            // Helper function for colors
            function getLabelColor($label) {
                switch($label) {
                    case 'Low': return 'text-green-600 dark:text-green-400 bg-green-100 dark:bg-green-900/30';
                    case 'Medium': return 'text-yellow-600 dark:text-yellow-400 bg-yellow-100 dark:bg-yellow-900/30';
                    case 'High': return 'text-orange-600 dark:text-orange-400 bg-orange-100 dark:bg-orange-900/30';
                    case 'Critical': return 'text-red-600 dark:text-red-400 bg-red-100 dark:bg-red-900/30';
                    default: return 'text-gray-600 dark:text-gray-400 bg-gray-100 dark:bg-gray-900/30';
                }
            }

            // Simple HTML Bar Chart Color
            function getBarColor($score) {
                if ($score <= 25) return 'bg-green-500';
                if ($score <= 50) return 'bg-yellow-500';
                if ($score <= 75) return 'bg-orange-500';
                return 'bg-red-500';
            }

            $labels = [
                $mamdaniResult['label'],
                $sugenoResult['label'],
                $tsukamotoResult['label']
            ];
            $isConsistent = count(array_unique($labels)) === 1;
        @endphp

        <!-- Kesimpulan Otomatis -->
        <div class="mb-8 p-6 rounded-2xl border {{ $isConsistent ? 'bg-green-50 dark:bg-green-900/20 border-green-200 dark:border-green-800' : 'bg-yellow-50 dark:bg-yellow-900/20 border-yellow-200 dark:border-yellow-800' }}">
            <div class="flex items-start">
                <div class="text-3xl mr-4 {{ $isConsistent ? 'text-green-500' : 'text-yellow-500' }}">
                    <i class="fas {{ $isConsistent ? 'fa-check-circle' : 'fa-exclamation-triangle' }}"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-1">Kesimpulan Komparasi</h3>
                    <p class="text-gray-700 dark:text-gray-300">
                        @if($isConsistent)
                            Ketiga metode menghasilkan prioritas yang konsisten. Ini menunjukkan bahwa nilai input memicu area himpunan fuzzy yang sangat dominan.
                        @else
                            Terdapat perbedaan hasil antar metode karena karakteristik inferensi yang berbeda. Mamdani berfokus pada peleburan area konstan (Max), Sugeno bertumpu pada formula ekuasi konstan, sedangkan Tsukamoto menggunakan fungsi monoton linear.
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- 3 Cards Sejajar -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Mamdani -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 text-center hover:shadow-lg transition-shadow">
                <div class="w-12 h-12 mx-auto bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-full flex items-center justify-center text-xl mb-4">
                    <i class="fas fa-chart-area"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-2">Mamdani</h3>
                <div class="text-4xl font-black text-gray-800 dark:text-white mb-3">{{ $mamdaniResult['score'] }}</div>
                <div class="inline-block px-4 py-1 rounded-full font-bold text-sm {{ getLabelColor($mamdaniResult['label']) }}">
                    {{ $mamdaniResult['label'] }}
                </div>
            </div>

            <!-- Sugeno -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 text-center hover:shadow-lg transition-shadow">
                <div class="w-12 h-12 mx-auto bg-cyan-100 dark:bg-cyan-900/30 text-cyan-600 dark:text-cyan-400 rounded-full flex items-center justify-center text-xl mb-4">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-2">Sugeno</h3>
                <div class="text-4xl font-black text-gray-800 dark:text-white mb-3">{{ $sugenoResult['score'] }}</div>
                <div class="inline-block px-4 py-1 rounded-full font-bold text-sm {{ getLabelColor($sugenoResult['label']) }}">
                    {{ $sugenoResult['label'] }}
                </div>
            </div>

            <!-- Tsukamoto -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 text-center hover:shadow-lg transition-shadow">
                <div class="w-12 h-12 mx-auto bg-teal-100 dark:bg-teal-900/30 text-teal-600 dark:text-teal-400 rounded-full flex items-center justify-center text-xl mb-4">
                    <i class="fas fa-wave-square"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-2">Tsukamoto</h3>
                <div class="text-4xl font-black text-gray-800 dark:text-white mb-3">{{ $tsukamotoResult['score'] }}</div>
                <div class="inline-block px-4 py-1 rounded-full font-bold text-sm {{ getLabelColor($tsukamotoResult['label']) }}">
                    {{ $tsukamotoResult['label'] }}
                </div>
            </div>
        </div>

        <!-- Grafik Batang HTML/Tailwind -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 mb-8">
            <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-6 border-b border-gray-100 dark:border-gray-700 pb-3">
                <i class="fas fa-chart-bar text-blue-500 mr-2"></i> Visualisasi Skor Defuzzifikasi
            </h3>
            <div class="space-y-6">
                <!-- Bar Mamdani -->
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="font-bold text-gray-700 dark:text-gray-300">Mamdani</span>
                        <span class="font-mono text-gray-500">{{ $mamdaniResult['score'] }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-4 relative overflow-hidden">
                        <div class="{{ getBarColor($mamdaniResult['score']) }} h-4 rounded-full transition-all duration-1000 ease-out" style="width: {{ $mamdaniResult['score'] }}%"></div>
                    </div>
                </div>
                <!-- Bar Sugeno -->
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="font-bold text-gray-700 dark:text-gray-300">Sugeno</span>
                        <span class="font-mono text-gray-500">{{ $sugenoResult['score'] }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-4 relative overflow-hidden">
                        <div class="{{ getBarColor($sugenoResult['score']) }} h-4 rounded-full transition-all duration-1000 ease-out" style="width: {{ $sugenoResult['score'] }}%"></div>
                    </div>
                </div>
                <!-- Bar Tsukamoto -->
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="font-bold text-gray-700 dark:text-gray-300">Tsukamoto</span>
                        <span class="font-mono text-gray-500">{{ $tsukamotoResult['score'] }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-4 relative overflow-hidden">
                        <div class="{{ getBarColor($tsukamotoResult['score']) }} h-4 rounded-full transition-all duration-1000 ease-out" style="width: {{ $tsukamotoResult['score'] }}%"></div>
                    </div>
                </div>
            </div>
            
            <div class="flex items-center justify-center mt-6 gap-4 text-xs text-gray-500 dark:text-gray-400">
                <div class="flex items-center"><span class="w-3 h-3 rounded-full bg-green-500 mr-1"></span> Low</div>
                <div class="flex items-center"><span class="w-3 h-3 rounded-full bg-yellow-500 mr-1"></span> Medium</div>
                <div class="flex items-center"><span class="w-3 h-3 rounded-full bg-orange-500 mr-1"></span> High</div>
                <div class="flex items-center"><span class="w-3 h-3 rounded-full bg-red-500 mr-1"></span> Critical</div>
            </div>
        </div>

        <!-- Tabel Perbandingan -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="p-6 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white">
                    <i class="fas fa-table text-cyan-500 mr-2"></i> Rincian Metode
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100 dark:bg-gray-700/50">
                            <th class="p-4 border-b border-gray-200 dark:border-gray-700 font-semibold text-gray-700 dark:text-gray-300">Metode</th>
                            <th class="p-4 border-b border-gray-200 dark:border-gray-700 font-semibold text-gray-700 dark:text-gray-300 text-center">Skor Akhir</th>
                            <th class="p-4 border-b border-gray-200 dark:border-gray-700 font-semibold text-gray-700 dark:text-gray-300 text-center">Label Prioritas</th>
                            <th class="p-4 border-b border-gray-200 dark:border-gray-700 font-semibold text-gray-700 dark:text-gray-300">Karakteristik Komputasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Mamdani Row -->
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/20 transition-colors">
                            <td class="p-4 border-b border-gray-100 dark:border-gray-700/50 font-bold text-blue-600 dark:text-blue-400">Mamdani</td>
                            <td class="p-4 border-b border-gray-100 dark:border-gray-700/50 text-center font-mono font-bold text-gray-800 dark:text-white">{{ $mamdaniResult['score'] }}</td>
                            <td class="p-4 border-b border-gray-100 dark:border-gray-700/50 text-center">
                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ getLabelColor($mamdaniResult['label']) }}">
                                    {{ $mamdaniResult['label'] }}
                                </span>
                            </td>
                            <td class="p-4 border-b border-gray-100 dark:border-gray-700/50 text-sm text-gray-600 dark:text-gray-400">
                                Agregasi menggunakan nilai keanggotaan maksimum (MAX). Defuzzifikasi titik berat ruang kurva (Centroid). Sangat intuitif.
                            </td>
                        </tr>
                        <!-- Sugeno Row -->
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/20 transition-colors">
                            <td class="p-4 border-b border-gray-100 dark:border-gray-700/50 font-bold text-cyan-600 dark:text-cyan-400">Sugeno</td>
                            <td class="p-4 border-b border-gray-100 dark:border-gray-700/50 text-center font-mono font-bold text-gray-800 dark:text-white">{{ $sugenoResult['score'] }}</td>
                            <td class="p-4 border-b border-gray-100 dark:border-gray-700/50 text-center">
                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ getLabelColor($sugenoResult['label']) }}">
                                    {{ $sugenoResult['label'] }}
                                </span>
                            </td>
                            <td class="p-4 border-b border-gray-100 dark:border-gray-700/50 text-sm text-gray-600 dark:text-gray-400">
                                Konsekuen berupa nilai konstanta diskrit (Zero-Order). Evaluasi sangat cepat dengan Weighted Average.
                            </td>
                        </tr>
                        <!-- Tsukamoto Row -->
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/20 transition-colors">
                            <td class="p-4 border-b border-gray-100 dark:border-gray-700/50 font-bold text-teal-600 dark:text-teal-400">Tsukamoto</td>
                            <td class="p-4 border-b border-gray-100 dark:border-gray-700/50 text-center font-mono font-bold text-gray-800 dark:text-white">{{ $tsukamotoResult['score'] }}</td>
                            <td class="p-4 border-b border-gray-100 dark:border-gray-700/50 text-center">
                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ getLabelColor($tsukamotoResult['label']) }}">
                                    {{ $tsukamotoResult['label'] }}
                                </span>
                            </td>
                            <td class="p-4 border-b border-gray-100 dark:border-gray-700/50 text-sm text-gray-600 dark:text-gray-400">
                                Output memiliki fungsi keanggotaan linier monoton yang ditarik menjadi skalar menggunakan bobot (Weighted Average).
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @else
    <div class="bg-gray-50/50 dark:bg-gray-800/50 border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-2xl h-64 flex flex-col items-center justify-center p-8 text-center transition-all duration-300 hover:bg-gray-50 dark:hover:bg-gray-800 group">
        <div class="w-20 h-20 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center text-gray-400 dark:text-gray-500 text-3xl mb-4 shadow-inner group-hover:scale-110 group-hover:text-blue-500 dark:group-hover:text-blue-400 transition-all duration-500">
            <i class="fas fa-balance-scale animate-pulse"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-600 dark:text-gray-300 mb-2">Menunggu Data Input</h3>
        <p class="text-gray-500 dark:text-gray-400 max-w-md">
            Masukkan parameter pada form di atas lalu klik tombol <strong>Bandingkan</strong> untuk melihat perbedaan hasil ketiga metode secara langsung.
        </p>
    </div>
    @endif
</div>

@section('scripts')
<script>
    window.fillSampleData = function(sev, imp, usr) {
        const sevInput = document.getElementById('severity');
        const impInput = document.getElementById('impact');
        const usrInput = document.getElementById('affected_users');

        animateValue(sevInput, parseInt(sevInput.value || 0), sev, 400);
        animateValue(impInput, parseInt(impInput.value || 0), imp, 400);
        animateValue(usrInput, parseInt(usrInput.value || 0), usr, 400);
    };

    function animateValue(input, start, end, duration) {
        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            // easeOutQuart
            const easeProgress = 1 - Math.pow(1 - progress, 4);
            const currentVal = Math.floor(start + (end - start) * easeProgress);
            
            input.value = currentVal;
            
            if (progress < 1) {
                window.requestAnimationFrame(step);
            } else {
                input.value = end;
            }
        };
        window.requestAnimationFrame(step);
    }

    // Loading state on submit
    const form = document.querySelector('form');
    const btnText = document.getElementById('btn-text');
    const btnLoading = document.getElementById('btn-loading');
    
    if (form) {
        form.addEventListener('submit', function() {
            btnText.classList.add('hidden');
            btnLoading.classList.remove('hidden');
            document.querySelector('button[type="submit"]').classList.add('opacity-80', 'cursor-not-allowed');
        });
    }
</script>
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up {
        animation: fadeInUp 0.5s ease-out forwards;
    }
</style>
@endsection
@endsection
