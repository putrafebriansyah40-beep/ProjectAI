@extends('layouts.app')

@section('title', 'Simulasi Fuzzy')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header -->
    <div class="text-center mb-10">
        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-800 dark:text-white mb-4">
            Simulasi <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500">Bug Priority</span>
        </h1>
        <p class="text-gray-600 dark:text-gray-300">
            Masukkan parameter bug untuk melihat analisis menggunakan ketiga metode Logika Fuzzy.
        </p>
    </div>

    <!-- Alert / Success message -->
    @if(isset($success_message))
    <div class="bg-green-100 dark:bg-green-900/30 border-l-4 border-green-500 text-green-700 dark:text-green-400 p-4 mb-8 rounded shadow-sm flex items-center animate-fade-in-up">
        <i class="fas fa-check-circle text-xl mr-3"></i>
        {{ $success_message }}
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        <!-- Form Section -->
        <div class="lg:col-span-5 sticky top-24 bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700/50 overflow-hidden transition-all duration-300 hover:shadow-2xl z-20">
            <div class="bg-gradient-to-r from-blue-600 to-cyan-600 p-6">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-sliders-h mr-3"></i> Parameter Input
                </h2>
            </div>
            
            <form action="{{ route('simulasi.calculate') }}" method="POST" class="p-6 md:p-8">
                @csrf

                <!-- Quick Sample Data -->
                <div class="mb-6 pb-6 border-b border-gray-100 dark:border-gray-700">
                    <p class="text-xs font-bold text-gray-500 dark:text-gray-400 mb-3 uppercase tracking-wider">Contoh Data Cepat:</p>
                    <div class="flex flex-wrap gap-2">
                        <button type="button" onclick="fillSampleData(20, 25, 15)" class="px-3 py-1.5 text-xs font-bold bg-green-100 text-green-700 hover:bg-green-200 dark:bg-green-900/30 dark:text-green-400 dark:hover:bg-green-900/50 rounded-full transition-colors"><i class="fas fa-bolt text-[10px] mr-1"></i> Ringan</button>
                        <button type="button" onclick="fillSampleData(50, 45, 40)" class="px-3 py-1.5 text-xs font-bold bg-yellow-100 text-yellow-700 hover:bg-yellow-200 dark:bg-yellow-900/30 dark:text-yellow-400 dark:hover:bg-yellow-900/50 rounded-full transition-colors"><i class="fas fa-exclamation text-[10px] mr-1"></i> Sedang</button>
                        <button type="button" onclick="fillSampleData(75, 80, 70)" class="px-3 py-1.5 text-xs font-bold bg-orange-100 text-orange-700 hover:bg-orange-200 dark:bg-orange-900/30 dark:text-orange-400 dark:hover:bg-orange-900/50 rounded-full transition-colors"><i class="fas fa-exclamation-triangle text-[10px] mr-1"></i> Berat</button>
                        <button type="button" onclick="fillSampleData(95, 95, 90)" class="px-3 py-1.5 text-xs font-bold bg-red-100 text-red-700 hover:bg-red-200 dark:bg-red-900/30 dark:text-red-400 dark:hover:bg-red-900/50 rounded-full transition-colors"><i class="fas fa-fire text-[10px] mr-1"></i> Critical</button>
                    </div>
                </div>

                <!-- Severity -->
                <div class="mb-8">
                    <div class="flex justify-between items-end mb-2">
                        <label for="severity" class="block text-sm font-bold text-gray-700 dark:text-gray-200">Severity</label>
                        <input type="number" id="severity_input" value="{{ old('severity', $input['severity'] ?? 50) }}" class="w-16 text-center border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-white rounded-md text-sm py-1 font-mono focus:ring-blue-500 focus:border-blue-500" min="0" max="100">
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-3">Tingkat keparahan bug dari segi teknis (0-100).</p>
                    <input type="range" name="severity" id="severity" min="0" max="100" value="{{ old('severity', $input['severity'] ?? 50) }}" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700 accent-blue-600">
                    @error('severity') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Impact -->
                <div class="mb-8">
                    <div class="flex justify-between items-end mb-2">
                        <label for="impact" class="block text-sm font-bold text-gray-700 dark:text-gray-200">Impact</label>
                        <input type="number" id="impact_input" value="{{ old('impact', $input['impact'] ?? 50) }}" class="w-16 text-center border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-white rounded-md text-sm py-1 font-mono focus:ring-blue-500 focus:border-blue-500" min="0" max="100">
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-3">Dampak operasional bug terhadap sistem (0-100).</p>
                    <input type="range" name="impact" id="impact" min="0" max="100" value="{{ old('impact', $input['impact'] ?? 50) }}" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700 accent-blue-600">
                    @error('impact') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Affected Users -->
                <div class="mb-8">
                    <div class="flex justify-between items-end mb-2">
                        <label for="affected_users" class="block text-sm font-bold text-gray-700 dark:text-gray-200">Affected Users</label>
                        <input type="number" id="affected_users_input" value="{{ old('affected_users', $input['affectedUsers'] ?? 50) }}" class="w-16 text-center border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-white rounded-md text-sm py-1 font-mono focus:ring-blue-500 focus:border-blue-500" min="0" max="100">
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-3">Persentase jumlah pengguna yang terdampak bug (0-100).</p>
                    <input type="range" name="affected_users" id="affected_users" min="0" max="100" value="{{ old('affected_users', $input['affectedUsers'] ?? 50) }}" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700 accent-blue-600">
                    @error('affected_users') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="w-full py-3 px-4 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white rounded-xl font-bold text-lg shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5 group relative overflow-hidden flex items-center justify-center">
                    <span id="btn-text" class="flex items-center"><i class="fas fa-calculator mr-2 group-hover:rotate-12 transition-transform duration-300"></i> Hitung Prioritas</span>
                    <span id="btn-loading" class="hidden flex items-center"><i class="fas fa-circle-notch fa-spin mr-2"></i> Memproses...</span>
                    <div class="absolute inset-0 h-full w-full bg-white/20 scale-0 group-active:scale-100 rounded-xl transition-transform duration-300 opacity-0 group-active:opacity-100"></div>
                </button>
            </form>
        </div>

        <!-- Results Section -->
        <div class="lg:col-span-7 animate-fade-in-up">
            @if(isset($mamdaniResult))
                <!-- Section Proses Perhitungan -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg border border-gray-100 dark:border-gray-700/50 mb-6">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-6 border-b border-gray-100 dark:border-gray-700 pb-3">
                        <i class="fas fa-microchip text-blue-500 mr-2"></i> Proses Perhitungan
                    </h3>
                    <div class="flex items-center justify-between relative px-2 sm:px-6">
                        <!-- Garis penghubung -->
                        <div class="absolute left-6 right-6 top-5 h-1 bg-gray-200 dark:bg-gray-700 z-0"></div>
                        <div class="absolute left-6 right-6 top-5 h-1 bg-gradient-to-r from-blue-500 to-cyan-400 z-0 animate-pulse"></div>
                        
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
                <!-- Section Rule yang Digunakan -->
                @if(isset($activeRule))
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg border border-gray-100 dark:border-gray-700/50 mb-6">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-4 border-b border-gray-100 dark:border-gray-700 pb-3">
                        <i class="fas fa-list-ul text-blue-500 mr-2"></i> Rule yang Digunakan
                    </h3>
                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800 rounded-xl p-5 relative overflow-hidden">
                        <div class="absolute right-0 top-0 w-24 h-24 bg-blue-100 dark:bg-blue-800 rounded-full opacity-50 transform translate-x-8 -translate-y-8"></div>
                        <div class="relative z-10">
                            <div class="text-sm text-gray-600 dark:text-gray-400 font-bold mb-2 uppercase tracking-wider">Rule dengan kontribusi terbesar:</div>
                            <div class="font-mono text-lg text-gray-800 dark:text-gray-200 mb-4 bg-white dark:bg-gray-800 p-4 rounded border border-gray-200 dark:border-gray-700 shadow-inner">
                                <span class="text-blue-600 dark:text-blue-400">IF</span> Severity {{ $activeRule['severity'] }}<br>
                                <span class="text-blue-600 dark:text-blue-400">AND</span> Impact {{ $activeRule['impact'] }}<br>
                                <span class="text-blue-600 dark:text-blue-400">AND</span> Users {{ $activeRule['users'] }}<br>
                                <br>
                                <span class="text-green-600 dark:text-green-400">THEN</span> Priority <span class="font-bold">{{ $activeRule['priority'] }}</span>
                            </div>
                            
                            <div class="flex items-center justify-between mt-4">
                                <div class="bg-white dark:bg-gray-800 px-4 py-2 rounded-lg border border-gray-200 dark:border-gray-700 font-bold text-gray-700 dark:text-gray-300">
                                    <span class="text-gray-500 text-sm mr-2">Firing Strength (α):</span>
                                    <span class="text-blue-600 dark:text-blue-400">{{ number_format($activeRule['alpha'], 2) }}</span>
                                </div>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-4 italic border-l-4 border-blue-500 pl-3">
                                "Rule di atas memberikan kontribusi terbesar sehingga sistem menghasilkan prioritas {{ $activeRule['priority'] }}."
                            </p>
                        </div>
                    </div>
                </div>
                @endif

                @php
                    function getRecommendation($label) {
                        switch($label) {
                            case 'Low': return 'Dapat diperbaiki pada sprint berikutnya.';
                            case 'Medium': return 'Perlu dijadwalkan dalam waktu dekat.';
                            case 'High': return 'Sebaiknya segera diperbaiki.';
                            case 'Critical': return 'Wajib diperbaiki sebelum release.';
                            default: return 'Tidak diketahui.';
                        }
                    }

                    function getAlertClass($label) {
                        switch($label) {
                            case 'Low': return 'bg-green-50 dark:bg-green-900/20 border-green-200 dark:border-green-800 text-green-700 dark:text-green-400';
                            case 'Medium': return 'bg-yellow-50 dark:bg-yellow-900/20 border-yellow-200 dark:border-yellow-800 text-yellow-700 dark:text-yellow-400';
                            case 'High': return 'bg-orange-50 dark:bg-orange-900/20 border-orange-200 dark:border-orange-800 text-orange-700 dark:text-orange-400';
                            case 'Critical': return 'bg-red-50 dark:bg-red-900/20 border-red-200 dark:border-red-800 text-red-700 dark:text-red-400';
                            default: return 'bg-gray-50 dark:bg-gray-800 border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-400';
                        }
                    }

                    function getAlertIcon($label) {
                        switch($label) {
                            case 'Low': return 'fa-check-circle text-green-500';
                            case 'Medium': return 'fa-exclamation-circle text-yellow-500';
                            case 'High': return 'fa-exclamation-triangle text-orange-500';
                            case 'Critical': return 'fa-radiation text-red-500';
                            default: return 'fa-info-circle text-gray-500';
                        }
                    }

                    function getColorClass($label) {
                        switch($label) {
                            case 'Low': return 'text-green-500 border-green-500';
                            case 'Medium': return 'text-yellow-500 border-yellow-500';
                            case 'High': return 'text-orange-500 border-orange-500';
                            case 'Critical': return 'text-red-500 border-red-500';
                            default: return 'text-gray-500 border-gray-500';
                        }
                    }
                    
                    function getBgClass($label) {
                        switch($label) {
                            case 'Low': return 'bg-green-500';
                            case 'Medium': return 'bg-yellow-500';
                            case 'High': return 'bg-orange-500';
                            case 'Critical': return 'bg-red-500';
                            default: return 'bg-gray-500';
                        }
                    }
                @endphp

                <div class="grid gap-6">
                    <!-- Mamdani Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg border-l-4 border-blue-500 relative overflow-hidden group">
                        <div class="absolute -right-6 -top-6 text-blue-50 dark:text-blue-900/10 text-9xl transition-transform group-hover:scale-110"><i class="fas fa-chart-area"></i></div>
                        <div class="relative z-10">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-sm uppercase tracking-wider text-gray-500 dark:text-gray-400 font-bold mb-1">Metode</h3>
                                    <p class="text-2xl font-black text-gray-800 dark:text-white">Mamdani</p>
                                </div>
                                <div class="text-right">
                                    <div class="text-3xl font-mono font-black {{ getColorClass($mamdaniResult['label']) }}">{{ $mamdaniResult['score'] }}</div>
                                    <p class="text-xs text-gray-500 mt-1">Skor Defuzzifikasi</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center mb-4">
                                <span class="px-3 py-1 rounded-full text-white text-xs font-bold {{ getBgClass($mamdaniResult['label']) }} shadow-sm">
                                    {{ $mamdaniResult['label'] }} Priority
                                </span>
                            </div>
                            
                            <div class="rounded-xl p-4 border {{ getAlertClass($mamdaniResult['label']) }} flex items-start shadow-sm transition-all hover:shadow-md">
                                <div class="text-xl mr-3 mt-0.5">
                                    <i class="fas {{ getAlertIcon($mamdaniResult['label']) }}"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold mb-1 uppercase tracking-wider opacity-80">Rekomendasi Tindakan</h4>
                                    <p class="text-sm font-medium">{{ getRecommendation($mamdaniResult['label']) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sugeno Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg border-l-4 border-cyan-500 relative overflow-hidden group">
                        <div class="absolute -right-6 -top-6 text-cyan-50 dark:text-cyan-900/10 text-9xl transition-transform group-hover:scale-110"><i class="fas fa-chart-line"></i></div>
                        <div class="relative z-10">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-sm uppercase tracking-wider text-gray-500 dark:text-gray-400 font-bold mb-1">Metode</h3>
                                    <p class="text-2xl font-black text-gray-800 dark:text-white">Sugeno</p>
                                </div>
                                <div class="text-right">
                                    <div class="text-3xl font-mono font-black {{ getColorClass($sugenoResult['label']) }}">{{ $sugenoResult['score'] }}</div>
                                    <p class="text-xs text-gray-500 mt-1">Skor Defuzzifikasi</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center mb-4">
                                <span class="px-3 py-1 rounded-full text-white text-xs font-bold {{ getBgClass($sugenoResult['label']) }} shadow-sm">
                                    {{ $sugenoResult['label'] }} Priority
                                </span>
                            </div>
                            
                            <div class="rounded-xl p-4 border {{ getAlertClass($sugenoResult['label']) }} flex items-start shadow-sm transition-all hover:shadow-md">
                                <div class="text-xl mr-3 mt-0.5">
                                    <i class="fas {{ getAlertIcon($sugenoResult['label']) }}"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold mb-1 uppercase tracking-wider opacity-80">Rekomendasi Tindakan</h4>
                                    <p class="text-sm font-medium">{{ getRecommendation($sugenoResult['label']) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tsukamoto Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg border-l-4 border-teal-500 relative overflow-hidden group">
                        <div class="absolute -right-6 -top-6 text-teal-50 dark:text-teal-900/10 text-9xl transition-transform group-hover:scale-110"><i class="fas fa-wave-square"></i></div>
                        <div class="relative z-10">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-sm uppercase tracking-wider text-gray-500 dark:text-gray-400 font-bold mb-1">Metode</h3>
                                    <p class="text-2xl font-black text-gray-800 dark:text-white">Tsukamoto</p>
                                </div>
                                <div class="text-right">
                                    <div class="text-3xl font-mono font-black {{ getColorClass($tsukamotoResult['label']) }}">{{ $tsukamotoResult['score'] }}</div>
                                    <p class="text-xs text-gray-500 mt-1">Skor Defuzzifikasi</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center mb-4">
                                <span class="px-3 py-1 rounded-full text-white text-xs font-bold {{ getBgClass($tsukamotoResult['label']) }} shadow-sm">
                                    {{ $tsukamotoResult['label'] }} Priority
                                </span>
                            </div>
                            
                            <div class="rounded-xl p-4 border {{ getAlertClass($tsukamotoResult['label']) }} flex items-start shadow-sm transition-all hover:shadow-md">
                                <div class="text-xl mr-3 mt-0.5">
                                    <i class="fas {{ getAlertIcon($tsukamotoResult['label']) }}"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold mb-1 uppercase tracking-wider opacity-80">Rekomendasi Tindakan</h4>
                                    <p class="text-sm font-medium">{{ getRecommendation($tsukamotoResult['label']) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-gray-50/50 dark:bg-gray-800/50 border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-2xl h-full min-h-[500px] flex flex-col items-center justify-center p-8 text-center transition-all duration-300 hover:bg-gray-50 dark:hover:bg-gray-800 group">
                    <div class="w-24 h-24 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center text-gray-400 dark:text-gray-500 text-4xl mb-6 shadow-inner group-hover:scale-110 group-hover:text-blue-500 dark:group-hover:text-blue-400 transition-all duration-500">
                        <i class="fas fa-robot animate-pulse"></i>
                    </div>
                    <h3 class="text-2xl font-black text-gray-700 dark:text-gray-200 mb-3 tracking-tight">Menunggu Input Anda</h3>
                    <p class="text-gray-500 dark:text-gray-400 max-w-sm leading-relaxed">
                        Sesuaikan parameter pada form di samping dan klik tombol <strong class="text-blue-600 dark:text-blue-400">Hitung Prioritas</strong> untuk melihat hasil analisis AI.
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const syncInputs = (sliderId, inputId) => {
            const slider = document.getElementById(sliderId);
            const input = document.getElementById(inputId);
            
            if(slider && input) {
                slider.addEventListener('input', function() {
                    input.value = this.value;
                });
                
                input.addEventListener('input', function() {
                    if(this.value !== '') {
                        let val = parseInt(this.value);
                        if(val > 100) val = 100;
                        if(val < 0) val = 0;
                        slider.value = val;
                        this.value = val;
                    }
                });
            }
        };

        syncInputs('severity', 'severity_input');
        syncInputs('impact', 'impact_input');
        syncInputs('affected_users', 'affected_users_input');

        window.fillSampleData = function(sev, imp, usr) {
            const sevSlider = document.getElementById('severity');
            const impSlider = document.getElementById('impact');
            const usrSlider = document.getElementById('affected_users');
            
            const sevInput = document.getElementById('severity_input');
            const impInput = document.getElementById('impact_input');
            const usrInput = document.getElementById('affected_users_input');

            animateValue(sevSlider, sevInput, parseInt(sevSlider.value || 0), sev, 400);
            animateValue(impSlider, impInput, parseInt(impSlider.value || 0), imp, 400);
            animateValue(usrSlider, usrInput, parseInt(usrSlider.value || 0), usr, 400);
        };

        function animateValue(slider, input, start, end, duration) {
            let startTimestamp = null;
            const step = (timestamp) => {
                if (!startTimestamp) startTimestamp = timestamp;
                const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                // easeOutQuart
                const easeProgress = 1 - Math.pow(1 - progress, 4);
                const currentVal = Math.floor(start + (end - start) * easeProgress);
                
                slider.value = currentVal;
                input.value = currentVal;
                
                if (progress < 1) {
                    window.requestAnimationFrame(step);
                } else {
                    slider.value = end;
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
    });
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
