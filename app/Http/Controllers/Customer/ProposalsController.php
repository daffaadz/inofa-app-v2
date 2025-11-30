<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectAgreement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProposalsController extends Controller
{
    /**
     * Display proposals for consumer's projects
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Get all consumer's projects
        $projects = Project::where('consumer_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Get selected project from query string or default to first project
        $selectedProjectId = $request->query('project');
        $selectedProject = null;
        
        if ($selectedProjectId) {
            $selectedProject = Project::where('id', $selectedProjectId)
                ->where('consumer_id', $user->id)
                ->first();
        }
        
        // If no project selected or invalid project, use first project
        if (!$selectedProject && $projects->isNotEmpty()) {
            $selectedProject = $projects->first();
        }
        
        // Get pending agreements for selected project
        $proposals = collect();
        
        if ($selectedProject) {
            $proposals = ProjectAgreement::where('project_id', $selectedProject->id)
                ->where('status', 'pending')
                ->with(['developer.developerProfile'])
                ->orderBy('created_at', 'desc')
                ->get();
        }
        
        return view('dashboard.consumer.proposals.index', [
            'projects' => $projects,
            'selectedProject' => $selectedProject,
            'proposals' => $proposals,
        ]);
    }
}
