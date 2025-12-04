<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\ProjectAgreement;
use App\Models\ChMessage;
use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AgreementController extends Controller
{
    // Lihat semua agreement milik customer
    public function index()
    {
        $agreements = ProjectAgreement::where('consumer_id', Auth::id())
            ->with('project', 'developer')
            ->get();

        return response()->json(['status' => true, 'data' => $agreements]);
    }

    // Lihat detail agreement tertentu
    public function show($id)
    {
        $agreement = ProjectAgreement::where('consumer_id', Auth::id())
            ->findOrFail($id);

        return response()->json(['status' => true, 'data' => $agreement]);
    }

    // Tanda tangani agreement
    public function sign($id)
    {
        $agreement = ProjectAgreement::where('consumer_id', Auth::id())
            ->findOrFail($id);

        $agreement->signed_at = now();
        $agreement->save();

        return response()->json(['status' => true, 'message' => 'Agreement signed successfully', 'data' => $agreement]);
    }

    /**
     * Complete project - change status to completed
     */
    public function complete($id)
    {
        try {
            $agreement = ProjectAgreement::where('id', $id)
                ->where('consumer_id', Auth::id())
                ->where('status', 'active')
                ->firstOrFail();

            $agreement->status = ProjectAgreement::STATUS_COMPLETED;
            $agreement->save();

            return redirect()->route('dashboard')
                ->with('success', 'Project marked as completed successfully!');

        } catch (\Exception $e) {
            return redirect()->route('dashboard')
                ->with('error', 'Failed to complete project. Please try again.');
        }
    }

    /**
     * Stop project - send message to developer for confirmation
     */
    public function stop($id)
    {
        try {
            DB::beginTransaction();

            $agreement = ProjectAgreement::where('id', $id)
                ->where('consumer_id', Auth::id())
                ->where('status', 'active')
                ->with('developer')
                ->firstOrFail();

            // Get or create conversation with developer
            $conversation = $this->getOrCreateConversation(Auth::id(), $agreement->developer_id);

            if (!$conversation) {
                throw new \Exception('Unable to create conversation');
            }

            // Send termination request message with button
            $messageBody = "I would like to stop the project '{$agreement->project_title}'. Please confirm if you agree to terminate this project.";
            
            $message = ChMessage::create([
                'from_id' => Auth::id(),
                'to_id' => $agreement->developer_id,
                'body' => $messageBody,
                'conversation_id' => $conversation->id,
                'project_agreement_id' => $agreement->id,
                'metadata' => json_encode([
                    'type' => 'termination_request',
                    'agreement_id' => $agreement->id,
                    'requires_action' => true,
                    'action_type' => 'confirm_termination',
                    'button_text' => 'Confirm Stop Project',
                    'show_to_role' => 'developer' // Only developer can see and click the button
                ]),
                'seen' => false,
            ]);

            // Update conversation last message
            $conversation->update([
                'last_message_at' => now(),
            ]);

            DB::commit();

            // Redirect to chat with developer
            return redirect()->route('user', ['id' => $agreement->developer_id])
                ->with('success', 'Termination request sent to developer. Please wait for their confirmation.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('dashboard')
                ->with('error', 'Failed to send termination request. Please try again.');
        }
    }

    /**
     * Get or create conversation between two users
     */
    protected function getOrCreateConversation($userId1, $userId2)
    {
        // Find existing conversation between these two users
        $conversation = Conversation::whereHas('participants', function ($query) use ($userId1) {
                $query->where('user_id', $userId1);
            })
            ->whereHas('participants', function ($query) use ($userId2) {
                $query->where('user_id', $userId2);
            })
            ->whereDoesntHave('participants', function ($query) use ($userId1, $userId2) {
                $query->whereNotIn('user_id', [$userId1, $userId2]);
            })
            ->first();

        if (!$conversation) {
            // Create new conversation
            $conversation = Conversation::create([
                'type' => 'project',
                'title' => 'Project Discussion',
                'is_active' => true,
                'last_message_at' => now(),
            ]);

            // Add participants
            $conversation->participants()->attach($userId1, [
                'role' => 'participant',
                'joined_at' => now(),
                'is_active' => true,
            ]);

            $conversation->participants()->attach($userId2, [
                'role' => 'participant',
                'joined_at' => now(),
                'is_active' => true,
            ]);
        }

        return $conversation;
    }
}
