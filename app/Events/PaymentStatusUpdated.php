<?php

namespace App\Events;

use App\Models\Payment;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PaymentStatusUpdated implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public Payment $payment;

    public function __construct(Payment $payment)
    {
        $this->payment = $payment->load('agreement.conversation');
    }

    public function broadcastOn()
    {
        $conversationId = $this->payment->agreement->conversation_id;
        return new PrivateChannel('conversation.' . $conversationId);
    }

    public function broadcastAs()
    {
        return 'payment.status.updated';
    }
}
