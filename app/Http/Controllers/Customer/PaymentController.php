<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function show(Payment $payment)
    {
        abort_unless($payment->payer_id === Auth::id(), 403);

        return view('customer.payments.show', [
            'payment' => $payment->load('agreement.project', 'receiver')
        ]);
    }

    public function pay(Payment $payment)
    {
        abort_unless($payment->payer_id === Auth::id(), 403);

        // contoh: redirect ke gateway (simulasi manual)
        $payment->update([
            'status' => 'pending',
            'method' => 'qris',
            'transaction_ref' => 'TX-' . strtoupper(uniqid()),
        ]);

        return redirect()->route('customer.payments.confirm', $payment);
    }

    public function confirm(Payment $payment)
    {
        $payment->update([
            'status' => 'pending',
            'consumer_payment_proof' => $request->file('proof')->store('payments', 'public'),
        ]);

        event(new PaymentStatusUpdated($payment));

        return redirect()->route('customer.payments.show', $payment)
            ->with('success', 'Pembayaran dikirim untuk verifikasi.');
    }
}
