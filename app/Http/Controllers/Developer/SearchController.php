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
        $experience = $request->get('experience');
        $skills = $request->get('skills', []);
        $sortBy = $request->get('sort_by', 'most_recent');
        $perPage = $request->get('per_page', 10);

        /** ----------------------------------------
         * 1️⃣ Base Query - Open Projects Only (exclude in_progress)
         * ---------------------------------------- */
        $query = Project::where('status', 'open')
            ->whereNotIn('status', ['in_progress', 'completed', 'cancelled'])
            ->withCount('offers')
            ->with([
            'consumer:id,name,avatar,location',
            'skills' => function ($q) {
                $q->select('skills.id', 'skills.name')->withPivot('required_level');
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
         * 3️⃣ Filter by Experience Level (calculated from required_level)
         * Beginner: avg 1-2, Intermediate: avg 2.1-3.5, Advance: avg 3.6-4.5, Expert: avg 4.6-5
         * ---------------------------------------- */
        if ($experience && $experience !== 'all') {
            $levelRanges = $this->getExperienceLevelRange($experience);
            
            if ($levelRanges) {
                $query->whereIn('id', function ($subQuery) use ($levelRanges) {
                    $subQuery->select('project_id')
                        ->from('project_skills')
                        ->groupBy('project_id')
                        ->havingRaw('AVG(required_level) >= ? AND AVG(required_level) <= ?', $levelRanges);
                });
            }
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

            case 'most_proposals':
                $query->orderByDesc('offers_count');
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
        return view('search.projects', compact('projects', 'categories', 'locations', 'allSkills', 'keyword', 'minBudget', 'maxBudget', 'category', 'location', 'experience', 'skills', 'sortBy'));
    }

    /**
     * Helper method to get experience level range
     */
    private function getExperienceLevelRange($experience)
    {
        switch ($experience) {
            case 'beginner':
                return [1, 2];
            case 'intermediate':
                return [2.01, 3.5];
            case 'advance':
                return [3.51, 4.5];
            case 'expert':
                return [4.51, 5];
            default:
                return null;
        }
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
                    $q->select('id', 'name', 'avatar', 'location', 'created_at')->withCount('postedProjects');
                },
                'skills' => function ($q) {
                    $q->select('skills.id', 'skills.name')->withPivot('required_level');
                },
            ])
            ->withCount('offers')
            ->findOrFail($id);

        // Check if current user already applied
        $hasApplied = false;
        $userOffer = null;

        if (Auth::check() && Auth::user()->role === 'developer') {
            $userOffer = $project->agreements()->where('developer_id', Auth::id())->first();
            $hasApplied = $userOffer !== null;
        }

        // Get similar projects
        $similarProjects = Project::where('status', 'open')
            ->where('id', '!=', $project->id)
            ->whereHas('skills', function ($q) use ($project) {
                $q->whereIn('skills.id', $project->skills->pluck('id'));
            })
            ->with('consumer:id,name,avatar', 'skills')
            ->withCount('offers')
            ->limit(4)
            ->latest()
            ->get();

        return view('search.projects-show', compact('project', 'hasApplied', 'userOffer', 'similarProjects'));
    }
}
