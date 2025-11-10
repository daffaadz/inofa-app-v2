<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Pilih salah satu guard sesuai skenario login.
        // Kalau pakai session biasa (Echo + web guard):
        Broadcast::routes(['middleware' => ['web','auth']]);

        // Kalau benar2 butuh Sanctum token, ganti jadi:
        // Broadcast::routes(['middleware' => ['auth:sanctum']]);

        // Muat definisi channel:
        require base_path('routes/channels.php');

        // (Opsional, jika kamu sengaja pisahkan untuk modul Chatify)
        $chatifyChannels = base_path('routes/chatify/channels.php');
        if (file_exists($chatifyChannels)) {
            require $chatifyChannels;
        }
    }
}
