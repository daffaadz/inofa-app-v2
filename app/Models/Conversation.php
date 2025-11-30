<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Conversation extends Model
{
    use HasFactory;
    
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
        return $this->hasMany(ChMessage::class, 'conversation_id');
    }

    public function latestMessage()
    { 
        return $this->hasOne(ChMessage::class, 'conversation_id')->latest('created_at');
    }

    public function participantLinks()
    {
        return $this->hasMany(ConversationParticipant::class);
    }

}