<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    public function show($id)
    {
        return back()->with('info','Admin payment view not implemented.');
    }

    public function approve($id)
    {
        return back()->with('success','Payment approved.');
    }

    public function reject(Request $request, $id)
    {
        return back()->with('warning','Payment rejected: '.$request->reason);
    }
}
