<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\ProjectAgreement;
use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgreementController extends Controller
{
    /**
     * Developer mengirim agreement ke chat
     */
    public function send(Request $request, Conversation $conversation)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'estimation' => 'nullable|string|max:255',
            'payment_scheme' => 'nullable|string|max:255',
            'deliverables' => 'nullable|array',
        ]);

        $agreement = ProjectAgreement::create([
            'conversation_id' => $conversation->id,
            'project_id' => $conversation->project_id,
            'developer_id' => Auth::id(),
            'client_id' => $conversation->participants()->where('users.id', '!=', Auth::id())->first()->id,
            'status' => 'pending',
            ...$data
        ]);

        // kirim message ke chat
        $message = $conversation->messages()->create([
            'sender_id' => Auth::id(),
            'type' => 'agreement',
            'body' => "Proposal dikirim: {$data['title']}",
            'payload' => ['agreement_id' => $agreement->id],
            'sent_at' => now(),
        ]);

        broadcast(new MessageSent($message->load('sender')))->toOthers();

        return response()->json(['agreement' => $agreement, 'message' => $message], 201);
    }

    /**
     * Client menekan tombol Terima / Minta Revisi
     */
    public function updateStatus(ProjectAgreement $agreement, Request $request)
    {
        $data = $request->validate([
            'status' => 'required|in:accepted,revised,rejected',
        ]);

        $agreement->update(['status' => $data['status']]);

        // kirim notifikasi system message ke chat
        $message = $agreement->conversation->messages()->create([
            'sender_id' => Auth::id(),
            'type' => 'system',
            'body' => match($data['status']) {
                'accepted' => 'Agreement telah disetujui oleh client.',
                'revised' => 'Client meminta revisi pada agreement.',
                'rejected' => 'Agreement ditolak oleh client.',
            },
            'payload' => ['agreement_id' => $agreement->id, 'status' => $data['status']],
            'sent_at' => now(),
        ]);

        broadcast(new MessageSent($message->load('sender')))->toOthers();

        return response()->json(['status' => true, 'message' => $message]);
    }
}
