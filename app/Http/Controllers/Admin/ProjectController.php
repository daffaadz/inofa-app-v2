<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectAgreement;
use App\Models\Payment;
use App\Models\ProjectDispute;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $status = $request->status;

        $query = ProjectAgreement::with(['consumer', 'developer', 'project', 'payments']);

        // Search filter
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('project_title', 'like', "%$search%")
                  ->orWhereHas('consumer', function($q2) use ($search) {
                      $q2->where('name', 'LIKE', "%{$search}%");
                  })
                  ->orWhereHas('developer', function($q2) use ($search) {
                      $q2->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Status filter
        if ($status) {
            $query->where('status', $status);
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Budget range filter (based on project agreement final_price)
        if ($request->filled('amount_min')) {
            $query->where('final_price', '>=', $request->amount_min);
        }
        if ($request->filled('amount_max')) {
            $query->where('final_price', '<=', $request->amount_max);
        }

        // Sort filter
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'highest':
                // Sort by highest budget (project agreement final_price)
                $query->orderByDesc('final_price');
                break;
            case 'lowest':
                // Sort by lowest budget (project agreement final_price)
                $query->orderBy('final_price');
                break;
            default: // newest
                $query->orderByDesc('created_at');
                break;
        }

        return view('admin.projects.index', [
            'projects' => $query->paginate(15)->withQueryString(),
            'search'   => $search,
            'status'   => $status,
            'stats'    => [
                'total'     => ProjectAgreement::count(),
                'ongoing'   => ProjectAgreement::where('status', 'active')->count(),
                'completed' => ProjectAgreement::where('status', 'completed')->count(),
                'allTimePayment' => (float) Payment::whereIn('status', ['confirmed', 'transferred'])->sum('amount'),
            ]
        ]);
    }

    public function show($id)
    {
        return back()->with('info','Admin project view not implemented yet.');
    }

    public function approve($id)
    {
        return back()->with('success','Project approved (stub).');
    }

    public function reject(Request $request, $id)
    {
        return back()->with('warning','Project rejected (stub): '.$request->reason);
    }
}
