<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;

class Project extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'consumer_id',
        'title',
        'description',
        'budget',
        'deadline',
        'status',
        'views_count',
        'is_featured',
        'requirements',
    ];

    protected $casts = [
        'budget'       => 'decimal:2',
        'deadline'     => 'date',
        'is_featured'  => 'boolean',
        'requirements' => 'array',
    ];

    public function consumer()
    {
        return $this->belongsTo(User::class, 'consumer_id');
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'project_skills')
                    ->withPivot('required_level')
                    ->withTimestamps();
    }

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    public function agreement()
    {
        return $this->hasOne(ProjectAgreement::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function conversations()
    {
        return $this->hasMany(Conversation::class);
    }
}