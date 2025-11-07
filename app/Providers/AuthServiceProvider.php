<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Conversation;
use App\Models\Offer;
use App\Policies\OfferPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Offer::class => OfferPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('talk-in-conversation', function (User $user, Conversation $conversation) {
            return $conversation->participants()
                ->where('users.id', $user->id)
                ->exists();
        });
    }
}
