@extends('layouts.app')

@section('title', 'Inofa – Bring Your Digital Projects to Life')

@section('content')
    {{-- Hero Section --}}
    <section class="relative pt-24 z-10">
        <div class="max-w-8xl mx-4 md:mx-16 py-12 md:py-24 overflow-hidden bg-cover bg-center rounded-xl"
            style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('/assets/images/hero-bg.png');">
            <div class="mx-auto max-w-3xl text-center">
                <h1 class="text-h-2 sm:text-h-1 text-white mb-8">
                    <span class="italic">Bring Your Digital</span> Projects to Life<br>
                    with <span class="text-secondary-500">Expert Developers</span>
                </h1>

                <div
                    class="bg-black/10 border-[0.5px] border-white/40 py-8 rounded-xl backdrop-blur-lg flex flex-col items-center justify-center px-8">
                    {{-- Search Bar --}}
                    <div class="mx-auto w-full mb-6">
                        <div class="relative">
                            <input type="text" placeholder="Search for any service..."
                                class="w-full px-6 py-4 pr-12 text-b-1 rounded-full border-0 focus:ring-2 focus:ring-primary-500">
                            <button
                                class="absolute right-3 top-1/2 -translate-y-1/2 bg-neutral-1000 text-white p-2 rounded-full hover:bg-neutral-800 transition">
                                {{-- Search icon SVG --}}
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Create Project Button --}}
                    <div class="flex flex-col items-center justify-center gap-4 text-white w-full text-b-2">
                        <div class="flex items-center gap-4 w-full">
                            <div class="flex-1 border-t border-neutral-10"></div>
                            <span class="whitespace-nowrap text-neutral-0">or</span>
                            <div class="flex-1 border-t border-neutral-10"></div>
                        </div>
                        <button
                            class="px-6 py-3 bg-transparent w-full border-[1px] border-white rounded-lg hover:bg-white hover:text-neutral-1000 transition font-medium">
                            Create a new project request
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Service Categories --}}
        <div class="my-16 max-w-8xl mx-4 md:mx-16">
            <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-4">
                {{-- Full-stack Developer --}}
                <a href="#"
                    class="flex flex-col items-center p-4 bg-white rounded-xl hover:shadow-lg transition group border border-primary-500">
                    {{-- Icon: Tree/Stack SVG - replace with actual icon --}}
                    <div class="w-12 h-12 mb-3 text-primary-500">
                        <img src='{{ asset('assets/vector/fs_logo.svg') }}' alt="">
                    </div>
                    <span class="text-b-1 text-center font-medium">Hire Full-stack Developer</span>
                </a>

                {{-- Front-end Developer --}}
                <a href="#"
                    class="flex flex-col items-center p-4 bg-white rounded-xl hover:shadow-lg transition group border border-primary-500">
                    <div class="w-12 h-12 mb-3 text-primary-500">
                        <img src='{{ asset('assets/vector/fe_logo.svg') }}' alt="">
                    </div>
                    <span class="text-b-1 text-center font-medium">Hire Front-end Developer</span>
                </a>

                {{-- Back-end Developer --}}
                <a href="#"
                    class="flex flex-col items-center p-4 bg-white rounded-xl hover:shadow-lg transition group border border-primary-500">
                    <div class="w-12 h-12 mb-3 text-primary-500">
                        <img src='{{ asset('assets/vector/be_logo.svg') }}' alt="">
                    </div>
                    <span class="text-b-1 text-center font-medium">Hire Back-end Developer</span>
                </a>

                {{-- Mobile Developer --}}
                <a href="#"
                    class="flex flex-col items-center p-4 bg-white rounded-xl hover:shadow-lg transition group border border-primary-500">
                    <div class="w-12 h-12 mb-3 text-primary-500">
                        <img src='{{ asset('assets/vector/md_logo.svg') }}' alt="">
                    </div>
                    <span class="text-b-1 text-center font-medium">Hire Mobile Developer</span>
                </a>

                {{-- UI/UX Designer --}}
                <a href="#"
                    class="flex flex-col items-center p-4 bg-white rounded-xl hover:shadow-lg transition group border border-primary-500">
                    <div class="w-12 h-12 mb-3 text-primary-500">
                        <img src='{{ asset('assets/vector/ui_logo.svg') }}' alt="">
                    </div>
                    <span class="text-b-1 text-center font-medium">Hire UI/UX</span>
                </a>

                {{-- Game Developer --}}
                <a href="#"
                    class="flex flex-col items-center p-4 bg-white rounded-xl hover:shadow-lg transition group border border-primary-500">
                    <div class="w-12 h-12 mb-3 text-primary-500">
                        <img src='{{ asset('assets/vector/gd_logo.svg') }}' alt="">
                    </div>
                    <span class="text-b-1 text-center font-medium">Hire Game Developer</span>
                </a>

                {{-- DevOps Engineer --}}
                <a href="#"
                    class="flex flex-col items-center p-4 bg-white rounded-xl hover:shadow-lg transition group border border-primary-500">
                    <div class="w-12 h-12 mb-3 text-primary-500">
                        <img src='{{ asset('assets/vector/de_logo.svg') }}' alt="">
                    </div>
                    <span class="text-b-1 text-center font-medium">Hire DevOps Engineer</span>
                </a>

                {{-- Data Analyst --}}
                <a href="#"
                    class="flex flex-col items-center p-4 bg-white rounded-xl hover:shadow-lg transition group border border-primary-500">
                    <div class="w-12 h-12 mb-3 text-primary-500">
                        <img src='{{ asset('assets/vector/da_logo.svg') }}' alt="">
                    </div>
                    <span class="text-b-1 text-center font-medium">Hire Data Analyst</span>
                </a>
            </div>
        </div>
    </section>

    {{-- Hire Top Developers --}}
    <section class="py-16">
        <div class="mx-4 md:mx-16 max-w-8xl">
            <h2 class="text-h-3 text-neutral-1000 mb-12">Hire Top Developers</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @php
                    // Get 4 top developers with profiles
                    $developers = \App\Models\User::with(['developerProfile.skills'])
                        ->where('role', 'developer')
                        ->whereHas('developerProfile')
                        ->join('developer_profiles', 'users.id', '=', 'developer_profiles.user_id')
                        ->where('developer_profiles.availability', '!=', 'unavailable')
                        ->orderByDesc('developer_profiles.rating_average')
                        ->select('users.*')
                        ->limit(4)
                        ->get();
                @endphp

                @forelse($developers as $developer)
                    <div
                        class="bg-white rounded-xl p-6 shadow-xl hover:shadow-2xl hover:scale-105 border-[0.2px] border-neutral-800 transition-all">
                        <div class="flex items-start gap-4 mb-4">
                            {{-- Profile Image --}}
                            @if ($developer->avatar)
                                @php
                                    $src = $developer->avatar
                                        ? (Str::startsWith($developer->avatar, 'http')
                                            ? $developer->avatar
                                            : asset('storage/' . $developer->avatar))
                                        : 'https://ui-avatars.com/api/?name=' .
                                            urlencode($developer->name) .
                                            '&size=56';
                                @endphp

                                <img src="{{ $src }}" alt="{{ $developer->name }}"
                                    class="w-14 h-14 rounded-full object-cover">
                            @else
                                <div
                                    class="w-14 h-14 rounded-full bg-primary-200 flex items-center justify-center text-primary-700 font-semibold text-b-1">
                                    {{ substr($developer->name, 0, 2) }}
                                </div>
                            @endif
                            <div>
                                <h3 class="text-b-1 font-semibold text-neutral-1000">{{ $developer->name }}</h3>
                                @if ($developer->location)
                                    <div class="flex items-center gap-1 text-b-3 text-neutral-500">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span>{{ $developer->location }}</span>
                                    </div>
                                @endif
                                @if ($developer->developerProfile)
                                    <div class="flex items-center gap-1 mt-1">
                                        @for ($j = 0; $j < 5; $j++)
                                            <svg class="w-4 h-4 {{ $j < floor($developer->developerProfile->rating_average) ? 'text-secondary-500' : 'text-neutral-300' }}"
                                                fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @endfor
                                        <span class="text-b-3 text-neutral-500 ml-1">
                                            {{ number_format($developer->developerProfile->rating_average, 1) }}
                                            ({{ $developer->developerProfile->rating_count }})
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        @if ($developer->developerProfile && $developer->developerProfile->headline)
                            <p class="text-b-2 text-neutral-600 mb-4 line-clamp-3">
                                {{ $developer->developerProfile->headline }}
                            </p>
                        @elseif($developer->bio)
                            <p class="text-b-2 text-neutral-600 mb-4 line-clamp-3">
                                {{ $developer->bio }}
                            </p>
                        @else
                            <p class="text-b-2 text-neutral-600 mb-4 line-clamp-3">
                                Professional developer with {{ $developer->developerProfile->experience_years ?? 0 }}+
                                years of experience.
                            </p>
                        @endif

                        <div class="mb-4">
                            @if ($developer->developerProfile && $developer->developerProfile->skills->isNotEmpty())
                                <h4 class="text-b-3 font-semibold text-neutral-1000 mb-2">Top Skills</h4>
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($developer->skills->take(3) as $skill)
                                        <span class="px-3 py-1 bg-neutral-100 text-neutral-700 rounded-full text-b-3">
                                            {{ $skill->name }}
                                        </span>
                                    @endforeach
                                </div>
                            @elseif($developer->developerProfile && $developer->developerProfile->projects_completed > 0)
                                <div class="flex items-center gap-2 text-b-3 text-neutral-600">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                        <path fill-rule="evenodd"
                                            d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span>{{ $developer->developerProfile->projects_completed }} projects completed</span>
                                </div>
                            @endif

                            @if ($developer->developerProfile && $developer->developerProfile->rate_min_byproject)
                                <div class="flex items-center gap-2 text-b-3 text-neutral-600 mt-2">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span>Rp{{ number_format($developer->developerProfile->rate_min_byproject, 0, ',', '.') }}
                                        -
                                        Rp{{ number_format($developer->developerProfile->rate_max_byproject, 0, ',', '.') }}/project</span>
                                </div>
                            @endif
                        </div>

                        <a href="{{ route('landing', $developer->id) }}"
                            class="block w-full py-3 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition font-medium text-b-1 text-center">
                            View Full Profile
                        </a>
                    </div>
                @empty
                    {{-- Fallback if no developers --}}
                    <div class="col-span-full text-center py-12">
                        <p class="text-b-1 text-neutral-500">No developers available at the moment.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- Connecting Developers and Clients --}}
    <section class="py-16 bg-white">
        <div class="mx-4 md:mx-16 max-w-8xl">
            <h2 class="text-h-3 text-neutral-1000 mb-12">Connecting Developers and Clients</h2>

            <div class="grid grid-cols-1 lg:grid-cols-4">
                {{-- Search Card - Left Side --}}
                <div class="flex flex-col rounded-l-xl p-8 justify-center border-l border-y border-neutral-200">
                    <div class="space-y-4">
                        <h3 class="text-b-2 text-neutral-500 font-medium">Search</h3>
                        <h4 class="text-h-6 text-neutral-1000 leading-tight">Find the Right Developer for Your Needs</h4>
                        <p class="text-b-2 text-neutral-600">
                            Search by type of software, skills, location, and experience
                        </p>
                        <a href="#"
                            class="inline-flex items-center text-primary-500 font-medium text-b-1 hover:text-primary-600 group">
                            Explore
                            <svg class="w-5 h-5 ml-1 group-hover:translate-x-1 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>

                {{-- Main Image - Center --}}
                <div class="lg:mr-8">
                    <div class="rounded-r-xl border-r border-y border-neutral-200 overflow-hidden h-full">
                        <img src="{{ asset('assets/images/placeholder_search.jpg') }}" alt="Developers collaborating"
                            class="w-full h-full object-cover">
                    </div>
                </div>

                {{-- Right Side Cards --}}
                <div class="col-span-2 grid grid-cols-2 gap-8">
                    {{-- Project Management Card --}}
                    <div class="space-y-4 flex flex-col justify-between  border border-neutral-200 rounded-xl">
                        <div class="p-8">
                            <span class="text-b-3 text-neutral-500 uppercase tracking-wide font-medium">Projects</span>
                            <h4 class="text-h-7 text-neutral-1000 mt-1 mb-2">Project Management</h4>
                            <p class="text-b-2 text-neutral-600 mb-3">
                                Manage tasks and communication in one platform
                            </p>
                            <a href="#"
                                class="inline-flex items-center text-primary-500 font-medium text-b-2 hover:text-primary-600 group">
                                Explore
                                <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                        <div class="rounded-b-xl overflow-hidden">
                            <img src="{{ asset('assets/images/placeholder_management.jpg') }}" alt="Project Management"
                                class="w-full h-40 object-cover">
                        </div>
                    </div>

                    {{-- Chat Card --}}
                    <div class="space-y-4 flex flex-col justify-between border border-neutral-200 rounded-xl">
                        <div class="p-8">
                            <span class="text-b-3 text-neutral-500 uppercase tracking-wide font-medium">Chat</span>
                            <h4 class="text-h-7 text-neutral-1000 mt-1 mb-2">Real-Time Chat</h4>
                            <p class="text-b-2 text-neutral-600 mb-3">
                                Communicate with developers in real time
                            </p>
                            <a href="#"
                                class="inline-flex items-center text-primary-500 font-medium text-b-2 hover:text-primary-600 group">
                                Explore
                                <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                        <div class="rounded-b-xl overflow-hidden">
                            <img src="{{ asset('assets/images/placeholder_chat.jpg') }}" alt="Real-Time Chat"
                                class="w-full h-40 object-cover">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- How it works --}}
    <section class="py-16">
        <div class="mx-4 md:mx-16 max-w-8xl">
            <div class="flex items-center justify-between mb-12">
                <h2 class="text-h-3 text-neutral-1000">How it works</h2>
                <div class="flex gap-2">
                    <button
                        class="px-4 py-2 border-2 border-neutral-300 rounded-full text-b-2 font-medium hover:border-primary-500 hover:text-primary-500 transition">
                        For Hiring
                    </button>
                    <button
                        class="px-4 py-2 border-2 border-neutral-300 rounded-full text-b-2 font-medium hover:border-primary-500 hover:text-primary-500 transition">
                        For finding work
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                {{-- Step 1 --}}
                <div class="text-center">
                    <div class="w-24 h-24 mx-auto mb-6">
                        {{-- Illustration: Post a job --}}
                        <img src="{{ asset('assets/images/how-it-works/1.png') }}" alt="Post a job"
                            class="w-full h-full">
                    </div>
                    <h3 class="text-h-7 text-neutral-1000 mb-3">Search or Post a job</h3>
                    <p class="text-b-2 text-neutral-600">
                        Tell us what you need. Describe your project idea or task to help us find or match you with the
                        right talent.
                    </p>
                </div>

                {{-- Step 2 --}}
                <div class="text-center">
                    <div class="w-24 h-24 mx-auto mb-6">
                        {{-- Illustration: Hire talent --}}
                        <img src="{{ asset('assets/images/how-it-works/2.png') }}" alt="Hire talent"
                            class="w-full h-full">
                    </div>
                    <h3 class="text-h-7 text-neutral-1000 mb-3">Hire top talent fast</h3>
                    <p class="text-b-2 text-neutral-600">
                        Connect, interview, and hire in no time. We give you talented freelancers that best fit your needs.
                    </p>
                </div>

                {{-- Step 3 --}}
                <div class="text-center">
                    <div class="w-24 h-24 mx-auto mb-6">
                        {{-- Illustration: Collaborate --}}
                        <img src="{{ asset('assets/images/how-it-works/3.png') }}" alt="Collaborate"
                            class="w-full h-full">
                    </div>
                    <h3 class="text-h-7 text-neutral-1000 mb-3">Collaborate easily</h3>
                    <p class="text-b-2 text-neutral-600">
                        Use Inofa's chat, share docs, give work status progress right from the job dashboard.
                    </p>
                </div>

                {{-- Step 4 --}}
                <div class="text-center">
                    <div class="w-24 h-24 mx-auto mb-6">
                        {{-- Illustration: Payment --}}
                        <img src="{{ asset('assets/images/how-it-works/4.png') }}" alt="Payment" class="w-full h-full">
                    </div>
                    <h3 class="text-h-7 text-neutral-1000 mb-3">Payment simplified</h3>
                    <p class="text-b-2 text-neutral-600">
                        Manage payments in one place using multiple payment gateways with flexibility of daily or by
                        milestone.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Testimonials --}}
    <section class="py-16 bg-radial-green-to-white">
        <div class="mx-4 md:mx-16 max-w-8xl">
            <h2 class="text-h-3 text-neutral-1000 mb-12">Real results from clients</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @php
                    // Get 3 random public reviews with relationships
                    $reviews = \App\Models\Review::with(['consumer', 'developer', 'project'])
                        ->where('is_public', true)
                        ->whereHas('consumer')
                        ->whereHas('developer')
                        ->inRandomOrder()
                        ->limit(3)
                        ->get();
                @endphp

                @forelse($reviews as $review)
                    <div class="bg-white/90 shadow-xl backdrop-blur-lg rounded-xl p-8">
                        <div class="mb-6">
                            <svg class="w-10 h-10 text-primary-500 mb-4" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                            </svg>
                            <p class="text-b-1 text-neutral-800 leading-relaxed">
                                "{{ Str::limit($review->comment ?? 'Great experience working together!', 150) }}"
                            </p>
                        </div>

                        <div class="flex items-center gap-1 mb-4">
                            @for ($i = 0; $i < 5; $i++)
                                <svg class="w-5 h-5 {{ $i < $review->rating ? 'text-secondary-500' : 'text-neutral-300' }}"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            @endfor
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t border-neutral-200">
                            <div>
                                <p class="text-b-2 font-semibold text-neutral-1000">Work done by:
                                    {{ $review->developer->name ?? 'Developer' }}</p>
                                <p class="text-b-3 text-neutral-600">For: {{ $review->consumer->name ?? 'Client' }}</p>
                                <p class="text-b-3 text-neutral-500">{{ $review->created_at->format('M d, Y') }}</p>
                            </div>
                            @if ($review->consumer && $review->consumer->avatar)
                                <img src="{{ asset('storage/' . $review->consumer->avatar) }}"
                                    alt="{{ $review->consumer->name }}" class="w-12 h-12 rounded-full object-cover">
                            @else
                                <div
                                    class="w-12 h-12 rounded-full bg-primary-200 flex items-center justify-center text-primary-700 font-semibold">
                                    {{ $review->consumer ? substr($review->consumer->name, 0, 1) : 'C' }}
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    {{-- Fallback if no reviews --}}
                    <div class="bg-white/90 backdrop-blur-lg shadow-xl rounded-xl p-8">
                        <div class="mb-6">
                            <svg class="w-10 h-10 text-primary-500 mb-4" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                            </svg>
                            <p class="text-b-1 text-neutral-800 leading-relaxed">
                                "Inofa came in and helped us transfer knowledge from one departing developer, meeting a
                                serious deadline, without fail. His knowledge and experience are exceptional."
                            </p>
                        </div>
                        <div class="flex items-center gap-1 mb-4">
                            @for ($i = 0; $i < 5; $i++)
                                <svg class="w-5 h-5 text-secondary-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            @endfor
                        </div>
                        <div class="flex items-center justify-between pt-4 border-t border-neutral-200">
                            <div>
                                <p class="text-b-2 font-semibold text-neutral-1000">Work done by: Sarah K.</p>
                                <p class="text-b-3 text-neutral-600">Full Stack Developer</p>
                                <p class="text-b-3 text-neutral-500">Apr 1, 2025</p>
                            </div>
                            <div
                                class="w-12 h-12 rounded-full bg-primary-200 flex items-center justify-center text-primary-700 font-semibold">
                                S
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="my-16">
        <div
            class="mx-4 md:mx-16 max-w-8xl bg-gradient-to-br from-primary-400 to-primary-500 rounded-2xl px-6 py-16 sm:py-20 text-center">
            <h2 class="text-h-2 text-white mb-8">Ready to Build Something Amazing?</h2>
            <button
                class="px-8 py-4 bg-white text-primary-500 rounded-lg hover:bg-neutral-100 transition font-semibold text-b-1 shadow-lg">
                Hire Talent
            </button>
        </div>
    </section>
@endsection
