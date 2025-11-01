<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $skills = Skill::all();
        return view('auth.developer-information', compact('skills'));
    }

    public function storeDeveloperInformation(Request $request)
    {
        $request->validate([
            'headline' => 'nullable|string|max:255',
            'experience' => 'nullable|string',
            'rate_min_byproject' => 'nullable|numeric|min:0',
            'rate_max_byproject' => 'nullable|numeric|min:0',
            'availability' => 'nullable|in:available,busy,unavailable',
            'experience_years' => 'nullable|integer|min:0',
            'education' => 'nullable|string|max:255',
            'certifications' => 'nullable|string',
            'portfolio_links' => 'nullable|string',
            'skills' => 'nullable|array',
            'skills.*' => 'exists:skills,id',
        ]);

        $user = auth()->user();

        $profile = $user->developerProfile()->create([
            'headline' => $request->headline,
            'experience' => $request->experience,
            'rate_min_byproject' => $request->rate_min_byproject,
            'rate_max_byproject' => $request->rate_max_byproject,
            'availability' => $request->availability ?? 'available',
            'experience_years' => $request->experience_years ?? 0,
            'education' => $request->education,
            'certifications' => $request->certifications,
            'portfolio_links' => $request->portfolio_links,
        ]);

        if ($request->has('skills')) {
            $user->skills()->attach($request->skills);
        }

        return redirect()->route('redirect-after-login');
    }
}