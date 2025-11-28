<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $status = $request->status;

        $query = Project::query();

        if ($search) {
            $query->where('title', 'like', "%$search%");
        }

        if ($status) {
            $query->where('status', $status);
        }

        return view('admin.projects.index', [
            'projects' => $query->orderByDesc('created_at')->paginate(15)->withQueryString(),
            'search'   => $search,
            'status'   => $status,
            'stats'    => [
                'total'     => Project::count(),
                'ongoing'   => Project::where('status', 'in_progress')->count(),
                'completed' => Project::where('status', 'completed')->count(),
                'budget'    => (float) Project::sum('budget'),
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
