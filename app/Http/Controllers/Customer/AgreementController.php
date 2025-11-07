<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Agreement;
use Illuminate\Support\Facades\Auth;

class AgreementController extends Controller
{
    /**
     * 📄 Lihat semua agreement yang terhubung dengan project milik customer
     */
    public function index()
    {
        $agreements = Agreement::whereHas('project', function ($q) {
            $q->where('customer_id', Auth::id());
        })->with('project', 'developer')->get();

        return response()->json(['status' => true, 'data' => $agreements]);
    }

    /**
     * 👁️ Lihat detail agreement
     */
    public function show($id)
    {
        $agreement = Agreement::whereHas('project', function ($q) {
            $q->where('customer_id', Auth::id());
        })->findOrFail($id);

        return response()->json(['status' => true, 'data' => $agreement]);
    }

    /**
     * ✍️ Customer menandatangani agreement
     */
    public function sign($id)
    {
        $agreement = Agreement::whereHas('project', function ($q) {
            $q->where('customer_id', Auth::id());
        })->findOrFail($id);

        $agreement->signed_by_customer = true;
        $agreement->save();

        return response()->json(['status' => true, 'message' => 'Agreement signed successfully', 'data' => $agreement]);
    }
}
