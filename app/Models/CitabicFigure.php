<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CitabicFigure extends Model
{
    protected $fillable = [
        'citabic_profile_id',
        'label',
        'value',
        'sort_order',
        'translations',
    ];

    protected function casts(): array
    {
        return [
            'translations' => 'array',
        ];
    }

    public function profile()
    {
        return $this->belongsTo(CitabicProfile::class, 'citabic_profile_id');
    }
}
