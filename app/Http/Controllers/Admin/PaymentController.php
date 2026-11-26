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
            
            // Hanya pembayaran pending: yang failed harus lewat review dulu
            if ($payment->status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Only pending payments can be approved.'
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
            report($e);
            return response()->json([
                'success' => false,
                'message' => 'Failed to approve payment.'
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

            if ($payment->status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Only pending payments can be rejected.'
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
            report($e);
            return response()->json([
                'success' => false,
                'message' => 'Failed to reject payment.'
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

            // Dana yang sudah keluar tidak boleh kembali ke pending (bisa dibayar dua kali)
            if (in_array($payment->status, ['transferred', 'refunded'], true)) {
                return response()->json([
                    'success' => false,
                    'message' => 'A transferred or refunded payment cannot be reviewed again.'
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
            report($e);
            return response()->json([
                'success' => false,
                'message' => 'Failed to review payment.'
            ], 500);
        }
    }

    public function transfer($id)
    {
        try {
            $payment = Payment::findOrFail($id);
            
            // Check if payment is confirmed
            if ($payment->status !== 'confirmed') {
                return response()->json([
                    'success' => false,
                    'message' => 'Only confirmed payments can be transferred.'
                ], 400);
            }

            // Check if already transferred
            if ($payment->status === 'transferred') {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment has already been transferred.'
                ], 400);
            }

            // Update payment status to transferred
            $payment->markAsTransferred();

            // Dispatch event untuk broadcast dan notifikasi
            event(new PaymentStatusUpdated($payment));

            return response()->json([
                'success' => true,
                'message' => 'Payment has been transferred successfully to the developer.',
                'data' => [
                    'status' => 'transferred',
                    'payment_id' => $payment->id,
                    'transferred_at' => $payment->admin_transferred_at
                ]
            ]);

        } catch (\Exception $e) {
            report($e);
            return response()->json([
                'success' => false,
                'message' => 'Failed to transfer payment.'
            ], 500);
        }
    }
}
