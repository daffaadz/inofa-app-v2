<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Events\PaymentStatusUpdated;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function show($id)
    {
        return back()->with('info','Admin payment view not implemented.');
    }

    public function approve($id)
    {
        try {
            $payment = Payment::findOrFail($id);
            
            // Check if already approved
            if ($payment->status === 'confirmed' || $payment->status === 'transferred') {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment has already been approved.'
                ], 400);
            }

            // Update payment status to confirmed
            $payment->update([
                'status' => 'confirmed',
                'admin_confirmed' => true,
                'admin_confirmed_at' => now(),
            ]);

            // Update project agreement status to active
            $agreement = $payment->agreement;
            if ($agreement && $agreement->status !== 'active') {
                $agreement->update([
                    'status' => 'active'
                ]);
            }

            // Dispatch event untuk broadcast dan notifikasi
            event(new PaymentStatusUpdated($payment));

            return response()->json([
                'success' => true,
                'message' => 'Payment approved successfully and project is now active.',
                'data' => [
                    'status' => 'confirmed',
                    'payment_id' => $payment->id,
                    'agreement_status' => $agreement ? $agreement->status : null
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to approve payment: ' . $e->getMessage()
            ], 500);
        }
    }

    public function reject(Request $request, $id)
    {
        try {
            $payment = Payment::findOrFail($id);
            
            // Check if already rejected or confirmed
            if ($payment->status === 'failed') {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment has already been rejected.'
                ], 400);
            }

            if ($payment->status === 'confirmed' || $payment->status === 'transferred') {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot reject an approved payment.'
                ], 400);
            }

            $reason = $request->input('reason', 'No reason provided');

            // Update payment status to failed
            $payment->update([
                'status' => 'failed',
                'admin_confirmed' => false,
            ]);

            // Dispatch event untuk broadcast dan notifikasi
            event(new PaymentStatusUpdated($payment));

            return response()->json([
                'success' => true,
                'message' => 'Payment rejected successfully. Reason: ' . $reason,
                'data' => [
                    'status' => 'failed',
                    'payment_id' => $payment->id,
                    'reason' => $reason
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to reject payment: ' . $e->getMessage()
            ], 500);
        }
    }

    public function review($id)
    {
        try {
            $payment = Payment::findOrFail($id);
            
            // Check if payment can be reviewed
            if ($payment->status === 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment is already in pending status.'
                ], 400);
            }

            // Update payment status back to pending for review
            $payment->update([
                'status' => 'pending',
                'admin_confirmed' => false,
                'admin_confirmed_at' => null,
            ]);

            // Dispatch event untuk broadcast dan notifikasi
            event(new PaymentStatusUpdated($payment));

            return response()->json([
                'success' => true,
                'message' => 'Payment status has been set to pending for review.',
                'data' => [
                    'status' => 'pending',
                    'payment_id' => $payment->id
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to review payment: ' . $e->getMessage()
            ], 500);
        }
    }
}
