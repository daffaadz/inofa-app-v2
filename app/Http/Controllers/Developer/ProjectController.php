<?php

namespace App\Http\Controllers\Developer;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectAgreement;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /* ---------- List open projects ---------- */
    public function index()
    {
        $projects = Project::with(['consumer', 'skills'])
            ->where('status', 'open')
            ->latest()
            ->paginate(12);

        return view('developer.projects.index', compact('projects'));
    }

    /* ---------- Detail project + form submit proposal ---------- */
    public function show(Project $project)
    {
        // hanya boleh lihat project yg masih open
        abort_if($project->status !== 'open', 403);

        $project->load(['skills', 'consumer']);

        // cek apakah developer sudah mengajukan proposal (agreement)
        $myProposal = ProjectAgreement::where('project_id', $project->id)
            ->where('developer_id', Auth::id())
            ->first();

        return view('developer.projects.show', compact('project', 'myProposal'));
    }

    /* ---------- Store new proposal (akan membuat project agreement) ---------- */
    public function propose(Project $project)
    {
        request()->validate([
            'proposed_price'    => 'required|numeric|min:1',
            'proposed_deadline' => 'required|date|after:today',
            'cover_letter'      => 'required|string|max:2000',
            'milestones'        => 'nullable|array',
        ]);

        // cegah duplicate
        if (ProjectAgreement::where('project_id', $project->id)
                ->where('developer_id', Auth::id())
                ->exists()) {
            return back()->with('error', 'You have already sent a proposal for this project.');
        }

        ProjectAgreement::create([
            'project_id'        => $project->id,
            'developer_id'      => Auth::id(),
            'consumer_id'       => $project->consumer_id,
            'price'             => request('proposed_price'),
            'deadline'          => request('proposed_deadline'),
            'terms'             => request('cover_letter'),
            'milestones'        => request('milestones', []),
            'status'            => 'pending',
        ]);

        return back()->with('success', 'Proposal sent successfully.');
    }
}