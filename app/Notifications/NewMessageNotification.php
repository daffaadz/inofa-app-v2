<?php

namespace App\Notifications;

use App\Models\ChMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class NewMessageNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    public function __construct(public ChMessage $message) {}

    public function via($notifiable)
    {
        // Simpan di database + kirim ke Pusher
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        // Load sender relationship sekali saja
        $this->message->loadMissing('sender', 'conversation');

        return [
            'conversation_id' => $this->message->conversation_id,
            'message_id' => $this->message->id,
            'sender' => [
                'id' => $this->message->sender_id,
                'name' => $this->message->sender->name,
                'avatar' => $this->message->sender->avatar,
            ],
            'preview' => Str::limit($this->message->body ?? '[attachment]', 80),
            'sent_at' => $this->message->sent_at?->toIso8601String(),
        ];
    }

    public function toBroadcast($notifiable)
    {
        // Data yang dikirim realtime ke frontend (Echo/Pusher)
        return new BroadcastMessage($this->toDatabase($notifiable));
    }

    public function broadcastOn()
    {
        // Kirim ke channel user yang menerima saja
        $recipientIds = $this->message->conversation
            ->participantLinks()
            ->where('user_id', '!=', $this->message->sender_id)
            ->pluck('user_id');

        return $recipientIds->map(function ($id) {
            return new \Illuminate\Broadcasting\PrivateChannel('user.' . $id);
        })->toArray();
    }

    public function broadcastAs()
    {
        return 'new.message';
    }
}
