<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bug;
use App\Services\FuzzyMamdaniService;
use App\Services\FuzzySugenoService;
use App\Services\FuzzyTsukamotoService;

class PerbandinganController extends Controller
{
    /**
     * Dependency Injection untuk layanan logika fuzzy
     */
    protected $mamdaniService;
    protected $sugenoService;
    protected $tsukamotoService;

    public function __construct(
        FuzzyMamdaniService $mamdaniService,
        FuzzySugenoService $sugenoService,
        FuzzyTsukamotoService $tsukamotoService
    ) {
        $this->mamdaniService = $mamdaniService;
        $this->sugenoService = $sugenoService;
        $this->tsukamotoService = $tsukamotoService;
    }

    /**
     * Menampilkan form untuk perbandingan metode
     */
    public function index()
    {
        return view('perbandingan');
    }

    /**
     * Memproses input perbandingan dari tiga metode,
     * menampilkan komparasinya secara mendetail, dan menyimpan di database.
     */
    public function calculate(Request $request)
    {
        // 1. Validasi input: batas wajib 0-100
        $validated = $request->validate([
            'title'          => 'nullable|string|max:255',
            'description'    => 'nullable|string',
            'severity'       => 'required|integer|min:0|max:100',
            'impact'         => 'required|integer|min:0|max:100',
            'affected_users' => 'required|integer|min:0|max:100',
        ], [
            'severity.required'       => 'Parameter Severity wajib diisi.',
            'severity.integer'        => 'Severity harus bilangan bulat.',
            'severity.min'            => 'Nilai minimum untuk Severity adalah 0.',
            'severity.max'            => 'Nilai maksimum untuk Severity adalah 100.',
            'impact.required'         => 'Parameter Impact wajib diisi.',
            'impact.integer'          => 'Impact harus bilangan bulat.',
            'impact.min'              => 'Nilai minimum untuk Impact adalah 0.',
            'impact.max'              => 'Nilai maksimum untuk Impact adalah 100.',
            'affected_users.required' => 'Parameter Affected Users wajib diisi.',
            'affected_users.integer'  => 'Affected Users harus bilangan bulat.',
            'affected_users.min'      => 'Nilai minimum untuk Affected Users adalah 0.',
            'affected_users.max'      => 'Nilai maksimum untuk Affected Users adalah 100.',
        ]);

        $severity = $validated['severity'];
        $impact = $validated['impact'];
        $affectedUsers = $validated['affected_users'];

        // 2. Pemanggilan fungsi calculate() dari masing-masing metode
        $mamdaniResult   = $this->mamdaniService->calculate($severity, $impact, $affectedUsers);
        $sugenoResult    = $this->sugenoService->calculate($severity, $impact, $affectedUsers);
        $tsukamotoResult = $this->tsukamotoService->calculate($severity, $impact, $affectedUsers);

        // 3. Simpan riwayat simulasi komparasi ke tabel database
        Bug::create([
            'title'           => $request->input('title', 'Perbandingan Metode'),
            'description'     => $request->input('description', ''),
            'severity'        => $severity,
            'impact'          => $impact,
            'affected_users'  => $affectedUsers,
            'mamdani_score'   => $mamdaniResult['score'],
            'mamdani_label'   => $mamdaniResult['label'],
            'sugeno_score'    => $sugenoResult['score'],
            'sugeno_label'    => $sugenoResult['label'],
            'tsukamoto_score' => $tsukamotoResult['score'],
            'tsukamoto_label' => $tsukamotoResult['label'],
        ]);

        // 4. Return data untuk ditampilkan pada halaman perbandingan (termasuk komparasi skor)
        return view('perbandingan', [
            'input'           => compact('severity', 'impact', 'affectedUsers'),
            'mamdaniResult'   => $mamdaniResult,
            'sugenoResult'    => $sugenoResult,
            'tsukamotoResult' => $tsukamotoResult,
            'success_message' => 'Analisis komparatif dari ketiga metode berhasil diselesaikan!'
        ]);
    }
}
