<?php

namespace App\Http\Controllers;

use Chatify\Http\Controllers\MessagesController as BaseController;

class CustomChatifyController extends BaseController
{
    // Override fungsi yang perlu disesuaikan
    public function fetch(Request $request)
    {
        // Ambil dari tabel conversations custom kamu
        $conversation = \App\Models\Conversation::with('participants', 'messages')
            ->findOrFail($request->conversation_id);

        return response()->json([
            'messages' => $conversation->messages,
            'participants' => $conversation->participants,
        ]);
    }
}
