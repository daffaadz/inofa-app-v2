<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Event → Listener mapping.
     */
    protected $listen = [
        // 🧾 Saat offer dibuat, otomatis buat percakapan
        \App\Events\OfferCreated::class => [
            \App\Listeners\CreateConversationForOffer::class,
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
