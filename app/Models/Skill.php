<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;


class Skill extends Model
{
    use HasFactory, Searchable;
    
    protected $fillable = [
        'name',
        'slug',
        'category',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'skill_user')
                    ->withPivot('proficiency_level')
                    ->withTimestamps();
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_skills')
                    ->withPivot('required_level')
                    ->withTimestamps();
    }
}