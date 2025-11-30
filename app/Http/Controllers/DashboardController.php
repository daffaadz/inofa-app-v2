<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use App\Models\ProjectAgreement;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return $this->adminDashboard();
        } elseif ($user->isDeveloper()) {
            return $this->developerDashboard();
        } else {
            return $this->consumerDashboard();
        }
    }

    public function consumer()
    {
        return $this->consumerDashboard();
    }

    public function developer()
    {
        return $this->developerDashboard();
    }

    public function admin()
    {
        return $this->adminDashboard();
    }

    /**
     * CONSUMER DASHBOARD
     * Shows all projects created by the consumer
     */
    private function consumerDashboard()
    {
        $user = Auth::user();

        $projects = Project::where('consumer_id', $user->id)
            ->whereNotIn('status', ['in_progress', 'completed'])
            ->with('skills')
            ->withCount(['agreements as offers_count' => function ($query) {
                $query->where('status', 'pending');
            }])
            ->latest()
            ->get();

        $agreements = ProjectAgreement::where('consumer_id', $user->id)
            ->where('status', '!=', 'pending')
            ->with(['developer', 'project'])
            ->latest()
            ->get();

        $totalProjects = $projects->count() + $agreements->count();

        $inProgressCount = $agreements->where('status', 'active')->count();

        $completedCount = $agreements->where('status', 'completed')->count();

        $totalSpent = Payment::whereHas('agreement', function ($query) use ($user) {
            $query->where('consumer_id', $user->id);
        })
            ->whereIn('status', ['confirmed', 'transferred'])
            ->sum('amount');

        return view('dashboard.consumer.index', compact(
            'projects',
            'agreements',
            'totalProjects',
            'inProgressCount',
            'completedCount',
            'totalSpent',
            'user'
        ));
    }

    /**
     * DEVELOPER DASHBOARD
     * Shows active projects and available opportunities
     */
    private function developerDashboard()
    {
        $user = Auth::user();

        // 1. Available open projects (with consumer info)
        $availableProjects = Project::with('consumer')
            ->where('status', 'open')
            ->whereDoesntHave('agreement')
            ->latest()
            ->take(10)
            ->get();

        // 2. My pending/submitted agreements (replace offers)
        $myAgreements = ProjectAgreement::where('developer_id', $user->id)
            ->whereIn('status', ['pending', 'accepted'])
            ->with('project.consumer')
            ->latest()
            ->get();

        // 3. Active agreements (with project and consumer)
        $activeAgreements = ProjectAgreement::where('developer_id', $user->id)
            ->where('status', 'active')
            ->with(['project', 'consumer'])
            ->get();

        // 4. Total earnings (transferred payments only)
        $earnings = Payment::whereHas('agreement', function ($query) use ($user) {
            $query->where('developer_id', $user->id);
        })
            ->where('status', 'transferred')
            ->where('admin_transferred', true)
            ->sum('amount');

        // 4.1 Monthly earnings calculation
        $currentMonthStart = now()->startOfMonth();
        $lastMonthStart = now()->subMonth()->startOfMonth();
        $lastMonthEnd = now()->subMonth()->endOfMonth();

        $currentMonthEarnings = Payment::whereHas('agreement', function ($query) use ($user) {
            $query->where('developer_id', $user->id);
        })
            ->where('status', 'transferred')
            ->where('admin_transferred', true)
            ->where('admin_transferred_at', '>=', $currentMonthStart)
            ->sum('amount');

        $lastMonthEarnings = Payment::whereHas('agreement', function ($query) use ($user) {
            $query->where('developer_id', $user->id);
        })
            ->where('status', 'transferred')
            ->where('admin_transferred', true)
            ->whereBetween('admin_transferred_at', [$lastMonthStart, $lastMonthEnd])
            ->sum('amount');

        $earningsIncrease = $currentMonthEarnings - $lastMonthEarnings;

        // 4.2 Active projects increase calculation
        $currentMonthActiveProjects = ProjectAgreement::where('developer_id', $user->id)
            ->where('status', 'active')
            ->where('start_date', '>=', $currentMonthStart)
            ->count();

        $lastMonthActiveProjects = ProjectAgreement::where('developer_id', $user->id)
            ->where('status', 'active')
            ->whereBetween('start_date', [$lastMonthStart, $lastMonthEnd])
            ->count();

        $activeProjectsIncrease = $currentMonthActiveProjects - $lastMonthActiveProjects;

        // 5. Pending agreements count
        $pendingAgreements = $myAgreements->where('status', 'pending')->count();

        // 6. Profile views from developer_profiles
        $profileViews = $user->developerProfile->profile_view_count ?? 0;
        
        // 6.1 Weekly profile views calculation
        $currentWeekStart = now()->startOfWeek();
        
        // Get total views from last week by checking last_viewed_at timestamps
        // This is an approximation - for accurate weekly tracking, you'd need a separate views log table
        // For now, we'll calculate based on the assumption that views are relatively consistent
        $profileViewsIncrease = 0; // Placeholder - will need proper weekly tracking
        
        // Alternative: If you want to estimate weekly increase
        // You could track daily average and multiply by 7, but this requires historical data
        // For now, keeping it simple with total count only

        return view('dashboard.developer.index', compact(
            'availableProjects',
            'myAgreements',
            'activeAgreements',
            'earnings',
            'earningsIncrease',
            'activeProjectsIncrease',
            'pendingAgreements',
            'profileViews',
            'profileViewsIncrease',
            'user'
        ));
    }

    /**
     * ADMIN DASHBOARD
     * Shows platform statistics and management tools
     */
    private function adminDashboard()
    {
        $user = Auth::user();

        // Total users
        $totalUsers = User::count();
        $totalDevelopers = User::where('role', 'developer')->count();
        $totalConsumers = User::where('role', 'consumer')->count();

        // Total projects
        $totalProjects = Project::count();
        $activeProjects = Project::where('status', 'in_progress')->count();
        $completedProjects = Project::where('status', 'completed')->count();

        // Payments pending admin confirmation
        $pendingPayments = Payment::where('admin_confirmed', false)
            ->where('status', 'pending')
            ->with(['agreement.project', 'agreement.consumer', 'agreement.developer'])
            ->latest()
            ->get();

        // Payments to transfer
        $paymentsToTransfer = Payment::where('admin_confirmed', true)
            ->where('admin_transferred', false)
            ->where('status', 'confirmed')
            ->with(['agreement.project', 'agreement.developer'])
            ->latest()
            ->get();

        // Total platform revenue (you can add commission logic)
        $totalRevenue = Payment::whereIn('status', ['confirmed', 'transferred'])
            ->sum('amount');

        // Recent projects
        $recentProjects = Project::with(['consumer', 'agreement.developer'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalDevelopers',
            'totalConsumers',
            'totalProjects',
            'activeProjects',
            'completedProjects',
            'pendingPayments',
            'paymentsToTransfer',
            'totalRevenue',
            'recentProjects',
            'user'
        ));
    }
}
