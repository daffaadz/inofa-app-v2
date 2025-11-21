<?php

namespace Database\Seeders;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Database\Seeder;

class ConversationSeeder extends Seeder
{
    public function run()
    {
        $users = User::take(2)->get();

        if ($users->count() < 2) {
            // Buat user dummy jika kurang
            $users = collect([
                User::first(),
                User::create([
                    'name' => 'Test User',
                    'email' => 'test@example.com',
                    'password' => bcrypt('password'),
                ])
            ]);
        }

        // Buat 3 conversation
        for ($i = 0; $i < 3; $i++) {
            $conversation = Conversation::create([
                'type' => 'private',
                'title' => 'Chat ' . ($i + 1),
                'last_message_at' => now()->subDays($i),
                'is_active' => true,
            ]);

            $conversation->participants()->attach([
                $users[0]->id => ['role' => 'admin', 'joined_at' => now(), 'is_active' => true],
                $users[1]->id => ['role' => 'participant', 'joined_at' => now(), 'is_active' => true],
            ]);

            // Buat beberapa pesan
            $messages = [
                ['sender' => $users[1]->id, 'body' => 'Hello! How are you?', 'time' => 5],
                ['sender' => $users[0]->id, 'body' => 'Hi! I\'m doing great, thanks!', 'time' => 3],
                ['sender' => $users[1]->id, 'body' => 'That\'s wonderful to hear!', 'time' => 1],
            ];

            foreach ($messages as $msg) {
                $conversation->messages()->create([
                    'sender_id' => $msg['sender'],
                    'type' => 'text',
                    'body' => $msg['body'],
                    'sent_at' => now()->subMinutes($msg['time']),
                ]);
            }

            $conversation->update(['last_message_at' => now()]);
        }

        $this->command->info('✅ Created 3 conversations with messages');
    }
}
