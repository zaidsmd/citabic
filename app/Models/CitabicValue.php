<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CitabicValue extends Model
{
    protected $fillable = [
        'citabic_profile_id',
        'type',
        'title',
        'text',
        'image',
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
