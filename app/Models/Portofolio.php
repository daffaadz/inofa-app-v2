<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'image_url',
        'project_url',
        'technologies',
        'completed_at',
        'is_featured',
        'sort_order',
    ];

    protected $casts = [
        'technologies' => 'array',
        'completed_at' => 'date',
        'is_featured'  => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}