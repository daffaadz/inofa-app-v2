<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $skills = Skill::where('is_active', 1)->get();
        return view('projects.create-skills', compact('skills'));
    }

    public function createBudget()
    {
        return view('projects.create-budget');
    }

    public function createAttachment()
    {
        return view('projects.create-attachment');
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
            'requirements' => 'nullable|string',
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
            'skills.*.skill_id' => 'required|exists:skills,id',
            'skills.*.required_level' => 'required|integer|min:1|max:4', // 1=Beginner, 2=Intermediate, 3=Advanced, 4=Expert
        ]);

        // Simpan ke session
        session()->put('project.skills', $validated['skills']);

        return response()->json([
            'status' => true,
            'message' => 'Skills saved to session',
            'data' => $validated['skills'],
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
     * 📎 Menyimpan attachment ke session (opsional)
     */
    public function storeAttachment(Request $request)
    {
        $validated = $request->validate([
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120', // max 5MB
        ]);

        $attachmentPaths = [];

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                // Simpan file sementara
                $path = $file->store('temp/attachments', 'public');
                $attachmentPaths[] = [
                    'original_name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                ];
            }
        }

        // Simpan ke session
        session()->put('project.attachments', $attachmentPaths);

        return response()->json([
            'status' => true,
            'message' => 'Attachments saved to session',
            'data' => $attachmentPaths,
        ]);
    }

    /**
     * ➕ Memasukkan project baru ke database (dari session)
     */
    public function store(Request $request)
    {
        // Ambil semua data dari session
        $details = session()->get('project.details');
        $skills = session()->get('project.skills ');
        $budget = session()->get('project.budget');
        $attachments = session()->get('project.attachments', []);

        // Validasi apakah semua data tersedia
        if (!$details || !$skills || !$budget) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Incomplete project data. Please complete all steps.',
                ],
                422,
            );
        }

        // Gabungkan data untuk create project
        $projectData = array_merge($details, $budget);
        $projectData['consumer_id'] = Auth::id();
        $projectData['status'] = 'open'; // atau status default lainnya
        $projectData['views_count'] = 0;
        $projectData['is_featured'] = false;

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

        // Pindahkan attachments dari temp ke permanent (jika ada)
        if (!empty($attachments)) {
            foreach ($attachments as $attachment) {
                // Logic untuk memindahkan file dari temp ke folder permanent
                // Dan simpan ke database jika ada tabel attachments
                // Contoh:
                // Storage::move($attachment['path'], 'projects/'.$project->id.'/'.$attachment['original_name']);
            }
        }

        // Hapus data dari session setelah berhasil disimpan
        session()->forget(['project.details', 'project.skills', 'project.budget', 'project.attachments']);

        return response()->json([
            'status' => true,
            'message' => 'Project created successfully',
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

        $data = $request->only(['title', 'description', 'budget', 'deadline', 'requirements']);
        $project->update($data);

        // Update skills jika ada
        if ($request->has('skills')) {
            $project->skills()->detach(); // Hapus relasi lama

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
        session()->forget(['project.details', 'project.skills', 'project.budget', 'project.attachments']);

        return response()->json([
            'status' => true,
            'message' => 'Project session cleared',
        ]);
    }
}
