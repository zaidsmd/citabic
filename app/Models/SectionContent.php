<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SectionContent extends Model
{
    protected $fillable = [
        'key',
        'value',
        'language',
    ];
}
