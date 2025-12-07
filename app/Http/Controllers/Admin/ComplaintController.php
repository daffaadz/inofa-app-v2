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
    public function index(Request $request)
    {
        $query = Complaint::with('user');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('user_name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', function($q2) use ($search) {
                      $q2->where('name', 'LIKE', "%{$search}%")
                         ->orWhere('email', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Raiser role filter (filter by user role)
        if ($request->filled('raiser_role')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('role', $request->raiser_role);
            });
        }

        // Sort filter
        $sort = $request->get('sort', 'newest');
        if ($sort === 'oldest') {
            $query->oldest();
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $complaints = $query->paginate(15)->withQueryString();

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
