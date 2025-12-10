<x-app-layout>
    {{-- Hero Section --}}
    <section class="relative pt-20 md:pt-24 z-10" x-data="{
        currentSlide: 0,
        slides: [
            '/assets/images/hero/1.png',
            '/assets/images/hero/2.png',
            '/assets/images/hero/3.png',
            '/assets/images/hero/4.png'
        ],
        init() {
            setInterval(() => {
                this.currentSlide = (this.currentSlide + 1) % this.slides.length;
            }, 3000); // Change image every 2.5 seconds
        }
    }">
        <div
            class="max-w-8xl mx-4 md:mx-16 py-8 sm:py-12 md:py-24 overflow-hidden bg-cover bg-center rounded-xl relative">
            {{-- Background slideshow images --}}
            <template x-for="(slide, index) in slides" :key="index">
                <div x-show="currentSlide === index" x-transition:enter="transition ease-in-out duration-1000"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in-out duration-1000" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" class="absolute inset-0 bg-cover bg-center rounded-xl"
                    :style="`background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('${slide}');`">
                </div>
            </template>

            <div class="mx-auto max-w-3xl text-center relative z-10 px-4">
                <h1 class="text-h-5 md:text-h-3 lg:text-h-1 font-medium text-white mb-6 md:mb-8">
                    <span class="italic">Bring Your Digital</span> Projects to Life<br class="hidden sm:block">
                    <span class="sm:hidden"> </span>with <span class="text-[#D2FF00]">Expert Developers</span>
                </h1>

                @auth
                    <div
                        class="bg-black/10 border-[0.5px] border-white/40 py-4 sm:py-6 md:py-8 rounded-xl backdrop-blur-lg flex flex-col items-center justify-center px-4 sm:px-6 md:px-8">

                        @if (auth()->user()->role === 'developer')
                            {{-- Developer: Search for Projects --}}
                            <form action="{{ route('search.projects') }}" method="GET" class="mx-auto w-full">
                                <div class="relative">
                                    <input type="text" name="q" placeholder="Search for projects..."
                                        value="{{ request('q') }}"
                                        class="w-full px-4 sm:px-6 py-3 sm:py-4 pr-12 text-sm sm:text-b-1 rounded-full border-0 focus:ring-2 focus:ring-primary-500">
                                    <button type="submit"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 bg-neutral-1000 text-white p-2 rounded-full hover:bg-neutral-800 transition">
                                        {{-- Search icon SVG --}}
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        @else
                            {{-- Customer/Admin: Search for Developers --}}
                            <form action="{{ route('search.developers') }}" method="GET"
                                class="mx-auto w-full mb-4 sm:mb-6">
                                <div class="relative">
                                    <input type="text" name="q" placeholder="Search for developers..."
                                        value="{{ request('q') }}"
                                        class="w-full px-4 sm:px-6 py-3 sm:py-4 pr-12 text-sm sm:text-b-1 rounded-full border-0 focus:ring-2 focus:ring-primary-500">
                                    <button type="submit"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 bg-neutral-1000 text-white p-2 rounded-full hover:bg-neutral-800 transition">
                                        {{-- Search icon SVG --}}
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </button>
                                </div>
                            </form>

                            {{-- Create Project Button (only for customer/admin) --}}
                            <div
                                class="flex flex-col items-center justify-center gap-3 sm:gap-4 text-white w-full text-sm sm:text-b-2">
                                <div class="flex items-center gap-4 w-full">
                                    <div class="flex-1 border-t border-neutral-10"></div>
                                    <span class="whitespace-nowrap text-neutral-0">or</span>
                                    <div class="flex-1 border-t border-neutral-10"></div>
                                </div>
                                <a href="{{ route('consumer.project.create') }}"
                                    class="px-4 sm:px-6 py-2.5 sm:py-3 bg-transparent w-full border-[1px] border-white rounded-lg hover:bg-white hover:text-neutral-1000 transition font-medium text-center">
                                    Create a new project request
                                </a>
                            </div>
                        @endif
                    </div>
                @else
                    <div
                        class="bg-black/10 border-[0.5px] border-white/40 py-4 sm:py-6 md:py-8 rounded-xl backdrop-blur-lg flex flex-col items-center justify-center px-4 sm:px-6 md:px-8">
                        {{-- Login prompt for guests --}}
                        <div class="w-full text-center text-white space-y-2">
                            <h3 class="text-lg sm:text-xl font-semibold">Get Started with Inofa</h3>
                            <p class="text-sm sm:text-b-2 text-neutral-100">Sign in to search for developers and create
                                projects</p>
                            <div class="w-full flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center pt-2 px-4">
                                <a href="{{ route('login') }}"
                                    class="w-full px-6 py-3 bg-white text-neutral-1000 rounded-xl hover:bg-neutral-100 transition font-medium text-center">
                                    Sign In
                                </a>
                                <a href="{{ route('register') }}"
                                    class="w-full px-6 py-3 bg-transparent border-[1px] border-white rounded-xl hover:bg-white hover:text-neutral-1000 transition font-medium text-center">
                                    Register
                                </a>
                            </div>
                        </div>
                    </div>
                @endauth
            </div>
        </div>

        {{-- Service Categories --}}
        <div class="my-8 sm:my-12 md:my-16 max-w-8xl mx-4 md:mx-16">
            <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-3 sm:gap-4">
                {{-- Full-stack Developer --}}
                <a href="#"
                    class="flex flex-col items-center p-3 sm:p-4 bg-white rounded-xl hover:shadow-lg transition group border border-primary-500">
                    {{-- Icon: Tree/Stack SVG - replace with actual icon --}}
                    <div class="w-10 h-10 sm:w-12 sm:h-12 mb-2 sm:mb-3 text-primary-500">
                        <img src='{{ asset('assets/vector/fs_logo.svg') }}' alt="">
                    </div>
                    <span class="text-xs sm:text-b-1 text-center font-medium">Hire Full-stack Developer</span>
                </a>

                {{-- Front-end Developer --}}
                <a href="#"
                    class="flex flex-col items-center p-3 sm:p-4 bg-white rounded-xl hover:shadow-lg transition group border border-primary-500">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 mb-2 sm:mb-3 text-primary-500">
                        <img src='{{ asset('assets/vector/fe_logo.svg') }}' alt="">
                    </div>
                    <span class="text-xs sm:text-b-1 text-center font-medium">Hire Front-end Developer</span>
                </a>

                {{-- Back-end Developer --}}
                <a href="#"
                    class="flex flex-col items-center p-3 sm:p-4 bg-white rounded-xl hover:shadow-lg transition group border border-primary-500">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 mb-2 sm:mb-3 text-primary-500">
                        <img src='{{ asset('assets/vector/be_logo.svg') }}' alt="">
                    </div>
                    <span class="text-xs sm:text-b-1 text-center font-medium">Hire Back-end Developer</span>
                </a>

                {{-- Mobile Developer --}}
                <a href="#"
                    class="flex flex-col items-center p-3 sm:p-4 bg-white rounded-xl hover:shadow-lg transition group border border-primary-500">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 mb-2 sm:mb-3 text-primary-500">
                        <img src='{{ asset('assets/vector/md_logo.svg') }}' alt="">
                    </div>
                    <span class="text-xs sm:text-b-1 text-center font-medium">Hire Mobile Developer</span>
                </a>

                {{-- UI/UX Designer --}}
                <a href="#"
                    class="flex flex-col items-center p-3 sm:p-4 bg-white rounded-xl hover:shadow-lg transition group border border-primary-500">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 mb-2 sm:mb-3 text-primary-500">
                        <img src='{{ asset('assets/vector/ui_logo.svg') }}' alt="">
                    </div>
                    <span class="text-xs sm:text-b-1 text-center font-medium">Hire UI/UX</span>
                </a>

                {{-- Game Developer --}}
                <a href="#"
                    class="flex flex-col items-center p-3 sm:p-4 bg-white rounded-xl hover:shadow-lg transition group border border-primary-500">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 mb-2 sm:mb-3 text-primary-500">
                        <img src='{{ asset('assets/vector/gd_logo.svg') }}' alt="">
                    </div>
                    <span class="text-xs sm:text-b-1 text-center font-medium">Hire Game Developer</span>
                </a>

                {{-- DevOps Engineer --}}
                <a href="#"
                    class="flex flex-col items-center p-3 sm:p-4 bg-white rounded-xl hover:shadow-lg transition group border border-primary-500">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 mb-2 sm:mb-3 text-primary-500">
                        <img src='{{ asset('assets/vector/de_logo.svg') }}' alt="">
                    </div>
                    <span class="text-xs sm:text-b-1 text-center font-medium">Hire DevOps Engineer</span>
                </a>

                {{-- Data Analyst --}}
                <a href="#"
                    class="flex flex-col items-center p-3 sm:p-4 bg-white rounded-xl hover:shadow-lg transition group border border-primary-500">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 mb-2 sm:mb-3 text-primary-500">
                        <img src='{{ asset('assets/vector/da_logo.svg') }}' alt="">
                    </div>
                    <span class="text-xs sm:text-b-1 text-center font-medium">Hire Data Analyst</span>
                </a>
            </div>
        </div>
    </section>

    {{-- Hire Top Developers / Find Top Projects --}}
    <section class="py-8 sm:py-12 md:py-16">
        <div class="mx-4 md:mx-16 max-w-8xl">
            @auth
                @if (auth()->user()->role === 'developer')
                    {{-- For Developers: Show Top Projects --}}
                    <h2 class="text-h-5 md:text-h-3 text-neutral-1000 mb-6 sm:mb-8 md:mb-12">Find Top Projects</h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @php
                            // Get top 5 high paid projects
                            $projects = \App\Models\Project::with(['consumer', 'skills'])
                                ->where('status', 'open')
                                ->whereHas('consumer')
                                ->orderByDesc('budget')
                                ->limit(5)
                                ->get();
                        @endphp

                        @forelse($projects->take(4) as $project)
                            <x-project-card :project="$project" />
                        @empty
                            {{-- Fallback if no projects --}}
                            <div class="col-span-full text-center py-12">
                                <p class="text-b-1 text-neutral-500">No projects available at the moment.</p>
                            </div>
                        @endforelse
                    </div>
                @else
                    {{-- For Customer/Admin: Show Top Developers --}}
                    <h2 class="text-h-5 md:text-h-3 text-neutral-1000 mb-6 sm:mb-8 md:mb-12">Hire Top Developers</h2>

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
                            <x-profile-card :developer="$developer" />
                        @empty
                            {{-- Fallback if no developers --}}
                            <div class="col-span-full text-center py-12">
                                <p class="text-b-1 text-neutral-500">No developers available at the moment.</p>
                            </div>
                        @endforelse
                    </div>
                @endif
            @else
                {{-- For Guests: Show Top Developers --}}
                <h2 class="text-h-5 md:text-h-3 text-neutral-1000 mb-6 sm:mb-8 md:mb-12">Hire Top Developers</h2>

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
                        <x-profile-card :developer="$developer" />
                    @empty
                        {{-- Fallback if no developers --}}
                        <div class="col-span-full text-center py-12">
                            <p class="text-b-1 text-neutral-500">No developers available at the moment.</p>
                        </div>
                    @endforelse
                </div>
            @endauth
        </div>
    </section>

    {{-- Connecting Developers and Clients --}}
    <section class="py-16 bg-white">
        <div class="mx-4 md:mx-16 max-w-8xl">
            <h2 class="text-h-5 md:text-h-3 text-neutral-1000 mb-12">Connecting Developers and Clients</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4">
                {{-- Search Card - Left Side --}}
                <div
                    class="flex flex-col rounded-t-xl md:rounded-t-none md:rounded-l-xl p-8 justify-center border-t border-x md:border-l md:border-y border-neutral-200">
                    <div class="space-y-4">
                        <h3 class="text-b-2 text-neutral-500 font-medium">Search</h3>
                        <h4 class="text-h-6 text-neutral-1000 leading-tight">Find the Right Developer for Your Needs
                        </h4>
                        <p class="text-b-2 text-neutral-600">
                            Search by type of software, skills, location, and experience
                        </p>
                        <a href="{{ auth()->check() ? route('dashboard') : route('login') }}"
                            class="inline-flex items-center text-primary-500 font-medium text-b-1 hover:text-primary-600 group">
                            Explore
                            <svg class="w-5 h-5 ml-1 group-hover:translate-x-1 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>

                {{-- Main Image - Center --}}
                <div class="lg:mr-8 mb-4 md:mb-0">
                    <div
                        class="md:rounded-r-xl md:rounded-b-none rounded-b-xl border-r border-y border-neutral-200 overflow-hidden h-full">
                        <img src="{{ asset('assets/images/placeholder_search.jpg') }}" alt="Developers collaborating"
                            class="w-full h-full object-cover">
                    </div>
                </div>

                {{-- Right Side Cards --}}
                <div class="md:col-span-2 grid grid-cols-2 gap-4 md:gap-8">
                    {{-- Project Management Card --}}
                    <div class="space-y-4 flex flex-col justify-between  border border-neutral-200 rounded-xl">
                        <div class="p-8">
                            <span class="text-b-3 text-neutral-500 uppercase tracking-wide font-medium">Projects</span>
                            <h4 class="text-h-7 text-neutral-1000 mt-1 mb-2">Project Management</h4>
                            <p class="text-b-2 text-neutral-600 mb-3">
                                Manage tasks and communication in one platform
                            </p>
                            <a href="{{ auth()->check() ? route('dashboard') : route('login') }}"
                                class="inline-flex items-center text-primary-500 font-medium text-b-2 hover:text-primary-600 group">
                                Explore
                                <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                        <div class="rounded-b-xl overflow-hidden">
                            <img src="{{ asset('assets/images/placeholder_management.jpg') }}"
                                alt="Project Management" class="w-full h-40 object-cover">
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
                            <a href="{{ auth()->check() ? route('dashboard') : route('login') }}"
                                class="inline-flex items-center text-primary-500 font-medium text-b-2 hover:text-primary-600 group">
                                Explore
                                <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
    <section class="py-8 sm:py-12 md:py-16" x-data="{
        mode: '{{ auth()->check() && auth()->user()->role === 'developer' ? 'finding' : 'hiring' }}'
    }">
        <div class="mx-4 md:mx-16 max-w-8xl">
            <div
                class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6 sm:mb-8 md:mb-12">
                <h2 class="text-h-5 md:text-h-3 text-neutral-1000">How it works</h2>
                @auth
                    @if (auth()->user()->role === 'developer')
                        {{-- Developer: Only show "For finding work" --}}
                        <div class="flex gap-2 w-full sm:w-auto">
                            <div
                                class="flex-1 sm:flex-none justify-center items-center text-center px-3 sm:px-4 py-2 border-2 border-primary-500 text-primary-500 bg-primary-50 rounded-full text-xs sm:text-b-2 font-medium">
                                For finding work
                            </div>
                        </div>
                    @elseif(auth()->user()->role === 'consumer')
                        {{-- Customer: Only show "For Hiring" --}}
                        <div class="flex gap-2 w-full sm:w-auto">
                            <div
                                class="flex-1 sm:flex-none justify-center items-center text-center px-3 sm:px-4 py-2 border-2 border-primary-500 text-primary-500 bg-primary-50 rounded-full text-xs sm:text-b-2 font-medium">
                                For Hiring
                            </div>
                        </div>
                    @else
                        {{-- Admin or other: Show both toggles --}}
                        <div class="flex gap-2 w-full sm:w-auto">
                            <button @click="mode = 'hiring'"
                                :class="mode === 'hiring' ? 'border-primary-500 text-primary-500 bg-primary-50' :
                                    'border-neutral-300 text-neutral-600'"
                                class="flex-1 sm:flex-none justify-center items-center text-center px-3 sm:px-4 py-2 border-2 rounded-full text-xs sm:text-b-2 font-medium hover:border-primary-500 hover:text-primary-500 transition-all duration-300">
                                For Hiring
                            </button>
                            <button @click="mode = 'finding'"
                                :class="mode === 'finding' ? 'border-primary-500 text-primary-500 bg-primary-50' :
                                    'border-neutral-300 text-neutral-600'"
                                class="flex-1 sm:flex-none justify-center items-center text-center px-3 sm:px-4 py-2 border-2 rounded-full text-xs sm:text-b-2 font-medium hover:border-primary-500 hover:text-primary-500 transition-all duration-300">
                                For finding work
                            </button>
                        </div>
                    @endif
                @else
                    {{-- Guest: Show both toggles --}}
                    <div class="flex gap-2 w-full sm:w-auto">
                        <button @click="mode = 'hiring'"
                            :class="mode === 'hiring' ? 'border-primary-500 text-primary-500 bg-primary-50' :
                                'border-neutral-300 text-neutral-600'"
                            class="flex-1 sm:flex-none px-3 sm:px-4 py-2 border-2 rounded-full text-xs sm:text-b-2 font-medium hover:border-primary-500 hover:text-primary-500 transition-all duration-300">
                            For Hiring
                        </button>
                        <button @click="mode = 'finding'"
                            :class="mode === 'finding' ? 'border-primary-500 text-primary-500 bg-primary-50' :
                                'border-neutral-300 text-neutral-600'"
                            class="flex-1 sm:flex-none px-3 sm:px-4 py-2 border-2 rounded-full text-xs sm:text-b-2 font-medium hover:border-primary-500 hover:text-primary-500 transition-all duration-300">
                            For finding work
                        </button>
                    </div>
                @endauth
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
                {{-- Step 1 --}}
                <div class="text-center">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 mx-auto mb-4 sm:mb-6 overflow-hidden">
                        <img x-show="mode === 'hiring'" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 transform scale-95"
                            x-transition:enter-end="opacity-100 transform scale-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 transform scale-100"
                            x-transition:leave-end="opacity-0 transform scale-95"
                            src="{{ asset('assets/images/how-it-works/1.png') }}" alt="Post a job"
                            class="w-full h-full">
                        <img x-show="mode === 'finding'" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 transform scale-95"
                            x-transition:enter-end="opacity-100 transform scale-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 transform scale-100"
                            x-transition:leave-end="opacity-0 transform scale-95"
                            src="{{ asset('assets/images/how-it-works-2/create-profile.png') }}"
                            alt="Create your profile" class="w-full h-full" style="display: none;">
                    </div>
                    <div x-show="mode === 'hiring'" x-transition:enter="transition ease-out duration-300 delay-75"
                        x-transition:enter-start="opacity-0 transform translate-y-2"
                        x-transition:enter-end="opacity-100 transform translate-y-0"
                        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0">
                        <h3 class="text-base sm:text-lg md:text-h-7 text-neutral-1000 mb-2 sm:mb-3">Search or Post a
                            job</h3>
                        <p class="text-sm sm:text-b-2 text-neutral-600">
                            Tell us what you need. Describe your project idea or task to help us find or match you with
                            the
                            right talent.
                        </p>
                    </div>
                    <div x-show="mode === 'finding'" x-transition:enter="transition ease-out duration-300 delay-75"
                        x-transition:enter-start="opacity-0 transform translate-y-2"
                        x-transition:enter-end="opacity-100 transform translate-y-0"
                        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0" style="display: none;">
                        <h3 class="text-base sm:text-lg md:text-h-7 text-neutral-1000 mb-2 sm:mb-3">Create your profile
                        </h3>
                        <p class="text-sm sm:text-b-2 text-neutral-600">
                            Build a standout profile showcasing your skills and experience to attract top clients.
                        </p>
                    </div>
                </div>

                {{-- Step 2 --}}
                <div class="text-center">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 mx-auto mb-4 sm:mb-6 overflow-hidden">
                        <img x-show="mode === 'hiring'" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 transform scale-95"
                            x-transition:enter-end="opacity-100 transform scale-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 transform scale-100"
                            x-transition:leave-end="opacity-0 transform scale-95"
                            src="{{ asset('assets/images/how-it-works/2.png') }}" alt="Hire talent"
                            class="w-full h-full">
                        <img x-show="mode === 'finding'" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 transform scale-95"
                            x-transition:enter-end="opacity-100 transform scale-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 transform scale-100"
                            x-transition:leave-end="opacity-0 transform scale-95"
                            src="{{ asset('assets/images/how-it-works-2/browse-apply.png') }}" alt="Browse and apply"
                            class="w-full h-full" style="display: none;">
                    </div>
                    <div x-show="mode === 'hiring'" x-transition:enter="transition ease-out duration-300 delay-75"
                        x-transition:enter-start="opacity-0 transform translate-y-2"
                        x-transition:enter-end="opacity-100 transform translate-y-0"
                        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0">
                        <h3 class="text-base sm:text-lg md:text-h-7 text-neutral-1000 mb-2 sm:mb-3">Hire top talent
                            fast</h3>
                        <p class="text-sm sm:text-b-2 text-neutral-600">
                            Connect, interview, and hire in no time. We give you talented freelancers that best fit your
                            needs.
                        </p>
                    </div>
                    <div x-show="mode === 'finding'" x-transition:enter="transition ease-out duration-300 delay-75"
                        x-transition:enter-start="opacity-0 transform translate-y-2"
                        x-transition:enter-end="opacity-100 transform translate-y-0"
                        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0" style="display: none;">
                        <h3 class="text-base sm:text-lg md:text-h-7 text-neutral-1000 mb-2 sm:mb-3">Browse and apply
                        </h3>
                        <p class="text-sm sm:text-b-2 text-neutral-600">
                            Explore projects that match your expertise. Apply to work that fits your skills and
                            schedule.
                        </p>
                    </div>
                </div>

                {{-- Step 3 --}}
                <div class="text-center">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 mx-auto mb-4 sm:mb-6 overflow-hidden">
                        <img x-show="mode === 'hiring'" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 transform scale-95"
                            x-transition:enter-end="opacity-100 transform scale-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 transform scale-100"
                            x-transition:leave-end="opacity-0 transform scale-95"
                            src="{{ asset('assets/images/how-it-works/3.png') }}" alt="Collaborate"
                            class="w-full h-full">
                        <img x-show="mode === 'finding'" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 transform scale-95"
                            x-transition:enter-end="opacity-100 transform scale-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 transform scale-100"
                            x-transition:leave-end="opacity-0 transform scale-95"
                            src="{{ asset('assets/images/how-it-works-2/interview-hired.png') }}"
                            alt="Interview and get hired" class="w-full h-full" style="display: none;">
                    </div>
                    <div x-show="mode === 'hiring'" x-transition:enter="transition ease-out duration-300 delay-75"
                        x-transition:enter-start="opacity-0 transform translate-y-2"
                        x-transition:enter-end="opacity-100 transform translate-y-0"
                        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0">
                        <h3 class="text-base sm:text-lg md:text-h-7 text-neutral-1000 mb-2 sm:mb-3">Collaborate easily
                        </h3>
                        <p class="text-sm sm:text-b-2 text-neutral-600">
                            Use Inofa's chat, share docs, give work status progress right from the job dashboard.
                        </p>
                    </div>
                    <div x-show="mode === 'finding'" x-transition:enter="transition ease-out duration-300 delay-75"
                        x-transition:enter-start="opacity-0 transform translate-y-2"
                        x-transition:enter-end="opacity-100 transform translate-y-0"
                        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0" style="display: none;">
                        <h3 class="text-base sm:text-lg md:text-h-7 text-neutral-1000 mb-2 sm:mb-3">Interview and get
                            hired</h3>
                        <p class="text-sm sm:text-b-2 text-neutral-600">
                            Connect with clients, discuss project details, and impress them with your expertise.
                        </p>
                    </div>
                </div>

                {{-- Step 4 --}}
                <div class="text-center">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 mx-auto mb-4 sm:mb-6 overflow-hidden">
                        <img x-show="mode === 'hiring'" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 transform scale-95"
                            x-transition:enter-end="opacity-100 transform scale-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 transform scale-100"
                            x-transition:leave-end="opacity-0 transform scale-95"
                            src="{{ asset('assets/images/how-it-works/4.png') }}" alt="Payment"
                            class="w-full h-full">
                        <img x-show="mode === 'finding'" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 transform scale-95"
                            x-transition:enter-end="opacity-100 transform scale-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 transform scale-100"
                            x-transition:leave-end="opacity-0 transform scale-95"
                            src="{{ asset('assets/images/how-it-works-2/get-paid.png') }}" alt="Deliver and get paid"
                            class="w-full h-full" style="display: none;">
                    </div>
                    <div x-show="mode === 'hiring'" x-transition:enter="transition ease-out duration-300 delay-75"
                        x-transition:enter-start="opacity-0 transform translate-y-2"
                        x-transition:enter-end="opacity-100 transform translate-y-0"
                        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0">
                        <h3 class="text-base sm:text-lg md:text-h-7 text-neutral-1000 mb-2 sm:mb-3">Payment simplified
                        </h3>
                        <p class="text-sm sm:text-b-2 text-neutral-600">
                            Manage payments in one place using multiple payment gateways with flexibility of daily or by
                            milestone.
                        </p>
                    </div>
                    <div x-show="mode === 'finding'" x-transition:enter="transition ease-out duration-300 delay-75"
                        x-transition:enter-start="opacity-0 transform translate-y-2"
                        x-transition:enter-end="opacity-100 transform translate-y-0"
                        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0" style="display: none;">
                        <h3 class="text-base sm:text-lg md:text-h-7 text-neutral-1000 mb-2 sm:mb-3">Deliver and get
                            paid</h3>
                        <p class="text-sm sm:text-b-2 text-neutral-600">
                            Complete projects with confidence. Receive payment for approved work hourly or by milestone.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Testimonials --}}
    <section class="py-8 sm:py-12 md:py-16 bg-radial-green-to-white">
        <div class="mx-4 md:mx-16 max-w-8xl">
            <h2 class="text-xl sm:text-2xl md:text-h-3 text-neutral-1000 mb-6 sm:mb-8 md:mb-12">Real results from
                clients</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
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
                    <div class="bg-white/90 shadow-xl backdrop-blur-lg rounded-xl p-6 sm:p-8">
                        <div class="mb-4 sm:mb-6">
                            <svg class="w-8 h-8 sm:w-10 sm:h-10 text-primary-500 mb-3 sm:mb-4" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                            </svg>
                            <p class="text-sm sm:text-b-1 text-neutral-800 leading-relaxed">
                                "{{ Str::limit($review->comment ?? 'Great experience working together!', 150) }}"
                            </p>
                        </div>

                        <div class="flex items-center gap-1 mb-3 sm:mb-4">
                            @for ($i = 0; $i < 5; $i++)
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 {{ $i < $review->rating ? 'text-secondary-500' : 'text-neutral-300' }}"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            @endfor
                        </div>

                        <div class="flex items-center justify-between pt-3 sm:pt-4 border-t border-neutral-200">
                            <div>
                                <p class="text-xs sm:text-b-2 font-semibold text-neutral-1000">Work done by:
                                    {{ $review->developer->name ?? 'Developer' }}</p>
                                <p class="text-xs sm:text-b-3 text-neutral-600">For:
                                    {{ $review->consumer->name ?? 'Client' }}
                                </p>
                                <p class="text-xs sm:text-b-3 text-neutral-500">
                                    {{ $review->created_at->format('M d, Y') }}</p>
                            </div>
                            @php
                                $avatarSrc = $review->consumer->getRawOriginal('avatar')
                                    ? (filter_var($review->consumer->getRawOriginal('avatar'), FILTER_VALIDATE_URL)
                                        ? $review->consumer->getRawOriginal('avatar')
                                        : asset('storage/' . $review->consumer->getRawOriginal('avatar')))
                                    : 'https://ui-avatars.com/api/?name=' . urlencode($review->consumer->name);
                            @endphp
                            <img src="{{ $avatarSrc }}" alt="{{ $review->consumer->name }}"
                                class="w-10 h-10 sm:w-12 sm:h-12 rounded-full object-cover">
                        </div>
                    </div>
                @empty
                    {{-- Fallback if no reviews --}}
                    <div class="bg-white/90 backdrop-blur-lg shadow-xl rounded-xl p-6 sm:p-8">
                        <div class="mb-4 sm:mb-6">
                            <svg class="w-8 h-8 sm:w-10 sm:h-10 text-primary-500 mb-3 sm:mb-4" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                            </svg>
                            <p class="text-sm sm:text-b-1 text-neutral-800 leading-relaxed">
                                "Inofa came in and helped us transfer knowledge from one departing developer, meeting a
                                serious deadline, without fail. His knowledge and experience are exceptional."
                            </p>
                        </div>
                        <div class="flex items-center gap-1 mb-3 sm:mb-4">
                            @for ($i = 0; $i < 5; $i++)
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-secondary-500" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            @endfor
                        </div>
                        <div class="flex items-center justify-between pt-3 sm:pt-4 border-t border-neutral-200">
                            <div>
                                <p class="text-xs sm:text-b-2 font-semibold text-neutral-1000">Work done by: Sarah K.
                                </p>
                                <p class="text-xs sm:text-b-3 text-neutral-600">Full Stack Developer</p>
                                <p class="text-xs sm:text-b-3 text-neutral-500">Apr 1, 2025</p>
                            </div>
                            <div
                                class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-primary-200 flex items-center justify-center text-primary-700 font-semibold text-sm sm:text-base">
                                S
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="my-8 sm:my-12 md:my-16">
        <div
            class="mx-4 md:mx-16 max-w-8xl bg-gradient-to-br from-primary-400 to-primary-500 rounded-2xl px-6 py-12 sm:py-16 md:py-20 text-center">
            <h2 class="text-2xl sm:text-3xl md:text-h-2 text-white mb-6 sm:mb-8">Ready to Build Something Amazing?</h2>
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center items-center">
                @auth
                    @if (auth()->user()->role === 'developer')
                        {{-- Developer: Only show Find Projects button --}}
                        <a href="{{ route('search.projects') }}"
                            class="w-full sm:w-auto px-6 sm:px-8 py-3 sm:py-4 bg-white text-primary-500 rounded-lg hover:bg-neutral-100 transition font-semibold text-sm sm:text-b-1 shadow-lg">
                            Find Projects
                        </a>
                    @elseif(auth()->user()->role === 'consumer')
                        {{-- Customer: Only show Hire Talent button --}}
                        <a href="{{ route('search.developers') }}"
                            class="w-full sm:w-auto px-6 sm:px-8 py-3 sm:py-4 bg-white text-primary-500 rounded-lg hover:bg-neutral-100 transition font-semibold text-sm sm:text-b-1 shadow-lg">
                            Hire Talent
                        </a>
                    @else
                        {{-- Admin or other: Show both buttons --}}
                        <a href="{{ route('search.developers') }}"
                            class="w-full sm:w-auto px-6 sm:px-8 py-3 sm:py-4 bg-white text-primary-500 rounded-lg hover:bg-neutral-100 transition font-semibold text-sm sm:text-b-1 shadow-lg">
                            Hire Talent
                        </a>
                        <a href="{{ route('search.projects') }}"
                            class="w-full sm:w-auto px-6 sm:px-8 py-3 sm:py-4 bg-white text-primary-500 rounded-lg hover:bg-neutral-100 transition font-semibold text-sm sm:text-b-1 shadow-lg">
                            Find Projects
                        </a>
                    @endif
                @else
                    {{-- Guest: Show both buttons --}}
                    <a href="{{ route('search.developers') }}"
                        class="w-full sm:w-auto px-6 sm:px-8 py-3 sm:py-4 bg-white text-primary-500 rounded-lg hover:bg-neutral-100 transition font-semibold text-sm sm:text-b-1 shadow-lg">
                        Hire Talent
                    </a>
                    <a href="{{ route('search.projects') }}"
                        class="w-full sm:w-auto px-6 sm:px-8 py-3 sm:py-4 bg-white text-primary-500 rounded-lg hover:bg-neutral-100 transition font-semibold text-sm sm:text-b-1 shadow-lg">
                        Find Projects
                    </a>
                @endauth
            </div>
        </div>
    </section>
</x-app-layout>
