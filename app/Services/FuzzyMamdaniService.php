<?php

namespace App\Services;

class FuzzyMamdaniService
{
    /**
     * Menghitung nilai prioritas bug menggunakan metode Fuzzy Mamdani
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

        // 2. Evaluasi Rule (Mencari derajat kebenaran setiap rule)
        $rules_activation = $this->evaluateRules($sev, $imp, $usr);

        // 3 & 4. Agregasi dan Defuzzifikasi (Metode Centroid)
        $score = $this->defuzzify($rules_activation);

        // Penentuan Label Akhir berdasarkan rentang skor
        $label = $this->determineLabel($score);

        return [
            'score' => round($score, 2),
            'label' => $label
        ];
    }

    /**
     * Fuzzifikasi variabel Severity
     * Low [0, 0, 20, 40], Medium [20, 50, 80], High [60, 80, 100, 100]
     */
    private function fuzzifySeverity($x)
    {
        return [
            'Low'    => $this->trapezoid($x, 0, 0, 20, 40),
            'Medium' => $this->triangle($x, 20, 50, 80),
            'High'   => $this->trapezoid($x, 60, 80, 100, 100),
        ];
    }

    /**
     * Fuzzifikasi variabel Impact
     * Low [0, 0, 25, 45], Medium [25, 50, 75], High [55, 75, 100, 100]
     */
    private function fuzzifyImpact($x)
    {
        return [
            'Low'    => $this->trapezoid($x, 0, 0, 25, 45),
            'Medium' => $this->triangle($x, 25, 50, 75),
            'High'   => $this->trapezoid($x, 55, 75, 100, 100),
        ];
    }

    /**
     * Fuzzifikasi variabel Affected Users
     * Few [0, 0, 30, 50], Moderate [30, 60, 90], Many [70, 90, 100, 100]
     */
    private function fuzzifyUsers($x)
    {
        return [
            'Few'      => $this->trapezoid($x, 0, 0, 30, 50),
            'Moderate' => $this->triangle($x, 30, 60, 90),
            'Many'     => $this->trapezoid($x, 70, 90, 100, 100),
        ];
    }

    /**
     * Evaluasi 27 Aturan (Rule Base)
     * Menggunakan operator MIN untuk kondisi AND
     * Mengembalikan aktivasi maksimum untuk masing-masing label konsekuen
     */
    private function evaluateRules($sev, $imp, $usr)
    {
        // Menyimpan nilai aktivasi maksimal untuk masing-masing output himpunan fuzzy
        $priority = [
            'Low'      => 0.0,
            'Medium'   => 0.0,
            'High'     => 0.0,
            'Critical' => 0.0,
        ];

        // Helper function untuk fungsi AND (Min)
        $and = function (...$values) {
            return min($values);
        };

        // --- Aturan saat Severity LOW (9 Rules) ---
        $this->updateMax($priority['Low'],    $and($sev['Low'], $imp['Low'], $usr['Few']));
        $this->updateMax($priority['Low'],    $and($sev['Low'], $imp['Low'], $usr['Moderate']));
        $this->updateMax($priority['Medium'], $and($sev['Low'], $imp['Low'], $usr['Many']));
        
        $this->updateMax($priority['Low'],    $and($sev['Low'], $imp['Medium'], $usr['Few']));
        $this->updateMax($priority['Medium'], $and($sev['Low'], $imp['Medium'], $usr['Moderate']));
        $this->updateMax($priority['Medium'], $and($sev['Low'], $imp['Medium'], $usr['Many']));
        
        $this->updateMax($priority['Medium'], $and($sev['Low'], $imp['High'], $usr['Few']));
        $this->updateMax($priority['Medium'], $and($sev['Low'], $imp['High'], $usr['Moderate']));
        $this->updateMax($priority['High'],   $and($sev['Low'], $imp['High'], $usr['Many']));

        // --- Aturan saat Severity MEDIUM (9 Rules) ---
        $this->updateMax($priority['Low'],    $and($sev['Medium'], $imp['Low'], $usr['Few']));
        $this->updateMax($priority['Medium'], $and($sev['Medium'], $imp['Low'], $usr['Moderate']));
        $this->updateMax($priority['Medium'], $and($sev['Medium'], $imp['Low'], $usr['Many']));
        
        $this->updateMax($priority['Medium'], $and($sev['Medium'], $imp['Medium'], $usr['Few']));
        $this->updateMax($priority['Medium'], $and($sev['Medium'], $imp['Medium'], $usr['Moderate']));
        $this->updateMax($priority['High'],   $and($sev['Medium'], $imp['Medium'], $usr['Many']));
        
        $this->updateMax($priority['Medium'], $and($sev['Medium'], $imp['High'], $usr['Few']));
        $this->updateMax($priority['High'],   $and($sev['Medium'], $imp['High'], $usr['Moderate']));
        $this->updateMax($priority['Critical'],$and($sev['Medium'], $imp['High'], $usr['Many']));

        // --- Aturan saat Severity HIGH (9 Rules) ---
        $this->updateMax($priority['Medium'], $and($sev['High'], $imp['Low'], $usr['Few']));
        $this->updateMax($priority['High'],   $and($sev['High'], $imp['Low'], $usr['Moderate']));
        $this->updateMax($priority['High'],   $and($sev['High'], $imp['Low'], $usr['Many']));
        
        $this->updateMax($priority['Medium'], $and($sev['High'], $imp['Medium'], $usr['Few']));
        $this->updateMax($priority['High'],   $and($sev['High'], $imp['Medium'], $usr['Moderate']));
        $this->updateMax($priority['Critical'],$and($sev['High'], $imp['Medium'], $usr['Many']));
        
        $this->updateMax($priority['High'],   $and($sev['High'], $imp['High'], $usr['Few']));
        $this->updateMax($priority['Critical'],$and($sev['High'], $imp['High'], $usr['Moderate']));
        $this->updateMax($priority['Critical'],$and($sev['High'], $imp['High'], $usr['Many']));

        return $priority;
    }

