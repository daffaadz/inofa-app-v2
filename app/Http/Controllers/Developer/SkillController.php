<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SkillController extends Controller
{
    /**
     * Add a skill to the authenticated user.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'skill_name' => ['required', 'string', 'max:255'],
            'proficiency_level' => ['nullable', 'integer', 'min:1', 'max:4'],
        ]);

        $user = $request->user();

        // Find or create the skill
        $skill = Skill::firstOrCreate(
            ['name' => $request->skill_name],
            [
                'slug' => Str::slug($request->skill_name),
                'is_active' => true,
            ]
        );

        // Attach skill to user if not already attached
        if (!$user->skills()->where('skill_id', $skill->id)->exists()) {
            $user->skills()->attach($skill->id, [
                'proficiency_level' => $request->proficiency_level ?? 2,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return back()->with('status', 'skill-added');
    }

    /**
     * Remove a skill from the authenticated user.
     */
    public function destroy(Request $request, Skill $skill): RedirectResponse
    {
        $request->user()->skills()->detach($skill->id);

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
