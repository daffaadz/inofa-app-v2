<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProjectSkill extends Pivot
{
    protected $table = 'project_skills';

    protected $casts = [
        'required_level' => 'integer',
    ];
}