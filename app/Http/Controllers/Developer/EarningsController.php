<?php

namespace App\Http\Controllers\Developer;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class EarningsController extends Controller
{
    /* ---------- Ringkasan & riwayat ---------- */
    public function index()
    {
        $developerId = Auth::id();

        // Total yang sudah ditransfer
        $totalEarnings = Payment::whereHas('agreement', fn ($q) => $q->where('developer_id', $developerId))
            ->where('status', 'transferred')
            ->sum('amount');

        // Riwayat payment (termasuk yang masih pending)
        $payments = Payment::with(['agreement.project'])
            ->whereHas('agreement', fn ($q) => $q->where('developer_id', $developerId))
            ->latest()
            ->paginate(15);

        // Grafik bulanan (contoh)
        $monthly = Payment::selectRaw('SUM(amount) as total, DATE_FORMAT(created_at, "%Y-%m") as month')
            ->whereHas('agreement', fn ($q) => $q->where('developer_id', $developerId))
            ->where('status', 'transferred')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        return view('developer.earnings.index', compact('totalEarnings', 'payments', 'monthly'));
    }
}