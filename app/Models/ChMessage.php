<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Chatify\Traits\UUID;

class ChMessage extends Model
{
    use UUID;

    // Pastikan tabel mengarah ke ch_messages
    protected $table = 'ch_messages';

    // HAPUS baris ini agar Auto Increment berfungsi normal kembali
    // public $incrementing = false; 

    // Update fillable
    protected $fillable = [
        'from_id', // Hapus 'id' dari sini, biarkan auto-generate
        'to_id',
        'body',
        'attachment',
        'seen',
        'conversation_id',
        'project_agreement_id', 
        'metadata',             
    ];

    protected $casts = [
        'metadata' => 'array',
        'seen' => 'boolean',
    ];

    /**
     * Relationship dengan conversation
     */
    public function conversation()
    {
        return $this->belongsTo(Conversation::class, 'conversation_id');
    }

    /**
     * Relationship dengan sender
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'from_id');
    }

    /**
     * Relationship dengan receiver
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'to_id');
    }

    /**
     * Relasi ke Project Agreement
     */
    public function projectAgreement()
    {
        return $this->belongsTo(ProjectAgreement::class, 'project_agreement_id');
    }

    /**
     * Check if message is a proposal
     */
    public function isProposal()
    {
        return !is_null($this->project_agreement_id);
    }

    /**
     * Get parsed metadata
     */
    public function getMetadataAttribute($value)
    {
        return $value ? json_decode($value, true) : null;
    }

    /**
     * Set metadata
     */
    public function setMetadataAttribute($value)
    {
        $this->attributes['metadata'] = is_array($value) ? json_encode($value) : $value;
    }

    /**
     * Scope for proposal messages
     */
    public function scopeProposals($query)
    {
        return $query->whereNotNull('project_agreement_id');
    }

    /**
     * Scope for between two users
     */
    public function scopeBetween($query, $userId1, $userId2)
    {
        return $query->where(function ($q) use ($userId1, $userId2) {
            $q->where('from_id', $userId1)->where('to_id', $userId2);
        })->orWhere(function ($q) use ($userId1, $userId2) {
            $q->where('from_id', $userId2)->where('to_id', $userId1);
        });
    }
}