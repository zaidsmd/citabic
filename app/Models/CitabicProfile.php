<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CitabicProfile extends Model
{
    protected $fillable = [
        'name',
        'tagline',
        'full_name',
        'legal_name',
        'legal_form',
        'capital',
        'head_office',
        'ice',
        'company_created_at',
        'rc',
        'status',
        'phone',
        'email',
        'hero_video_path',
        'information_system',
        'language'
    ];

    public function processes()
    {
        return $this->hasMany(CitabicProcess::class, 'citabic_profile_id')->orderBy('sort_order');
    }

    public function values()
    {
        return $this->hasMany(CitabicValue::class, 'citabic_profile_id')->where('type', 'values')->orderBy('sort_order');
    }

    public function human_values()
    {
        return $this->hasMany(CitabicValue::class, 'citabic_profile_id')->where('type', 'human_values')->orderBy('sort_order');
    }

    public function domains()
    {
        return $this->hasMany(CitabicDomain::class, 'citabic_profile_id')->orderBy('sort_order');
    }

    public function figures()
    {
        return $this->hasMany(CitabicFigure::class, 'citabic_profile_id')->orderBy('sort_order');
    }

    public function infos()
    {
        return $this->hasMany(CitabicInfo::class, 'citabic_profile_id')->orderBy('sort_order');
    }

    public function getInfo(string $type)
    {
        return $this->infos()->where('type', $type)->get();
    }
}
