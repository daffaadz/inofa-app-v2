<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Chat\MessageController as ChatMessageController;
use App\Http\Controllers\Controller;
use App\Models\Conversation;
use Illuminate\Http\Request;

class ChatController extends ChatMessageController
{
    /**
     * fetch messages dari tabel 
     * GET /chatify/fetch?conversation_id=...
     */
    public function fetch(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required|exists:conversations,id',
        ]);

        $conversation = Conversation::with([
            'participants:id,name',
            'messages' => fn ($q) => $q->with('sender:id,name')->orderBy('sent_at', 'asc'),
        ])->findOrFail($request->conversation_id);

        return response()->json([
            'messages'     => $conversation->messages,
            'participants' => $conversation->participants,
        ]);
    }
}
