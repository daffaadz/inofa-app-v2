<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RegistrationFlowController extends Controller
{
    public function showRoleSelection()
    {
        return view('auth.select-role');
    }

    public function storeRole(Request $request)
    {
        $request->validate([
            'role' => 'required|in:consumer,developer',
        ]);

        $user = auth()->user();
        $user->update(['role' => $request->role]);

        return redirect()->route('personal-information');
    }

    public function showPersonalInformation()
    {
        return view('auth.personal-information');
    }

    public function storePersonalInformation(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'location' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|max:2048',
        ]);

        $user = auth()->user();
        $user->update([
            'name' => $request->name,
            'bio' => $request->bio,
            'location' => $request->location,
        ]);

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->update(['avatar' => $path]);
        }

        if ($user->role === 'developer') {
            return redirect()->route('developer.information');
        }

        return redirect()->route('redirect-after-login');
    }

    public function showDeveloperInformation()
    {
        $skills = Skill::where('is_active', true)->orderBy('name')->get();
        return view('auth.developer-information', compact('skills'));
    }

    public function storeDeveloperInformation(Request $request)
    {
        $request->validate([
            'headline' => 'nullable|string|max:255',
            'experience' => 'nullable|string',
            'rate_min_byproject' => 'nullable|numeric|min:0',
            'rate_max_byproject' => 'nullable|numeric|min:0|gte:rate_min_byproject',
            'availability' => 'nullable|in:available,busy,unavailable',
            'experience_years' => 'nullable|integer|min:0',
            'education' => 'nullable|string|max:255',
            'certifications' => 'nullable|string',
            'portfolio_links' => 'nullable|string',
            'skills' => 'nullable|array',
            'skills.*' => 'exists:skills,id',
            'custom_skills' => 'nullable|array',
            'custom_skills.*' => 'string|max:100',
        ]);

        $user = auth()->user();

        // Create or update developer profile
        $profile = $user->developerProfile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'headline' => $request->headline,
                'experience' => $request->experience,
                'rate_min_byproject' => $request->rate_min_byproject,
                'rate_max_byproject' => $request->rate_max_byproject,
                'availability' => $request->availability ?? 'available',
                'experience_years' => $request->experience_years ?? 0,
                'education' => $request->education,
                'certifications' => $request->certifications,
                'portfolio_links' => $request->portfolio_links,
            ]
        );

        // Sync existing skills (replace old with new)
        if ($request->has('skills') && is_array($request->skills)) {
            $skillIds = $request->skills;
        } else {
            $skillIds = [];
        }

        // Create and attach custom skills
        if ($request->has('custom_skills') && is_array($request->custom_skills)) {
            foreach ($request->custom_skills as $customSkillName) {
                $skillName = trim($customSkillName);

                if (empty($skillName)) {
                    continue;
                }

                // Check if skill already exists (case-insensitive)
                $existingSkill = Skill::whereRaw('LOWER(name) = ?', [strtolower($skillName)])->first();

                if ($existingSkill) {
                    // If skill exists, add it to the array
                    if (!in_array($existingSkill->id, $skillIds)) {
                        $skillIds[] = $existingSkill->id;
                    }
                } else {
                    // Create new skill
                    $newSkill = Skill::create([
                        'name' => $skillName,
                        'slug' => Str::slug($skillName),
                        'category' => 'Other', // Default category
                        'is_active' => true,
                    ]);

                    // Add to skills array
                    $skillIds[] = $newSkill->id;
                }
            }
        }

        // Sync all skills at once (this will replace old skills with new ones)
        $user->skills()->sync($skillIds);

        return redirect()->route('redirect-after-login');
    }
}
