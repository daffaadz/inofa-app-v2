<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $selectedRole = $request->role;
        $status = $request->status;

        $query = User::query();

        // Filter out admin users
        $query->where('role', '!=', 'admin');

        // Search filter
        if ($search) {
            $query->where(fn($q) =>
                $q->where('name','like',"%$search%")
                  ->orWhere('email','like',"%$search%")
            );
        }

        // Role filter
        if ($selectedRole) {
            $query->where('role', $selectedRole);
        }

        // Status filter
        if ($status) {
            $query->where('status', $status);
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Sort filter
        $sort = $request->get('sort', 'newest');
        if ($sort === 'oldest') {
            $query->oldest();
        } else {
            $query->orderByDesc('created_at');
        }

        $users = $query->paginate(15)->withQueryString();

        return view('admin.users.index', [
            'users' => $users,
            'search' => $search,
            'selectedRole' => $selectedRole,
            'selectedStatus' => $status,
            'totalUsers' => User::where('role', '!=', 'admin')->count(),
            'activeUsers' => User::where('role', '!=', 'admin')->where('status', 'active')->count(),
            'developers' => User::where('role', 'developer')->count(),
            'clients' => User::where('role', 'consumer')->count(),
        ]);
    }

    public function show($id)
    {
        $user = User::with([
            'developerProfile',
            'skills',
            'portfolios',
            'postedProjects',
            'agreementsAsConsumer',
            'agreementsAsDeveloper.payments',
            'reviewsReceived',
            'reviewsGiven'
        ])->findOrFail($id);
        
        return response()->json([
            'user' => $user,
            'stats' => [
                'total_projects' => $user->postedProjects->count() + $user->agreementsAsDeveloper->count(),
                'completed_projects' => $user->agreementsAsDeveloper->where('status', 'completed')->count(),
                'total_spent' => $user->agreementsAsConsumer->sum(fn($agreement) => $agreement->payments->sum('amount')),
                'total_earned' => $user->agreementsAsDeveloper->sum(fn($agreement) => $agreement->payments->where('status', 'transferred')->sum('amount')),
                'average_rating' => $user->reviewsReceived->avg('rating'),
                'total_reviews' => $user->reviewsReceived->count(),
            ]
        ]);
    }

    public function suspend($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->role === 'admin') {
            return back()->with('error', 'Cannot suspend admin user.');
        }
        
        $user->update(['status' => 'suspended']);
        return back()->with('success', 'User has been suspended successfully.');
    }

    public function activate($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'active']);
        return back()->with('success', 'User has been activated successfully.');
    }
}
