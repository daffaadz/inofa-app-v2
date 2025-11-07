<?php

namespace App\Notifications;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class NewMessageNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    public function __construct(public Message $message) {}

    public function via($notifiable)
    {
        // Simpan di database + kirim ke Pusher
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'conversation_id' => $this->message->conversation_id,
            'message_id' => $this->message->id,
            'sender' => [
                'id' => $this->message->sender_id,
                'name' => $this->message->sender->name,
            ],
            'preview' => Str::limit($this->message->body ?? '[attachment]', 80),
        ];
    }

    public function toBroadcast($notifiable)
    {
        // Data yang dikirim realtime ke frontend (Echo/Pusher)
        return new BroadcastMessage($this->toDatabase($notifiable));
    }

    public function broadcastOn()
    {
        $recipientIds = $this->message->conversation
            ->participants()
            ->where('users.id', '!=', $this->message->sender_id)
            ->pluck('users.id');

        // Kirim notifikasi ke setiap channel user.{id}
        return $recipientIds->map(fn($id) => new \Illuminate\Broadcasting\PrivateChannel('user.' . $id));
    }

    public function broadcastAs()
    {
        return 'new.message';
    }
}
