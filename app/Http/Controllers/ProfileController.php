<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        // Load relationships for developer
        if ($user->role === 'developer') {
            $user->load(['developerProfile', 'skills', 'portfolios']);
        }

        return view('profile.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Update basic user info
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Update additional fields
        if ($request->has('location')) {
            $user->location = $request->location;
        }

        if ($request->has('bio')) {
            $user->bio = $request->bio;
        }

        $user->save();

        // Update developer profile if user is a developer
        if ($user->role === 'developer') {
            $this->updateDeveloperProfile($user, $request);
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Update developer profile information.
     */
    protected function updateDeveloperProfile($user, Request $request): void
    {
        $developerProfile = $user->developerProfile ?? $user->developerProfile()->create([]);

        if ($request->has('job_title')) {
            $developerProfile->headline = $request->job_title;
        }

        if ($request->has('hourly_rate')) {
            $developerProfile->rate_min_byproject = $request->hourly_rate;
        }

        if ($request->has('experience_years')) {
            $developerProfile->experience_years = $request->experience_years;
        }

        if ($request->has('experience')) {
            $developerProfile->experience = $request->experience;
        }

        $developerProfile->save();
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Update user avatar.
     */
    public function updateAvatar(Request $request): RedirectResponse
    {
        $request->validate([
            'avatar' => ['required', 'image', 'max:2048'], // 2MB max
        ]);

        $user = $request->user();

        // Delete old avatar if exists
        if ($user->avatar && !filter_var($user->avatar, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Store new avatar
        $path = $request->file('avatar')->store('avatars', 'public');

        $user->update([
            'avatar' => $path,
        ]);

        return back()->with('status', 'avatar-updated');
    }
}
