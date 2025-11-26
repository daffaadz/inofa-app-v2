<?php

namespace App\Http\Controllers;

use App\Models\ProjectAgreement;
use App\Models\User;
use App\Models\ChMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Chatify\Facades\ChatifyMessenger as Chatify;

class ProposalController extends Controller
{
    /**
     * Show the proposal creation form
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'to_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', 'Invalid parameter');
        }

        $toUserId = $request->to_id;

        if (Auth::user()->role !== 'developer') {
            return redirect()->back()->with('error', 'Only developers can create proposals');
        }

        $client = User::findOrFail($toUserId);
        $project = null;
        $projectId = null;

        return view('proposals.create', compact('client', 'project', 'toUserId', 'projectId'));
    }

    /**
     * Store proposal and send as a message
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'to_id' => 'required|exists:users,id',
            'project_title' => 'required|string|max:255',
            'client_name' => 'required|string|max:255',
            'description' => 'required|string',
            'scope_projects' => 'required|string',
            'terms' => 'required|string',
            'final_price' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'deliverables' => 'required|array|min:1',
            'deliverables.*' => 'required|string',
            'price_details' => 'nullable|array',
            'price_details.*.item' => 'required|string',
            'price_details.*.price' => 'required|numeric|min:0',
            'mvp_features' => 'nullable|array',
            'mvp_features.*.name' => 'required|string',
            'mvp_features.*.description' => 'nullable|string',
            'mvp_features.*.priority' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();

        try {
            $toUserId = $request->to_id;

            if (Auth::user()->role !== 'developer') {
                throw new \Exception('Only developers can create proposals');
            }

            // 1. Create Project Agreement
            $agreement = ProjectAgreement::create([
                'project_title' => $request->project_title,
                'consumer_id' => $toUserId,
                'developer_id' => Auth::id(),
                'client_name' => $request->client_name,
                'final_price' => $request->final_price,
                'price_details' => $request->price_details,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'status' => ProjectAgreement::STATUS_PENDING,
                'description' => $request->description,
                'terms' => $request->terms,
                'scope_projects' => $request->scope_projects,
                'projects_mvp' => $request->mvp_features,
                'deliverables' => $request->deliverables,
                'milestones' => null,
            ]);

            // 2. Buat attachment virtual untuk proposal
            $attachmentId = (string) \Illuminate\Support\Str::uuid();
            $attachmentData = json_encode([
                'new' => true,
                'id' => $attachmentId,
                'type' => 'proposal',
                'title' => $request->project_title,
                'file' => null,
                'agreement_id' => $agreement->id,
            ]);

            // 3. Generate Chat Message dengan attachment proposal
            $message = ChMessage::create([
                'from_id' => Auth::id(),
                'to_id' => $toUserId,
                'body' => null, // Kosongkan body karena pakai attachment
                'attachment' => $attachmentData,
                'seen' => 0,
                'project_agreement_id' => $agreement->id,
                'metadata' => json_encode([
                    'type' => 'proposal',
                    'project_title' => $request->project_title,
                    'client_name' => $request->client_name,
                    'final_price' => $request->final_price,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'deliverables' => $request->deliverables,
                    'description' => $request->description,
                    'scope_projects' => $request->scope_projects,
                    'price_details' => $request->price_details,
                    'mvp_features' => $request->mvp_features,
                    'status' => 'pending',
                    'agreement_id' => $agreement->id,
                ]),
            ]);

            // 4. Real-time Notification (Pusher)
            if (config('chatify.pusher.enabled')) {
                Chatify::push("private-chatify.{$toUserId}", 'messaging', [
                    'from_id' => Auth::id(),
                    'to_id' => $toUserId,
                    'message' => 'New Proposal Received'
                ]);
            }

            // 5. Database Notification
            \App\Models\UserNotification::create([
                'user_id' => $toUserId,
                'type' => 'proposal_received',
                'title' => 'New Proposal',
                'message' => Auth::user()->name . ' sent you a project proposal',
                'data' => json_encode([
                    'agreement_id' => $agreement->id,
                    'from_user_id' => Auth::id(),
                ]),
            ]);

            DB::commit();

            return redirect()->route('user', ['id' => $toUserId])
                ->with('success', 'Proposal sent successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }
    }

    public function accept(Request $request, $agreementId)
    {
        DB::beginTransaction();
        try {
            $agreement = ProjectAgreement::with('developer')->findOrFail($agreementId);
            if (!$agreement->isPending()) throw new \Exception('This proposal can no longer be processed');
            if ($agreement->consumer_id !== Auth::id()) throw new \Exception('You are not authorized to accept this proposal');

            $agreement->update([
                'status' => ProjectAgreement::STATUS_ACCEPTED,
                'signed_at' => now(),
            ]);

            $message = ChMessage::where('project_agreement_id', $agreementId)->first();
            if ($message) {
                $metadata = json_decode($message->metadata, true);
                $metadata['status'] = 'accepted';
                $message->update(['metadata' => json_encode($metadata)]);

                // Update attachment juga
                if ($message->attachment) {
                    $attachment = json_decode($message->attachment, true);
                    $attachment['status'] = 'accepted';
                    $message->update(['attachment' => json_encode($attachment)]);
                }
            }

            \App\Models\UserNotification::create([
                'user_id' => $agreement->developer_id,
                'type' => 'proposal_accepted',
                'title' => 'Proposal Accepted',
                'message' => 'Your proposal has been accepted by ' . Auth::user()->name,
                'data' => json_encode(['agreement_id' => $agreement->id]),
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Proposal successfully accepted', 'data' => ['agreement_id' => $agreement->id, 'status' => 'accepted']]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public function reject(Request $request, $agreementId)
    {
        DB::beginTransaction();
        try {
            $agreement = ProjectAgreement::findOrFail($agreementId);
            if (!$agreement->isPending()) throw new \Exception('This proposal can no longer be processed');
            if ($agreement->consumer_id !== Auth::id()) throw new \Exception('You are not authorized to reject this proposal');

            $agreement->update(['status' => ProjectAgreement::STATUS_TERMINATED]);

            $message = ChMessage::where('project_agreement_id', $agreementId)->first();
            if ($message) {
                $metadata = json_decode($message->metadata, true);
                $metadata['status'] = 'rejected';
                $message->update(['metadata' => json_encode($metadata)]);

                // Update attachment juga
                if ($message->attachment) {
                    $attachment = json_decode($message->attachment, true);
                    $attachment['status'] = 'rejected';
                    $message->update(['attachment' => json_encode($attachment)]);
                }
            }

            \App\Models\UserNotification::create([
                'user_id' => $agreement->developer_id,
                'type' => 'proposal_rejected',
                'title' => 'Proposal Rejected',
                'message' => 'Your proposal has been rejected',
                'data' => json_encode(['agreement_id' => $agreement->id]),
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Proposal successfully rejected', 'data' => ['agreement_id' => $agreement->id, 'status' => 'rejected']]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }
}
