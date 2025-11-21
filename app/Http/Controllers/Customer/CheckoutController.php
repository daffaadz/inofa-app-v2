<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\ProjectAgreement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{

    // CREATE PAYMENT AND REDIRECT TO CHECKOUT
    public function create(ProjectAgreement $agreement)
    {
        // Must belong to consumer
        abort_unless($agreement->consumer_id === Auth::id(), 403);

        // Prevent duplicate payment
        $payment = Payment::firstOrCreate(
            [
                'project_agreement_id' => $agreement->id
            ],
            [
                'amount' => $agreement->final_price,
                'status' => 'unpaid',
                'type' => 'escrow'
            ]
        );

        return redirect()->route('consumer.payments.checkout', $payment->id);
    }

    // SHOW CHECKOUT PAGE
    public function checkout(Payment $payment)
    {
        abort_unless($payment->agreement->consumer_id === Auth::id(), 403);

        return view('payments.checkout', [
            'payment' => $payment->load('agreement.project', 'agreement.developer'),
            'agreement' => $payment->agreement,
            'project' => $payment->agreement->project,
            'developer' => $payment->agreement->developer,
        ]);
    }

    // CONFIRM PAYMENT UPLOAD
    public function confirm(Request $request, Payment $payment)
    {
        abort_unless($payment->agreement->consumer_id === Auth::id(), 403);

        $validated = $request->validate([
            'proof' => 'required|mimes:jpg,jpeg,png,pdf|max:5120', // max 5 MB
        ]);

        $path = $request->file('proof')->store('payments/proofs', 'public');

        $payment->update([
            'consumer_payment_proof' => $path,
            'status' => 'pending',
        ]);

        return redirect()
            ->route('consumer.payments.checkout', $payment->id)
            ->with('success', 'Payment proof uploaded and awaiting verification.');
    }
}
