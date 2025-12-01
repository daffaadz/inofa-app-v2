<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Conversation;
use App\Models\ConversationParticipant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComplaintController extends Controller
{
    // List semua complaint
    public function index()
    {
        $complaints = Complaint::with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.complaint.index', compact('complaints'));
    }

    // Lihat detail complaint
    public function show($id)
    {
        $complaint = Complaint::with('user')->findOrFail($id);
        
        return view('admin.complaint.show', compact('complaint'));
    }

    // Response via chat - redirect ke halaman chat dengan user tersebut
    public function response($id)
    {
        $complaint = Complaint::with('user')->findOrFail($id);
        
        if (!$complaint->user) {
            return redirect()->back()->with('error', 'User not found for this complaint.');
        }

        // Update status menjadi in_progress jika masih baru
        if ($complaint->status !== 'resolved' && $complaint->status !== 'rejected') {
            $complaint->update(['status' => 'in_progress']);
        }

        // Cari atau buat conversation antara admin dan user
        $adminId = Auth::id();
        $userId = $complaint->user_id;

        // Cek apakah sudah ada conversation
        $conversation = Conversation::whereHas('participants', function ($query) use ($adminId) {
            $query->where('user_id', $adminId);
        })->whereHas('participants', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->where('type', 'support')->first();

        // Jika belum ada, buat conversation baru
        if (!$conversation) {
            $conversation = Conversation::create([
                'type' => 'support',
                'title' => 'Admin Support - ' . $complaint->user->name,
            ]);

            // Tambahkan participants
            ConversationParticipant::create([
                'conversation_id' => $conversation->id,
                'user_id' => $adminId,
            ]);

            ConversationParticipant::create([
                'conversation_id' => $conversation->id,
                'user_id' => $userId,
            ]);
        }

        // Redirect ke halaman chat dengan user tersebut
        return redirect()->route('user', ['id' => $userId]);
    }

    // Mark as resolved
    public function resolve($id)
    {
        $complaint = Complaint::findOrFail($id);
        
        $complaint->update([
            'status' => 'resolved',
            'responded_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Complaint marked as resolved.');
    }

    // Reject complaint
    public function reject($id)
    {
        $complaint = Complaint::findOrFail($id);
        
        $complaint->update([
            'status' => 'rejected',
            'responded_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Complaint has been rejected.');
    }
}
