<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Conversation;

/*
|--------------------------------------------------------------------------
| Base broadcast channels
|--------------------------------------------------------------------------
| Channel ini dipakai untuk otorisasi user pada private channel
| seperti conversation dan notifikasi personal.
*/

Broadcast::channel('conversation.{id}', function ($user, $id) {
    if (!is_numeric($id)) {
        return false; // keamanan tambahan
    }

    return \App\Models\Conversation::whereKey($id)
        ->where('is_active', true)
        ->whereHas('participants', function ($q) use ($user) {
            $q->where('user_id', $user->id)
              ->where('is_active', true);
        })
        ->exists();
});

Broadcast::channel('user.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

/*
|--------------------------------------------------------------------------
| Chatify specific channels (optional)
|--------------------------------------------------------------------------
| Hanya akan dimuat jika modul Chatify punya file channels sendiri.
| Aman untuk dilewati jika tidak ada file tersebut.
*/

$chatifyChannels = base_path('routes/chatify/channels.php');
if (file_exists($chatifyChannels)) {
    require_once $chatifyChannels;
}
