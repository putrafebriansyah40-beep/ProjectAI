@extends('layouts.app')

@section('title', 'Riwayat Simulasi')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="text-center mb-10">
        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-800 dark:text-white mb-4">
            Riwayat <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500">Simulasi</span>
        </h1>
        <p class="text-gray-600 dark:text-gray-300">
            Daftar lengkap hasil kalkulasi penentuan prioritas bug yang telah dilakukan.
        </p>
    </div>

    <!-- Statistik Ringkas -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
        <!-- Total -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 shadow-sm border border-gray-100 dark:border-gray-700/50 text-center">
            <h4 class="text-xs font-bold text-gray-500 uppercase mb-1">Total Simulasi</h4>
            <div class="text-3xl font-black text-gray-800 dark:text-white">{{ $stats['total'] ?? 0 }}</div>
        </div>
        <!-- Low -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 shadow-sm border border-green-100 dark:border-green-900/30 text-center">
            <h4 class="text-xs font-bold text-green-500 uppercase mb-1">Low</h4>
            <div class="text-3xl font-black text-green-600 dark:text-green-400">{{ $stats['low'] ?? 0 }}</div>
        </div>
        <!-- Medium -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 shadow-sm border border-yellow-100 dark:border-yellow-900/30 text-center">
            <h4 class="text-xs font-bold text-yellow-500 uppercase mb-1">Medium</h4>
            <div class="text-3xl font-black text-yellow-600 dark:text-yellow-400">{{ $stats['medium'] ?? 0 }}</div>
        </div>
        <!-- High -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 shadow-sm border border-orange-100 dark:border-orange-900/30 text-center">
            <h4 class="text-xs font-bold text-orange-500 uppercase mb-1">High</h4>
            <div class="text-3xl font-black text-orange-600 dark:text-orange-400">{{ $stats['high'] ?? 0 }}</div>
        </div>
        <!-- Critical -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 shadow-sm border border-red-100 dark:border-red-900/30 text-center">
            <h4 class="text-xs font-bold text-red-500 uppercase mb-1">Critical</h4>
            <div class="text-3xl font-black text-red-600 dark:text-red-400">{{ $stats['critical'] ?? 0 }}</div>
        </div>
    </div>

    @php
        function getBadgeColor($label) {
            switch($label) {
                case 'Low': return 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 border border-green-200 dark:border-green-800';
                case 'Medium': return 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400 border border-yellow-200 dark:border-yellow-800';
                case 'High': return 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400 border border-orange-200 dark:border-orange-800';
                case 'Critical': return 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 border border-red-200 dark:border-red-800';
                default: return 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-400';
            }
        }
    @endphp

    <!-- Tabel Riwayat -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md border border-gray-100 dark:border-gray-700/50 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-700/50 border-b border-gray-200 dark:border-gray-700">
                        <th class="p-4 font-semibold text-gray-600 dark:text-gray-300 text-sm whitespace-nowrap">Tanggal</th>
                        <th class="p-4 font-semibold text-gray-600 dark:text-gray-300 text-sm whitespace-nowrap text-center">Input <br><span class="text-xs font-normal text-gray-500">(Sev/Imp/Usr)</span></th>
                        <th class="p-4 font-semibold text-gray-600 dark:text-gray-300 text-sm whitespace-nowrap text-center border-l border-gray-200 dark:border-gray-700">Mamdani</th>
                        <th class="p-4 font-semibold text-gray-600 dark:text-gray-300 text-sm whitespace-nowrap text-center border-l border-gray-200 dark:border-gray-700">Sugeno</th>
                        <th class="p-4 font-semibold text-gray-600 dark:text-gray-300 text-sm whitespace-nowrap text-center border-l border-gray-200 dark:border-gray-700">Tsukamoto</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700/50">
                    @forelse($histories as $history)
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/20 transition-colors">
                        <td class="p-4 text-sm text-gray-600 dark:text-gray-400 whitespace-nowrap font-medium">
                            {{ $history->created_at->format('d M Y, H:i') }}
                        </td>
                        <td class="p-4 text-center">
                            <div class="flex justify-center gap-2 font-mono text-sm">
                                <span class="bg-gray-100 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-gray-800 dark:text-gray-200 px-2 py-0.5 rounded shadow-sm" title="Severity">{{ $history->severity }}</span>
                                <span class="bg-gray-100 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-gray-800 dark:text-gray-200 px-2 py-0.5 rounded shadow-sm" title="Impact">{{ $history->impact }}</span>
                                <span class="bg-gray-100 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-gray-800 dark:text-gray-200 px-2 py-0.5 rounded shadow-sm" title="Affected Users">{{ $history->affected_users }}</span>
                            </div>
                        </td>
                        <!-- Mamdani -->
                        <td class="p-4 text-center border-l border-gray-100 dark:border-gray-700/50">
                            <div class="flex flex-col items-center gap-1.5">
                                <span class="font-mono font-bold text-gray-800 dark:text-white">{{ number_format($history->mamdani_score, 1) }}</span>
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] uppercase tracking-wide font-bold {{ getBadgeColor($history->mamdani_label) }}">
                                    {{ $history->mamdani_label }}
                                </span>
                            </div>
                        </td>
                        <!-- Sugeno -->
                        <td class="p-4 text-center border-l border-gray-100 dark:border-gray-700/50">
                            <div class="flex flex-col items-center gap-1.5">
                                <span class="font-mono font-bold text-gray-800 dark:text-white">{{ number_format($history->sugeno_score, 1) }}</span>
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] uppercase tracking-wide font-bold {{ getBadgeColor($history->sugeno_label) }}">
                                    {{ $history->sugeno_label }}
                                </span>
                            </div>
                        </td>
                        <!-- Tsukamoto -->
                        <td class="p-4 text-center border-l border-gray-100 dark:border-gray-700/50">
                            <div class="flex flex-col items-center gap-1.5">
                                <span class="font-mono font-bold text-gray-800 dark:text-white">{{ number_format($history->tsukamoto_score, 1) }}</span>
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] uppercase tracking-wide font-bold {{ getBadgeColor($history->tsukamoto_label) }}">
                                    {{ $history->tsukamoto_label }}
                                </span>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-16 text-center">
                            <div class="w-20 h-20 mx-auto bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center text-gray-400 dark:text-gray-600 text-3xl mb-4">
                                <i class="fas fa-folder-open"></i>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-2">Belum Ada Riwayat</h3>
                            <p class="text-gray-500 dark:text-gray-400">Silakan lakukan simulasi atau perbandingan terlebih dahulu.</p>
                            <a href="{{ route('simulasi') }}" class="inline-block mt-4 px-6 py-2 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white rounded-lg font-bold transition-all shadow-md">
                                Mulai Simulasi
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
