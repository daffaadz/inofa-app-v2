<?php

namespace App\Http\Controllers;

use App\Models\Portofolio;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{
    /**
     * Store a newly created portfolio item in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:2000'],
            'image_file' => ['nullable', 'image', 'max:5120'], // 5MB max
            'image_url' => ['nullable', 'url', 'max:500'],
            'project_url' => ['nullable', 'url', 'max:500'],
            'technologies' => ['nullable', 'string'],
        ]);

        $imageUrl = null;

        // Handle image upload
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('portfolios', 'public');
            $imageUrl = Storage::url($path);
        } elseif ($request->filled('image_url')) {
            $imageUrl = $validated['image_url'];
        }

        // Parse technologies from comma-separated string to array
        $technologies = null;
        if ($request->filled('technologies')) {
            $technologies = array_map('trim', explode(',', $validated['technologies']));
        }

        // Create portfolio item
        Portofolio::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'image_url' => $imageUrl,
            'project_url' => $validated['project_url'] ?? null,
            'technologies' => $technologies,
        ]);

        return back()->with('status', 'portfolio-added');
    }

    /**
     * Remove the specified portfolio item from storage.
     */
    public function destroy(Portofolio $portfolio): RedirectResponse
    {
        // Ensure the portfolio belongs to the authenticated user
        if ($portfolio->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Delete image from storage if it's a local file
        if ($portfolio->image_url && !filter_var($portfolio->image_url, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($portfolio->image_url);
        }

        $portfolio->delete();

        return back()->with('status', 'portfolio-deleted');
    }
}
