<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * 🔍 Menampilkan semua project milik customer
     */
    public function index()
    {
        $projects = Project::where('consumer_id', Auth::id())->latest()->get();
        return response()->json(['status' => true, 'data' => $projects]);
    }

    /**
     * ➕ Form buat project baru
     */
    public function create()
    {
        return view('projects.create');
    }

    public function createSkills()
    {
        // Ambil semua skills untuk ditampilkan di form
        $skills = Skill::where('is_active', 1)->orderBy('name')->get();
        return view('projects.create-skills', compact('skills'));
    }

    public function createBudget()
    {
        // Validasi apakah sudah mengisi details dan skills
        if (!session()->has('project.details') || !session()->has('project.skills')) {
            return redirect()->route('consumer.project.create')
                ->with('error', 'Please complete previous steps first.');
        }
        return view('projects.create-budget');
    }

    public function createRequirements()
    {
        // Validasi apakah sudah mengisi semua step sebelumnya
        if (
            !session()->has('project.details') ||
            !session()->has('project.skills') ||
            !session()->has('project.budget')
        ) {
            return redirect()->route('consumer.project.create')
                ->with('error', 'Please complete previous steps first.');
        }
        return view('projects.create-requirements');
    }

    // ➕ Menyimpan data sementara sebelum submit

    /**
     * 📝 Menyimpan detail project ke session
     */
    public function storeDetails(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // Simpan ke session
        session()->put('project.details', $validated);

        return response()->json([
            'status' => true,
            'message' => 'Project details saved to session',
            'data' => $validated,
        ]);
    }

    /**
     * 🛠️ Menyimpan skills yang dipilih ke session
     */
    public function storeSkills(Request $request)
    {
        $validated = $request->validate([
            'skills' => 'required|array|min:1',
            'skills.*.skill_id' => 'required|integer',
            'skills.*.skill_name' => 'required|string',
            'skills.*.required_level' => 'required|integer|min:1|max:4',
        ]);

        $processedSkills = [];

        foreach ($validated['skills'] as $skillData) {
            // Cek apakah skill sudah ada di database
            $skill = Skill::find($skillData['skill_id']);

            // Jika skill_id = 0, berarti skill baru yang perlu ditambahkan
            if (!$skill || $skillData['skill_id'] == 0) {
                // Cek apakah skill dengan nama yang sama sudah ada
                $existingSkill = Skill::where('name', $skillData['skill_name'])->first();

                if ($existingSkill) {
                    $skill = $existingSkill;
                } else {
                    // Buat skill baru
                    $skill = Skill::create([
                        'name' => $skillData['skill_name'],
                        'slug' => Str::slug($skillData['skill_name']),
                        'is_active' => true,
                    ]);
                }
            }

            $processedSkills[] = [
                'skill_id' => $skill->id,
                'skill_name' => $skill->name,
                'required_level' => $skillData['required_level'],
            ];
        }

        // Simpan ke session
        session()->put('project.skills', $processedSkills);

        return response()->json([
            'status' => true,
            'message' => 'Skills saved to session',
            'data' => $processedSkills,
        ]);
    }

    /**
     * 💰 Menyimpan budget dan deadline ke session
     */
    public function storeBudget(Request $request)
    {
        $validated = $request->validate([
            'budget' => 'required|numeric|min:0',
            'deadline' => 'required|date|after:today',
        ]);

        // Simpan ke session
        session()->put('project.budget', $validated);

        return response()->json([
            'status' => true,
            'message' => 'Budget and deadline saved to session',
            'data' => $validated,
        ]);
    }

    /**
     * 📋 Menyimpan requirements ke session (JSON format)
     */
    public function storeRequirements(Request $request)
    {
        $validated = $request->validate([
            'requirements' => 'nullable|array',
            'requirements.*.type' => 'required|string|in:feature,technical,deliverable,other',
            'requirements.*.description' => 'required|string|max:500',
            'requirements.*.priority' => 'required|string|in:must_have,should_have,nice_to_have',
        ]);

        // Simpan ke session
        session()->put('project.requirements', $validated['requirements'] ?? []);

        return response()->json([
            'status' => true,
            'message' => 'Requirements saved to session',
            'data' => $validated['requirements'] ?? [],
        ]);
    }

    /**
     * ➕ Memasukkan project baru ke database (dari session)
     */
    public function store(Request $request)
    {
        // Ambil semua data dari session
        $details = session()->get('project.details');
        $skills = session()->get('project.skills'); // FIXED: hapus spasi
        $budget = session()->get('project.budget');
        $requirements = session()->get('project.requirements', []);

        // Validasi apakah semua data tersedia
        if (!$details || !$skills || !$budget) {
            return response()->json([
                'status' => false,
                'message' => 'Incomplete project data. Please complete all steps.',
            ], 422);
        }

        // Gabungkan data untuk create project
        $projectData = array_merge($details, $budget);
        $projectData['consumer_id'] = Auth::id();
        $projectData['status'] = 'open';
        $projectData['views_count'] = 0;
        $projectData['is_featured'] = false;

        // Simpan requirements sebagai JSON
        $projectData['requirements'] = !empty($requirements) ? json_encode($requirements) : null;

        // Buat project
        $project = Project::create($projectData);

        // Simpan skills ke pivot table project_skills
        foreach ($skills as $skill) {
            $project->skills()->attach($skill['skill_id'], [
                'required_level' => $skill['required_level'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Hapus data dari session setelah berhasil disimpan
        session()->forget(['project.details', 'project.skills', 'project.budget', 'project.requirements']);

        return response()->json([
            'status' => true,
            'message' => 'Project created successfully!',
            'data' => $project->load('skills'),
        ]);
    }

    /**
     * 👁️ Menampilkan detail project
     */
    public function show($id)
    {
        $project = Project::where('consumer_id', Auth::id())->with('skills')->findOrFail($id);

        return response()->json(['status' => true, 'data' => $project]);
    }

    /**
     * ✏️ Update project
     */
    public function update(Request $request, $id)
    {
        $project = Project::where('consumer_id', Auth::id())->findOrFail($id);

        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'budget' => 'sometimes|required|numeric|min:0',
            'deadline' => 'sometimes|required|date',
            'requirements' => 'sometimes|nullable|array',
            'skills' => 'sometimes|array',
            'skills.*.skill_id' => 'required|integer|exists:skills,id',
            'skills.*.required_level' => 'required|integer|min:1|max:4',
        ]);

        $data = $request->only(['title', 'description', 'budget', 'deadline']);

        // Update requirements jika ada
        if ($request->has('requirements')) {
            $data['requirements'] = json_encode($request->requirements);
        }

        $project->update($data);

        // Update skills jika ada
        if ($request->has('skills')) {
            $project->skills()->detach();

            foreach ($request->skills as $skill) {
                $project->skills()->attach($skill['skill_id'], [
                    'required_level' => $skill['required_level'],
                    'updated_at' => now(),
                ]);
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Project updated',
            'data' => $project->load('skills'),
        ]);
    }

    /**
     * 🗑️ Hapus project
     */
    public function destroy($id)
    {
        $project = Project::where('consumer_id', Auth::id())->findOrFail($id);

        // Hapus relasi skills
        $project->skills()->detach();

        // Hapus project
        $project->delete();

        return response()->json(['status' => true, 'message' => 'Project deleted']);
    }

    /**
     * 🔄 Reset session project (jika user ingin mulai dari awal)
     */
    public function resetSession()
    {
        session()->forget(['project.details', 'project.skills', 'project.budget', 'project.requirements']);

        return response()->json([
            'status' => true,
            'message' => 'Project session cleared',
        ]);
    }
}
