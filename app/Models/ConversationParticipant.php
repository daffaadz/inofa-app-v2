<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ConversationParticipant extends Pivot
{
    protected $table = 'conversation_participants';

    protected $casts = [
        'joined_at'   => 'datetime',
        'last_read_at'=> 'datetime',
        'is_active'   => 'boolean',
    ];
}