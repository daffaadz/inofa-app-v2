<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Skill;
use App\Models\Review;

class SearchController extends Controller
{
    /**
     * 🔍 Search & Filter Developers
     * GET /search/developers
     */
    public function index(Request $request)
    {
        $keyword = $request->get('q');
        $category = $request->get('category');
        $location = $request->get('location');
        $skills = $request->get('skills', []);
        $minRating = $request->get('min_rating');
        $sortBy = $request->get('sort_by', 'recommended');
        $perPage = $request->get('per_page', 10);

        /** ----------------------------------------
         * 1️⃣ Base Query - Developers Only
         * ---------------------------------------- */
        $query = User::where('role', 'developer')->with([
            'developerProfile',
            'skills' => function ($q) {
                $q->orderBy('proficiency_level', 'desc');
            },
        ]);

        /** ----------------------------------------
         * 2️⃣ Full-text Search (Name or Skills)
         * ---------------------------------------- */
        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'LIKE', "%{$keyword}%")
                    ->orWhere('bio', 'LIKE', "%{$keyword}%")
                    ->orWhereHas('developerProfile', function ($dp) use ($keyword) {
                        $dp->where('headline', 'LIKE', "%{$keyword}%")->orWhere('experience', 'LIKE', "%{$keyword}%");
                    })
                    ->orWhereHas('skills', function ($s) use ($keyword) {
                        $s->where('name', 'LIKE', "%{$keyword}%");
                    });
            });
        }

        /** ----------------------------------------
         * 3️⃣ Filter by Category (Skills Category)
         * ---------------------------------------- */
        if ($category && $category !== 'all') {
            $query->whereHas('skills', function ($s) use ($category) {
                $s->where('category', $category);
            });
        }

        /** ----------------------------------------
         * 4️⃣ Filter by Location
         * ---------------------------------------- */
        if ($location && $location !== 'all') {
            $query->where('location', 'LIKE', "%{$location}%");
        }

        /** ----------------------------------------
         * 5️⃣ Filter by Skills (Multiple)
         * ---------------------------------------- */
        if (!empty($skills) && is_array($skills)) {
            foreach ($skills as $skillName) {
                $query->whereHas('skills', function ($s) use ($skillName) {
                    $s->where('name', $skillName);
                });
            }
        }

        /** ----------------------------------------
         * 6️⃣ Filter by Minimum Rating
         * ---------------------------------------- */
        if ($minRating) {
            $query->whereHas('developerProfile', function ($dp) use ($minRating) {
                $dp->where('rating_average', '>=', $minRating);
            });
        }

        /** ----------------------------------------
         * 7️⃣ Sorting
         * ---------------------------------------- */
        switch ($sortBy) {
            case 'rating_high':
                $query->orderByDesc(function ($q) {
                    $q->select('rating_average')->from('developer_profiles')->whereColumn('developer_profiles.user_id', 'users.id')->limit(1);
                });
                break;

            case 'rating_low':
                $query->orderBy(function ($q) {
                    $q->select('rating_average')->from('developer_profiles')->whereColumn('developer_profiles.user_id', 'users.id')->limit(1);
                });
                break;

            case 'projects_completed':
                $query->orderByDesc(function ($q) {
                    $q->select('projects_completed')->from('developer_profiles')->whereColumn('developer_profiles.user_id', 'users.id')->limit(1);
                });
                break;

            case 'newest':
                $query->latest('created_at');
                break;

            case 'recommended':
            default:
                // Sort by: rating * projects_completed (best match)
                $query->orderByRaw('(
                    SELECT rating_average * projects_completed
                    FROM developer_profiles
                    WHERE developer_profiles.user_id = users.id
                ) DESC');
                break;
        }

        /** ----------------------------------------
         * 8️⃣ Pagination
         * ---------------------------------------- */
        $developers = $query->paginate($perPage);

        /** ----------------------------------------
         * 9️⃣ Get Filter Options for UI
         * ---------------------------------------- */
        $categories = Skill::select('category')->whereNotNull('category')->where('is_active', true)->groupBy('category')->pluck('category');

        $locations = User::where('role', 'developer')->whereNotNull('location')->select('location')->groupBy('location')->pluck('location');

        $allSkills = Skill::where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'category']);

        /** ----------------------------------------
         * 🔟 Return View
         * ---------------------------------------- */
        return view('search.developers', compact('developers', 'categories', 'locations', 'allSkills', 'keyword', 'category', 'location', 'skills', 'minRating', 'sortBy'));
    }

    /**
     * 📄 Show Developer Profile Detail
     * GET /search/developers/{id}
     */
    public function show($id)
    {
        $developer = User::where('role', 'developer')
            ->with([
                'developerProfile',
                'skills' => function ($q) {
                    $q->orderBy('proficiency_level', 'desc');
                },
                'portfolios' => function ($q) {
                    $q->orderBy('is_featured', 'desc')->orderBy('sort_order', 'asc');
                },
            ])
            ->withCount(['completedProjects as total_projects', 'reviewsReceived as total_reviews'])
            ->findOrFail($id);

        // Get reviews for this developer
        $reviews = Review::where('developer_id', $id)
            ->where('is_public', true)
            ->with(['consumer:id,name,avatar', 'project:id,title'])
            ->latest()
            ->paginate(10);

        // Calculate review statistics
        $reviewStats = [
            'total' => $reviews->total(),
            'average' => $developer->developerProfile->rating_average ?? 0,
            'distribution' => [
                5 => Review::where('developer_id', $id)->where('rating', 5)->count(),
                4 => Review::where('developer_id', $id)->where('rating', 4)->count(),
                3 => Review::where('developer_id', $id)->where('rating', 3)->count(),
                2 => Review::where('developer_id', $id)->where('rating', 2)->count(),
                1 => Review::where('developer_id', $id)->where('rating', 1)->count(),
            ],
        ];

        // Group skills by category
        $skillsByCategory = $developer->skills->groupBy('category');

        // Developer statistics
        $stats = [
            'projects_completed' => $developer->developerProfile->projects_completed ?? 0,
            'success_rate' => $this->calculateSuccessRate($developer),
            'avg_delivery_time' => $this->calculateAvgDeliveryTime($developer),
        ];

        return view('search.developers-show', compact('developer', 'reviews', 'reviewStats', 'skillsByCategory', 'stats'));
    }

    /**
     * Calculate Success Rate
     * (Completed Projects / Total Projects) * 100
     */
    private function calculateSuccessRate($developer)
    {
        $totalProjects = $developer->total_projects ?? 0;
        $completed = $developer->developerProfile->projects_completed ?? 0;

        if ($totalProjects == 0) {
            return 100; // Default if no projects
        }

        return round(($completed / $totalProjects) * 100);
    }

    /**
     * Calculate Average Delivery Time (in days)
     * Based on project_agreements data
     */
    private function calculateAvgDeliveryTime($developer)
    {
        $agreements = \App\Models\ProjectAgreement::where('developer_id', $developer->id)->where('status', 'completed')->whereNotNull('signed_at')->whereNotNull('end_date')->get();

        if ($agreements->isEmpty()) {
            return null;
        }

        $totalDays = 0;
        foreach ($agreements as $agreement) {
            $start = \Carbon\Carbon::parse($agreement->start_date);
            $end = \Carbon\Carbon::parse($agreement->end_date);
            $totalDays += $start->diffInDays($end);
        }

        return round($totalDays / $agreements->count());
    }
}
