<x-app-layout>
    <x-slot:title>{{ __('Find Projects - Inofa') }}</x-slot:title>

    {{-- Background putih dengan section abu-abu --}}
    <div class="bg-white min-h-screen">
        
        {{-- Hero Section dengan background putih --}}
        <div class="bg-white border-b border-neutral-100">
            <div class="container max-w-[86rem] mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <h1 class="text-h-3 text-neutral-900 mb-6 mt-16">Find Your Next Project</h1>
                <div class="relative max-w-md">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-neutral-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="search" name="q" id="q" value="{{ $keyword ?? '' }}" form="project-search-form"
                        class="w-full pl-12 pr-4 py-3 border border-neutral-300 rounded-lg text-b-1 placeholder:text-neutral-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                        placeholder="Search for jobs..."
                        onkeypress="if(event.key === 'Enter') { event.preventDefault(); submitProjectSearchForm(); }">
                </div>
            </div>
        </div>

        {{-- Main Content dengan background abu-abu --}}
        <div class="bg-neutral-50">
            <div class="container max-w-[86rem] mx-auto px-4 sm:px-6 lg:px-8 py-8">

                {{-- Form utama untuk filter, pencarian, dan sorting --}}
                <form action="{{ route('search.projects') }}" method="GET" id="project-search-form">

                    <!-- Layout Grid (Filter + Hasil) -->
                    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

                        <!-- Sidebar Filter (Kiri) -->
                        <aside class="lg:col-span-1">
                            <div class="bg-white rounded-lg p-6 border border-neutral-200 sticky top-24">
                                <h2 class="text-h-6 text-neutral-900 mb-6">Job Filters</h2>

                                {{-- Submit form on change --}}
                                <script>
                                    function submitProjectSearchForm() {
                                        document.getElementById('project-search-form').submit();
                                    }
                                </script>

                                <!-- Filter: Experience Level -->
                                <div class="mb-6">
                                    <h3 class="text-b-1 font-semibold text-neutral-900 mb-3">Experience Level</h3>
                                    <div class="space-y-1">
                                        <button type="button" onclick="document.querySelector('[name=experience]').value='all'; submitProjectSearchForm();"
                                            class="w-full text-left text-b-2 py-2.5 px-4 rounded-lg transition-colors {{ empty(request('experience')) || request('experience') === 'all' ? 'bg-primary-500 text-white font-medium' : 'text-neutral-700 font-medium bg-[#F5F5F5] hover:bg-neutral-50' }}">
                                            All levels
                                        </button>
                                        <input type="hidden" name="experience" value="{{ request('experience', 'all') }}">
                                        
                                        <button type="button" onclick="document.querySelector('[name=experience]').value='beginner'; submitProjectSearchForm();"
                                            class="w-full text-left text-b-2 py-2.5 px-4 rounded-lg transition-colors {{ request('experience') === 'beginner' ? 'bg-primary-500 text-white font-medium' : 'text-neutral-700 font-medium bg-[#F5F5F5] hover:bg-neutral-50' }}">
                                            Beginner
                                        </button>
                                        
                                        <button type="button" onclick="document.querySelector('[name=experience]').value='intermediate'; submitProjectSearchForm();"
                                            class="w-full text-left text-b-2 py-2.5 px-4 rounded-lg transition-colors {{ request('experience') === 'intermediate' ? 'bg-primary-500 text-white font-medium' : 'text-neutral-700 font-medium bg-[#F5F5F5] hover:bg-neutral-50' }}">
                                            Intermediate
                                        </button>
                                        
                                        <button type="button" onclick="document.querySelector('[name=experience]').value='advance'; submitProjectSearchForm();"
                                            class="w-full text-left text-b-2 py-2.5 px-4 rounded-lg transition-colors {{ request('experience') === 'advance' ? 'bg-primary-500 text-white font-medium' : 'text-neutral-700 font-medium bg-[#F5F5F5] hover:bg-neutral-50' }}">
                                            Advance
                                        </button>
                                        
                                        <button type="button" onclick="document.querySelector('[name=experience]').value='expert'; submitProjectSearchForm();"
                                            class="w-full text-left text-b-2 py-2.5 px-4 rounded-lg transition-colors {{ request('experience') === 'expert' ? 'bg-primary-500 text-white font-medium' : 'text-neutral-700 font-medium bg-[#F5F5F5] hover:bg-neutral-50' }}">
                                            Expert
                                        </button>
                                    </div>
                                </div>

                                <!-- Filter: Budget Range -->
                                <div class="mb-6">
                                    <h3 class="text-b-1 font-semibold text-neutral-900 mb-3">Budget Range</h3>
                                    <div class="space-y-1">
                                        <button type="button" onclick="document.querySelector('[name=min_budget]').value=''; document.querySelector('[name=max_budget]').value=''; submitProjectSearchForm();"
                                            class="w-full text-left text-b-2 py-2.5 px-4 rounded-lg transition-colors {{ empty(request('min_budget')) && empty(request('max_budget')) ? 'bg-primary-500 text-white font-medium' : 'text-neutral-700 font-medium bg-[#F5F5F5] hover:bg-neutral-50' }}">
                                            All budgets
                                        </button>
                                        
                                        <button type="button" onclick="document.querySelector('[name=min_budget]').value='0'; document.querySelector('[name=max_budget]').value='500000'; submitProjectSearchForm();"
                                            class="w-full text-left text-b-2 py-2.5 px-4 rounded-lg transition-colors {{ request('min_budget') == '0' && request('max_budget') == '500000' ? 'bg-primary-500 text-white font-medium' : 'text-neutral-700 font-medium bg-[#F5F5F5] hover:bg-neutral-50' }}">
                                            Rp0 - Rp500K
                                        </button>
                                        
                                        <button type="button" onclick="document.querySelector('[name=min_budget]').value='500000'; document.querySelector('[name=max_budget]').value='1000000'; submitProjectSearchForm();"
                                            class="w-full text-left text-b-2 py-2.5 px-4 rounded-lg transition-colors {{ request('min_budget') == '500000' && request('max_budget') == '1000000' ? 'bg-primary-500 text-white font-medium' : 'text-neutral-700 font-medium bg-[#F5F5F5] hover:bg-neutral-50' }}">
                                            Rp500K - Rp1M
                                        </button>
                                        
                                        <button type="button" onclick="document.querySelector('[name=min_budget]').value='1000000'; document.querySelector('[name=max_budget]').value='5000000'; submitProjectSearchForm();"
                                            class="w-full text-left text-b-2 py-2.5 px-4 rounded-lg transition-colors {{ request('min_budget') == '1000000' && request('max_budget') == '5000000' ? 'bg-primary-500 text-white font-medium' : 'text-neutral-700 font-medium bg-[#F5F5F5] hover:bg-neutral-50' }}">
                                            Rp1M - Rp5M
                                        </button>
                                        
                                        <button type="button" onclick="document.querySelector('[name=min_budget]').value='5000000'; document.querySelector('[name=max_budget]').value='10000000'; submitProjectSearchForm();"
                                            class="w-full text-left text-b-2 py-2.5 px-4 rounded-lg transition-colors {{ request('min_budget') == '5000000' && request('max_budget') == '10000000' ? 'bg-primary-500 text-white font-medium' : 'text-neutral-700 font-medium bg-[#F5F5F5] hover:bg-neutral-50' }}">
                                            Rp5M - Rp10M
                                        </button>
                                        
                                        <button type="button" onclick="document.querySelector('[name=min_budget]').value='10000000'; document.querySelector('[name=max_budget]').value=''; submitProjectSearchForm();"
                                            class="w-full text-left text-b-2 py-2.5 px-4 rounded-lg transition-colors {{ request('min_budget') == '10000000' && empty(request('max_budget')) ? 'bg-primary-500 text-white font-medium' : 'text-neutral-700 font-medium bg-[#F5F5F5] hover:bg-neutral-50' }}">
                                            Rp10M+
                                        </button>
                                        
                                        <input type="hidden" name="min_budget" value="{{ request('min_budget', '') }}">
                                        <input type="hidden" name="max_budget" value="{{ request('max_budget', '') }}">
                                    </div>
                                    
                                    <!-- Custom Range Input -->
                                    <div class="mt-4 pt-4 border-t border-neutral-200">
                                        <h4 class="text-b-2 font-medium text-neutral-700 mb-2">Custom Range</h4>
                                        <div class="flex gap-2">
                                            <input type="number" id="custom_min" placeholder="Min" 
                                                class="w-1/2 px-3 py-2 text-sm border border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                            <input type="number" id="custom_max" placeholder="Max"
                                                class="w-1/2 px-3 py-2 text-sm border border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                        </div>
                                        <button type="button" onclick="applyCustomBudget()" 
                                            class="w-full mt-2 text-b-2 py-2 px-3 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors">
                                            Apply
                                        </button>
                                    </div>
                                </div>

                                <!-- Filter: Category -->
                                <div class="mb-6">
                                    <h3 class="text-b-1 font-semibold text-neutral-900 mb-3">Category</h3>
                                    <select name="category" id="category" onchange="submitProjectSearchForm()"
                                        class="w-full px-4 py-2.5 border border-neutral-300 rounded-lg text-b-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 bg-white">
                                        <option value="all" @selected(empty($category) || $category === 'all')>All category</option>
                                        @foreach ($categories as $cat)
                                            <option value="{{ $cat }}" @selected($category === $cat)>{{ $cat }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Filter: Location -->
                                <div class="mb-6">
                                    <h3 class="text-b-1 font-semibold text-neutral-900 mb-3">Location</h3>
                                    <select name="location" id="location" onchange="submitProjectSearchForm()"
                                        class="w-full px-4 py-2.5 border border-neutral-300 rounded-lg text-b-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 bg-white">
                                        <option value="all" @selected(empty($location) || $location === 'all')>All locations</option>
                                        @foreach ($locations as $loc)
                                            <option value="{{ $loc }}" @selected($location === $loc)>{{ $loc }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Filter: Skills Required -->
                                <div class="mb-6">
                                    <h3 class="text-b-1 font-semibold text-neutral-900 mb-3">Skills Required</h3>

                                    <!-- Search Input -->
                                    <div class="mb-3 relative">
                                        <input type="text" id="skillSearch" placeholder="Search skills..."
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
                                        @foreach ($allSkills->take(8) as $skill)
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

                                <!-- Clear Filters -->
                                <div>
                                    <a href="{{ route('search.projects') }}"
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
                                    <span class="font-semibold">{{ $projects->total() }}</span> jobs found
                                </p>

                                <div class="flex items-center">
                                    <label for="sort_by" class="text-b-2 text-neutral-700 mr-3">Sort by:</label>
                                    <select name="sort_by" id="sort_by" onchange="submitProjectSearchForm()"
                                        class="border border-neutral-300 rounded-lg px-4 py-2 text-b-2 font-medium focus:ring-2 focus:ring-primary-500 focus:border-primary-500 bg-white">
                                        <option value="most_recent" @selected($sortBy === 'most_recent')>Most Recent</option>
                                        <option value="budget_high" @selected($sortBy === 'budget_high')>Budget: High to Low</option>
                                        <option value="budget_low" @selected($sortBy === 'budget_low')>Budget: Low to High</option>
                                        <option value="deadline_soon" @selected($sortBy === 'deadline_soon')>Deadline: Soonest</option>
                                        <option value="most_proposals" @selected($sortBy === 'most_proposals')>Most Proposals</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Daftar Project Card -->
                            <div class="space-y-4">
                                @forelse ($projects as $project)
                                    <div class="bg-white rounded-lg border border-neutral-200 p-6 hover:shadow-md transition-shadow">
                                        <div class="flex flex-col sm:flex-row gap-5">
                                            
                                            <!-- Icon/Logo -->
                                            <div class="flex-shrink-0">
                                                <div class="h-16 w-16 bg-green-100 rounded-lg flex items-center justify-center">
                                                    <svg class="w-8 h-8 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                            </div>

                                            <!-- Info Utama -->
                                            <div class="flex-1 min-w-0">
                                                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between mb-2">
                                                    <div class="mb-2 sm:mb-0 flex-1">
                                                        <h3 class="text-h-6 text-neutral-900 mb-2">{{ $project->title }}</h3>
                                                        <p class="text-b-3 text-neutral-600 mb-1">{{ $project->consumer->name ?? 'TechMart Indonesia' }}</p>
                                                    </div>
                                                </div>

                                                <!-- Meta Info -->
                                                <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-b-2 text-neutral-600 mb-3">
                                                    @if($project->consumer && $project->consumer->location)
                                                        <div class="flex items-center">
                                                            <svg class="h-4 w-4 mr-1 text-neutral-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            </svg>
                                                            {{ $project->consumer->location }}
                                                        </div>
                                                    @endif
                                                    @php
                                                        $avgLevel = $project->skills->avg('pivot.required_level');
                                                        $experienceLabel = 'N/A';
                                                        if ($avgLevel >= 1 && $avgLevel <= 2) {
                                                            $experienceLabel = 'Beginner';
                                                        } elseif ($avgLevel > 2 && $avgLevel <= 3.5) {
                                                            $experienceLabel = 'Intermediate';
                                                        } elseif ($avgLevel > 3.5 && $avgLevel <= 4.5) {
                                                            $experienceLabel = 'Advance';
                                                        } elseif ($avgLevel > 4.5 && $avgLevel <= 5) {
                                                            $experienceLabel = 'Expert';
                                                        }
                                                    @endphp
                                                    @if($avgLevel)
                                                    <div class="flex items-center">
                                                        <svg class="h-4 w-4 mr-1 text-neutral-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                        </svg>
                                                        {{ $experienceLabel }}
                                                    </div>
                                                    @endif
                                                    <div class="flex items-center">
                                                        <svg class="h-4 w-4 mr-1 text-neutral-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                        {{ $project->created_at->diffForHumans() }}
                                                    </div>
                                                </div>

                                                <!-- Budget & Proposals -->
                                                <div class="flex items-center gap-4 mb-3">
                                                    <div class="flex items-center text-primary-600 font-semibold">
                                                        <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
                                                        </svg>
                                                        Rp {{ number_format($project->budget, 0, ',', '.') }}/month
                                                    </div>
                                                    <span class="text-b-2 text-neutral-600">• {{ $project->offers_count ?? 0 }} proposals</span>
                                                </div>

                                                <!-- Deskripsi -->
                                                <p class="text-b-2 text-neutral-700 mb-4 line-clamp-2 leading-relaxed">
                                                    {{ Str::limit($project->description, 150) }}
                                                </p>

                                                <!-- Skills -->
                                                <div class="flex flex-wrap gap-2 mb-4">
                                                    @foreach ($project->skills->take(5) as $skill)
                                                        <span class="inline-flex items-center bg-neutral-100 text-neutral-700 text-b-3 font-medium px-3 py-1.5 rounded-md">
                                                            {{ $skill->name }}
                                                        </span>
                                                    @endforeach
                                                </div>

                                                <!-- Apply Button -->
                                                <div class="flex justify-end">
                                                    <a href="{{ route('search.projects.show', $project->id) }}"
                                                        class="inline-flex bg-primary-500 text-white text-b-2 font-medium px-6 py-2.5 rounded-lg hover:bg-primary-600 transition-colors">
                                                        View Project
                                                    </a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                @empty
                                    <div class="bg-white p-12 rounded-lg border border-neutral-200 text-center">
                                        <svg class="mx-auto h-12 w-12 text-neutral-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                        </svg>
                                        <h3 class="text-h-6 text-neutral-800 mb-2">No Projects Found</h3>
                                        <p class="text-b-1 text-neutral-600">Try adjusting your filters or search criteria.</p>
                                    </div>
                                @endforelse
                            </div>

                            <!-- Pagination -->
                            @if($projects->hasPages())
                            <div class="mt-8 flex justify-center items-center gap-2">
                                {{-- Previous Button --}}
                                @if ($projects->onFirstPage())
                                    <span class="px-3 py-2 text-b-2 text-neutral-400 cursor-not-allowed">
                                        Previous
                                    </span>
                                @else
                                    <a href="{{ $projects->previousPageUrl() }}" class="px-3 py-2 text-b-2 text-neutral-700 hover:text-primary-600 transition-colors">
                                        Previous
                                    </a>
                                @endif

                                {{-- Page Numbers --}}
                                @foreach(range(1, min(3, $projects->lastPage())) as $page)
                                    @if($page == $projects->currentPage())
                                        <span class="px-3 py-2 bg-primary-500 text-white rounded-lg text-b-2 font-medium">
                                            {{ $page }}
                                        </span>
                                    @else
                                        <a href="{{ $projects->url($page) }}" class="px-3 py-2 text-neutral-700 hover:bg-neutral-100 rounded-lg text-b-2 transition-colors">
                                            {{ $page }}
                                        </a>
                                    @endif
                                @endforeach

                                {{-- Next Button --}}
                                @if ($projects->hasMorePages())
                                    <a href="{{ $projects->nextPageUrl() }}" class="px-3 py-2 text-b-2 text-neutral-700 hover:text-primary-600 transition-colors">
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

    {{-- JavaScript for Skills Search & Selection --}}
    <script>
        // All available skills from backend
        const allSkillsData = @json($allSkills->pluck('name'));
        let selectedSkills = @json($skills ?? []);

        const searchInput = document.getElementById('skillSearch');
        const suggestionsBox = document.getElementById('skillSuggestions');
        const selectedContainer = document.getElementById('selectedSkillsContainer');
        const hiddenContainer = document.getElementById('hiddenSkillsContainer');

        // Search and show suggestions
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            
            if (searchTerm.length < 1) {
                suggestionsBox.classList.add('hidden');
                return;
            }

            const matches = allSkillsData.filter(skill => 
                skill.toLowerCase().includes(searchTerm) && !selectedSkills.includes(skill)
            );

            if (matches.length === 0) {
                suggestionsBox.classList.add('hidden');
                return;
            }

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
            submitProjectSearchForm();
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
            submitProjectSearchForm();
        }

        // Update checkboxes based on selected skills
        function updateCheckboxes() {
            document.querySelectorAll('.skill-checkbox').forEach(checkbox => {
                checkbox.checked = selectedSkills.includes(checkbox.value);
            });
        }

        // Apply custom budget
        function applyCustomBudget() {
            const minBudget = document.getElementById('custom_min').value;
            const maxBudget = document.getElementById('custom_max').value;
            
            if (minBudget) {
                document.querySelector('[name=min_budget]').value = minBudget;
            }
            if (maxBudget) {
                document.querySelector('[name=max_budget]').value = maxBudget;
            }
            
            submitProjectSearchForm();
        }
    </script>
</x-app-layout>