<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\ConversationParticipant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ConversationController extends Controller
{
    /**
     * GET /chat/conversations
     * List percakapan user (dengan last message & unread count).
     */
    public function index()
    {
        $userId = Auth::id();

        $conversations = Conversation::query()
            ->whereHas('participants', fn ($q) => $q->where('user_id', $userId))
            ->with([
                'participants' => fn ($q) => $q->select('users.id', 'users.name'),
                'messages'     => fn ($q) => $q->latest('sent_at')->limit(1)->with('sender:id,name'),
            ])
            ->orderByDesc('last_message_at')
            ->get()
            ->map(function ($c) use ($userId) {
                return [
                    'id'              => $c->id,
                    'title'           => $c->title,
                    'type'            => $c->type,
                    'project_id'      => $c->project_id,
                    'is_active'       => $c->is_active,
                    'last_message'    => $c->messages->first()?->body,
                    'last_message_at' => $c->last_message_at?->toIso8601String(),
                    'participants'    => $c->participants->map(fn ($p) => [
                        'id'   => $p->id,
                        'name' => $p->name,
                    ]),
                    'unread_count'    => $this->getUnreadCount($c, $userId),
                ];
            });

        return response()->json([
            'status' => true,
            'data'   => $conversations,
        ]);
    }

    /**
     * POST /chat/conversations
     * Buat percakapan private manual.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id'    => 'required|exists:users,id',
            'project_id' => 'nullable|exists:projects,id',
            'title'      => 'nullable|string|max:255',
        ]);

        $authId = Auth::id();

        // Cek percakapan 1-on-1
        $existing = Conversation::where('type', 'private')
            ->whereHas('participants', fn ($q) => $q->where('user_id', $authId))
            ->whereHas('participants', fn ($q) => $q->where('user_id', $data['user_id']))
            ->first();

        if ($existing) {
            return response()->json([
                'status'  => true,
                'message' => 'Conversation already exists',
                'data'    => $existing,
            ]);
        }

        $conversation = null;

        DB::transaction(function () use (&$conversation, $authId, $data) {
            $conversation = Conversation::create([
                'type'            => 'private',
                'title'           => $data['title'] ?? 'Chat with user '.$data['user_id'],
                'project_id'      => $data['project_id'] ?? null,
                'last_message_at' => now(),
                'is_active'       => true,
            ]);

            $conversation->participants()->attach([
                $authId           => ['role' => 'admin',       'joined_at' => now(), 'is_active' => true],
                $data['user_id']  => ['role' => 'participant', 'joined_at' => now(), 'is_active' => true],
            ]);
        });

        return response()->json([
            'status'  => true,
            'message' => 'Conversation created',
            'data'    => $conversation,
        ], 201);
    }

    /**
     * GET /chat/conversations/{conversation}
     */
    public function show(Conversation $conversation)
    {
        Gate::authorize('talk-in-conversation', $conversation);

        $conversation->load([
            'participants:id,name',
            'messages' => fn ($q) => $q->with('sender:id,name')->latest('sent_at')->limit(50),
        ]);

        return response()->json([
            'status' => true,
            'data'   => $conversation,
        ]);
    }

    /**
     * Hitung jumlah pesan belum dibaca untuk user dalam conversation.
     */
    private function getUnreadCount(Conversation $conversation, int $userId): int
    {
        $participant = ConversationParticipant::where('conversation_id', $conversation->id)
            ->where('user_id', $userId)
            ->first();

        $lastReadAt = $participant?->last_read_at;

        return $lastReadAt
            ? $conversation->messages()->where('sent_at', '>', $lastReadAt)->count()
            : $conversation->messages()->count();
    }
}
