<x-app-layout>
    <x-slot:title>{{ __('Dashboard Anda - Inofa') }}</x-slot:title>
    <section class="min-h-screen flex">

        <!-- ===== SIDEBAR ===== -->
        @include('partials.global-sidebar')

        <!-- ===== MAIN CONTENT ===== -->
        <div class="flex-1 ml-[18rem]">

            <!-- MAIN CONTENT AREA -->
            <div class="mt-16">

                <!-- HEADER SECTION -->
                <div
                    class="p-8 pb-16 flex flex-row items-center justify-between border-b-[0.5px] border-neutral-100 bg-neutral-0">
                    <div>
                        <h1 class="text-h-3 font-bold text-neutral-900">My Projects</h1>
                        <p class="mt-1 text-b-1 text-neutral-600">Manage and track all your project collaborations</p>
                    </div>
                </div>

                <!-- ===== KEY STATS GRID ===== -->
                <div class="p-8 bg-neutral-10/50">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">

                        <!-- Total Projects -->
                        <div class="bg-white rounded-2xl border border-neutral-200 p-6 hover:shadow-lg transition">
                            <div class="flex items-start justify-between mb-2">
                                <svg class="w-12 h-auto" viewBox="0 0 48 48" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M0 14C0 6.26801 6.26801 0 14 0H34C41.732 0 48 6.26801 48 14V34C48 41.732 41.732 48 34 48H14C6.26801 48 0 41.732 0 34V14Z"
                                        fill="url(#paint0_linear_total)" />
                                    <path
                                        d="M28 32V16C28 15.4696 27.7893 14.9609 27.4142 14.5858C27.0391 14.2107 26.5304 14 26 14H22C21.4696 14 20.9609 14.2107 20.5858 14.5858C20.2107 14.9609 20 15.4696 20 16V32"
                                        stroke="#108A00" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M32 18H16C14.8954 18 14 18.8954 14 20V30C14 31.1046 14.8954 32 16 32H32C33.1046 32 34 31.1046 34 30V20C34 18.8954 33.1046 18 32 18Z"
                                        stroke="#108A00" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <defs>
                                        <linearGradient id="paint0_linear_total" x1="0" y1="0"
                                            x2="48" y2="48" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#108A00" stop-opacity="0.1" />
                                            <stop offset="1" stop-color="#D2FF00" stop-opacity="0.2" />
                                        </linearGradient>
                                    </defs>
                                </svg>
                                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M9 11H15M12 8V14M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z"
                                        stroke="#108A00" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </div>
                            <p class="text-b-3 text-neutral-500 mb-1">Total Projects</p>
                            <p class="text-h-4 font-bold text-neutral-900">{{ $totalProjects }}</p>
                        </div>

                        <!-- In Progress -->
                        <div class="bg-white rounded-2xl border border-neutral-200 p-6 hover:shadow-lg transition">
                            <div class="flex items-center justify-between mb-2">
                                <div class="w-12 h-12 rounded-2xl bg-blue-100 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-auto text-blue-600"
                                        fill="currentColor" viewBox="0 0 256 256">
                                        <path
                                            d="M184,24H72A16,16,0,0,0,56,40V76a16.07,16.07,0,0,0,6.4,12.8L114.67,128,62.4,167.2A16.07,16.07,0,0,0,56,180v36a16,16,0,0,0,16,16H184a16,16,0,0,0,16-16V180.36a16.09,16.09,0,0,0-6.35-12.77L141.27,128l52.38-39.6A16.05,16.05,0,0,0,200,75.64V40A16,16,0,0,0,184,24Zm0,16V56H72V40Zm0,176H72V180l56-42,56,42.35Zm-56-98L72,76V72H184v3.64Z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-b-3 text-neutral-500 mb-1">In Progress</p>
                            <p class="text-h-4 font-bold text-neutral-900">{{ $inProgressCount }}</p>
                        </div>

                        <!-- Completed -->
                        <div class="bg-white rounded-2xl border border-neutral-200 p-6 hover:shadow-lg transition">
                            <div class="flex items-center justify-between mb-2">
                                <div class="w-12 h-12 rounded-2xl bg-green-100 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-auto text-green-600"
                                        fill="currentColor" viewBox="0 0 256 256">
                                        <path
                                            d="M254.3,107.91,228.78,56.85a16,16,0,0,0-21.47-7.15L182.44,62.13,130.05,48.27a8.14,8.14,0,0,0-4.1,0L73.56,62.13,48.69,49.7a16,16,0,0,0-21.47,7.15L1.7,107.9a16,16,0,0,0,7.15,21.47l27,13.51,55.49,39.63a8.06,8.06,0,0,0,2.71,1.25l64,16a8,8,0,0,0,7.6-2.1l55.07-55.08,26.42-13.21a16,16,0,0,0,7.15-21.46Zm-54.89,33.37L165,113.72a8,8,0,0,0-10.68.61C136.51,132.27,116.66,130,104,122L147.24,80h31.81l27.21,54.41ZM41.53,64,62,74.22,36.43,125.27,16,115.06Zm116,119.13L99.42,168.61l-49.2-35.14,28-56L128,64.28l9.8,2.59-45,43.68-.08.09a16,16,0,0,0,2.72,24.81c20.56,13.13,45.37,11,64.91-5L188,152.66Zm62-57.87-25.52-51L214.47,64,240,115.06Zm-87.75,92.67a8,8,0,0,1-7.75,6.06,8.13,8.13,0,0,1-1.95-.24L80.41,213.33a7.89,7.89,0,0,1-2.71-1.25L51.35,193.26a8,8,0,0,1,9.3-13l25.11,17.94L126,208.24A8,8,0,0,1,131.82,217.94Z">
                                        </path>
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

                    <!-- FILTERS & SEARCH -->
                    <div class="mb-6 flex items-center gap-4">
                        <div class="flex-1 relative">
                            <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-neutral-400"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <input type="text" placeholder="Search projects..."
                                class="w-full pl-12 pr-4 py-3 bg-white border border-neutral-200 rounded-xl font-sans text-b-2 text-neutral-700 placeholder:text-neutral-400 focus:outline-none focus:ring-2 focus:ring-primary-500">
                        </div>
                        <select
                            class="px-6 py-3 bg-white border border-neutral-200 rounded-xl font-sans text-b-2 text-neutral-700 focus:outline-none focus:ring-2 focus:ring-primary-500">
                            <option>All Status</option>
                            <option>Draft</option>
                            <option>Open</option>
                            <option>In Progress</option>
                            <option>Completed</option>
                            <option>Cancelled</option>
                        </select>
                        <select
                            class="px-6 py-3 bg-white border border-neutral-200 rounded-xl font-sans text-b-2 text-neutral-700 focus:outline-none focus:ring-2 focus:ring-primary-500">
                            <option>Newest First</option>
                            <option>Oldest First</option>
                            <option>Budget: High to Low</option>
                            <option>Budget: Low to High</option>
                        </select>
                    </div>

                    <!-- PROJECT LIST -->
                    <div class="space-y-4">
                        @forelse($projects as $project)
                            <div class="bg-white rounded-2xl border border-neutral-200 p-6 hover:shadow-lg transition">
                                <div class="flex items-start justify-between gap-6">

                                    <!-- Left Content -->
                                    <div class="flex-1">
                                        <div class="mb-4">
                                            <h3 class="text-b-1 font-semibold text-neutral-900 mb-2">
                                                {{ $project->title }}</h3>
                                            <p class="text-b-2 text-neutral-600 line-clamp-2">
                                                {{ $project->description }}</p>
                                        </div>

                                        <!-- Tech Stack Tags -->
                                        @if ($project->skills->count() > 0)
                                            <div class="flex flex-wrap gap-2 mb-4">
                                                @foreach ($project->skills->take(3) as $skill)
                                                    <span
                                                        class="px-3 py-1 bg-neutral-100 text-neutral-700 text-b-4 rounded-lg">{{ $skill->name }}</span>
                                                @endforeach
                                                @if ($project->skills->count() > 3)
                                                    <span
                                                        class="px-3 py-1 bg-neutral-100 text-neutral-700 text-b-4 rounded-lg">+{{ $project->skills->count() - 3 }}
                                                        more</span>
                                                @endif
                                            </div>
                                        @endif

                                        <!-- Meta Info -->
                                        <div class="flex items-center gap-4 text-b-3 text-neutral-600">
                                            @if ($project->agreement)
                                                <span class="flex items-center gap-1">
                                                    <img src="{{ $project->agreement->developer->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($project->agreement->developer->name) }}"
                                                        alt="{{ $project->agreement->developer->name }}"
                                                        class="w-5 h-5 rounded-full object-cover">
                                                    {{ $project->agreement->developer->name }}
                                                </span>
                                            @endif

                                            @if ($project->offers_count > 0)
                                                <span class="flex items-center gap-1">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                        <circle cx="12" cy="12" r="8" />
                                                    </svg>
                                                    {{ $project->offers_count }} offers
                                                </span>
                                            @endif

                                            <span class="flex items-center gap-1">
                                                Started: {{ $project->created_at->format('M d, Y') }}
                                            </span>
                                            <span class="flex items-center gap-1">
                                                Deadline:
                                                {{ \Carbon\Carbon::parse($project->deadline)->format('M d, Y') }}
                                            </span>
                                        </div>

                                        <!-- Progress Bar (if in progress) -->
                                        @if ($project->agreement && $project->status === 'in_progress')
                                            <div class="mt-4">
                                                <div class="flex items-center justify-between mb-1">
                                                    <span class="text-b-3 text-neutral-600">Progress:
                                                        {{ $project->progress ?? 0 }}%</span>
                                                </div>
                                                <div class="w-full bg-neutral-200 rounded-full h-2">
                                                    <div class="bg-primary-500 h-2 rounded-full transition-all"
                                                        style="width: {{ $project->progress ?? 0 }}%"></div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Right Content -->
                                    <div class="flex flex-col items-end gap-3">
                                        <!-- Status Badge -->
                                        @php
                                            $statusConfig = [
                                                'draft' => [
                                                    'bg' => 'bg-neutral-100',
                                                    'text' => 'text-neutral-600',
                                                    'label' => 'Draft',
                                                ],
                                                'open' => [
                                                    'bg' => 'bg-blue-100',
                                                    'text' => 'text-blue-600',
                                                    'label' => 'Open',
                                                ],
                                                'in_progress' => [
                                                    'bg' => 'bg-blue-100',
                                                    'text' => 'text-blue-600',
                                                    'label' => 'In Progress',
                                                ],
                                                'completed' => [
                                                    'bg' => 'bg-green-100',
                                                    'text' => 'text-green-600',
                                                    'label' => 'Completed',
                                                ],
                                                'cancelled' => [
                                                    'bg' => 'bg-red-100',
                                                    'text' => 'text-red-600',
                                                    'label' => 'Cancelled',
                                                ],
                                            ];
                                            $status = $statusConfig[$project->status] ?? $statusConfig['draft'];
                                        @endphp
                                        <span
                                            class="px-4 py-2 {{ $status['bg'] }} {{ $status['text'] }} text-b-3 font-medium rounded-full">
                                            {{ $status['label'] }}
                                        </span>

                                        <!-- Budget -->
                                        <div class="text-right">
                                            <p class="text-h-6 font-bold text-neutral-900">
                                                Rp{{ number_format($project->budget, 0, ',', '.') }}</p>
                                            <p class="text-b-3 text-neutral-600">Total budget</p>
                                        </div>

                                        <!-- Actions -->
                                        <div class="flex gap-2 mt-2">
                                            @if ($project->status === 'draft' || $project->status === 'open')
                                                <button class="p-2 hover:bg-neutral-100 rounded-lg transition">
                                                    <svg class="w-5 h-5 text-neutral-600" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </button>
                                            @endif
                                            <button class="p-2 hover:bg-neutral-100 rounded-lg transition">
                                                <svg class="w-5 h-5 text-neutral-600" fill="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <circle cx="12" cy="6" r="2" />
                                                    <circle cx="12" cy="12" r="2" />
                                                    <circle cx="12" cy="18" r="2" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @empty
                            <div class="bg-white rounded-2xl border border-neutral-200 p-12 text-center">
                                <div
                                    class="w-16 h-16 rounded-full bg-neutral-100 flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-neutral-400" fill="currentColor" viewBox="0 0 24 24">
                                        <circle cx="12" cy="12" r="10" />
                                    </svg>
                                </div>
                                <p class="text-b-1 text-neutral-600 mb-2">No projects yet</p>
                                <p class="text-b-3 text-neutral-500 mb-4">Create your first project to get started</p>
                                <a href="{{ route('consumer.project.create') }}"
                                    class="inline-flex items-center gap-2 px-6 py-3 bg-primary-500 text-white text-b-2 font-medium rounded-xl hover:bg-primary-600 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                    Create Project
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>

    </section>

</x-app-layout>
