<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\ProjectAgreement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Store a newly created review in storage.
     */
    public function store(Request $request, $agreementId)
    {
        // Validasi request
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000',
        ]);

        // Cari agreement
        $agreement = ProjectAgreement::findOrFail($agreementId);

        // Pastikan agreement sudah completed
        if ($agreement->status !== ProjectAgreement::STATUS_COMPLETED) {
            return back()->with('error', 'Hanya project yang sudah completed yang dapat direview.');
        }

        // Pastikan yang melakukan review adalah consumer dari agreement tersebut
        if ($agreement->consumer_id !== Auth::id()) {
            return back()->with('error', 'Anda tidak memiliki akses untuk mereview project ini.');
        }

        // Cek apakah sudah pernah review
        $existingReview = Review::where('project_id', $agreement->project_id)
            ->where('consumer_id', Auth::id())
            ->first();

        if ($existingReview) {
            return back()->with('error', 'Anda sudah memberikan review untuk project ini.');
        }

        // Buat review baru
        Review::create([
            'project_id' => $agreement->project_id,
            'consumer_id' => Auth::id(),
            'developer_id' => $agreement->developer_id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'is_public' => true,
        ]);

        return back()->with('success', 'Review berhasil dikirim. Terima kasih atas feedback Anda!');
    }
}
