<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use App\Models\ProjectAgreement;
use App\Models\Payment;
use App\Models\Complaint;
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
    
    public function admin(Request $request)
    {
        return $this->adminDashboard($request, $request->query('tab', 'projects'));
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
     */
    private function adminDashboard(Request $request, string $tab = 'projects')
    {
        $user = Auth::user();

        // ---------- GLOBAL KPI (selalu ada, di bagian atas atau sidebar) ----------
        $totalUsers       = User::count();
        $totalDevelopers  = User::where('role', 'developer')->count();
        $totalConsumers   = User::where('role', 'consumer')->count();

        $totalProjects    = Project::count();
        $activeProjects   = Project::where('status', 'in_progress')->count();
        $completedProjects= Project::where('status', 'completed')->count();

        $totalRevenue     = Payment::whereIn('status', ['confirmed', 'transferred'])
                            ->sum('amount');

        // kalau masih mau pakai:
        $pendingPaymentsGlobal = Payment::where('admin_confirmed', false)
            ->where('status', 'pending')
            ->count();

        // ---------- TAB / SLICING ----------
        $tab = $request->get('tab', 'projects'); // default: projects

        // Prepare dataset variables expected by view
        $projects = collect();
        $payments = collect();
        $complaints = collect();

        switch ($tab) {
            /* =====================================================
            * 1) VALIDASI PROYEK
            * ===================================================== */
            case 'projects':
                $projects = Project::with(['consumer', 'agreement.developer'])
                    ->latest()
                    ->get();

                $stats = [
                    'pending'  => Project::where('status', 'pending')->count(),
                    'progress' => Project::where('status', 'in_progress')->count(),
                    'approved' => Project::where('status', 'completed')->count(),
                    'total'    => Project::count(),
                ];
                break;

            /* =====================================================
            * 2) VALIDASI PEMBAYARAN
            * ===================================================== */
            case 'payments':
                $payments = Payment::with(['agreement.project', 'agreement.consumer', 'agreement.developer'])
                    ->latest()
                    ->get();

                $stats = [
                    'pending'  => Payment::where('status', 'pending')->count(),
                    'progress' => Payment::where('status', 'unpaid')->count(),
                    'approved' => Payment::where('status', 'confirmed')->count(),
                    'total'    => Payment::count(),
                ];
                break;

            /* =====================================================
            * 3) KELUHAN PENGGUNA
            * (sesuaikan model & status)
            * ===================================================== */
            case 'complaints':
                $complaints = Complaint::with('user')->latest()->get();

                $stats = [
                    'pending'  => Complaint::where('status', 'pending')->count(),
                    'progress' => Complaint::where('status', 'review')->count(),
                    'approved' => Complaint::where('status', 'resolved')->count(),
                    'total'    => Complaint::count(),
                ];
                break;

            default:
                abort(404);
        }

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
                $query = Payment::with(['agreement.project', 'agreement.consumer'])->latest();
                if ($request->filled('status')) {
                    $query->where('status', $request->string('status'));
                }
                if ($request->filled('date_from') || $request->filled('date_to')) {
                    $from = $request->date('date_from', now()->subYears(10));
                    $to   = $request->date('date_to', now());
                    $query->whereBetween('created_at', [$from, $to]);
                }
                if ($request->filled('amount_min')) {
                    $query->where('amount', '>=', (float)$request->input('amount_min'));
                }
                if ($request->filled('amount_max')) {
                    $query->where('amount', '<=', (float)$request->input('amount_max'));
                }
                $items = $query->get();
                $headers = ['Project', 'Client', 'Amount', 'Status', 'Date'];
                $rows = $items->map(function ($pay) {
                    return [
                        optional(optional($pay->agreement)->project)->title,
                        optional(optional($pay->agreement)->consumer)->name,
                        $pay->amount,
                        $pay->status,
                        optional($pay->created_at)?->toDateTimeString(),
                    ];
                });
                $filename = 'payments_export_'.now()->format('Ymd_His').'.csv';
                break;

            case 'complaints':
                if (!class_exists(\App\Models\Complaint::class)) {
                    $headers = ['Message'];
                    $rows = collect([['Complaints module not available']]);
                    $filename = 'complaints_export_'.now()->format('Ymd_His').'.csv';
                    break;
                }
                $query = Complaint::with('user')->latest();
                if ($request->filled('status')) {
                    $query->where('status', $request->string('status'));
                }
                if ($request->filled('priority')) {
                    $query->where('priority', $request->string('priority'));
                }
                if ($request->filled('date_from') || $request->filled('date_to')) {
                    $from = $request->date('date_from', now()->subYears(10));
                    $to   = $request->date('date_to', now());
                    $query->whereBetween('created_at', [$from, $to]);
                }
                $items = $query->get();
                $headers = ['User', 'Complainant', 'Category', 'Priority', 'Status', 'Date'];
                $rows = $items->map(function ($c) {
                    return [
                        optional($c->user)->name,
                        $c->complainant ?? '',
                        $c->category ?? '',
                        $c->priority ?? '',
                        $c->status ?? '',
                        optional($c->created_at)?->toDateTimeString(),
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