<?php

namespace App\Http\Controllers\Chat;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\User;
use App\Notifications\NewMessageNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Notification;

class MessageController extends Controller
{
    /**
     * GET /chat/conversations/{conversation}/messages
     */
    public function index(Conversation $conversation)
    {
        Gate::authorize('talk-in-conversation', $conversation);
        abort_if(! $conversation->is_active, 403, 'Conversation is not active.');

        $messages = $conversation->messages()
            ->with(['sender:id,name', 'attachments'])
            ->orderBy('sent_at', 'asc')
            ->paginate(50);

        return response()->json($messages);
    }

    /**
     * POST /chat/conversations/{conversation}/messages
     */
    public function send(Request $request, Conversation $conversation)
    {
        Gate::authorize('talk-in-conversation', $conversation);
        abort_if(! $conversation->is_active, 403, 'Conversation is not active.');

        $data = $request->validate([
            'type'     => 'nullable|in:text,attachment,system,proposal',
            'body'     => 'nullable|string',
            'payload'  => 'nullable|array',
            'files.*'  => 'file|max:20480', // 20 MB per file
        ]);

        $message = DB::transaction(function () use ($request, $conversation, $data) {
            $msg = $conversation->messages()->create([
                'sender_id' => $request->user()->id,
                'type'      => $data['type'] ?? ($request->hasFile('files') ? 'attachment' : 'text'),
                'body'      => $data['body'] ?? null,
                'payload'   => $data['payload'] ?? null,
                'sent_at'   => now(),
            ]);

            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $path = $file->store('chat/attachments', 'public');
                    $msg->attachments()->create([
                        'disk'          => 'public',
                        'path'          => $path,
                        'original_name' => $file->getClientOriginalName(),
                        'mime'          => $file->getClientMimeType(),
                        'size'          => $file->getSize(),
                    ]);
                }
            }

            // Update last activity di conversation
            $conversation->update(['last_message_at' => $msg->sent_at]);

            return $msg->load('sender:id,name', 'attachments');
        });

        // Kirim notifikasi realtime + simpan ke DB notifications
        $recipientIds = $conversation->participants()
            ->where('users.id', '!=', $request->user()->id)
            ->pluck('users.id');

        if ($recipientIds->isNotEmpty()) {
            $recipients = User::whereIn('id', $recipientIds)->get();
            Notification::send($recipients, new NewMessageNotification($message));

                // Update unread count untuk penerima
                foreach ($recipientIds as $recipientId) {
                    $participant = $conversation->participantLinks()
                        ->where('user_id', $recipientId)
                        ->first();

                    $unread = $conversation->messages()
                        ->where('sent_at', '>', $participant?->last_read_at ?? now()->subCentury())
                        ->count();

                    broadcast(new \App\Events\ConversationUnreadUpdated(
                        $conversation->id,
                        $recipientId,
                        $unread
                    ))->toOthers();
                }

        }

        // Broadcast ke channel conversation.{id} 
        broadcast(new MessageSent($message))->toOthers();

        return response()->json(['message' => $message], 201);
    }

    /**
     * POST /chat/conversations/{conversation}/read
     */
    public function markRead(Conversation $conversation)
    {
        Gate::authorize('talk-in-conversation', $conversation);

        $userId = auth()->id();

        $conversation->participantLinks()
            ->where('user_id', $userId)
            ->update(['last_read_at' => now()]);

        // broadcast update unread count = 0
        broadcast(new \App\Events\ConversationUnreadUpdated(
            $conversation->id,
            $userId,
            0
        ))->toOthers();

        return response()->noContent();
    }
}
