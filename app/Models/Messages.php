<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'conversation_id',
        'sender_id',
        'type',
        'body',
        'payload',
        'sent_at'
    ];

    protected $casts = [
        'payload' => 'array',
        'sent_at' => 'datetime',
    ];

    protected $dispatchesEvents = [
    'created' => \App\Events\MessageCreated::class,
    ];

    public function conversation(){ 
        return $this->belongsTo(Conversation::class); 
    }
    public function sender(){ 
        return $this->belongsTo(User::class,'sender_id'); 
    }
    public function attachments(){ 
        return $this->hasMany(Attachment::class); 
    }

    public function agreement() {
    return $this->belongsTo(ProjectAgreement::class);
    }
}