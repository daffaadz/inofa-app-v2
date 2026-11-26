<?php

namespace App\Http\Controllers\Developer;

use App\Http\Controllers\Controller;
use App\Models\Portofolio;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{
    /**
     * Store a new portfolio item.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'image_url' => ['nullable', 'url', 'max:255'],
            'image_file' => ['nullable', 'image', 'max:5120'], // 5MB max
            'project_url' => ['nullable', 'url', 'max:255'],
            'technologies' => ['nullable', 'string'],
            'completed_at' => ['nullable', 'date'],
            'is_featured' => ['nullable', 'boolean'],
        ]);

        $user = $request->user();

        // Handle image upload if provided
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('portfolios', 'public');
            $validated['image_url'] = $path;
        }

        // Convert technologies string to JSON array
        if (isset($validated['technologies'])) {
            // Model meng-cast ke array, jadi jangan di-encode dua kali
            $validated['technologies'] = array_map('trim', explode(',', $validated['technologies']));
        }

        // Set sort order
        $maxOrder = $user->portfolios()->max('sort_order') ?? 0;
        $validated['sort_order'] = $maxOrder + 1;

        // Create portfolio
        $user->portfolios()->create($validated);

        return back()->with('status', 'portfolio-added');
    }

    /**
     * Update an existing portfolio item.
     */
    public function update(Request $request, Portofolio $portfolio): RedirectResponse
    {
        // Ensure user owns this portfolio
        if ($portfolio->user_id !== $request->user()->id) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'image_url' => ['nullable', 'url', 'max:255'],
            'image_file' => ['nullable', 'image', 'max:5120'],
            'project_url' => ['nullable', 'url', 'max:255'],
            'technologies' => ['nullable', 'string'],
            'completed_at' => ['nullable', 'date'],
            'is_featured' => ['nullable', 'boolean'],
        ]);

        // Handle image upload if provided
        if ($request->hasFile('image_file')) {
            // Delete old image if exists
            if ($portfolio->image_url && !filter_var($portfolio->image_url, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($portfolio->image_url);
            }

            $path = $request->file('image_file')->store('portfolios', 'public');
            $validated['image_url'] = $path;
        }

        // Convert technologies string to JSON array
        if (isset($validated['technologies'])) {
            // Model meng-cast ke array, jadi jangan di-encode dua kali
            $validated['technologies'] = array_map('trim', explode(',', $validated['technologies']));
        }

        $portfolio->update($validated);

        return back()->with('status', 'portfolio-updated');
    }

    /**
     * Delete a portfolio item.
     */
    public function destroy(Request $request, Portofolio $portfolio): RedirectResponse
    {
        // Ensure user owns this portfolio
        if ($portfolio->user_id !== $request->user()->id) {
            abort(403);
        }

        // Delete image if exists
        if ($portfolio->image_url && !filter_var($portfolio->image_url, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($portfolio->image_url);
        }

        $portfolio->delete();

        return back()->with('status', 'portfolio-deleted');
    }

    /**
     * Toggle featured status of a portfolio item.
     */
    public function toggleFeatured(Request $request, Portofolio $portfolio): RedirectResponse
    {
        // Ensure user owns this portfolio
        if ($portfolio->user_id !== $request->user()->id) {
            abort(403);
        }

        $portfolio->update([
            'is_featured' => !$portfolio->is_featured,
        ]);

        return back()->with('status', 'portfolio-featured-toggled');
    }
}
