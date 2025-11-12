<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class ConversationUnreadUpdated implements ShouldBroadcast
{
    use SerializesModels;

    public int $conversationId;
    public int $userId;
    public int $unreadCount;

    public function __construct(int $conversationId, int $userId, int $unreadCount)
    {
        $this->conversationId = $conversationId;
        $this->userId = $userId;
        $this->unreadCount = $unreadCount;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('user.' . $this->userId);
    }

    public function broadcastAs()
    {
        return 'conversation.unread.updated';
    }

    public function broadcastWith()
    {
        return [
            'conversation_id' => $this->conversationId,
            'unread_count' => $this->unreadCount,
        ];
    }
}
