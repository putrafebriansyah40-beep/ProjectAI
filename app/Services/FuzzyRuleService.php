<?php

namespace App\Services;

class FuzzyRuleService
{
    /**
     * Mengevaluasi dan mendapatkan rule yang paling dominan (kontribusi terbesar)
     */
    public function getActiveRule($severity, $impact, $affected_users)
    {
        $sev = $this->fuzzifySeverity($severity);
        $imp = $this->fuzzifyImpact($impact);
        $usr = $this->fuzzifyUsers($affected_users);

        $rules = $this->evaluateRules($sev, $imp, $usr);
        
        $maxRule = null;
        $maxAlpha = -1;

        foreach ($rules as $rule) {
            if ($rule['alpha'] > $maxAlpha) {
                $maxAlpha = $rule['alpha'];
                $maxRule = $rule;
            }
        }

        return $maxRule;
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

    private function evaluateRules($sev, $imp, $usr)
    {
        $rules = [];
        $and = function (...$values) {
            return min($values);
        };

        $addRule = function($alpha, $sevLabel, $impLabel, $usrLabel, $priorityLabel) use (&$rules) {
            $rules[] = [
                'alpha' => $alpha,
                'severity' => $sevLabel,
                'impact' => $impLabel,
                'users' => $usrLabel,
                'priority' => $priorityLabel
            ];
        };

        // --- Aturan saat Severity LOW ---
        $addRule($and($sev['Low'], $imp['Low'], $usr['Few']), 'Low', 'Low', 'Few', 'Low');
        $addRule($and($sev['Low'], $imp['Low'], $usr['Moderate']), 'Low', 'Low', 'Moderate', 'Low');
        $addRule($and($sev['Low'], $imp['Low'], $usr['Many']), 'Low', 'Low', 'Many', 'Medium');
        
        $addRule($and($sev['Low'], $imp['Medium'], $usr['Few']), 'Low', 'Medium', 'Few', 'Low');
        $addRule($and($sev['Low'], $imp['Medium'], $usr['Moderate']), 'Low', 'Medium', 'Moderate', 'Medium');
        $addRule($and($sev['Low'], $imp['Medium'], $usr['Many']), 'Low', 'Medium', 'Many', 'Medium');
        
        $addRule($and($sev['Low'], $imp['High'], $usr['Few']), 'Low', 'High', 'Few', 'Medium');
        $addRule($and($sev['Low'], $imp['High'], $usr['Moderate']), 'Low', 'High', 'Moderate', 'Medium');
        $addRule($and($sev['Low'], $imp['High'], $usr['Many']), 'Low', 'High', 'Many', 'High');

        // --- Aturan saat Severity MEDIUM ---
        $addRule($and($sev['Medium'], $imp['Low'], $usr['Few']), 'Medium', 'Low', 'Few', 'Low');
        $addRule($and($sev['Medium'], $imp['Low'], $usr['Moderate']), 'Medium', 'Low', 'Moderate', 'Medium');
        $addRule($and($sev['Medium'], $imp['Low'], $usr['Many']), 'Medium', 'Low', 'Many', 'Medium');
        
        $addRule($and($sev['Medium'], $imp['Medium'], $usr['Few']), 'Medium', 'Medium', 'Few', 'Medium');
        $addRule($and($sev['Medium'], $imp['Medium'], $usr['Moderate']), 'Medium', 'Medium', 'Moderate', 'Medium');
        $addRule($and($sev['Medium'], $imp['Medium'], $usr['Many']), 'Medium', 'Medium', 'Many', 'High');
        
        $addRule($and($sev['Medium'], $imp['High'], $usr['Few']), 'Medium', 'High', 'Few', 'Medium');
        $addRule($and($sev['Medium'], $imp['High'], $usr['Moderate']), 'Medium', 'High', 'Moderate', 'High');
        $addRule($and($sev['Medium'], $imp['High'], $usr['Many']), 'Medium', 'High', 'Many', 'Critical');

        // --- Aturan saat Severity HIGH ---
        $addRule($and($sev['High'], $imp['Low'], $usr['Few']), 'High', 'Low', 'Few', 'Medium');
        $addRule($and($sev['High'], $imp['Low'], $usr['Moderate']), 'High', 'Low', 'Moderate', 'High');
        $addRule($and($sev['High'], $imp['Low'], $usr['Many']), 'High', 'Low', 'Many', 'High');
        
        $addRule($and($sev['High'], $imp['Medium'], $usr['Few']), 'High', 'Medium', 'Few', 'Medium');
        $addRule($and($sev['High'], $imp['Medium'], $usr['Moderate']), 'High', 'Medium', 'Moderate', 'High');
        $addRule($and($sev['High'], $imp['Medium'], $usr['Many']), 'High', 'Medium', 'Many', 'Critical');
        
        $addRule($and($sev['High'], $imp['High'], $usr['Few']), 'High', 'High', 'Few', 'High');
        $addRule($and($sev['High'], $imp['High'], $usr['Moderate']), 'High', 'High', 'Moderate', 'Critical');
        $addRule($and($sev['High'], $imp['High'], $usr['Many']), 'High', 'High', 'Many', 'Critical');

        return $rules;
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
