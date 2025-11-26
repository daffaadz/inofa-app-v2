<div class="space-y-6">
    <!-- Skills & Technologies -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center gap-2 mb-4">
            <div class="w-10 h-10 bg-primary-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                </svg>
            </div>
            <h3 class="text-h-6 text-neutral-1000">Skills & Technologies</h3>
        </div>

        @if (session('status') === 'skill-added')
            <div class="mb-4 p-3 bg-green-100 border border-green-200 text-green-700 rounded-lg text-b-2">
                Skill added successfully!
            </div>
        @endif

        @if (session('status') === 'skill-removed')
            <div class="mb-4 p-3 bg-red-100 border border-red-200 text-red-700 rounded-lg text-b-2">
                Skill removed successfully!
            </div>
        @endif

        <!-- Add Skill Form -->
        <form method="POST" action="{{ route('skills.store') }}" class="mb-4">
            @csrf
            <div class="flex gap-2">
                <input type="text" id="skill_name" name="skill_name" placeholder="Add a new skill..."
                    class="flex-1 px-4 py-2.5 text-b-1 border border-neutral-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                    required>
                <select name="proficiency_level"
                    class="px-4 py-2.5 text-b-1 border border-neutral-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                    <option value="1">Beginner</option>
                    <option value="2" selected>Intermediate</option>
                    <option value="3">Advanced</option>
                    <option value="4">Expert</option>
                </select>
                <button type="submit"
                    class="px-6 py-2.5 bg-primary-500 text-white text-b-1 font-medium rounded-lg hover:bg-primary-600 transition flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Add
                </button>
            </div>
            @error('skill_name')
                <p class="mt-1 text-b-3 text-red-500">{{ $message }}</p>
            @enderror
        </form>

        <!-- Skills Tags -->
        <div class="flex flex-wrap gap-2">
            @forelse($user->skills ?? [] as $skill)
                <div
                    class="px-4 py-2 bg-primary-100 text-primary-700 text-b-2 font-medium rounded-full flex items-center gap-2">
                    {{ $skill->name }}
                    <span class="text-b-4 opacity-75">
                        @switch($skill->pivot->proficiency_level)
                            @case(1)
                                (Beginner)
                            @break

                            @case(2)
                                (Intermediate)
                            @break

                            @case(3)
                                (Advanced)
                            @break

                            @case(4)
                                (Expert)
                            @break
                        @endswitch
                    </span>
                    <form method="POST" action="{{ route('skills.destroy', $skill) }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="hover:text-primary-900">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </form>
                </div>
                @empty
                    <p class="text-b-2 text-neutral-500">No skills added yet. Add your first skill above!</p>
                @endforelse
            </div>
        </div>

        <!-- Certifications & Awards -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center gap-2 mb-4">
                <div class="w-10 h-10 bg-secondary-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-secondary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                    </svg>
                </div>
                <h3 class="text-h-6 text-neutral-1000">Certifications & Awards</h3>
            </div>

            <!-- Empty State -->
            <div
                class="flex flex-col items-center justify-center py-12 border-2 border-dashed border-neutral-200 rounded-lg">
                <div class="w-16 h-16 bg-neutral-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </div>
                <p class="text-b-1 text-neutral-500 mb-1">Add Certification</p>
                <p class="text-b-3 text-neutral-400">Showcase your professional credentials (Coming soon)</p>
            </div>
        </div>
    </div>
</div>
