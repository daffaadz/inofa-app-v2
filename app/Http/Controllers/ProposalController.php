<?php

namespace App\Http\Controllers;

use App\Models\ProjectAgreement;
use App\Models\User;
use App\Models\ChMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
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
            'project_id' => 'nullable|exists:projects,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', 'Invalid parameter');
        }

        $toUserId = $request->to_id;
        $projectId = $request->project_id;

        if (Auth::user()->role !== 'developer') {
            return redirect()->back()->with('error', 'Only developers can create proposals');
        }

        $client = User::findOrFail($toUserId);
        $project = null;
        
        // Load project if project_id is provided
        if ($projectId) {
            $project = \App\Models\Project::find($projectId);
        }

        return view('proposals.create', compact('client', 'project', 'toUserId', 'projectId'));
    }

    /**
     * Store proposal and send as a message
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'to_id' => 'required|exists:users,id',
            'project_id' => ['nullable', Rule::exists('projects', 'id')->where('consumer_id', $request->to_id)],
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
                'project_id' => $request->project_id,
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

            // 3. Generate Chat Message dengan attachment proposal
            $message = ChMessage::create([
                'from_id' => Auth::id(),
                'to_id' => $toUserId,
                'body' => null, // Kosongkan body karena pakai attachment
                'attachment' => null,
                'seen' => 0,
                'project_agreement_id' => $agreement->id,
                'metadata' => json_encode([
                    'type' => 'proposal',
                    'project_id' => $request->project_id,
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

    /**
     * Show proposal detail
     */
    public function show($agreementId)
    {
        $agreement = ProjectAgreement::with(['developer.developerProfile', 'project'])
            ->findOrFail($agreementId);
        
        // Check authorization
        if ($agreement->consumer_id !== Auth::id()) {
            abort(403, 'You are not authorized to view this proposal');
        }

        return view('proposals.show', compact('agreement'));
    }

    /**
     * Edit proposal (Developer only)
     */
    public function edit($agreementId)
    {
        $agreement = ProjectAgreement::with(['consumer', 'project'])
            ->findOrFail($agreementId);
        
        // Check authorization - only developer who created it can edit
        if ($agreement->developer_id !== Auth::id()) {
            abort(403, 'You are not authorized to edit this proposal');
        }

        // Only pending proposals can be edited
        if ($agreement->status !== ProjectAgreement::STATUS_PENDING) {
            return redirect()->back()->with('error', 'Only pending proposals can be edited');
        }

        $client = $agreement->consumer;
        $project = $agreement->project;
        $toUserId = $agreement->consumer_id;
        $projectId = $agreement->project_id;

        return view('proposals.edit', compact('agreement', 'client', 'project', 'toUserId', 'projectId'));
    }

    /**
     * Update proposal
     */
    public function update(Request $request, $agreementId)
    {
        $validator = Validator::make($request->all(), [
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
            $agreement = ProjectAgreement::findOrFail($agreementId);

            // Check authorization
            if ($agreement->developer_id !== Auth::id()) {
                throw new \Exception('You are not authorized to edit this proposal');
            }

            // Only pending proposals can be edited
            if ($agreement->status !== ProjectAgreement::STATUS_PENDING) {
                throw new \Exception('Only pending proposals can be edited');
            }

            // Update Project Agreement
            $agreement->update([
                'project_title' => $request->project_title,
                'client_name' => $request->client_name,
                'final_price' => $request->final_price,
                'price_details' => $request->price_details,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'description' => $request->description,
                'terms' => $request->terms,
                'scope_projects' => $request->scope_projects,
                'projects_mvp' => $request->mvp_features,
                'deliverables' => $request->deliverables,
            ]);

            // Update chat message metadata
            $message = ChMessage::where('project_agreement_id', $agreementId)->first();
            if ($message) {
                $metadata = $message->metadata ?? [];
                $metadata['project_title'] = $request->project_title;
                $metadata['client_name'] = $request->client_name;
                $metadata['final_price'] = $request->final_price;
                $metadata['start_date'] = $request->start_date;
                $metadata['end_date'] = $request->end_date;
                $metadata['deliverables'] = $request->deliverables;
                $metadata['description'] = $request->description;
                $metadata['scope_projects'] = $request->scope_projects;
                $metadata['price_details'] = $request->price_details;
                $metadata['mvp_features'] = $request->mvp_features;
                
                $message->metadata = $metadata;
                $message->save();
            }

            // Send notification to client
            \App\Models\UserNotification::create([
                'user_id' => $agreement->consumer_id,
                'type' => 'proposal_updated',
                'title' => 'Proposal Updated',
                'message' => Auth::user()->name . ' has updated the proposal',
                'data' => json_encode([
                    'agreement_id' => $agreement->id,
                    'from_user_id' => Auth::id(),
                ]),
            ]);

            DB::commit();

            return redirect()->route('user', ['id' => $agreement->consumer_id])
                ->with('success', 'Proposal updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Quick apply - Send automatic message to project owner
     */
    public function quickApply(Request $request, $projectId)
    {
        try {
            // Verify user is a developer
            if (Auth::user()->role !== 'developer') {
                return response()->json([
                    'success' => false,
                    'message' => 'Only developers can apply to projects'
                ], 403);
            }

            // Get project
            $project = \App\Models\Project::findOrFail($projectId);
            
            // Check if already contacted via message
            $existingMessage = ChMessage::where('from_id', Auth::id())
                ->where('to_id', $project->consumer_id)
                ->where('body', 'LIKE', "%I'm interested in discussing your project titled '" . addcslashes(e($project->title), '%_\\') . "'%")
                ->first();
            
            if ($existingMessage) {
                return response()->json([
                    'success' => false,
                    'message' => 'You have already sent an interest message for this project'
                ], 400);
            }

            // Setelah pemeriksaan, supaya return lebih awal tidak meninggalkan transaksi terbuka
            DB::beginTransaction();

            // Create automatic message
            // Isi chat dirender tanpa escape, jadi nama dan judul di-escape di sini
            $developerName = e(Auth::user()->name);
            $projectTitle = e($project->title);
            $messageBody = "Hello, I'm {$developerName} and I'm interested in discussing your project titled '{$projectTitle}'. I would love to learn more about your requirements and how I can contribute to making this project successful. Looking forward to hearing from you!";

            // Create chat message
            $message = ChMessage::create([
                'from_id' => Auth::id(),
                'to_id' => $project->consumer_id,
                'body' => $messageBody,
                'attachment' => null,
                'seen' => 0,
            ]);

            // Real-time notification via Pusher
            if (config('chatify.pusher.enabled')) {
                Chatify::push("private-chatify.{$project->consumer_id}", 'messaging', [
                    'from_id' => Auth::id(),
                    'to_id' => $project->consumer_id,
                    'message' => $messageBody
                ]);
            }

            // Database notification
            \App\Models\UserNotification::create([
                'user_id' => $project->consumer_id,
                'type' => 'project_interest',
                'title' => 'Someone Interested in Your Project',
                'message' => Auth::user()->name . ' is interested in your project: ' . $project->title,
                'data' => json_encode([
                    'project_id' => $project->id,
                    'from_user_id' => Auth::id(),
                ]),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Interest message sent successfully! The project owner has been notified.',
                'redirect_url' => route('user', ['id' => $project->consumer_id])
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Quick apply failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to send application.'
            ], 500);
        }
    }

    public function accept(Request $request, $agreementId)
    {
        DB::beginTransaction();
        try {
            Log::info('Accept proposal request', ['agreementId' => $agreementId, 'userId' => Auth::id()]);
            
            $agreement = ProjectAgreement::with('developer')->findOrFail($agreementId);
            Log::info('Agreement found', ['agreement' => $agreement->toArray()]);
            
            if (!$agreement->isPending()) {
                Log::warning('Proposal not pending', ['status' => $agreement->status]);
                throw new \Exception('This proposal can no longer be processed');
            }
            
            if ($agreement->consumer_id !== Auth::id()) {
                Log::warning('Unauthorized access', ['consumer_id' => $agreement->consumer_id, 'user_id' => Auth::id()]);
                throw new \Exception('You are not authorized to accept this proposal');
            }

            $agreement->update([
                'status' => ProjectAgreement::STATUS_ACCEPTED,
                'signed_at' => now(),
            ]);
            Log::info('Agreement updated');

            // Update project status to in_progress if project_id exists
            if ($agreement->project_id) {
                $project = \App\Models\Project::find($agreement->project_id);
                if ($project) {
                    $project->update(['status' => 'in_progress']);
                    Log::info('Project status updated to in_progress', ['project_id' => $project->id]);
                }
            }

            $message = ChMessage::where('project_agreement_id', $agreementId)->first();
            if ($message) {
                // metadata and attachment are already arrays (casted by model)
                $metadata = $message->metadata ?? [];
                $metadata['status'] = 'accepted';
                $message->metadata = $metadata;

                // Update attachment juga
                if ($message->attachment) {
                    $attachment = is_array($message->attachment) ? $message->attachment : json_decode($message->attachment, true);
                    $attachment['status'] = 'accepted';
                    $message->attachment = $attachment;
                }
                
                $message->save();
                Log::info('Message metadata updated');
            }

            // Send notification to developer
            try {
                $agreement->developer->notify(new \App\Notifications\ProposalStatusUpdated($agreement, Auth::user()));
                Log::info('Notification sent');
            } catch (\Exception $e) {
                Log::error('Notification failed', ['error' => $e->getMessage()]);
                // Continue even if notification fails
            }

            \App\Models\UserNotification::create([
                'user_id' => $agreement->developer_id,
                'type' => 'proposal_accepted',
                'title' => 'Proposal Accepted',
                'message' => 'Your proposal has been accepted by ' . Auth::user()->name,
                'data' => json_encode(['agreement_id' => $agreement->id]),
            ]);
            Log::info('User notification created');

            DB::commit();
            Log::info('Transaction committed');
            
            return response()->json([
                'success' => true, 
                'message' => 'Proposal successfully accepted', 
                'data' => [
                    'agreement_id' => $agreement->id, 
                    'status' => 'accepted'
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Accept proposal failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false, 
                'message' => $e->getMessage()
            ], 400);
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
                // metadata sudah berupa array (accessor di model)
                $metadata = $message->metadata ?? [];
                $metadata['status'] = 'rejected';
                $message->metadata = $metadata;

                // Update attachment juga
                if ($message->attachment) {
                    $attachment = json_decode($message->attachment, true);
                    $attachment['status'] = 'rejected';
                    $message->attachment = json_encode($attachment);
                }

                $message->save();
            }

            // Send notification to developer
            try {
                $agreement->developer->notify(new \App\Notifications\ProposalStatusUpdated($agreement, Auth::user()));
            } catch (\Exception $e) {
                Log::error('Notification failed', ['error' => $e->getMessage()]);
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
