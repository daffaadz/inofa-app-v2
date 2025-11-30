<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Skill;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

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
        $query = User::where('role', 'developer')
            ->leftJoin('developer_profiles', 'users.id', '=', 'developer_profiles.user_id')
            ->select('users.*', 'developer_profiles.rating_average', 'developer_profiles.projects_completed')
            ->with([
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
                $query->orderByDesc('developer_profiles.rating_average');
                break;

            case 'rating_low':
                $query->orderBy('developer_profiles.rating_average');
                break;

            case 'projects_completed':
                $query->orderByDesc('developer_profiles.projects_completed');
                break;

            case 'newest':
                $query->latest('users.created_at');
                break;

            case 'recommended':
            default:
                // Sort by: rating * projects_completed (best match)
                $query->orderByRaw('(COALESCE(developer_profiles.rating_average, 0) * COALESCE(developer_profiles.projects_completed, 0)) DESC');
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
        // Fetch developer with all related data
        $developer = User::with([
            'developerProfile',
            'skills' => function ($query) {
                $query->orderBy('proficiency_level', 'desc');
            },
            'portfolios' => function ($query) {
                $query->orderBy('is_featured', 'desc')->orderBy('sort_order', 'asc');
            },
        ])->findOrFail($id);

        // Check if user is actually a developer
        if ($developer->role !== 'developer') {
            abort(404);
        }

        // Increment profile view count (only if visitor is not the profile owner)
        if ($developer->developerProfile && Auth::check() && Auth::id() !== (int)$developer->id) {
            $developer->developerProfile->incrementViewCount();
        }

        // Get reviews for this developer
        $reviews = Review::with('consumer')->where('developer_id', $id)->where('is_public', true)->orderBy('created_at', 'desc')->get();

        // Calculate statistics
        $totalReviews = $reviews->count();
        $averageRating = $reviews->avg('rating');
        $projectsCompleted = $developer->developerProfile->projects_completed ?? 0;

        // Group skills by category
        $skills = $developer->skills;

        // Get certifications
        $certifications = [];
        if ($developer->developerProfile && $developer->developerProfile->certifications) {
            $certifications = is_array($developer->developerProfile->certifications) ? $developer->developerProfile->certifications : json_decode($developer->developerProfile->certifications, true);

            // Ensure it's always an array
            if (!is_array($certifications)) {
                $certifications = [];
            }
        }

        $educations = $developer->developerProfile->education ?? [];
        if (!is_array($educations)) {
            $educations = [];
        }
        $rateMin = $developer->developerProfile->rate_min_byproject ?? 0;
        $rateMax = $developer->developerProfile->rate_max_byproject ?? 0;

        // Calculate review statistics for distribution
        $reviewStats = [
            'total' => $totalReviews,
            'average' => $averageRating ?? 0,
            'distribution' => [
                5 => Review::where('developer_id', $id)->where('rating', 5)->count(),
                4 => Review::where('developer_id', $id)->where('rating', 4)->count(),
                3 => Review::where('developer_id', $id)->where('rating', 3)->count(),
                2 => Review::where('developer_id', $id)->where('rating', 2)->count(),
                1 => Review::where('developer_id', $id)->where('rating', 1)->count(),
            ],
        ];

        // Developer statistics
        $stats = [
            'projects_completed' => $projectsCompleted,
            'success_rate' => $this->calculateSuccessRate($developer),
            'avg_delivery_time' => $this->calculateAvgDeliveryTime($developer),
        ];

        return view('search.developers-show', compact('developer', 'reviews', 'totalReviews', 'averageRating', 'projectsCompleted', 'certifications', 'reviewStats', 'skills', 'stats', 'educations', 'rateMin', 'rateMax'));
    }

    /**
     * Calculate Success Rate
     * (Completed Projects / Total Projects) * 100
     */
    private function calculateSuccessRate($developer)
    {
        $totalProjects = \App\Models\ProjectAgreement::where('developer_id', $developer->id)
            ->whereIn('status', ['completed', 'active', 'terminated'])
            ->count();

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
