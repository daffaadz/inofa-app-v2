<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // guard sesuai skenario login.
        Broadcast::routes(['middleware' => ['web','auth']]);

        // Kalau benar2 butuh Sanctum token, ganti jadi:
        // Broadcast::routes(['middleware' => ['auth:sanctum']]);

        // Muat definisi channel:
        require base_path('routes/channels.php');

        // (Opsional, khusus Chatify)
        $chatifyChannels = base_path('routes/chatify/channels.php');
        if (file_exists($chatifyChannels)) {
            require $chatifyChannels;
        }
    }
}
