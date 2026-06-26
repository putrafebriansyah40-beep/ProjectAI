<?php

namespace App\Services;

class FuzzySugenoService
{
    /**
     * Menghitung nilai prioritas bug menggunakan metode Fuzzy Sugeno (Zero-Order)
     *
     * @param float|int $severity
     * @param float|int $impact
     * @param float|int $affected_users
     * @return array
     */
    public function calculate($severity, $impact, $affected_users): array
    {
        // 1. Fuzzifikasi
        $sev = $this->fuzzifySeverity($severity);
        $imp = $this->fuzzifyImpact($impact);
        $usr = $this->fuzzifyUsers($affected_users);

        // 2. Evaluasi Aturan dan Implikasi (Mencari alpha-predicate dan nilai z_i)
        $rules_evaluation = $this->evaluateRules($sev, $imp, $usr);

        // 3. Defuzzifikasi (Weighted Average)
        $score = $this->defuzzify($rules_evaluation);

        // 4. Penentuan Label berdasarkan aturan baku
        $label = $this->determineLabel($score);

        return [
            'score' => round($score, 2),
            'label' => $label
        ];
    }

    private function fuzzifySeverity($x)
    {
        return [
            'Low'    => $this->trapezoid($x, 0, 0, 20, 40),
            'Medium' => $this->triangle($x, 20, 50, 80),
            'High'   => $this->trapezoid($x, 60, 80, 100, 100),
        ];
    }

    private function fuzzifyImpact($x)
    {
        return [
            'Low'    => $this->trapezoid($x, 0, 0, 25, 45),
            'Medium' => $this->triangle($x, 25, 50, 75),
            'High'   => $this->trapezoid($x, 55, 75, 100, 100),
        ];
    }

    private function fuzzifyUsers($x)
    {
        return [
            'Few'      => $this->trapezoid($x, 0, 0, 30, 50),
            'Moderate' => $this->triangle($x, 30, 60, 90),
            'Many'     => $this->trapezoid($x, 70, 90, 100, 100),
        ];
    }

    /**
     * Evaluasi Aturan (Sugeno Zero-Order)
     * Mengembalikan daftar nilai aktivasi (alpha) dan nilai skalar (z) untuk tiap rule
     */
    private function evaluateRules($sev, $imp, $usr)
    {
        $rules = [];

        // Konstanta konsekuen untuk Sugeno orde nol
        $const = [
            'Low'      => 20,
            'Medium'   => 50,
            'High'     => 80,
            'Critical' => 100,
        ];

        $and = function (...$values) {
            return min($values);
        };

        // Fungsi helper untuk menyimpan hasil evaluasi tiap rule
        $addRule = function($alpha, $consequentLabel) use (&$rules, $const) {
            if ($alpha > 0) {
                $rules[] = [
                    'alpha' => $alpha,
                    'z'     => $const[$consequentLabel]
                ];
            }
        };

        // --- Aturan saat Severity LOW ---
        $addRule($and($sev['Low'], $imp['Low'], $usr['Few']), 'Low');
        $addRule($and($sev['Low'], $imp['Low'], $usr['Moderate']), 'Low');
        $addRule($and($sev['Low'], $imp['Low'], $usr['Many']), 'Medium');
        
        $addRule($and($sev['Low'], $imp['Medium'], $usr['Few']), 'Low');
        $addRule($and($sev['Low'], $imp['Medium'], $usr['Moderate']), 'Medium');
        $addRule($and($sev['Low'], $imp['Medium'], $usr['Many']), 'Medium');
        
        $addRule($and($sev['Low'], $imp['High'], $usr['Few']), 'Medium');
        $addRule($and($sev['Low'], $imp['High'], $usr['Moderate']), 'Medium');
        $addRule($and($sev['Low'], $imp['High'], $usr['Many']), 'High');

        // --- Aturan saat Severity MEDIUM ---
        $addRule($and($sev['Medium'], $imp['Low'], $usr['Few']), 'Low');
        $addRule($and($sev['Medium'], $imp['Low'], $usr['Moderate']), 'Medium');
        $addRule($and($sev['Medium'], $imp['Low'], $usr['Many']), 'Medium');
        
        $addRule($and($sev['Medium'], $imp['Medium'], $usr['Few']), 'Medium');
        $addRule($and($sev['Medium'], $imp['Medium'], $usr['Moderate']), 'Medium');
        $addRule($and($sev['Medium'], $imp['Medium'], $usr['Many']), 'High');
        
        $addRule($and($sev['Medium'], $imp['High'], $usr['Few']), 'Medium');
        $addRule($and($sev['Medium'], $imp['High'], $usr['Moderate']), 'High');
        $addRule($and($sev['Medium'], $imp['High'], $usr['Many']), 'Critical');

        // --- Aturan saat Severity HIGH ---
        $addRule($and($sev['High'], $imp['Low'], $usr['Few']), 'Medium');
        $addRule($and($sev['High'], $imp['Low'], $usr['Moderate']), 'High');
        $addRule($and($sev['High'], $imp['Low'], $usr['Many']), 'High');
        
        $addRule($and($sev['High'], $imp['Medium'], $usr['Few']), 'Medium');
        $addRule($and($sev['High'], $imp['Medium'], $usr['Moderate']), 'High');
        $addRule($and($sev['High'], $imp['Medium'], $usr['Many']), 'Critical');
        
        $addRule($and($sev['High'], $imp['High'], $usr['Few']), 'High');
        $addRule($and($sev['High'], $imp['High'], $usr['Moderate']), 'Critical');
        $addRule($and($sev['High'], $imp['High'], $usr['Many']), 'Critical');

        return $rules;
    }

    /**
     * Defuzzifikasi menggunakan Weighted Average
     * Rumus: Z = sum(alpha_i * z_i) / sum(alpha_i)
     */
    private function defuzzify($rules)
    {
        $numerator = 0;
        $denominator = 0;

        foreach ($rules as $rule) {
            $numerator += $rule['alpha'] * $rule['z'];
            $denominator += $rule['alpha'];
        }

        if ($denominator == 0) {
            return 0; // Menghindari division by zero
        }

        return $numerator / $denominator;
    }

    /**
     * Menentukan label berdasarkan aturan spesifik:
     * 0-25 Low, 26-50 Medium, 51-75 High, 76-100 Critical
     */
    private function determineLabel($score)
    {
        // Membulatkan skor ke bawah atau format integer terdekat jika diperlukan, 
        // namun bisa juga diproses secara float. Di sini kita proses berbasis komparasi numerik baku.
        if ($score <= 25) return 'Low';
        if ($score <= 50) return 'Medium';
        if ($score <= 75) return 'High';
        return 'Critical';
    }

    private function triangle($x, $a, $b, $c)
    {
        if ($x <= $a || $x >= $c) {
            return 0.0;
        } elseif ($x > $a && $x <= $b) {
            return ($b == $a) ? 1.0 : ($x - $a) / ($b - $a);
        } elseif ($x > $b && $x < $c) {
            return ($c == $b) ? 1.0 : ($c - $x) / ($c - $b);
        }
        return 0.0;
    }

    private function trapezoid($x, $a, $b, $c, $d)
    {
        if ($x <= $a || $x >= $d) {
            return 0.0;
        } elseif ($x > $a && $x <= $b) {
            return ($b == $a) ? 1.0 : ($x - $a) / ($b - $a);
        } elseif ($x > $b && $x <= $c) {
            return 1.0;
        } elseif ($x > $c && $x < $d) {
            return ($d == $c) ? 1.0 : ($d - $x) / ($d - $c);
        }
        return 0.0;
    }
}
