<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * 🔍 Menampilkan semua project milik customer
     */
    public function index()
    {
        $projects = Project::where('customer_id', Auth::id())->latest()->get();
        return response()->json(['status' => true, 'data' => $projects]);
    }

    /**
     * ➕ Membuat project baru
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'budget' => 'required|numeric|min:0',
            'deadline' => 'nullable|date',
        ]);

        $data['customer_id'] = Auth::id();

        $project = Project::create($data);

        return response()->json(['status' => true, 'message' => 'Project created successfully', 'data' => $project]);
    }

    /**
     * 👁️ Menampilkan detail project
     */
    public function show($id)
    {
        $project = Project::where('customer_id', Auth::id())->findOrFail($id);
        return response()->json(['status' => true, 'data' => $project]);
    }

    /**
     * ✏️ Update project
     */
    public function update(Request $request, $id)
    {
        $project = Project::where('customer_id', Auth::id())->findOrFail($id);

        $data = $request->only(['title', 'description', 'budget', 'deadline']);
        $project->update($data);

        return response()->json(['status' => true, 'message' => 'Project updated', 'data' => $project]);
    }

    /**
     * 🗑️ Hapus project
     */
    public function destroy($id)
    {
        $project = Project::where('customer_id', Auth::id())->findOrFail($id);
        $project->delete();

        return response()->json(['status' => true, 'message' => 'Project deleted']);
    }
}
