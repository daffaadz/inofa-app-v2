<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Event → Listener mapping.
     */
    protected $listen = [
        //  buat escrow payment
        \App\Events\AgreementAccepted::class => [
            \App\Listeners\CreateEscrowPayment::class,
        ],
        // broadcast update status payment
        \App\Events\PaymentStatusUpdated::class => [
        \App\Listeners\BroadcastPaymentStatusUpdate::class,
    ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        parent::boot();
    }
}
