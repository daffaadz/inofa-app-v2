<?php

namespace App\Http\Controllers\Developer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    /**
     * 🔍 Search & Filter Projects (For Developers)
     * GET /search/projects
     */
    public function index(Request $request)
    {
        $keyword = $request->get('q');
        $minBudget = $request->get('min_budget');
        $maxBudget = $request->get('max_budget');
        $category = $request->get('category');
        $location = $request->get('location');
        $skills = $request->get('skills', []);
        $sortBy = $request->get('sort_by', 'most_recent');
        $perPage = $request->get('per_page', 10);

        /** ----------------------------------------
         * 1️⃣ Base Query - Open Projects Only
         * ---------------------------------------- */
        $query = Project::where('status', 'open')->with([
            'consumer:id,name,avatar,location',
            'skills' => function ($q) {
                $q->select('skills.id', 'skills.name');
            },
        ]);

        /** ----------------------------------------
         * 2️⃣ Full-text Search
         * ---------------------------------------- */
        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'LIKE', "%{$keyword}%")
                    ->orWhere('description', 'LIKE', "%{$keyword}%")
                    ->orWhereHas('skills', function ($s) use ($keyword) {
                        $s->where('name', 'LIKE', "%{$keyword}%");
                    });
            });
        }

        /** ----------------------------------------
         * 5️⃣ Filter by Budget Range
         * ---------------------------------------- */
        if ($minBudget) {
            $query->where('budget', '>=', $minBudget);
        }
        if ($maxBudget) {
            $query->where('budget', '<=', $maxBudget);
        }

        /** ----------------------------------------
         * 6️⃣ Filter by Category (Skills Category)
         * ---------------------------------------- */
        if ($category && $category !== 'all') {
            $query->whereHas('skills', function ($s) use ($category) {
                $s->where('category', $category);
            });
        }

        /** ----------------------------------------
         * 7️⃣ Filter by Location
         * ---------------------------------------- */
        if ($location && $location !== 'all') {
            $query->whereHas('consumer', function ($c) use ($location) {
                $c->where('location', 'LIKE', "%{$location}%");
            });
        }

        /** ----------------------------------------
         * 8️⃣ Filter by Skills (Multiple)
         * ---------------------------------------- */
        if (!empty($skills) && is_array($skills)) {
            foreach ($skills as $skillName) {
                $query->whereHas('skills', function ($s) use ($skillName) {
                    $s->where('name', $skillName);
                });
            }
        }

        /** ----------------------------------------
         * 9️⃣ Sorting
         * ---------------------------------------- */
        switch ($sortBy) {
            case 'budget_high':
                $query->orderByDesc('budget');
                break;

            case 'budget_low':
                $query->orderBy('budget');
                break;

            case 'deadline_soon':
                $query->orderBy('deadline');
                break;

            case 'most_applicants':
                $query->withCount('offers')->orderByDesc('offers_count');
                break;

            case 'most_recent':
            default:
                $query->latest('created_at');
                break;
        }

        /** ----------------------------------------
         * 🔟 Pagination
         * ---------------------------------------- */
        $projects = $query->paginate($perPage);

        /** ----------------------------------------
         * 1️⃣1️⃣ Get Filter Options for UI
         * ---------------------------------------- */
        $categories = Skill::select('category')->whereNotNull('category')->where('is_active', true)->groupBy('category')->pluck('category');

        $locations = Project::whereHas('consumer', function ($q) {
            $q->whereNotNull('location');
        })
            ->with('consumer:id,location')
            ->get()
            ->pluck('consumer.location')
            ->unique()
            ->filter()
            ->values();

        $allSkills = Skill::where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'category']);

        /** ----------------------------------------
         * 1️⃣2️⃣ Return View
         * ---------------------------------------- */
        return view('search.projects', compact('projects', 'categories', 'locations', 'allSkills', 'keyword', 'minBudget', 'maxBudget', 'category', 'location', 'skills', 'sortBy'));
    }

    /**
     * 📄 Show Project Detail (For Developers to Apply)
     * GET /search/projects/{id}
     */
    public function show($id)
    {
        $project = Project::where('status', 'open')
            ->with([
                'consumer' => function ($q) {
                    $q->select('id', 'name', 'avatar', 'location', 'created_at')->withCount('projects');
                },
                'skills',
                'offers' => function ($q) {
                    $q->select('id', 'project_id', 'status')->whereIn('status', ['pending', 'accepted']);
                },
            ])
            ->withCount([
                'offers as total_applicants' => function ($q) {
                    $q->where('status', 'pending');
                },
            ])
            ->findOrFail($id);

        // Check if current user already applied
        $hasApplied = false;
        $userOffer = null;

        if (Auth::check() && Auth::user()->role === 'developer') {
            $userOffer = $project->offers()->where('user_id', Auth::id())->first();
            $hasApplied = $userOffer !== null;
        }

        // Get similar projects
        $similarProjects = Project::where('status', 'open')
            ->where('id', '!=', $project->id)
            ->whereHas('skills', function ($q) use ($project) {
                $q->whereIn('skills.id', $project->skills->pluck('id'));
            })
            ->with('consumer:id,name,avatar', 'skills')
            ->limit(4)
            ->latest()
            ->get();

        return view('search.projects-show', compact('project', 'hasApplied', 'userOffer', 'similarProjects'));
    }
}
