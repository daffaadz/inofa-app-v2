<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\ProjectAgreement;
use App\Events\AgreementAccepted; 
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgreementController extends Controller
{
    public function send(Request $request, Conversation $conversation)
    {
        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'required|string',
            'price'          => 'required|numeric|min:0',
            'estimation'     => 'nullable|string|max:255',
            'payment_scheme' => 'nullable|string|max:255',
            'deliverables'   => 'nullable|array',
        ]);

        $agreement = ProjectAgreement::create([
            'conversation_id' => $conversation->id,
            'project_id'      => $conversation->project_id,
            'developer_id'    => Auth::id(),
            'consumer_id'     => $conversation->participants()->where('users.id', '!=', Auth::id())->first()->id,
            'status'          => 'pending',
            'final_price'     => $data['price'],        // selaraskan field dgn migration kamu
            'terms'           => $data['description'],  // selaraskan penamaan yang kamu pakai
            'milestones'      => $data['deliverables'] ?? null,
            // simpan field tambahan ssuai skema kamu
        ]);

        $message = $conversation->messages()->create([
            'sender_id' => Auth::id(),
            'type'      => 'agreement',
            'body'      => "Proposal dikirim: {$data['title']}",
            'payload'   => ['agreement_id' => $agreement->id],
            'sent_at'   => now(),
        ]);

        broadcast(new MessageSent($message->load('sender')))->toOthers();

        return response()->json(['agreement' => $agreement, 'message' => $message], 201);
    }

    public function updateStatus(ProjectAgreement $agreement, Request $request)
    {
        $data = $request->validate([
            'status' => 'required|in:accepted,revised,rejected',
        ]);

        // Map status tombol → status kontrak
        if ($data['status'] === 'accepted') {
            // kontrak menjadi aktif & ditandatangani
            $agreement->update([
                'status'    => 'active',
                'signed_at' => now(),
            ]);

            // trigger escrow creation via event
            event(new AgreementAccepted($agreement));
        } elseif ($data['status'] === 'revised') {
            $agreement->update(['status' => 'revised']);
        } else { // rejected
            $agreement->update(['status' => 'rejected']);
        }

        // kirim system message ke chat
        $message = $agreement->conversation->messages()->create([
            'sender_id' => Auth::id(),
            'type'      => 'system',
            'body'      => match ($data['status']) {
                'accepted' => 'Agreement telah disetujui oleh customer.',
                'revised'  => 'Customer meminta revisi pada agreement.',
                'rejected' => 'Agreement ditolak oleh customer.',
            },
            'payload'   => ['agreement_id' => $agreement->id, 'status' => $agreement->status],
            'sent_at'   => now(),
        ]);

        broadcast(new MessageSent($message->load('sender')))->toOthers();

        return response()->json(['status' => true, 'message' => $message]);
    }
}
