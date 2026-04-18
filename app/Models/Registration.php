<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'nrp',
        'faculty',
        'department',
        'major',
        'ukm',
        'phone',
        'has_allergy',
        'allergy_description',
        'integrity_accepted_at',
        'ip_address',
        'user_agent',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'has_allergy' => 'boolean',
            'integrity_accepted_at' => 'datetime',
        ];
    }
}