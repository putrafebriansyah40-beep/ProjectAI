<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bug;
use App\Services\FuzzyMamdaniService;
use App\Services\FuzzySugenoService;
use App\Services\FuzzyTsukamotoService;
use App\Services\FuzzyRuleService;

class SimulasiController extends Controller
{
    /**
     * Dependency Injection untuk semua layanan fuzzy
     */
    protected $mamdaniService;
    protected $sugenoService;
    protected $tsukamotoService;
    protected $ruleService;

    public function __construct(
        FuzzyMamdaniService $mamdaniService,
        FuzzySugenoService $sugenoService,
        FuzzyTsukamotoService $tsukamotoService,
        FuzzyRuleService $ruleService
    ) {
        $this->mamdaniService = $mamdaniService;
        $this->sugenoService = $sugenoService;
        $this->tsukamotoService = $tsukamotoService;
        $this->ruleService = $ruleService;
    }

    /**
     * Menampilkan form input simulasi
     */
    public function index()
    {
        return view('simulasi');
    }

    /**
     * Memproses input form simulasi dan menyimpan hasil kalkulasi ke database
     */
    public function calculate(Request $request)
    {
        // 1. Validasi input wajib dari 0 sampai 100
        $validated = $request->validate([
            'title'          => 'nullable|string|max:255',
            'description'    => 'nullable|string',
            'severity'       => 'required|integer|min:0|max:100',
            'impact'         => 'required|integer|min:0|max:100',
            'affected_users' => 'required|integer|min:0|max:100',
        ], [
            'severity.required'       => 'Severity wajib diisi.',
            'severity.integer'        => 'Severity harus berupa angka bulat.',
            'severity.min'            => 'Severity minimal 0.',
            'severity.max'            => 'Severity maksimal 100.',
            'impact.required'         => 'Impact wajib diisi.',
            'impact.integer'          => 'Impact harus berupa angka bulat.',
            'impact.min'              => 'Impact minimal 0.',
            'impact.max'              => 'Impact maksimal 100.',
            'affected_users.required' => 'Affected Users wajib diisi.',
            'affected_users.integer'  => 'Affected Users harus berupa angka bulat.',
            'affected_users.min'      => 'Affected Users minimal 0.',
            'affected_users.max'      => 'Affected Users maksimal 100.',
        ]);

        $severity = $validated['severity'];
        $impact = $validated['impact'];
        $affectedUsers = $validated['affected_users'];

        // 2. Pemanggilan ke semua layer service logika fuzzy (Clean Architecture)
        $mamdaniResult   = $this->mamdaniService->calculate($severity, $impact, $affectedUsers);
        $sugenoResult    = $this->sugenoService->calculate($severity, $impact, $affectedUsers);
        $tsukamotoResult = $this->tsukamotoService->calculate($severity, $impact, $affectedUsers);
        $activeRule      = $this->ruleService->getActiveRule($severity, $impact, $affectedUsers);

        // 3. Simpan hasil ke database (tabel bugs)
        Bug::create([
            'title'           => $request->input('title', 'Simulasi Biasa'),
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

        // 4. Return hasil untuk ditampilkan ke view
        return view('simulasi', [
            'input'           => compact('severity', 'impact', 'affectedUsers'),
            'mamdaniResult'   => $mamdaniResult,
            'sugenoResult'    => $sugenoResult,
            'tsukamotoResult' => $tsukamotoResult,
            'activeRule'      => $activeRule,
            'success_message' => 'Simulasi berhasil dihitung dan disimpan ke riwayat!'
        ]);
    }
}
