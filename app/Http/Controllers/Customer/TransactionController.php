<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * 💳 Lihat semua transaksi customer
     */
    public function index()
    {
        $transactions = Transaction::where('customer_id', Auth::id())->latest()->get();
        return response()->json(['status' => true, 'data' => $transactions]);
    }

    /**
     * 👁️ Detail transaksi
     */
    public function show($id)
    {
        $transaction = Transaction::where('customer_id', Auth::id())->findOrFail($id);
        return response()->json(['status' => true, 'data' => $transaction]);
    }
}
