<x-app-layout>
    <x-slot:title>{{ __('My Proposals - Inofa') }}</x-slot:title>
    <section class="min-h-screen flex">

        <!-- ===== SIDEBAR ===== -->
        @include('partials.global-sidebar')

        <!-- ===== MAIN CONTENT ===== -->
        <div class="flex-1 lg:ml-[18rem]">

            <!-- MAIN CONTENT AREA -->
            <div class="mt-16">

                <!-- HEADER SECTION -->
                <div class="p-8 pb-16 border-b-[0.5px] border-neutral-100 bg-neutral-0">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-h-3 font-bold text-neutral-900">My Proposals</h1>
                            <p class="mt-1 text-b-1 text-neutral-600">Track your pending and accepted project proposals
                            </p>
                        </div>

                        <a href="{{ route('search.projects') }}"
                            class="inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-primary-500 text-neutral-0
                                hover:bg-primary-600 hover:scale-[1.02] active:scale-[0.98]
                                [box-shadow:inset_0_2px_4px_0_rgba(0,0,0,0.06),0_4px_12px_rgba(16,138,0,0.25)]
                                transition-all duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <span class="text-b-1 font-light">Browse Projects</span>
                        </a>
                    </div>

                    <!-- Stats Summary -->
                    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="bg-blue-50 rounded-xl border border-blue-200 p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl bg-blue-500 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-b-3 text-blue-600">Pending Proposals</p>
                                    <p class="text-h-4 font-bold text-blue-900">{{ $pendingCount }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-green-50 rounded-xl border border-green-200 p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl bg-green-500 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-b-3 text-green-600">Accepted Proposals</p>
                                    <p class="text-h-4 font-bold text-green-900">{{ $acceptedCount }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- PROPOSALS LIST -->
                <div class="p-8 bg-neutral-10/50">
                    @if ($proposals->isEmpty())
                        <!-- Empty State -->
                        <div class="bg-white rounded-2xl border border-neutral-200 p-12 text-center">
                            <div
                                class="w-20 h-20 rounded-full bg-neutral-100 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-10 h-10 text-neutral-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h3 class="text-h-5 font-bold text-neutral-900 mb-2">No Proposals Yet</h3>
                            <p class="text-b-1 text-neutral-600 mb-6">You haven't submitted any proposals. Start browsing
                                open projects!</p>
                            <a href="{{ route('search.projects') }}"
                                class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-primary-500 text-white text-b-1 font-medium rounded-xl hover:bg-primary-600 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Browse Projects
                            </a>
                        </div>
                    @else
                        <!-- Proposals Grid -->
                        <div class="space-y-4">
                            @foreach ($proposals as $proposal)
                                <div
                                    class="bg-white rounded-2xl border border-neutral-200 p-6 hover:shadow-lg transition">
                                    <div class="flex items-start justify-between gap-6">

                                        <!-- Left Content -->
                                        <div class="flex-1">
                                            <!-- Header with Status Badge -->
                                            <div class="flex items-start gap-3 mb-4">
                                                @php
                                                    $avatarSrc = $proposal->consumer->getRawOriginal('avatar')
                                                        ? (filter_var($proposal->consumer->getRawOriginal('avatar'), FILTER_VALIDATE_URL)
                                                            ? $proposal->consumer->getRawOriginal('avatar')
                                                            : asset('storage/' . $proposal->consumer->getRawOriginal('avatar')))
                                                        : 'https://ui-avatars.com/api/?name=' . urlencode($proposal->consumer->name);
                                                @endphp
                                                <img src="{{ $avatarSrc }}"
                                                    alt="{{ $proposal->consumer->name }}"
                                                    class="w-12 h-12 rounded-full object-cover border-2 border-neutral-200">
                                                <div class="flex-1">
                                                    <div class="flex items-start justify-between gap-2">
                                                        <div>
                                                            <h3 class="text-h-5 font-semibold text-neutral-900">
                                                                {{ $proposal->project->title }}
                                                            </h3>
                                                            <p class="text-b-2 text-neutral-600">Client:
                                                                {{ $proposal->consumer->name }}</p>
                                                        </div>
                                                        @if ($proposal->status === 'pending')
                                                            <span
                                                                class="px-4 py-2 bg-blue-100 text-blue-600 text-b-3 font-medium rounded-xl flex items-center gap-1">
                                                                <svg class="w-4 h-4" fill="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path
                                                                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                                                                </svg>
                                                                Pending Review
                                                            </span>
                                                        @elseif($proposal->status === 'accepted')
                                                            <span
                                                                class="px-4 py-2 bg-green-100 text-green-600 text-b-3 font-medium rounded-xl flex items-center gap-1">
                                                                <svg class="w-4 h-4" fill="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path
                                                                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                                                                </svg>
                                                                Accepted
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Project Description -->
                                            @if ($proposal->project->description)
                                                <p class="text-b-2 text-neutral-600 mb-4 line-clamp-2">
                                                    {{ Str::limit($proposal->project->description, 150) }}
                                                </p>
                                            @endif

                                            <!-- Proposal Details Grid -->
                                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                                                <!-- Proposed Price -->
                                                <div class="bg-primary-50 rounded-lg p-3">
                                                    <p class="text-b-4 text-primary-600 mb-1">Your Proposal</p>
                                                    <p class="text-b-1 font-bold text-primary-900">
                                                        Rp.{{ number_format($proposal->final_price, 0) }}
                                                    </p>
                                                </div>

                                                <!-- Timeline -->
                                                <div class="bg-neutral-50 rounded-lg p-3">
                                                    <p class="text-b-4 text-neutral-600 mb-1">Timeline</p>
                                                    <p class="text-b-1 font-semibold text-neutral-900">
                                                        {{ $proposal->timeline ?? 'N/A' }}
                                                    </p>
                                                </div>

                                                <!-- Submitted Date -->
                                                <div class="bg-neutral-50 rounded-lg p-3">
                                                    <p class="text-b-4 text-neutral-600 mb-1">Submitted</p>
                                                    <p class="text-b-1 font-semibold text-neutral-900">
                                                        {{ $proposal->created_at->format('M d, Y') }}
                                                    </p>
                                                </div>

                                                <!-- Days Ago -->
                                                <div class="bg-neutral-50 rounded-lg p-3">
                                                    <p class="text-b-4 text-neutral-600 mb-1">Time Ago</p>
                                                    <p class="text-b-1 font-semibold text-neutral-900">
                                                        {{ $proposal->created_at->diffForHumans() }}
                                                    </p>
                                                </div>
                                            </div>

                                            <!-- Cover Letter Preview -->
                                            @if ($proposal->cover_letter)
                                                <div class="bg-neutral-50 rounded-lg p-4">
                                                    <p class="text-b-3 font-medium text-neutral-700 mb-2">Cover Letter:
                                                    </p>
                                                    <p class="text-b-2 text-neutral-600 line-clamp-3">
                                                        {{ $proposal->cover_letter }}
                                                    </p>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Right Actions -->
                                        <div class="flex flex-col items-end gap-3">
                                            <!-- View Project Button -->
                                            <a href="{{ route('search.projects') }}"
                                                class="px-4 py-2 border-2 border-primary-500 text-primary-500 text-b-3 font-medium rounded-lg hover:bg-primary-50 transition flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                    <path
                                                        d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z" />
                                                </svg>
                                                View Project
                                            </a>

                                            <!-- Chat with Client -->
                                            <a href="{{ route('landing', ['id' => $proposal->consumer->id]) }}"
                                                class="px-4 py-2 bg-primary-500 text-white text-b-3 font-medium rounded-lg hover:bg-primary-600 transition flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                    <path
                                                        d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H6l-2 2V4h16v12z" />
                                                </svg>
                                                Message Client
                                            </a>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>
        </div>

    </section>
</x-app-layout>
