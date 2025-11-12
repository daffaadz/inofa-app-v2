<?php

namespace App\Listeners;

use App\Events\AgreementAccepted;
use App\Models\Payment;
use App\Events\MessageSent;

class CreateEscrowPayment
{
    public function handle(AgreementAccepted $event): void
    {
        $agreement = $event->agreement;

        // Buat (escrow) pertama sesuai skema payments 
        $payment = Payment::create([
            'project_agreement_id' => $agreement->id,
            'amount'               => $agreement->final_price,
            'type'                 => 'deposit',   
            'status'               => 'pending',   
            'payment_method'       => null,    
        ]);

        // Kirim pesan sistem ke chat room
        $conversation = $agreement->conversation;
        if ($conversation) {
            $msg = $conversation->messages()->create([
                'sender_id' => $agreement->consumer_id,
                'type'      => 'system',
                'body'      => " Pembayaran escrow dibuat untuk agreement #{$agreement->id}. Silakan lanjut ke halaman pembayaran.",
                'payload'   => [
                    'payment_id' => $payment->id,
                    'amount'     => (string) $payment->amount,
                    'status'     => $payment->status,
                ],
                'sent_at'   => now(),
            ]);

            broadcast(new MessageSent($msg->load('sender')))->toOthers();
        }
    }
}
