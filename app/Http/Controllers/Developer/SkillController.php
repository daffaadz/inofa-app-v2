<?php

namespace App\Http\Controllers\Developer;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SkillController extends Controller
{
    /**
     * Search skills for autocomplete.
     */
    public function search(Request $request)
    {
        $query = $request->get('q', '');

        if (strlen($query) < 1) {
            return response()->json([]);
        }

        $skills = Skill::where('is_active', true)
            ->where('name', 'LIKE', "%{$query}%")
            ->orderBy('name')
            ->limit(10)
            ->get(['id', 'name']);

        return response()->json($skills);
    }

    /**
     * Capitalize each word in a string.
     */
    private function capitalizeWords(string $text): string
    {
        return mb_convert_case($text, MB_CASE_TITLE, 'UTF-8');
    }

    /**
     * Add a skill to the authenticated user.
     */
    public function store(Request $request)
    {
        $request->validate([
            'skill_name' => ['required', 'string', 'max:255'],
            'proficiency_level' => ['nullable', 'integer', 'min:1', 'max:4'],
        ]);

        $user = $request->user();

        // Capitalize skill name
        $skillName = $this->capitalizeWords(trim($request->skill_name));

        // Find or create the skill
        $skill = Skill::firstOrCreate(
            ['name' => $skillName],
            [
                'slug' => Str::slug($skillName),
                'is_active' => true,
            ]
        );

        // Check if already attached
        if ($user->skills()->where('skill_id', $skill->id)->exists()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Skill already added to your profile'
                ], 422);
            }
            return back()->withErrors(['skill_name' => 'Skill already added to your profile']);
        }

        // Attach skill to user
        $user->skills()->attach($skill->id, [
            'proficiency_level' => $request->proficiency_level ?? 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Skill added successfully',
                'skill' => $skill
            ], 200);
        }

        return back()->with('status', 'skill-added');
    }

    /**
     * Remove a skill from the authenticated user.
     */
    public function destroy(Request $request, Skill $skill)
    {
        $request->user()->skills()->detach($skill->id);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Skill removed successfully'
            ], 200);
        }

        return back()->with('status', 'skill-removed');
    }

    /**
     * Update skill proficiency level.
     */
    public function updateProficiency(Request $request, Skill $skill): RedirectResponse
    {
        $request->validate([
            'proficiency_level' => ['required', 'integer', 'min:1', 'max:4'],
        ]);

        $request->user()->skills()->updateExistingPivot($skill->id, [
            'proficiency_level' => $request->proficiency_level,
            'updated_at' => now(),
        ]);

        return back()->with('status', 'proficiency-updated');
    }
}
