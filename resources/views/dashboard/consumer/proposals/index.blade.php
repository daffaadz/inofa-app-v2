<x-app-layout>
    <x-slot:title>{{ __('Proposals - Inofa') }}</x-slot:title>
    <section class="min-h-screen flex bg-neutral-10">

        <!-- ===== SIDEBAR ===== -->
        @include('partials.global-sidebar')

        <!-- ===== MAIN CONTENT ===== -->
        <div class="flex-1 lg:ml-[18rem]">

            <!-- MAIN CONTENT AREA -->
            <div class="mt-16">

                <!-- HEADER SECTION -->
                <div class="px-8 py-8 flex flex-row items-center justify-between bg-white border-b border-neutral-100">
                    <div class="flex items-center gap-4">
                        <a href="{{ route('dashboard') }}"
                            class="p-2 hover:bg-neutral-100 rounded-lg transition group">
                            <svg class="w-6 h-6 text-neutral-600 group-hover:text-neutral-900" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                        </a>
                        <div>
                            <h1 class="text-h-3 font-bold text-neutral-900">Project Proposals</h1>
                            <p class="mt-1 text-b-1 text-neutral-600">Review and manage proposals from developers</p>
                        </div>
                    </div>
                </div>

                <!-- CONTENT -->
                <div class="p-8">

                    @if($projects->isEmpty())
                        <!-- EMPTY STATE - No Projects -->
                        <div class="bg-white rounded-2xl border border-neutral-200 p-12 text-center">
                            <div
                                class="w-16 h-16 rounded-full bg-neutral-100 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-neutral-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <p class="text-h-6 font-bold text-neutral-900 mb-2">No projects yet</p>
                            <p class="text-b-2 text-neutral-600 mb-6 max-w-md mx-auto">
                                You need to post a project first to receive proposals from developers.
                            </p>
                            <a href="{{ route('consumer.project.create') }}"
                                class="inline-flex items-center gap-2 px-6 py-3 bg-primary-500 text-white text-b-2 font-medium rounded-xl hover:bg-primary-600 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Post a Project
                            </a>
                        </div>
                    @else
                        <!-- PROJECT SELECTOR & INFO -->
                        <div class="bg-white rounded-2xl border border-neutral-200 p-6 mb-6">
                            <div class="flex items-start justify-between gap-8">
                                <!-- Project Dropdown -->
                                <div class="flex-1">
                                    <label class="block text-b-3 font-semibold text-neutral-700 mb-2">
                                        Select Project
                                    </label>
                                    <select onchange="window.location.href='{{ route('consumer.proposals.index') }}?project=' + this.value"
                                        class="w-full px-4 py-3 bg-white border border-neutral-200 rounded-xl font-sans text-b-2 text-neutral-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                        @foreach($projects as $project)
                                            <option value="{{ $project->id }}" 
                                                {{ ($selectedProject && $selectedProject->id === $project->id) ? 'selected' : '' }}>
                                                {{ $project->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                @if($selectedProject)
                                    <!-- Project Info -->
                                    <div class="flex-1">
                                        <h3 class="text-b-3 font-semibold text-neutral-700 mb-2">Project Details</h3>
                                        <div class="space-y-2">
                                            <p class="text-b-2 text-neutral-900 font-medium">{{ $selectedProject->title }}</p>
                                            <p class="text-b-3 text-neutral-600 line-clamp-2">{{ $selectedProject->description }}</p>
                                            <div class="flex items-center gap-6 pt-1">
                                                <div class="flex items-center gap-2">
                                                    <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <span class="text-b-3 text-neutral-600">
                                                        Budget: <span class="font-semibold text-neutral-900">Rp{{ number_format($selectedProject->budget, 0, ',', '.') }}</span>
                                                    </span>
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                    <span class="text-b-3 text-neutral-600">
                                                        Posted: <span class="font-semibold text-neutral-900">{{ $selectedProject->created_at->diffForHumans() }}</span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- PROPOSALS LIST -->
                        @if($proposals->isEmpty())
                            <!-- EMPTY STATE - No Proposals -->
                            <div class="bg-white rounded-2xl border border-neutral-200 p-12 text-center">
                                <div
                                    class="w-16 h-16 rounded-full bg-neutral-100 flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-neutral-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <p class="text-h-6 font-bold text-neutral-900 mb-2">No proposals yet</p>
                                <p class="text-b-2 text-neutral-600 max-w-md mx-auto">
                                    No developers have submitted proposals for this project yet. Check back later or share your project to attract more developers.
                                </p>
                            </div>
                        @else
                            <!-- Proposals Header -->
                            <div class="mb-4 flex items-center justify-between">
                                <h3 class="text-h-6 font-bold text-neutral-900">
                                    {{ $proposals->count() }} {{ $proposals->count() === 1 ? 'Proposal' : 'Proposals' }}
                                </h3>
                                @if($selectedProject)
                                    <span class="text-b-3 text-neutral-500">
                                        for "{{ $selectedProject->title }}"
                                    </span>
                                @endif
                            </div>

                            <!-- Proposals Cards -->
                            <div class="grid grid-cols-1 gap-4">
                                @foreach($proposals as $proposal)
                                    <div
                                        class="group bg-white rounded-2xl border border-neutral-200 py-6 px-8 hover:shadow-lg hover:border-primary-200 transition">
                                        
                                        <!-- Project Title Badge -->
                                        <div class="mb-4">
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-primary-50 text-primary-700 rounded-lg text-b-3 font-medium">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                {{ $proposal->project_title }}
                                            </span>
                                        </div>

                                        <!-- Developer Info & Price -->
                                        <div class="flex items-start justify-between mb-4">
                                            <!-- Developer -->
                                            @if($proposal->developer)
                                                <div class="flex items-center gap-3">
                                                    <img src="{{ $proposal->developer->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($proposal->developer->name) }}"
                                                        class="w-12 h-12 rounded-full object-cover ring-2 ring-white shadow-sm">
                                                    <div>
                                                        <p class="text-b-1 font-bold text-neutral-900">
                                                            {{ $proposal->developer->name }}
                                                        </p>
                                                        <p class="text-b-3 text-neutral-600">
                                                            {{ $proposal->developer->developerProfile->headline ?? 'Developer' }}
                                                        </p>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="flex items-center gap-3">
                                                    <div class="w-12 h-12 rounded-full bg-neutral-200"></div>
                                                    <span class="text-b-3 text-neutral-400">Developer not found</span>
                                                </div>
                                            @endif

                                            <!-- Price -->
                                            <div class="text-right">
                                                <p class="text-h-6 font-bold text-neutral-900">
                                                    Rp{{ number_format($proposal->final_price, 0, ',', '.') }}
                                                </p>
                                                <p class="text-xs text-neutral-500">Proposed Price</p>
                                            </div>
                                        </div>

                                        <!-- Proposal Details -->
                                        <div class="mb-4 ml-2">
                                            <h4 class="text-b-2 font-semibold text-neutral-900 mb-2">Project Scope</h4>
                                            <p class="text-b-2 text-neutral-600 line-clamp-3">
                                                {{ $proposal->scope_projects ?? 'No scope details provided.' }}
                                            </p>
                                        </div>

                                        <!-- Project Details Summary -->
                                        <div class="mb-4 grid grid-cols-2 gap-4">
                                            <div class="p-3 bg-neutral-50 rounded-lg">
                                                <p class="text-b-4 text-neutral-500 mb-1">Start Date</p>
                                                <p class="text-b-2 font-semibold text-neutral-900">
                                                    {{ $proposal->start_date ? $proposal->start_date->format('d M Y') : '-' }}
                                                </p>
                                            </div>
                                            <div class="p-3 bg-neutral-50 rounded-lg">
                                                <p class="text-b-4 text-neutral-500 mb-1">End Date</p>
                                                <p class="text-b-2 font-semibold text-neutral-900">
                                                    {{ $proposal->end_date ? $proposal->end_date->format('d M Y') : '-' }}
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Timeline & Actions -->
                                        <div class="flex items-center justify-between pt-4 border-t border-neutral-100">
                                            <span class="text-b-3 text-neutral-400">
                                                Submitted {{ $proposal->created_at->diffForHumans() }}
                                            </span>

                                            <!-- Action Buttons -->
                                            @if($proposal->developer)
                                                <div class="flex items-center gap-2">
                                                    <a href="{{ route('user', ['id' => $proposal->developer->id]) }}"
                                                        class="px-4 py-2 bg-white border border-neutral-300 text-neutral-700 text-b-3 font-medium rounded-lg hover:bg-neutral-50 transition">
                                                        Send Message
                                                    </a>
                                                    <a href="{{ route('consumer.payments.agreement-detail', $proposal->id) }}"
                                                        class="px-4 py-2 bg-primary-500 text-white text-b-3 font-medium rounded-lg hover:bg-primary-600 transition">
                                                        View Proposal
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @endif

                </div>
            </div>
        </div>
    </section>
</x-app-layout>
