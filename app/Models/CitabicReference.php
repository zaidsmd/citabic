<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CitabicReference extends Model
{
    protected $fillable = [
        'slug',
        'title',
        'client',
        'image',
        'summary',
        'description',
        'surface',
        'budget',
        'items',
        'blocks',
        'translations',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'items' => 'array',
            'blocks' => 'array',
            'translations' => 'array',
        ];
    }
}
