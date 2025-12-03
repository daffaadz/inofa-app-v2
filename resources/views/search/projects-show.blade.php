<x-app-layout>
    <x-slot name="title">{{ $project->title }} - Project Detail</x-slot>

    <div class="bg-neutral-10 min-h-screen">
        <!-- Project Header Section -->
        <div class="bg-white border-b border-neutral-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="flex flex-row gap-6 mt-16">
                    <!-- Project Icon -->
                    <div class="flex-shrink-0">
                        <div class="w-40 h-40 bg-gradient-to-br from-primary-400 to-primary-600 rounded-lg flex items-center justify-center border-4 border-primary-300">
                            <svg class="w-20 h-20 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>

                    <!-- Project Info -->
                    <div class="flex-grow">
                        <div class="flex items-center gap-3 mb-2">
                            <h1 class="text-h-2 font-bold text-neutral-900">{{ $project->title }}</h1>
                            <span class="px-3 py-1 text-xs font-bold uppercase tracking-wider rounded-full 
                                {{ $project->status === 'open' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $project->status === 'in_progress' ? 'bg-blue-100 text-blue-700' : '' }}
                                {{ $project->status === 'completed' ? 'bg-neutral-100 text-neutral-700' : '' }}">
                                {{ ucfirst($project->status) }}
                            </span>
                        </div>

                        <div class="flex flex-col items-start justify-center gap-4 mb-4">
                            <div class="flex flex-row gap-4">
                                <!-- Budget -->
                                <div class="flex items-center gap-1 text-b-1 text-primary-600 font-semibold">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
                                    </svg>
                                    Rp {{ number_format($project->budget, 0, ',', '.') }}/month
                                </div>

                                <!-- Posted Date -->
                                <div class="flex items-center gap-1 text-b-2 text-neutral-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    Posted {{ $project->created_at->diffForHumans() }}
                                </div>
                            </div>

                            <div class="flex flex-row gap-4">
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
                                
                                <!-- Experience Level -->
                                @if($avgLevel)
                                <div class="inline-flex items-center px-3 py-1 rounded-full text-b-3 font-medium
                                    {{ $experienceLabel === 'Beginner' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $experienceLabel === 'Intermediate' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $experienceLabel === 'Advance' ? 'bg-purple-100 text-purple-800' : '' }}
                                    {{ $experienceLabel === 'Expert' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ $experienceLabel }} Level
                                </div>
                                @endif

                                <!-- Proposals Count -->
                                <div class="flex items-center gap-1 text-b-2 text-neutral-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                        </path>
                                    </svg>
                                    {{ $project->offers_count ?? 0 }} Proposals
                                </div>

                                @if($project->deadline)
                                <!-- Deadline -->
                                <div class="flex items-center gap-1 text-b-2 text-neutral-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z">
                                        </path>
                                    </svg>
                                    Deadline: {{ $project->deadline->format('M d, Y') }}
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        @auth
                            @if(auth()->user()->role === 'developer')
                                <div class="flex flex-wrap gap-3">
                                    @if(!$hasApplied)
                                        <button onclick="quickApply({{ $project->id }})"
                                            id="applyBtn"
                                            class="inline-flex gap-2 items-center px-6 py-3 bg-primary-500 text-white text-b-2 font-medium rounded-lg hover:bg-primary-600 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                </path>
                                            </svg>
                                            Apply Now
                                        </button>
                                    @else
                                        <button disabled
                                            class="inline-flex gap-2 items-center px-6 py-3 bg-neutral-300 text-neutral-600 text-b-2 font-medium rounded-lg cursor-not-allowed">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z">
                                                </path>
                                            </svg>
                                            Already Applied
                                        </button>
                                    @endif
                                    
                                    <a href="{{ route('user', ['id' => $project->consumer_id]) }}"
                                        class="inline-flex items-center px-6 py-2.5 bg-white text-primary-500 text-b-2 font-medium rounded-lg border-2 border-primary-500 hover:bg-primary-50 transition-colors">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        Contact Owner
                                    </a>
                                </div>
                            @elseif(auth()->user()->role === 'consumer')
                                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                    <div class="flex items-start gap-3">
                                        <svg class="w-6 h-6 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                        </svg>
                                        <div>
                                            <h3 class="text-b-2 font-semibold text-yellow-900 mb-1">Cannot Apply to Projects</h3>
                                            <p class="text-b-3 text-yellow-800">You are logged in as a customer. Only developers can apply to projects. If you want to apply, please create or switch to a developer account.</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="flex flex-wrap gap-3">
                                <a href="{{ route('login') }}"
                                    class="inline-flex gap-2 items-center px-6 py-3 bg-primary-500 text-white text-b-2 font-medium rounded-lg hover:bg-primary-600 transition-colors">
                                    Login to Apply
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column - Main Info -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Project Description -->
                    <section class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-h-4 text-neutral-900 mb-4">Project Description</h2>
                        <div class="text-b-1 text-neutral-700 leading-relaxed whitespace-pre-line">
                            {{ $project->description }}
                        </div>
                    </section>

                    <!-- Requirements -->
                    @if($project->requirements)
                    <section class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-h-4 text-neutral-900 mb-4">Requirements</h2>
                        <div class="text-b-1 text-neutral-700 leading-relaxed">
                            @php
                                $requirements = is_string($project->requirements) 
                                    ? json_decode($project->requirements, true) 
                                    : $project->requirements;
                            @endphp
                            
                            @if(is_array($requirements) && isset($requirements[0]['type']))
                                <!-- Structured Requirements -->
                                <div class="space-y-4">
                                    @foreach($requirements as $requirement)
                                        <div class="flex items-start gap-3 p-4 bg-neutral-50 rounded-lg border border-neutral-200">
                                            <div class="flex-shrink-0 mt-1">
                                                @if($requirement['priority'] === 'must_have')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        Must Have
                                                    </span>
                                                @elseif($requirement['priority'] === 'nice_to_have')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                        Nice to Have
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                        {{ ucfirst(str_replace('_', ' ', $requirement['priority'])) }}
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="flex-1">
                                                @if(isset($requirement['type']))
                                                    <p class="text-xs text-neutral-500 uppercase tracking-wide mb-1">
                                                        {{ ucfirst($requirement['type']) }}
                                                    </p>
                                                @endif
                                                <p class="text-neutral-900">{{ $requirement['description'] }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @elseif(is_array($requirements))
                                <!-- Simple Array -->
                                <ul class="list-disc list-inside space-y-2">
                                    @foreach($requirements as $requirement)
                                        <li>{{ is_array($requirement) ? ($requirement['description'] ?? json_encode($requirement)) : $requirement }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <!-- Plain Text -->
                                <p class="whitespace-pre-line">{{ $project->requirements }}</p>
                            @endif
                        </div>
                    </section>
                    @endif

                    <!-- Skills Required -->
                    <section class="bg-gradient-to-br from-secondary-100 via-white to-secondary-100 rounded-lg shadow-sm p-6">
                        <h2 class="text-h-4 text-neutral-900 mb-6">Skills Required</h2>
                        @if ($project->skills->count() > 0)
                            <div class="flex flex-wrap gap-3">
                                @foreach ($project->skills as $skill)
                                    <span class="inline-flex items-center px-5 py-2.5 bg-transparent border-2 border-primary-500 text-primary-500 hover:bg-primary-500 hover:text-white transition-all duration-300 text-b-2 font-medium rounded-full">
                                        {{ $skill->name }}
                                        @if($skill->pivot->required_level)
                                            <span class="ml-2 text-xs opacity-75">
                                                (Level {{ $skill->pivot->required_level }})
                                            </span>
                                        @endif
                                    </span>
                                @endforeach
                            </div>
                        @else
                            <p class="text-neutral-600">No specific skills listed</p>
                        @endif
                    </section>
                </div>

                <!-- Right Column - Sidebar -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Project Owner -->
                    <section class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-h-6 text-neutral-900 mb-4">Project Owner</h3>
                        @if($project->consumer)
                            <div class="flex items-start gap-3 mb-4">
                                @php
                                    $avatarSrc = $project->consumer->getRawOriginal('avatar')
                                        ? (filter_var($project->consumer->getRawOriginal('avatar'), FILTER_VALIDATE_URL)
                                            ? $project->consumer->getRawOriginal('avatar')
                                            : asset('storage/' . $project->consumer->getRawOriginal('avatar')))
                                        : 'https://ui-avatars.com/api/?name=' . urlencode($project->consumer->name);
                                @endphp
                                <img src="{{ $avatarSrc }}" 
                                    alt="{{ $project->consumer->name }}"
                                    class="w-16 h-16 rounded-lg object-cover">
                                <div class="flex-1">
                                    <h4 class="text-b-1 font-semibold text-neutral-900">{{ $project->consumer->name }}</h4>
                                    @if($project->consumer->location)
                                        <p class="text-b-3 text-neutral-600 flex items-center gap-1 mt-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                </path>
                                            </svg>
                                            {{ $project->consumer->location }}
                                        </p>
                                    @endif
                                    <p class="text-b-3 text-neutral-500 mt-1">
                                        Member since {{ $project->consumer->created_at->format('Y') }}
                                    </p>
                                </div>
                            </div>
                            <div class="pt-4 border-t border-neutral-100">
                                <div class="flex items-center justify-between text-b-3 text-neutral-600 mb-2">
                                    <span>Total Projects</span>
                                    <span class="font-semibold text-neutral-900">{{ $project->consumer->posted_projects_count ?? 0 }}</span>
                                </div>
                            </div>
                        @else
                            <p class="text-neutral-600">Owner information not available</p>
                        @endif
                    </section>

                    <!-- Project Stats -->
                    <section class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-h-6 text-neutral-900 mb-4">Project Stats</h3>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between text-b-2">
                                <span class="text-neutral-600">Status</span>
                                <span class="font-semibold text-neutral-900 capitalize">{{ $project->status }}</span>
                            </div>
                            <div class="flex items-center justify-between text-b-2">
                                <span class="text-neutral-600">Budget</span>
                                <span class="font-semibold text-primary-600">Rp {{ number_format($project->budget, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex items-center justify-between text-b-2">
                                <span class="text-neutral-600">Proposals</span>
                                <span class="font-semibold text-neutral-900">{{ $project->offers_count ?? 0 }}</span>
                            </div>
                            @if($project->deadline)
                            <div class="flex items-center justify-between text-b-2">
                                <span class="text-neutral-600">Deadline</span>
                                <span class="font-semibold text-neutral-900">{{ $project->deadline->format('M d, Y') }}</span>
                            </div>
                            @endif
                            <div class="flex items-center justify-between text-b-2">
                                <span class="text-neutral-600">Posted</span>
                                <span class="font-semibold text-neutral-900">{{ $project->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </section>

                    <!-- Similar Projects -->
                    @if($similarProjects->count() > 0)
                    <section class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-h-6 text-neutral-900 mb-4">Similar Projects</h3>
                        <div class="space-y-4">
                            @foreach($similarProjects as $similar)
                                <a href="{{ route('search.projects.show', $similar->id) }}" 
                                    class="block p-3 rounded-lg hover:bg-neutral-50 transition-colors border border-neutral-100">
                                    <h4 class="text-b-2 font-semibold text-neutral-900 mb-1 line-clamp-2">{{ $similar->title }}</h4>
                                    <div class="flex items-center justify-between text-b-3 text-neutral-600">
                                        <span>Rp {{ number_format($similar->budget, 0, ',', '.') }}</span>
                                        <span>{{ $similar->created_at->diffForHumans() }}</span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </section>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @auth
    @if(auth()->user()->role === 'developer')
    <script>
        function quickApply(projectId) {
            const applyBtn = document.getElementById('applyBtn');
            const originalContent = applyBtn.innerHTML;
            
            // Disable button and show loading
            applyBtn.disabled = true;
            applyBtn.innerHTML = `
                <svg class="animate-spin h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Sending...
            `;

            fetch(`/projects/${projectId}/quick-apply`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    applyBtn.innerHTML = `
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Application Sent!
                    `;
                    applyBtn.classList.remove('bg-primary-500', 'hover:bg-primary-600');
                    applyBtn.classList.add('bg-green-500');

                    // Show success notification
                    const successDiv = document.createElement('div');
                    successDiv.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg z-50 animate-fade-in';
                    successDiv.innerHTML = `
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <p class="font-semibold">Success!</p>
                                <p class="text-sm">${data.message}</p>
                            </div>
                        </div>
                    `;
                    document.body.appendChild(successDiv);

                    // Redirect after 2 seconds
                    setTimeout(() => {
                        window.location.href = data.redirect_url;
                    }, 2000);
                } else {
                    throw new Error(data.message || 'Application failed');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                
                // Restore button
                applyBtn.disabled = false;
                applyBtn.innerHTML = originalContent;
                
                // Show error notification
                const errorDiv = document.createElement('div');
                errorDiv.className = 'fixed top-4 right-4 bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg z-50 animate-fade-in';
                errorDiv.innerHTML = `
                    <div class="flex items-center gap-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        <div>
                            <p class="font-semibold">Error!</p>
                            <p class="text-sm">${error.message}</p>
                        </div>
                    </div>
                `;
                document.body.appendChild(errorDiv);

                // Remove notification after 5 seconds
                setTimeout(() => {
                    errorDiv.remove();
                }, 5000);
            });
        }
    </script>
    @endif
    @endauth
</x-app-layout>
