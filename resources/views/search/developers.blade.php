<x-app-layout>
    <x-slot:title>{{ __('Find Developers - Inofa') }}</x-slot:title>

    {{-- Background putih dengan section abu-abu --}}
    <div class="bg-white min-h-screen">

        {{-- Hero Section dengan background putih --}}
        <div class="bg-white border-b border-neutral-100">
            <div class="container max-w-[86rem] mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <h1 class="text-h-3 text-neutral-900 mb-6 mt-16">Find the Perfect Developer</h1>
                <div class="relative max-w-4xl">
                    <div
                        class="absolute inset-y-0 left-0 top-1/2 -translate-y-1/2 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-neutral-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="search" name="q" id="q" value="{{ $keyword ?? '' }}"
                        form="developer-search-form"
                        class="w-3/4 pl-12 pr-4 py-3 border border-neutral-300 rounded-lg text-b-1 placeholder:text-neutral-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                        placeholder="Search by name or skills...">
                </div>
            </div>
        </div>

        {{-- Main Content dengan background abu-abu --}}
        <div class="bg-neutral-50">
            <div class="container max-w-[86rem] mx-auto px-4 sm:px-6 lg:px-8 py-8">

                {{-- Form utama untuk filter, pencarian, dan sorting --}}
                <form action="{{ route('search.developers') }}" method="GET" id="developer-search-form">

                    <!-- Layout Grid (Filter + Hasil) -->
                    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

                        <!-- Sidebar Filter (Kiri) -->
                        <aside class="lg:col-span-1">
                            <div class="bg-white rounded-lg p-6 border border-neutral-200 sticky top-24">
                                <h2 class="text-h-6 text-neutral-900 mb-6">Filters</h2>

                                {{-- Submit form on change --}}
                                <script>
                                    function submitSearchForm() {
                                        document.getElementById('developer-search-form').submit();
                                    }
                                </script>

                                <!-- Filter: Category -->
                                <div class="mb-6">
                                    <h3 class="text-b-1 font-semibold text-neutral-900 mb-3">Category</h3>
                                    <div class="space-y-1">
                                        <a href="{{ route('search.developers', array_merge(request()->except('category', 'page'), ['category' => 'all'])) }}"
                                            class="block text-b-2 py-2.5 px-4 rounded-lg transition-colors {{ empty($category) || $category === 'all' ? 'bg-primary-500 text-white font-medium' : 'text-neutral-700 bg-[#F5F5F5] hover:bg-neutral-50' }}">
                                            All category
                                        </a>
                                        @foreach ($categories as $cat)
                                            <a href="{{ route('search.developers', array_merge(request()->except('category', 'page'), ['category' => $cat])) }}"
                                                class="block text-b-2 py-2.5 px-4 rounded-lg transition-colors {{ $category === $cat ? 'bg-primary-500 text-white font-medium' : 'text-neutral-700 bg-[#F5F5F5] hover:bg-neutral-50' }}">
                                                {{ $cat }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Filter: Location -->
                                <div class="mb-6">
                                    <h3 class="text-b-1 font-semibold text-neutral-900 mb-3">Location</h3>
                                    <select name="location" id="location" onchange="submitSearchForm()"
                                        class="w-full px-4 py-2.5 border border-neutral-300 rounded-lg text-b-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 bg-white">
                                        <option value="all" @selected(empty($location) || $location === 'all')>All locations</option>
                                        @foreach ($locations as $loc)
                                            <option value="{{ $loc }}" @selected($location === $loc)>
                                                {{ $loc }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Filter: Skills -->
                                <div class="mb-6">
                                    <h3 class="text-b-1 font-semibold text-neutral-900 mb-3">Skills</h3>

                                    <!-- Search Input -->
                                    <div class="mb-3 relative">
                                        <input type="text" id="skillSearch" placeholder="Cari skill..."
                                            class="w-full px-3 py-2 text-sm border border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                            autocomplete="off">
                                        <!-- Suggestion Dropdown -->
                                        <div id="skillSuggestions"
                                            class="absolute z-10 w-full mt-1 bg-white border border-neutral-300 rounded-lg shadow-lg hidden max-h-48 overflow-y-auto">
                                            <!-- Suggestions will be populated here -->
                                        </div>
                                    </div>

                                    <!-- Selected Skills (Chips) -->
                                    <div id="selectedSkillsContainer" class="mb-3 flex flex-wrap gap-2">
                                        @foreach ($skills ?? [] as $selectedSkill)
                                            <div
                                                class="inline-flex items-center bg-primary-100 text-primary-700 px-3 py-1 rounded-full text-sm">
                                                <span>{{ $selectedSkill }}</span>
                                                <button type="button" onclick="removeSkill('{{ $selectedSkill }}')"
                                                    class="ml-2 text-primary-700 hover:text-primary-900">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Hidden Inputs for Selected Skills -->
                                    <div id="hiddenSkillsContainer">
                                        @foreach ($skills ?? [] as $selectedSkill)
                                            <input type="hidden" name="skills[]" value="{{ $selectedSkill }}"
                                                data-skill="{{ $selectedSkill }}">
                                        @endforeach
                                    </div>

                                    <!-- All Skills List (Checkboxes) -->
                                    <div class="space-y-2.5 max-h-64 overflow-y-auto pr-1">
                                        @foreach ($allSkills->take(6) as $skill)
                                            <label
                                                class="flex items-center text-b-2 text-neutral-700 cursor-pointer group skill-item"
                                                data-skill-name="{{ strtolower($skill->name) }}">
                                                <input type="checkbox" value="{{ $skill->name }}"
                                                    onchange="toggleSkill('{{ $skill->name }}')"
                                                    @checked(in_array($skill->name, $skills ?? []))
                                                    class="h-4 w-4 rounded border-neutral-300 text-primary-500 focus:ring-primary-500 cursor-pointer skill-checkbox">
                                                <span
                                                    class="ml-3 group-hover:text-neutral-900">{{ $skill->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Filter: Minimum Rating -->
                                <div class="mb-6">
                                    <h3 class="text-b-1 font-semibold text-neutral-900 mb-3">Minimum Rating</h3>
                                    <div class="space-y-2.5">
                                        @for ($i = 5; $i >= 1; $i--)
                                            <label class="flex items-center cursor-pointer group">
                                                <input type="radio" name="min_rating" value="{{ $i }}"
                                                    onchange="submitSearchForm()" @checked((int) $minRating === $i)
                                                    class="h-4 w-4 border-neutral-300 text-primary-500 focus:ring-primary-500 cursor-pointer">
                                                <div class="ml-3 flex items-center">
                                                    @for ($s = 1; $s <= 5; $s++)
                                                        <svg class="h-4 w-4 @if ($s <= $i) text-secondary-600 @else text-neutral-300 @endif"
                                                            fill="currentColor" viewBox="0 0 20 20">
                                                            <path
                                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.957a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.368 2.448a1 1 0 00-.364 1.118l1.287 3.957c.3.921-.755 1.688-1.54 1.118l-3.368-2.448a1 1 0 00-1.175 0l-3.368 2.448c-.784.57-1.838-.197-1.54-1.118l1.287-3.957a1 1 0 00-.364-1.118L2.064 9.39c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69L9.049 2.927z" />
                                                        </svg>
                                                    @endfor
                                                    <span class="ml-2 text-b-2 text-neutral-600">& up</span>
                                                </div>
                                            </label>
                                        @endfor
                                    </div>
                                </div>

                                <!-- Clear Filters -->
                                <div>
                                    <a href="{{ route('search.developers') }}"
                                        class="block text-center text-b-2 text-primary-600 hover:text-primary-700 font-medium py-2.5 px-4 border border-primary-600 rounded-lg hover:bg-primary-50 transition-colors">
                                        Clear All Filters
                                    </a>
                                </div>
                            </div>
                        </aside>

                        <!-- Hasil Pencarian (Kanan) -->
                        <main class="lg:col-span-3">

                            <!-- Header Hasil -->
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
                                <p class="text-b-1 text-neutral-700 mb-3 sm:mb-0">
                                    <span class="font-semibold">{{ $developers->total() }}</span> developers found
                                </p>

                                <div class="flex items-center">
                                    <label for="sort_by" class="text-b-2 text-neutral-700 mr-3">Sort by:</label>
                                    <select name="sort_by" id="sort_by" onchange="submitSearchForm()"
                                        class="border border-neutral-300 rounded-lg px-4 py-2 text-b-2 font-medium focus:ring-2 focus:ring-primary-500 focus:border-primary-500 bg-white">
                                        <option value="recommended" @selected($sortBy === 'recommended')>Recommended</option>
                                        <option value="rating_high" @selected($sortBy === 'rating_high')>Rating: High to Low
                                        </option>
                                        <option value="rating_low" @selected($sortBy === 'rating_low')>Rating: Low to High
                                        </option>
                                        <option value="projects_completed" @selected($sortBy === 'projects_completed')>Projects
                                            Completed
                                        </option>
                                        <option value="newest" @selected($sortBy === 'newest')>Newest</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Daftar Developer Card -->
                            <div class="space-y-6">
                                @forelse ($developers as $developer)
                                    <div
                                        class="bg-white rounded-lg border border-neutral-200 p-6 hover:shadow-md transition-shadow">
                                        <div class="flex flex-col sm:flex-row gap-5">

                                            <!-- Avatar -->
                                            <div class="flex-shrink-0">
                                                @php
                                                    $avatarSrc = $developer->getRawOriginal('avatar')
                                                        ? (filter_var($developer->getRawOriginal('avatar'), FILTER_VALIDATE_URL)
                                                            ? $developer->getRawOriginal('avatar')
                                                            : asset('storage/' . $developer->getRawOriginal('avatar')))
                                                        : 'https://ui-avatars.com/api/?name=' . urlencode($developer->name);
                                                @endphp
                                                <img class="h-20 w-20 rounded-lg object-cover"
                                                    src="{{ $avatarSrc }}"
                                                    alt="{{ $developer->name }}">
                                            </div>

                                            <!-- Info Utama -->
                                            <div class="flex-1 min-w-0">
                                                <div
                                                    class="flex flex-col sm:flex-row sm:items-start sm:justify-between mb-3">
                                                    <div class="mb-2 sm:mb-0">
                                                        <div class="flex items-center gap-3 mb-1">
                                                            <h3 class="text-h-6 text-neutral-900">
                                                                {{ $developer->name }}
                                                            </h3>
                                                            @if ($developer->developerProfile->headline)
                                                                <span
                                                                    class="inline-flex items-center bg-green-100 text-green-700 text-b-3 font-medium px-2.5 py-0.5 rounded">
                                                                    {{ $developer->developerProfile->headline }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <a href="{{ route('search.developers.show', $developer->id) }}"
                                                        class="hidden sm:inline-flex bg-primary-500 text-white text-b-2 font-medium px-6 py-2.5 rounded-lg hover:bg-primary-600 transition-colors whitespace-nowrap">
                                                        View Profile
                                                    </a>
                                                </div>

                                                <!-- Meta Info -->
                                                <div
                                                    class="flex flex-wrap items-center gap-x-4 gap-y-1 text-b-2 text-neutral-600 mb-4">
                                                    @if ($developer->location)
                                                        <div class="flex items-center">
                                                            <svg class="h-4 w-4 mr-1.5 text-neutral-500"
                                                                fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor" stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            </svg>
                                                            {{ $developer->location }}
                                                        </div>
                                                    @endif
                                                    <div class="flex items-center">
                                                        <svg class="h-4 w-4 mr-1.5 text-neutral-500" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor"
                                                            stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                        </svg>
                                                        {{ $developer->developerProfile->projects_completed ?? 0 }}
                                                        jobs
                                                        completed
                                                    </div>
                                                    <div class="flex items-center">
                                                        <svg class="h-4 w-4 mr-1 text-secondary-500"
                                                            fill="currentColor" viewBox="0 0 20 20">
                                                            <path
                                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.957a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.368 2.448a1 1 0 00-.364 1.118l1.287 3.957c.3.921-.755 1.688-1.54 1.118l-3.368-2.448a1 1 0 00-1.175 0l-3.368 2.448c-.784.57-1.838-.197-1.54-1.118l1.287-3.957a1 1 0 00-.364-1.118L2.064 9.39c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69L9.049 2.927z" />
                                                        </svg>
                                                        <span
                                                            class="font-semibold text-neutral-900 ml-0.5">{{ number_format($developer->developerProfile->rating_average ?? 0, 1) }}</span>
                                                    </div>
                                                </div>

                                                <!-- Deskripsi -->
                                                <p class="text-b-2 text-neutral-700 mb-4 line-clamp-2 leading-relaxed">
                                                    {{ $developer->developerProfile->experience ?? ($developer->bio ?? 'Full-stack developer with 5+ years of experience building scalable web applications. Specialized in React, Node.js, and cloud architecture.') }}
                                                </p>

                                                <!-- Skills -->
                                                <div class="flex flex-wrap gap-2">
                                                    @foreach ($developer->skills->take(5) as $skill)
                                                        <span
                                                            class="inline-flex items-center bg-neutral-100 text-neutral-700 text-b-3 font-medium px-3 py-1.5 rounded-md">
                                                            {{ $skill->name }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </div>

                                        </div>

                                        <!-- Mobile View Profile Button -->
                                        <a href="{{ route('search.developers.show', $developer->id) }}"
                                            class="sm:hidden mt-5 block text-center bg-primary-500 text-white text-b-2 font-medium py-2.5 rounded-lg hover:bg-primary-600 transition-colors">
                                            View Profile
                                        </a>
                                    </div>
                                @empty
                                    <div class="bg-white p-12 rounded-lg border border-neutral-200 text-center">
                                        <svg class="mx-auto h-12 w-12 text-neutral-400 mb-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                        </svg>
                                        <h3 class="text-h-6 text-neutral-800 mb-2">No Developers Found</h3>
                                        <p class="text-b-1 text-neutral-600">Try adjusting your filters or search
                                            criteria.
                                        </p>
                                    </div>
                                @endforelse
                            </div>

                            <!-- Pagination -->
                            @if ($developers->hasPages())
                                <div class="mt-8 flex justify-center items-center gap-2">
                                    {{-- Previous Button --}}
                                    @if ($developers->onFirstPage())
                                        <span class="px-3 py-2 text-b-2 text-neutral-400 cursor-not-allowed">
                                            Previous
                                        </span>
                                    @else
                                        <a href="{{ $developers->previousPageUrl() }}"
                                            class="px-3 py-2 text-b-2 text-neutral-700 hover:text-primary-600 transition-colors">
                                            Previous
                                        </a>
                                    @endif

                                    {{-- Page Numbers --}}
                                    @foreach (range(1, min(3, $developers->lastPage())) as $page)
                                        @if ($page == $developers->currentPage())
                                            <span
                                                class="px-3 py-2 bg-primary-500 text-white rounded-lg text-b-2 font-medium">
                                                {{ $page }}
                                            </span>
                                        @else
                                            <a href="{{ $developers->url($page) }}"
                                                class="px-3 py-2 text-neutral-700 hover:bg-neutral-100 rounded-lg text-b-2 transition-colors">
                                                {{ $page }}
                                            </a>
                                        @endif
                                    @endforeach

                                    {{-- Next Button --}}
                                    @if ($developers->hasMorePages())
                                        <a href="{{ $developers->nextPageUrl() }}"
                                            class="px-3 py-2 text-b-2 text-neutral-700 hover:text-primary-600 transition-colors">
                                            Next
                                        </a>
                                    @else
                                        <span class="px-3 py-2 text-b-2 text-neutral-400 cursor-not-allowed">
                                            Next
                                        </span>
                                    @endif
                                </div>
                            @endif

                        </main>

                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        // All available skills data
        const allSkills = @json($allSkills->pluck('name')->toArray());
        let selectedSkills = @json($skills ?? []);

        const searchInput = document.getElementById('skillSearch');
        const suggestionsBox = document.getElementById('skillSuggestions');
        const selectedContainer = document.getElementById('selectedSkillsContainer');
        const hiddenContainer = document.getElementById('hiddenSkillsContainer');

        // Search and show suggestions
        searchInput.addEventListener('input', function() {
            const keyword = this.value.trim().toLowerCase();

            if (keyword.length === 0) {
                suggestionsBox.classList.add('hidden');
                return;
            }

            // Filter skills by keyword (starts with)
            const matches = allSkills.filter(skill =>
                skill.toLowerCase().startsWith(keyword) && !selectedSkills.includes(skill)
            );

            if (matches.length === 0) {
                suggestionsBox.classList.add('hidden');
                return;
            }

            // Show suggestions
            suggestionsBox.innerHTML = matches.map(skill =>
                `<div class="px-3 py-2 hover:bg-primary-50 cursor-pointer text-sm suggestion-item" data-skill="${skill}">
            ${skill}
        </div>`
            ).join('');

            suggestionsBox.classList.remove('hidden');

            // Add click handlers to suggestions
            document.querySelectorAll('.suggestion-item').forEach(item => {
                item.addEventListener('click', function() {
                    addSkill(this.dataset.skill);
                    searchInput.value = '';
                    suggestionsBox.classList.add('hidden');
                });
            });
        });

        // Hide suggestions when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
                suggestionsBox.classList.add('hidden');
            }
        });

        // Toggle skill from checkbox
        function toggleSkill(skillName) {
            if (selectedSkills.includes(skillName)) {
                removeSkill(skillName);
            } else {
                addSkill(skillName);
            }
        }

        // Add skill
        function addSkill(skillName) {
            if (selectedSkills.includes(skillName)) return;

            selectedSkills.push(skillName);

            // Add chip
            const chip = document.createElement('div');
            chip.className = 'inline-flex items-center bg-primary-100 text-primary-700 px-3 py-1 rounded-full text-sm';
            chip.innerHTML = `
        <span>${skillName}</span>
        <button type="button" onclick="removeSkill('${skillName}')" class="ml-2 text-primary-700 hover:text-primary-900">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    `;
            selectedContainer.appendChild(chip);

            // Add hidden input
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'skills[]';
            hiddenInput.value = skillName;
            hiddenInput.dataset.skill = skillName;
            hiddenContainer.appendChild(hiddenInput);

            // Check the checkbox
            updateCheckboxes();

            // Submit form
            submitSearchForm();
        }

        // Remove skill
        function removeSkill(skillName) {
            selectedSkills = selectedSkills.filter(s => s !== skillName);

            // Remove chip
            const chips = selectedContainer.querySelectorAll('div');
            chips.forEach(chip => {
                if (chip.textContent.includes(skillName)) {
                    chip.remove();
                }
            });

            // Remove hidden input
            const hiddenInput = hiddenContainer.querySelector(`input[data-skill="${skillName}"]`);
            if (hiddenInput) {
                hiddenInput.remove();
            }

            // Uncheck the checkbox
            updateCheckboxes();

            // Submit form
            submitSearchForm();
        }

        // Update checkboxes based on selected skills
        function updateCheckboxes() {
            document.querySelectorAll('.skill-checkbox').forEach(checkbox => {
                checkbox.checked = selectedSkills.includes(checkbox.value);
            });
        }

        // Submit search form
        function submitSearchForm() {
            document.getElementById('developer-search-form').submit();
        }
    </script>
</x-app-layout>
