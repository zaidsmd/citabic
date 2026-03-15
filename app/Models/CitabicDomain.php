<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CitabicDomain extends Model
{
    protected $fillable = [
        'citabic_profile_id',
        'title',
        'items',
        'sort_order',
        'translations',
    ];

    protected function casts(): array
    {
        return [
            'items' => 'array',
            'translations' => 'array',
        ];
    }

    public function profile()
    {
        return $this->belongsTo(CitabicProfile::class, 'citabic_profile_id');
    }
}
