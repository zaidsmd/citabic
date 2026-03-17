<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApproachItemTranslation extends Model
{
    protected $fillable = [
        'label',
        'title',
        'description',
        'locale',
        'approach_item_id',
    ];

    public function approachItem()
    {
        return $this->belongsTo(ApproachItem::class);
    }
}

