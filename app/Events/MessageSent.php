<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Message $message) {}

    public function broadcastOn()
    {
        return new PrivateChannel('conversation.'.$this->message->conversation_id);
    }

    public function broadcastAs()
    {
        return 'message.sent';
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->message->id,
            'type' => $this->message->type,
            'body' => $this->message->body,
            'payload' => $this->message->payload,
            'sender' => [
                'id' => $this->message->sender_id,
                'name' => $this->message->sender->name,
            ],
            'attachments' => $this->message->attachments->map(fn($a) => [
                'url'=> $a->url(),
                'name'=> $a->original_name,
                'mime'=> $a->mime,
                'size'=> $a->size,
            ]),
            'sent_at' => $this->message->sent_at?->toIso8601String(),
        ];
    }
}
