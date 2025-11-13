<?php

namespace App\Listeners;

use App\Events\PaymentStatusUpdated;
use App\Events\MessageSent;

class BroadcastPaymentStatusUpdate
{
    public function handle(PaymentStatusUpdated $event): void
    {
        $payment = $event->payment;
        $agreement = $payment->agreement;
        $conversation = $agreement->conversation;

        if (! $conversation) return;

        // Buat pesan sistem otomatis di chat
        $msg = $conversation->messages()->create([
            'sender_id' => $agreement->consumer_id,
            'type' => 'system',
            'body' => match ($payment->status) {
                'pending'     => ' Pembayaran sedang menunggu konfirmasi admin.',
                'confirmed'   => ' Pembayaran dikonfirmasi dan dana ditahan di escrow.',
                'transferred' => ' Dana telah ditransfer ke developer.',
                'refunded'    => ' Dana telah dikembalikan ke customer.',
                default       => ' Status pembayaran diperbarui.',
            },
            'payload' => [
                'payment_id' => $payment->id,
                'status' => $payment->status,
                'amount' => (string)$payment->amount,
            ],
            'sent_at' => now(),
        ]);

        broadcast(new MessageSent($msg->load('sender')))->toOthers();
    }
}
