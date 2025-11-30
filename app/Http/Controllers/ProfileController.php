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

        if ($request->has('rate_min')) {
            $developerProfile->rate_min_byproject = $request->rate_min;
        }

        if ($request->has('rate_max')) {
            $developerProfile->rate_max_byproject = $request->rate_max;
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
    public function updateAvatar(Request $request): RedirectResponse|\Illuminate\Http\JsonResponse
    {
        try {
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

            // Return JSON for AJAX requests
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Avatar updated successfully!',
                    'avatar_url' => asset('storage/' . $path),
                ]);
            }

            return back()->with('status', 'avatar-updated');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->validator->errors()->first(),
                ], 422);
            }
            throw $e;
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update avatar. Please try again.',
                ], 500);
            }
            return back()->withErrors(['avatar' => 'Failed to update avatar. Please try again.']);
        }
    }

    /**
     * Update developer availability status.
     */
    public function updateAvailability(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $user = $request->user();

            // Check if user is a developer
            if ($user->role !== 'developer') {
                return response()->json([
                    'success' => false,
                    'message' => 'Only developers can update availability status.',
                ], 403);
            }

            $request->validate([
                'availability' => ['required', 'in:available,busy,unavailable'],
            ]);

            // Update or create developer profile
            $developerProfile = $user->developerProfile ?? $user->developerProfile()->create([]);
            $developerProfile->availability = $request->availability;
            $developerProfile->save();

            return response()->json([
                'success' => true,
                'message' => 'Availability updated successfully!',
                'availability' => $request->availability,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->validator->errors()->first(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update availability. Please try again.',
            ], 500);
        }
    }

    /**
     * Store a new education record.
     */
    public function storeEducation(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $user = $request->user();

            // Check if user is a developer
            if ($user->role !== 'developer') {
                return response()->json([
                    'success' => false,
                    'message' => 'Only developers can add education.',
                ], 403);
            }

            $validated = $request->validate([
                'degree' => ['required', 'string', 'max:255'],
                'institution' => ['required', 'string', 'max:255'],
                'start_year' => ['required', 'integer', 'min:1950', 'max:2100'],
                'end_year' => ['required', 'integer', 'min:1950', 'max:2100', 'gte:start_year'],
            ]);

            // Get or create developer profile
            $developerProfile = $user->developerProfile ?? $user->developerProfile()->create([]);
            
            // Get current education array
            $education = $developerProfile->education ?? [];
            
            // Add new education
            $newEducation = [
                'degree' => $validated['degree'],
                'institution' => $validated['institution'],
                'start_year' => $validated['start_year'],
                'end_year' => $validated['end_year'],
            ];
            
            $education[] = $newEducation;
            
            // Save updated education array
            $developerProfile->education = $education;
            $developerProfile->save();

            // Return with index
            $newEducation['index'] = count($education) - 1;

            return response()->json([
                'success' => true,
                'message' => 'Education added successfully!',
                'education' => $newEducation,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->validator->errors()->first(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add education. Please try again.',
            ], 500);
        }
    }

    /**
     * Delete an education record.
     */
    public function destroyEducation(Request $request, int $index): \Illuminate\Http\JsonResponse
    {
        try {
            $user = $request->user();

            // Check if user is a developer
            if ($user->role !== 'developer') {
                return response()->json([
                    'success' => false,
                    'message' => 'Only developers can delete education.',
                ], 403);
            }

            $developerProfile = $user->developerProfile;

            if (!$developerProfile) {
                return response()->json([
                    'success' => false,
                    'message' => 'Developer profile not found.',
                ], 404);
            }

            // Get current education array
            $education = $developerProfile->education ?? [];

            // Check if index exists
            if (!isset($education[$index])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Education record not found.',
                ], 404);
            }

            // Remove the education at the specified index
            array_splice($education, $index, 1);

            // Save updated education array
            $developerProfile->education = $education;
            $developerProfile->save();

            return response()->json([
                'success' => true,
                'message' => 'Education removed successfully!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove education. Please try again.',
            ], 500);
        }
    }
}
