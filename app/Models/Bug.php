<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bug extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'description',
        'severity',
        'impact',
        'affected_users',
        'mamdani_score',
        'mamdani_label',
        'sugeno_score',
        'sugeno_label',
        'tsukamoto_score',
        'tsukamoto_label',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'severity' => 'integer',
            'impact' => 'integer',
            'affected_users' => 'integer',
            'mamdani_score' => 'decimal:2',
            'sugeno_score' => 'decimal:2',
            'tsukamoto_score' => 'decimal:2',
        ];
    }
}
