<?php

namespace App\Http\Controllers\Developer;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use Illuminate\Support\Facades\Auth;

class OfferController extends Controller
{
    /**
     * Daftar penawaran milik developer yg login
     */
    public function index()
    {
        $offers = Offer::where('developer_id', Auth::id())
            ->with('project')          // hindari N+1
            ->latest()
            ->paginate(10);

        return view('developer.offers.index', compact('offers'));
    }

    /**
     * Withdraw / batalkan penawaran
     */
    public function destroy(Offer $offer)
    {
        // Policy: hanya pemilik + status masih pending
        $this->authorize('delete', $offer);

        $offer->update(['status' => 'withdrawn']);

        return redirect()
            ->route('developer.offers.index')
            ->with('success', 'Offer has been withdrawn.');
    }
}