<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApproachItem extends Model
{
    protected $fillable = [
        'color',
        'icon',
        'order',
    ];

    public function translations()
    {
        return $this->hasMany(ApproachItemTranslation::class);
    }
}
