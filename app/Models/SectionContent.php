<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SectionContent extends Model
{
    protected $fillable = [
        'section',
        'key',
        'value',
        'language',
    ];
}
