<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'project_id',
        'consumer_id',
        'developer_id',
        'rating',
        'comment',
        'rating_breakdown',
        'is_public',
    ];

    protected $casts = [
        'rating'          => 'integer',
        'rating_breakdown'=> 'array',
        'is_public'       => 'boolean',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function consumer()
    {
        return $this->belongsTo(User::class, 'consumer_id');
    }

    public function developer()
    {
        return $this->belongsTo(User::class, 'developer_id');
    }
}