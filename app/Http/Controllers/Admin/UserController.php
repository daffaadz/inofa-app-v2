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

        $query = User::query();

        if ($search) {
            $query->where(fn($q) =>
                $q->where('name','like',"%$search%")
                  ->orWhere('email','like',"%$search%")
            );
        }

        if ($selectedRole) {
            $query->where('role', $selectedRole);
        }

        $users = $query->orderByDesc('created_at')->paginate(15)->withQueryString();

        return view('admin.users.index', [
            'users' => $users,
            'search' => $search,
            'selectedRole' => $selectedRole,
            'totalUsers' => User::count(),
            'activeUsers' => User::where('status', 'active')->count(),
            'developers' => User::where('role', 'developer')->count(),
            'clients' => User::where('role', 'consumer')->count(),
        ]);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    public function suspend($id)
    {
        User::findOrFail($id)->update(['status' => 'suspended']);
        return back()->with('success', 'User suspended.');
    }

    public function activate($id)
    {
        User::findOrFail($id)->update(['status' => 'active']);
        return back()->with('success', 'User activated.');
    }
}
