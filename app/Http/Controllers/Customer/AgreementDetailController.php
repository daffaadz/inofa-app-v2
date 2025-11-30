<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\ProjectAgreement;
use Illuminate\Support\Facades\Auth;

class AgreementDetailController extends Controller
{
    public function show(ProjectAgreement $agreement)
    {
        // Pastikan customer adalah pemilik project
        abort_unless($agreement->consumer_id === Auth::id(), 403);

        $developer = $agreement->developer;
        $agreement->load(['developer', 'payments']);

        // Breakdown biaya dari price_details
        $totalCostBreakdown = collect($agreement->price_details ?? [])->map(function ($item) {
            return [
                'label' => $item['item'] ?? '',
                'amount' => (int) ($item['price'] ?? 0),
            ];
        })->toArray();

        return view('payments.agreement-detail', compact(
            'agreement',
            'developer',
            'totalCostBreakdown',
        ));
    }
}