    /**
     * Update nilai maksimal jika ada rule lain yang menghasilkan derajat kebenaran lebih tinggi
     */
    private function updateMax(&$currentMax, $newValue)
    {
        if ($newValue > $currentMax) {
            $currentMax = $newValue;
        }
    }

    /**
     * Mengambil nilai keanggotaan output Priority pada titik sampel x
     */
    private function getOutputMembership($x, $label)
    {
        switch ($label) {
            case 'Low':
                return $this->trapezoid($x, 0, 0, 25, 50);
            case 'Medium':
                return $this->triangle($x, 25, 50, 75);
            case 'High':
                return $this->triangle($x, 50, 75, 100);
            case 'Critical':
                return $this->trapezoid($x, 75, 90, 100, 100);
            default:
                return 0;
        }
    }

    /**
     * Defuzzifikasi menggunakan metode Centroid (titik berat)
     * Membagi area di bawah kurva agregasi untuk mencari nilai tegas (crisp)
     */
    private function defuzzify($priority)
    {
        $numerator = 0;
        $denominator = 0;
        
        // Melakukan sampling nilai z dari 0 hingga 100 dengan step 1
        for ($x = 0; $x <= 100; $x++) {
            $maxMembershipAtX = 0;
            
            // Evaluasi nilai keanggotaan gabungan (agregasi MAX) pada titik x
            foreach ($priority as $label => $activation) {
                // Potong (clip) himpunan fuzzy output berdasarkan aktivasi rule (metode MIN)
                $membershipValue = min($activation, $this->getOutputMembership($x, $label));
                if ($membershipValue > $maxMembershipAtX) {
                    $maxMembershipAtX = $membershipValue;
                }
            }
            
            // Rumus centroid: sum(x * miu(x)) / sum(miu(x))
            $numerator += $x * $maxMembershipAtX;
            $denominator += $maxMembershipAtX;
        }

        if ($denominator == 0) {
            return 0; // Menghindari division by zero
        }

        return $numerator / $denominator;
    }

    /**
     * Menentukan label akhir (Low, Medium, High, Critical) berdasarkan skor crisp
     */
    private function determineLabel($score)
    {
        if ($score < 40) return 'Low';
        if ($score < 65) return 'Medium';
        if ($score < 85) return 'High';
        return 'Critical';
    }

    /**
     * Fungsi Keanggotaan Segitiga
     */
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

    /**
     * Fungsi Keanggotaan Trapesium
     */
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
