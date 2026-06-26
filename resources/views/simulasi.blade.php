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
    <div class="bg-green-100 dark:bg-green-900/30 border-l-4 border-green-500 text-green-700 dark:text-green-400 p-4 mb-8 rounded shadow-sm flex items-center">
        <i class="fas fa-check-circle text-xl mr-3"></i>
        {{ $success_message }}
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Form Section -->
        <div class="lg:col-span-5 bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700/50 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-cyan-600 p-6">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-sliders-h mr-3"></i> Parameter Input
                </h2>
            </div>
            
            <form action="{{ route('simulasi.calculate') }}" method="POST" class="p-6 md:p-8">
                @csrf

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

                <button type="submit" class="w-full py-3 px-4 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white rounded-xl font-bold text-lg shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                    <i class="fas fa-calculator mr-2"></i> Hitung Prioritas
                </button>
            </form>
        </div>

        <!-- Results Section -->
        <div class="lg:col-span-7">
            @if(isset($mamdaniResult))
                @php
                    function getRecommendation($label) {
                        switch($label) {
                            case 'Low': return 'Dapat diperbaiki nanti jika ada waktu luang.';
                            case 'Medium': return 'Perlu dijadwalkan pada sprint atau rilis minor berikutnya.';
                            case 'High': return 'Segera ditangani, prioritas utama tim saat ini.';
                            case 'Critical': return 'Wajib diperbaiki segera sebelum sistem dilanjutkan atau rilis.';
                            default: return 'Tidak diketahui.';
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
                                <span class="px-3 py-1 rounded text-white text-sm font-bold {{ getBgClass($mamdaniResult['label']) }}">
                                    {{ $mamdaniResult['label'] }} Priority
                                </span>
                            </div>
                            
                            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4 border border-gray-100 dark:border-gray-700">
                                <p class="text-sm text-gray-700 dark:text-gray-300 flex items-start">
                                    <i class="fas fa-info-circle text-blue-500 mt-0.5 mr-2"></i>
                                    <span><strong>Rekomendasi:</strong> {{ getRecommendation($mamdaniResult['label']) }}</span>
                                </p>
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
                                <span class="px-3 py-1 rounded text-white text-sm font-bold {{ getBgClass($sugenoResult['label']) }}">
                                    {{ $sugenoResult['label'] }} Priority
                                </span>
                            </div>
                            
                            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4 border border-gray-100 dark:border-gray-700">
                                <p class="text-sm text-gray-700 dark:text-gray-300 flex items-start">
                                    <i class="fas fa-info-circle text-cyan-500 mt-0.5 mr-2"></i>
                                    <span><strong>Rekomendasi:</strong> {{ getRecommendation($sugenoResult['label']) }}</span>
                                </p>
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
                                <span class="px-3 py-1 rounded text-white text-sm font-bold {{ getBgClass($tsukamotoResult['label']) }}">
                                    {{ $tsukamotoResult['label'] }} Priority
                                </span>
                            </div>
                            
                            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4 border border-gray-100 dark:border-gray-700">
                                <p class="text-sm text-gray-700 dark:text-gray-300 flex items-start">
                                    <i class="fas fa-info-circle text-teal-500 mt-0.5 mr-2"></i>
                                    <span><strong>Rekomendasi:</strong> {{ getRecommendation($tsukamotoResult['label']) }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-gray-50 dark:bg-gray-800 border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-2xl h-full min-h-[400px] flex flex-col items-center justify-center p-8 text-center transition-colors">
                    <div class="w-24 h-24 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center text-gray-400 dark:text-gray-500 text-4xl mb-4">
                        <i class="fas fa-robot"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-600 dark:text-gray-300 mb-2">Menunggu Input Anda</h3>
                    <p class="text-gray-500 dark:text-gray-400 max-w-sm">
                        Sesuaikan parameter pada form di samping dan klik tombol <strong>Hitung Prioritas</strong> untuk melihat hasil analisis AI.
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
    });
</script>
@endsection
@endsection
