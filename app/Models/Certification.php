<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Certification extends Model
{
    protected $table = 'certifications';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'language',
        'image',
    ];
}
