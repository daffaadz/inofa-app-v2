<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OfferController extends Controller
{
    /**
     * 🔍 Lihat semua tawaran dari developer untuk project milik customer
     */
    public function index()
    {
        $offers = Offer::whereHas('project', function ($q) {
            $q->where('customer_id', Auth::id());
        })->with('developer', 'project')->get();

        return response()->json(['status' => true, 'data' => $offers]);
    }

    /**
     * 🆗 Setujui tawaran developer
     */
    public function accept($id)
    {
        $offer = Offer::whereHas('project', function ($q) {
            $q->where('customer_id', Auth::id());
        })->findOrFail($id);

        $offer->status = 'accepted';
        $offer->save();

        return response()->json(['status' => true, 'message' => 'Offer accepted', 'data' => $offer]);
    }

    /**
     * ❌ Tolak tawaran developer
     */
    public function reject($id)
    {
        $offer = Offer::whereHas('project', function ($q) {
            $q->where('customer_id', Auth::id());
        })->findOrFail($id);

        $offer->status = 'rejected';
        $offer->save();

        return response()->json(['status' => true, 'message' => 'Offer rejected', 'data' => $offer]);
    }
}
