<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeveloperProfile extends Model
{
    protected $table = 'developer_profiles';

    protected $fillable = [
        'user_id',
        'headline',
        'experience',
        'rate_min_byproject',
        'rate_max_byproject',
        'availability',
        'experience_years',
        'education',
        'certifications',
        'portfolio_links',
        'rating_average',
        'rating_count',
        'projects_completed',
    ];

    protected $casts = [
        'rate_min_byproject' => 'float',
        'rate_max_byproject' => 'float',
        'rating_average'     => 'float',
        'portfolio_links'    => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function skills()
    {
        return $this->hasManyThrough(
            Skill::class,
            SkillUser::class,
            'user_id',      // FK di skill_user
            'id',           // PK di skills
            'user_id',      // FK di developer_profiles
            'skill_id'      // FK di skill_user
        );
    }
}
