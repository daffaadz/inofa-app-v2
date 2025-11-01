<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use App\Models\Offer;
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

        // Get all projects with relationships
        $projects = Project::where('consumer_id', $user->id)
            ->with([
                'skills',
                'offers' => function($query) {
                    $query->where('status', 'pending');
                },
                'agreement.developer'
            ])
            ->withCount('offers')
            ->latest()
            ->get();

        // Stats
        $totalProjects = $projects->count();
        
        $inProgressCount = Project::where('consumer_id', $user->id)
            ->where('status', 'in_progress')
            ->count();

        $completedCount = Project::where('consumer_id', $user->id)
            ->where('status', 'completed')
            ->count();

        // Total spent - sum of all payments confirmed or transferred
        $totalSpent = Payment::whereHas('agreement', function($query) use ($user) {
                $query->where('consumer_id', $user->id);
            })
            ->whereIn('status', ['confirmed', 'transferred'])
            ->sum('amount');

        return view('dashboard.consumer.index', compact(
            'projects',
            'totalProjects',
            'inProgressCount',
            'completedCount',
            'totalSpent'
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
            ->whereDoesntHave('offers', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->latest()
            ->take(10)
            ->get();

        // 2. My offers (with project details)
        $myOffers = Offer::where('user_id', $user->id)
            ->with('project.consumer')
            ->latest()
            ->get();

        // 3. Active agreements (with project and consumer)
        $activeAgreements = ProjectAgreement::where('developer_id', $user->id)
            ->where('status', 'active')
            ->with(['project', 'consumer'])
            ->get();

        // 4. Total earnings (transferred payments only)
        $earnings = Payment::whereHas('agreement', function($query) use ($user) {
                $query->where('developer_id', $user->id);
            })
            ->where('status', 'transferred')
            ->where('admin_transferred', true)
            ->sum('amount');

        // 5. Pending offers count
        $pendingOffers = $myOffers->where('status', 'pending')->count();

        // 6. Profile views (you can implement analytics later)
        // For now, use a dummy or query from analytics table if exists
        $profileViews = 1247; // Replace with actual analytics query

        return view('dashboard.developer.index', compact(
            'availableProjects',
            'myOffers',
            'activeAgreements',
            'earnings',
            'pendingOffers',
            'profileViews'
        ));
    }

    /**
     * ADMIN DASHBOARD
     * Shows platform statistics and management tools
     */
    private function adminDashboard()
    {
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
            'recentProjects'
        ));
    }
}