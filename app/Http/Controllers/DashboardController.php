<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use App\Models\ProjectAgreement;
use App\Models\Payment;
use App\Models\ProjectDispute;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return $this->adminDashboard($request);
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
    
    public function admin(Request $request)
    {
        return $this->adminDashboard($request);
    }

    /**
     * CONSUMER DASHBOARD
     * Shows all projects created by the consumer
     */
    private function consumerDashboard()
    {
        $user = Auth::user();
        $statusFilter = request('status');

        // Base query for projects
        $projectsQuery = Project::where('consumer_id', $user->id)
            ->whereNotIn('status', ['in_progress', 'completed'])
            ->with('skills')
            ->withCount(['agreements as offers_count' => function ($query) {
                $query->where('status', 'pending');
            }]);

        // Base query for agreements
        $agreementsQuery = ProjectAgreement::where('consumer_id', $user->id)
            ->where('status', '!=', 'pending')
            ->with(['developer.developerProfile', 'project', 'review']);

        // Apply status filter
        if ($statusFilter && $statusFilter !== 'all') {
            if ($statusFilter === 'active_contract') {
                $agreementsQuery->where('status', 'active');
                $projectsQuery->whereRaw('1 = 0'); // Hide projects
            } elseif ($statusFilter === 'bidding') {
                $projectsQuery->where('status', 'open');
                $agreementsQuery->whereRaw('1 = 0'); // Hide agreements
            } elseif ($statusFilter === 'waiting_payment') {
                $agreementsQuery->where('status', 'accepted');
                $projectsQuery->whereRaw('1 = 0'); // Hide projects
            } elseif ($statusFilter === 'completed') {
                $agreementsQuery->where('status', 'completed');
                $projectsQuery->whereRaw('1 = 0'); // Hide projects
            }
        }

        $projects = $projectsQuery->latest()->get();
        $agreements = $agreementsQuery->latest()->get();

        // Calculate totals from all data (not filtered)
        $allProjects = Project::where('consumer_id', $user->id)
            ->whereNotIn('status', ['in_progress', 'completed'])
            ->count();
        
        $allAgreements = ProjectAgreement::where('consumer_id', $user->id)
            ->where('status', '!=', 'pending')
            ->get();

        $totalProjects = $allProjects + $allAgreements->count();
        $inProgressCount = $allAgreements->where('status', 'active')->count();
        $completedCount = $allAgreements->where('status', 'completed')->count();

        $totalSpent = Payment::whereHas('agreement', function ($query) use ($user) {
            $query->where('consumer_id', $user->id);
        })
            ->whereIn('status', ['confirmed', 'completed', 'transferred'])
            ->sum('amount');

        return view('dashboard.consumer.index', compact(
            'projects',
            'agreements',
            'totalProjects',
            'inProgressCount',
            'completedCount',
            'totalSpent',
            'statusFilter',
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

        // 3. Active and Completed agreements (with project, consumer, and review)
        $activeAgreements = ProjectAgreement::where('developer_id', $user->id)
            ->whereIn('status', ['active', 'completed'])
            ->with(['project', 'consumer', 'review'])
            ->orderByRaw("FIELD(status, 'active', 'completed')")
            ->latest()
            ->get();

        // 4. Total earnings (transferred payments only)
        $earnings = Payment::whereHas('agreement', function ($query) use ($user) {
            $query->where('developer_id', $user->id);
        })
            ->where('status', 'transferred')
            ->sum('amount');

        // 4.1 Monthly earnings calculation
        $currentMonthStart = now()->startOfMonth();
        $lastMonthStart = now()->subMonth()->startOfMonth();
        $lastMonthEnd = now()->subMonth()->endOfMonth();

        $currentMonthEarnings = Payment::whereHas('agreement', function ($query) use ($user) {
            $query->where('developer_id', $user->id);
        })
            ->where('status', 'transferred')
            ->where('created_at', '>=', $currentMonthStart)
            ->sum('amount');

        $lastMonthEarnings = Payment::whereHas('agreement', function ($query) use ($user) {
            $query->where('developer_id', $user->id);
        })
            ->where('status', 'transferred')
            ->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])
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
     * Load all data at once for client-side tab switching
     */
    private function adminDashboard(Request $request)
    {
        $user = Auth::user();

        // ---------- GLOBAL KPI ----------
        $totalUsers       = User::count();
        $totalDevelopers  = User::where('role', 'developer')->count();
        $totalConsumers   = User::where('role', 'consumer')->count();

        $totalProjects    = Project::count();
        $activeProjects   = Project::where('status', 'in_progress')->count();
        $completedProjects= Project::where('status', 'completed')->count();

        $totalRevenue     = Payment::whereIn('status', ['confirmed', 'completed', 'transferred'])
                            ->sum('amount');

        $pendingPaymentsGlobal = Payment::where('admin_confirmed', false)
            ->where('status', 'pending')
            ->count();

        // ---------- LOAD ALL DATA ----------
        // Tab dari request (untuk keperluan default active tab)
        $tab = $request->get('tab', 'payments');
        
        // Global stats untuk summary cards
        $stats = [
            'pending_payments'    => Payment::where('status', 'pending')->count(),
            'confirmed_payments'  => Payment::whereIn('status', ['confirmed', 'completed', 'transferred'])->count(),
            'complaints'          => \App\Models\Complaint::count(),
            'total_users'         => User::where('role', '!=', 'admin')->count(),
        ];

        // ========== FILTERS FOR PAYMENTS ==========
        $paymentsQuery = Payment::with(['agreement.project', 'agreement.consumer', 'agreement.developer']);
        
        // Only apply filters when payments tab is active
        if ($tab === 'payments') {
            // Search filter for payments
            if ($request->filled('search')) {
                $search = $request->search;
                $paymentsQuery->where(function($q) use ($search) {
                    $q->whereHas('agreement.project', function($q2) use ($search) {
                        $q2->where('title', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('agreement.consumer', function($q2) use ($search) {
                        $q2->where('name', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('agreement.developer', function($q2) use ($search) {
                        $q2->where('name', 'LIKE', "%{$search}%");
                    });
                });
            }
            
            // Status filter for payments
            if ($request->filled('status')) {
                $paymentsQuery->where('status', $request->status);
            }
            
            // Payment type filter
            if ($request->filled('payment_type')) {
                $paymentsQuery->where('type', $request->payment_type);
            }
            
            // Date range filter for payments
            if ($request->filled('date_from')) {
                $paymentsQuery->whereDate('created_at', '>=', $request->date_from);
            }
            if ($request->filled('date_to')) {
                $paymentsQuery->whereDate('created_at', '<=', $request->date_to);
            }
            
            // Sort for payments
            $sort = $request->get('sort', 'newest');
            switch ($sort) {
                case 'oldest':
                    $paymentsQuery->oldest();
                    break;
                case 'highest_amount':
                    $paymentsQuery->orderByDesc('amount');
                    break;
                case 'lowest_amount':
                    $paymentsQuery->orderBy('amount');
                    break;
                default: // newest
                    $paymentsQuery->latest();
                    break;
            }
        } else {
            $paymentsQuery->latest();
        }
        
        $payments = $paymentsQuery->get();

        // ========== FILTERS FOR COMPLAINTS ==========
        $complaintsQuery = \App\Models\Complaint::with('user');
        
        // Only apply filters when complaints tab is active
        if ($tab === 'complaints') {
            // Search filter for complaints
            if ($request->filled('search')) {
                $search = $request->search;
                $complaintsQuery->where(function($q) use ($search) {
                    $q->where('user_name', 'LIKE', "%{$search}%")
                      ->orWhere('description', 'LIKE', "%{$search}%")
                      ->orWhereHas('user', function($q2) use ($search) {
                          $q2->where('name', 'LIKE', "%{$search}%")
                             ->orWhere('email', 'LIKE', "%{$search}%");
                      });
                });
            }
            
            // Status filter for complaints
            if ($request->filled('status')) {
                $complaintsQuery->where('status', $request->status);
            }
            
            // Raiser role filter for complaints
            if ($request->filled('raiser_role')) {
                $complaintsQuery->whereHas('user', function($q) use ($request) {
                    $q->where('role', $request->raiser_role);
                });
            }
            
            // Date range filter for complaints
            if ($request->filled('date_from')) {
                $complaintsQuery->whereDate('created_at', '>=', $request->date_from);
            }
            if ($request->filled('date_to')) {
                $complaintsQuery->whereDate('created_at', '<=', $request->date_to);
            }
            
            // Sort for complaints
            $sort = $request->get('sort', 'newest');
            if ($sort === 'oldest') {
                $complaintsQuery->oldest();
            } else {
                $complaintsQuery->latest();
            }
        } else {
            $complaintsQuery->latest();
        }
        
        $complaints = $complaintsQuery->get();

        // Projects (jika diperlukan di masa depan)
        $projects = collect();

        return view('admin.dashboard', [
            'user'       => $user,
            'tab'        => $tab,
            'projects'   => $projects,
            'payments'   => $payments,
            'complaints' => $complaints,
            'stats'      => $stats,

            // global KPI lama tetap dikirim
            'totalUsers'      => $totalUsers,
            'totalDevelopers' => $totalDevelopers,
            'totalConsumers'  => $totalConsumers,
            'totalProjects'   => $totalProjects,
            'activeProjects'  => $activeProjects,
            'completedProjects'=> $completedProjects,
            'totalRevenue'    => $totalRevenue,
            'pendingPaymentsGlobal' => $pendingPaymentsGlobal,
        ]);
}

    /**
     * Export current tab data to CSV (basic placeholder).
     * Respects minimal filters for status and date range; payments support amount filter.
     */
    public function export(Request $request)
    {
        $tab = $request->get('tab', 'projects');

        switch ($tab) {
            case 'projects':
                $query = Project::with(['consumer', 'agreement.developer'])->latest();
                if ($request->filled('status')) {
                    $query->where('status', $request->string('status'));
                }
                if ($request->filled('date_from') || $request->filled('date_to')) {
                    $from = $request->date('date_from', now()->subYears(10));
                    $to   = $request->date('date_to', now());
                    $query->whereBetween('created_at', [$from, $to]);
                }
                $items = $query->get();
                $headers = ['Project', 'Client', 'Developer', 'Budget', 'Status', 'Created At'];
                $rows = $items->map(function ($p) {
                    return [
                        $p->title ?? $p->name,
                        optional($p->consumer)->name,
                        optional(optional($p->agreement)->developer)->name,
                        $p->budget ?? 0,
                        $p->status,
                        optional($p->created_at)?->toDateTimeString(),
                    ];
                });
                $filename = 'projects_export_'.now()->format('Ymd_His').'.csv';
                break;

            case 'payments':
                $query = Payment::with(['agreement.project', 'agreement.consumer', 'agreement.developer']);
                
                if ($request->filled('status')) {
                    $query->where('status', $request->string('status'));
                }
                if ($request->filled('payment_type')) {
                    $query->where('type', $request->string('payment_type'));
                }
                if ($request->filled('date_from')) {
                    $query->where('created_at', '>=', $request->date('date_from'));
                }
                if ($request->filled('date_to')) {
                    $query->where('created_at', '<=', $request->date('date_to')->endOfDay());
                }
                
                // Sorting
                $sort = $request->get('sort', 'newest');
                match($sort) {
                    'oldest' => $query->oldest(),
                    default => $query->latest(),
                };
                
                $items = $query->get();
                $headers = ['Project', 'Client', 'Developer', 'Amount', 'Type', 'Status', 'Date'];
                $rows = $items->map(function ($pay) {
                    return [
                        optional(optional($pay->agreement)->project)->title,
                        optional(optional($pay->agreement)->consumer)->name,
                        optional(optional($pay->agreement)->developer)->name,
                        $pay->amount,
                        $pay->type,
                        $pay->status,
                        optional($pay->created_at)?->toDateTimeString(),
                    ];
                });
                $filename = 'payments_export_'.now()->format('Ymd_His').'.csv';
                break;

            case 'complaints':
                $query = \App\Models\Complaint::with('user');
                
                // Search
                if ($request->filled('search')) {
                    $search = $request->string('search');
                    $query->where(function($q) use ($search) {
                        $q->where('user_name', 'LIKE', "%{$search}%")
                          ->orWhere('description', 'LIKE', "%{$search}%")
                          ->orWhereHas('user', function($q2) use ($search) {
                              $q2->where('name', 'LIKE', "%{$search}%");
                          });
                    });
                }
                
                // Status filter
                if ($request->filled('status')) {
                    $query->where('status', $request->string('status'));
                }
                
                // Default sorting: newest
                $query->latest();
                
                $items = $query->get();
                $headers = ['User', 'Email', 'Description', 'Status', 'Admin Response', 'Created At', 'Responded At'];
                $rows = $items->map(function ($complaint) {
                    return [
                        $complaint->user_name ?? optional($complaint->user)->name ?? 'Unknown',
                        optional($complaint->user)->email ?? 'N/A',
                        substr($complaint->description, 0, 200) . (strlen($complaint->description) > 200 ? '...' : ''),
                        $complaint->status,
                        substr($complaint->admin_response ?? 'No response', 0, 100),
                        optional($complaint->created_at)?->toDateTimeString(),
                        optional($complaint->responded_at)?->toDateTimeString() ?? 'Not responded',
                    ];
                });
                $filename = 'complaints_export_'.now()->format('Ymd_His').'.csv';
                break;

            default:
                abort(404);
        }

        return response()->streamDownload(function () use ($headers, $rows) {
            $out = fopen('php://output', 'w');
            // UTF-8 BOM for Excel compatibility
            fprintf($out, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($out, $headers);
            foreach ($rows as $row) {
                fputcsv($out, $row);
            }
            fclose($out);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

}