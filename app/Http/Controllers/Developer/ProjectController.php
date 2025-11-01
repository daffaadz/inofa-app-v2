<?php

namespace App\Http\Controllers\Developer;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Offer;

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

    /* ---------- Detail project + form kirim offer ---------- */
    public function show(Project $project)
    {
        // hanya boleh lihat project yg masih open
        abort_if($project->status !== 'open', 403);

        $project->load(['skills', 'consumer', 'offers' => fn($q) => $q->where('developer_id', auth()->id())]);

        // cek apakah developer sudah menawar
        $myOffer = $project->offers->first();

        return view('developer.projects.show', compact('project', 'myOffer'));
    }

    /* ---------- Store new offer (dipanggil dari form di halaman show) ---------- */
    public function offer(Project $project)
    {
        request()->validate([
            'proposed_price'    => 'required|numeric|min:1',
            'proposed_deadline' => 'required|date|after:today',
            'cover_letter'      => 'required|string|max:2000',
            'milestones'        => 'nullable|array',
        ]);

        // cegah duplicate
        if ($project->offers()->where('developer_id', auth()->id())->exists()) {
            return back()->with('error', 'You have already sent an offer for this project.');
        }

        $project->offers()->create([
            'developer_id'      => auth()->id(),
            'proposed_price'    => request('proposed_price'),
            'proposed_deadline' => request('proposed_deadline'),
            'cover_letter'      => request('cover_letter'),
            'milestones'        => request('milestones', []),
            'status'            => 'pending',
        ]);

        return back()->with('success', 'Offer sent successfully.');
    }
}