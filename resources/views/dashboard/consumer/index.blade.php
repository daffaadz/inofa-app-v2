<x-app-layout>
    <x-slot:title>{{ __('My Dashboard - Inofa') }}</x-slot:title>
    <section class="min-h-screen flex bg-neutral-10">

        <!-- ===== SIDEBAR ===== -->
        @include('partials.global-sidebar')

        <!-- ===== MAIN CONTENT ===== -->
        <div class="flex-1 ml-[18rem]">

            <!-- MAIN CONTENT AREA -->
            <div class="mt-16">

                <!-- HEADER SECTION -->
                <div class="px-8 py-8 flex flex-row items-center justify-between bg-white border-b border-neutral-100">
                    <div>
                        <h1 class="text-h-3 font-bold text-neutral-900">My Projects</h1>
                        <p class="mt-1 text-b-1 text-neutral-600">Manage and track all your project collaborations</p>
                    </div>
                    <a href="{{ route('consumer.project.create') }}"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary-500 text-white text-b-2 font-medium rounded-xl hover:bg-primary-600 transition shadow-sm hover:shadow-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Post New Project
                    </a>
                </div>

                <!-- ===== KEY STATS GRID ===== -->
                <div class="p-8">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">

                        <!-- Total Projects -->
                        <div class="bg-white rounded-2xl border border-neutral-200 p-6 hover:shadow-md transition">
                            <div class="flex items-start justify-between mb-2">
                                <div class="p-3 bg-primary-50 rounded-xl">
                                    <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                </div>
                            </div>
                            <p class="text-b-3 text-neutral-500 mb-1">Total Project</p>
                            <p class="text-h-4 font-bold text-neutral-900">{{ $totalProjects }}</p>
                        </div>

                        <!-- In Progress -->
                        <div class="bg-white rounded-2xl border border-neutral-200 p-6 hover:shadow-md transition">
                            <div class="flex items-center justify-between mb-2">
                                <div class="p-3 bg-blue-50 rounded-xl">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <p class="text-b-3 text-neutral-500 mb-1">In Progress</p>
                            <p class="text-h-4 font-bold text-neutral-900">{{ $inProgressCount }}</p>
                        </div>

                        <!-- Completed -->
                        <div class="bg-white rounded-2xl border border-neutral-200 p-6 hover:shadow-md transition">
                            <div class="flex items-center justify-between mb-2">
                                <div class="p-3 bg-green-50 rounded-xl">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <p class="text-b-3 text-neutral-500 mb-1">Completed</p>
                            <p class="text-h-4 font-bold text-neutral-900">{{ $completedCount }}</p>
                        </div>

                        <!-- Total Spent -->
                        <div
                            class="bg-gradient-to-br from-primary-100 to-primary-200 rounded-2xl border-[3px] border-primary-400 p-6 hover:shadow-lg transition">
                            <div class="flex items-center justify-between mb-2">
                                <div class="w-12 h-12 rounded-2xl bg-primary-500 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-auto text-white"
                                        fill="currentColor" viewBox="0 0 256 256">
                                        <path
                                            d="M128,88a40,40,0,1,0,40,40A40,40,0,0,0,128,88Zm0,64a24,24,0,1,1,24-24A24,24,0,0,1,128,152ZM240,56H16a8,8,0,0,0-8,8V192a8,8,0,0,0,8,8H240a8,8,0,0,0,8-8V64A8,8,0,0,0,240,56ZM193.65,184H62.35A56.78,56.78,0,0,0,24,145.65v-35.3A56.78,56.78,0,0,0,62.35,72h131.3A56.78,56.78,0,0,0,232,110.35v35.3A56.78,56.78,0,0,0,193.65,184ZM232,93.37A40.81,40.81,0,0,1,210.63,72H232ZM45.37,72A40.81,40.81,0,0,1,24,93.37V72ZM24,162.63A40.81,40.81,0,0,1,45.37,184H24ZM210.63,184A40.81,40.81,0,0,1,232,162.63V184Z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-b-3 text-primary-700 mb-1">Total Spent</p>
                            <p class="text-h-4 font-bold text-primary-900">
                                Rp{{ number_format($totalSpent, 0, ',', '.') }}</p>
                        </div>

                    </div>

                    <!-- FILTERS -->
                    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
                        <h3 class="text-h-6 font-bold text-neutral-900">Active Works & Postings</h3>
                        <div class="flex gap-3">
                            <select
                                class="px-4 py-2.5 bg-white border border-neutral-200 rounded-xl font-sans text-b-2 text-neutral-700 focus:outline-none focus:ring-2 focus:ring-primary-500">
                                <option>All Status</option>
                                <option>Active Contract</option>
                                <option>Bidding Phase</option>
                                <option>Completed</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-6">

                        {{-- 1. LOOP AGREEMENTS (CONTRACTS) --}}
                        @foreach ($agreements as $agreement)
                            <div
                                class="group bg-white rounded-2xl border border-neutral-200 p-6 hover:shadow-lg hover:border-primary-200 transition relative overflow-hidden">
                                {{-- Indicator Line --}}
                                <div
                                    class="absolute left-0 top-0 bottom-0 w-1 
                                    {{ $agreement->status === 'active' ? 'bg-green-500' : ($agreement->status === 'completed' ? 'bg-blue-500' : 'bg-yellow-500') }}">
                                </div>

                                <div class="flex justify-between items-start mb-4 pl-2">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-2">
                                            <span
                                                class="px-3 py-1 text-xs font-bold uppercase tracking-wider rounded-full 
                                                {{ $agreement->status === 'active'
                                                    ? 'bg-green-100 text-green-700'
                                                    : ($agreement->status === 'completed'
                                                        ? 'bg-blue-100 text-blue-700'
                                                        : 'bg-yellow-100 text-yellow-700') }}">
                                                {{ str_replace('_', ' ', $agreement->status) }}
                                            </span>
                                            <span class="text-xs text-neutral-400">Contract
                                                #{{ substr($agreement->id, 0, 8) }}</span>
                                        </div>
                                        <h3
                                            class="text-h-6 font-bold text-neutral-900 group-hover:text-primary-600 transition">
                                            {{ $agreement->project_title }}
                                        </h3>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-b-2 font-bold text-neutral-900">
                                            Rp{{ number_format($agreement->final_price, 0, ',', '.') }}
                                        </p>
                                        <p class="text-xs text-neutral-500">Agreed Price</p>
                                    </div>
                                </div>

                                <div class="pl-2 mb-6">
                                    <p class="text-b-2 text-neutral-600 line-clamp-2">
                                        {{ $agreement->scope_projects ?? 'No detailed scope provided.' }}
                                    </p>
                                </div>

                                <div class="pl-2 flex items-center justify-between pt-4 border-t border-neutral-100">
                                    <!-- Developer Info -->
                                    <div class="flex items-center gap-3">
                                        @if ($agreement->developer)
                                            <img src="{{ $agreement->developer->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($agreement->developer->name) }}"
                                                class="w-8 h-8 rounded-full object-cover ring-2 ring-white shadow-sm">
                                            <div>
                                                <p class="text-b-3 font-bold text-neutral-900">
                                                    {{ $agreement->developer->name }}</p>
                                                <p class="text-xs text-neutral-500">Developer</p>
                                            </div>
                                        @else
                                            <span class="text-xs text-neutral-400">Developer account deleted</span>
                                        @endif
                                    </div>

                                    <a href="#"
                                        class="px-4 py-2 bg-neutral-900 text-white text-b-3 font-medium rounded-lg hover:bg-neutral-800 transition">
                                        Manage Work
                                    </a>
                                </div>
                            </div>
                        @endforeach

                        {{-- 2. LOOP PROJECTS (BIDDING PHASE) --}}
                        @foreach ($projects as $project)
                            <div
                                class="group bg-white rounded-2xl border border-neutral-200 p-6 hover:shadow-lg transition">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <div class="flex items-center gap-2 mb-2">
                                            <span
                                                class="px-3 py-1 text-xs font-bold uppercase tracking-wider rounded-full bg-neutral-100 text-neutral-600">
                                                Open Bidding
                                            </span>
                                            <span class="text-xs text-neutral-400">
                                                Posted {{ $project->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                        <h3
                                            class="text-h-6 font-bold text-neutral-900 group-hover:text-primary-600 transition">
                                            {{ $project->title }}
                                        </h3>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-b-2 font-bold text-neutral-900">
                                            Rp{{ number_format($project->budget, 0, ',', '.') }}
                                        </p>
                                        <p class="text-xs text-neutral-500">Est. Budget</p>
                                    </div>
                                </div>

                                <div class="mb-6">
                                    <p class="text-b-2 text-neutral-600 line-clamp-2">
                                        {{ $project->description }}
                                    </p>
                                </div>

                                <!-- Skills Tags -->
                                @if ($project->skills->count() > 0)
                                    <div class="flex flex-wrap gap-2 mb-4">
                                        @foreach ($project->skills->take(3) as $skill)
                                            <span
                                                class="px-2.5 py-1 bg-neutral-50 text-neutral-600 text-xs rounded-md border border-neutral-100">
                                                {{ $skill->name }}
                                            </span>
                                        @endforeach
                                        @if ($project->skills->count() > 3)
                                            <span
                                                class="px-2.5 py-1 text-neutral-400 text-xs">+{{ $project->skills->count() - 3 }}</span>
                                        @endif
                                    </div>
                                @endif

                                <div class="flex items-center justify-between pt-4 border-t border-neutral-100">
                                    <div class="flex items-center gap-2 text-neutral-600">
                                        <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        <span class="text-b-2 font-medium">{{ $project->offers_count }}
                                            Proposals</span>
                                    </div>

                                    <a href="{{ route('consumer.project.show', $project->id) }}"
                                        class="px-4 py-2 border border-neutral-200 text-neutral-700 text-b-3 font-medium rounded-lg hover:bg-neutral-50 hover:border-neutral-300 transition">
                                        View Proposals
                                    </a>
                                </div>
                            </div>
                        @endforeach

                    </div>

                    <!-- EMPTY STATE -->
                    @if ($projects->isEmpty() && $agreements->isEmpty())
                        <div class="bg-white rounded-2xl border border-neutral-200 p-12 text-center mt-4">
                            <div
                                class="w-16 h-16 rounded-full bg-neutral-100 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-neutral-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                </svg>
                            </div>
                            <p class="text-h-6 font-bold text-neutral-900 mb-2">No projects yet</p>
                            <p class="text-b-2 text-neutral-600 mb-6 max-w-md mx-auto">
                                You haven't posted any projects or started any contracts yet. Post a project to get
                                started!
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
                    @endif

                </div>
            </div>
        </div>
    </section>
</x-app-layout>
