<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MissionTranslation extends Model
{
    protected $fillable = [
        'title',
        'description',
        'locale',
        'mission_id',
    ];

    public function mission()
    {
        return $this->belongsTo(Mission::class);
    }
}
