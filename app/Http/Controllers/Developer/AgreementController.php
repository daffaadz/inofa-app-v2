<?php

namespace App\Http\Controllers\Developer;

use App\Http\Controllers\Controller;
use App\Models\ProjectAgreement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AgreementController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $agreements = ProjectAgreement::where('developer_id', Auth::id())
            ->with(['project', 'consumer'])
            ->latest()
            ->paginate(10);

        return view('developer.agreements.index', compact('agreements'));
    }

    public function proposals()
    {
        $proposals = ProjectAgreement::where('developer_id', Auth::id())
            ->whereIn('status', ['pending', 'accepted'])
            ->with(['project', 'consumer'])
            ->latest()
            ->get();

        $pendingCount = $proposals->where('status', 'pending')->count();
        $acceptedCount = $proposals->where('status', 'accepted')->count();

        return view('dashboard.developer.proposals.index', compact('proposals', 'pendingCount', 'acceptedCount'));
    }

    public function show(ProjectAgreement $agreement)
    {
        $this->authorize('view', $agreement);
        $agreement->load(['project', 'consumer', 'payments']);
        return view('developer.agreements.show', compact('agreement'));
    }

    public function updateProgress(ProjectAgreement $agreement)
    {
        $this->authorize('update', $agreement);
        
        $validated = request()->validate([
            'progress' => 'required|integer|min:0|max:100'
        ]);

        $agreement->update([
            'progress' => $validated['progress']
        ]);

        // Return JSON response for AJAX requests
        if (request()->expectsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Progress updated successfully!',
                'progress' => $agreement->progress
            ]);
        }

        return back()->with('success', 'Progress updated successfully!');
    }
}