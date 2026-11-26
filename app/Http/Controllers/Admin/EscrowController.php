<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Events\PaymentStatusUpdated;
use Illuminate\Http\Request;

class EscrowController extends Controller
{
    // Tampilkan daftar pembayaran escrow
    public function index(Request $request)
    {
        $status = $request->get('status', 'pending');

        $payments = Payment::with(['agreement.project', 'agreement.consumer', 'agreement.developer'])
            ->when($status, fn($q) => $q->where('status', $status))
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('admin.escrow.index', compact('payments', 'status'));
    }

    // Konfirmasi pembayaran escrow (dana ditahan)
    public function confirm($id)
    {
        $payment = Payment::findOrFail($id);

        if ($payment->status !== 'pending') {
            return back()->with('error', 'Pembayaran ini sudah diproses.');
        }

        $payment->markAsConfirmed();

        event(new PaymentStatusUpdated($payment));

        return back()->with('success', 'Pembayaran dikonfirmasi dan dana ditahan di escrow.');
    }

    // Transfer dana ke developer
    public function transfer($id, Request $request)
    {
        $payment = Payment::findOrFail($id);
        
        if ($payment->status !== 'confirmed') {
            return back()->with('error', 'Pembayaran belum dikonfirmasi atau sudah ditransfer.');
        }

        $request->validate(['proof' => 'nullable|mimes:jpg,jpeg,png,pdf|max:5120']);

        if ($request->hasFile('proof')) {
            $path = $request->file('proof')->store('escrow/proof','public');
            $payment->update(['admin_transfer_proof' => $path]);
        }

        $payment->markAsTransferred();

        event(new PaymentStatusUpdated($payment));

        return back()->with('success', 'Dana telah ditransfer ke developer.');
    }

    // Refund dana ke customer
    public function refund($id)
    {
        $payment = Payment::findOrFail($id);

        if (! in_array($payment->status, ['pending', 'confirmed'])) {
            return back()->with('error', 'Pembayaran tidak bisa direfund.');
        }

        $payment->update(['status' => 'refunded']);

        event(new PaymentStatusUpdated($payment));

        return back()->with('success', 'Dana telah dikembalikan ke customer.');
    }
}
