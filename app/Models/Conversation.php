<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = [
        'title',
        'type',
        'project_id',
        'metadata',
        'is_active',
        'last_message_at',
    ];

    protected $casts = [
        'metadata'       => 'array',
        'is_active'      => 'boolean',
        'last_message_at'=> 'datetime',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'conversation_participants')
                    ->withPivot(['role', 'joined_at', 'last_read_at', 'is_active'])
                    ->withTimestamps();
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}