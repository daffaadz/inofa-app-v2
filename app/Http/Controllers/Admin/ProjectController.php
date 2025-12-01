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

        if ($search) {
            $query->where('project_title', 'like', "%$search%");
        }

        if ($status) {
            $query->where('status', $status);
        }

        return view('admin.projects.index', [
            'projects' => $query->orderByDesc('created_at')->paginate(15)->withQueryString(),
            'search'   => $search,
            'status'   => $status,
            'stats'    => [
                'total'     => ProjectAgreement::count(),
                'ongoing'   => ProjectAgreement::where('status', 'active')->count(),
                'completed' => ProjectAgreement::where('status', 'completed')->count(),
                'budget'    => (float) Payment::where('status', 'confirmed')->sum('amount'),
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
