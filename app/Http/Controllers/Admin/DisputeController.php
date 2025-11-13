<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DisputeController extends Controller
{
    public function index()
    {
        $disputes = ProjectDispute::with(['agreement.project','raiser'])
            ->orderByDesc('created_at')
            ->paginate(15);
        return view('admin.disputes.index', compact('disputes'));
    }

    public function show(ProjectDispute $dispute)
    {
        return view('admin.disputes.show', compact('dispute'));
    }

    public function resolve(Request $r, ProjectDispute $dispute)
    {
        $dispute->update([
            'status' => 'resolved',
            'resolution' => $r->resolution,
            'resolved_at' => now(),
        ]);

        event(new DisputeResolved($dispute));

        return back()->with('success', 'Sengketa berhasil diselesaikan.');
    }
}

