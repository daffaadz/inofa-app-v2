<x-app-layout>
    <x-slot:title>{{ __('My Dashboard - Inofa') }}</x-slot:title>
    <section class="min-h-screen flex">

        <!-- ===== SIDEBAR ===== -->
        @include('partials.global-sidebar')

        <!-- ===== MAIN CONTENT ===== -->
        <div class="flex-1 lg:ml-[18rem]">

            <!-- MAIN CONTENT AREA -->
            <div class="mt-16">

                <!-- HEADER SECTION -->
                <div
                    class="px-4 md:px-8 py-6 md:py-8 pb-8 md:pb-16 flex flex-col md:flex-row items-start md:items-center justify-between border-b-[0.5px] border-neutral-100 bg-neutral-0 gap-4">
                    <div>
                        <h1 class="text-h-4 md:text-h-3 font-bold text-neutral-900">Developer Dashboard</h1>
                        <p class="mt-1 text-b-2 md:text-b-1 text-neutral-600">Welcome back! Here's what's happening with your
                            projects
                        </p>
                    </div>

                    <div>
                        <a href="{{ route('search.developers.show', auth()->user()->id) }}" target="_blank"
                            class="inline-flex items-center justify-center gap-2 px-3 md:px-4 py-2 md:py-3 rounded-xl border border-primary-500 bg-primary-500 text-neutral-0
                                hover:bg-neutral-0 hover:text-primary-500 hover:scale-[1.02] active:scale-[0.98]
                                [box-shadow:inset_0_2px_4px_0_rgba(0,0,0,0.06),0_4px_12px_rgba(16,138,0,0.25)]
                                transition-all duration-200 group whitespace-nowrap">

                            <svg class="w-4 md:w-5 h-4 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 20 20">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.66667"
                                    d="M1.72 10.29c-.07-.19-.07-.4 0-.59C2.4 8.07 3.54 6.67 5.02 5.68c1.47-.99 3.2-1.51 4.98-1.51s3.51.52 4.98 1.51c1.48.99 2.62 2.39 3.3 4.02.07.19.07.4 0 .59-.68 1.63-1.82 3.03-3.3 4.02-1.47.99-3.2 1.51-4.98 1.51s-3.51-.52-4.98-1.51C3.54 13.32 2.4 11.92 1.72 10.29z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.66667"
                                    d="M10 12.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" />
                            </svg>

                            {{-- Label --}}
                            <span class="text-b-3 md:text-b-1 font-light">View Public Profile</span>
                        </a>
                    </div>
                </div>

                <!-- ===== KEY STATS GRID ===== -->
                <div class="p-4 md:p-8 bg-neutral-10/50">
                    <h2 class="text-h-5 font-bold text-neutral-900 mb-4">Key Stats</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                        <!-- Active Projects -->
                        <div
                            class="bg-white rounded-2xl border border-neutral-200 p-6 relative overflow-hidden hover:shadow-lg transition">
                            <div class="flex items-center justify-between mb-2">
                                {{-- left --}}
                                <svg class="w-14 h-auto" viewBox="0 0 48 48" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M0 14C0 6.26801 6.26801 0 14 0H34C41.732 0 48 6.26801 48 14V34C48 41.732 41.732 48 34 48H14C6.26801 48 0 41.732 0 34V14Z"
                                        fill="url(#paint0_linear_782_4044)" />
                                    <path
                                        d="M28 32V16C28 15.4696 27.7893 14.9609 27.4142 14.5858C27.0391 14.2107 26.5304 14 26 14H22C21.4696 14 20.9609 14.2107 20.5858 14.5858C20.2107 14.9609 20 15.4696 20 16V32"
                                        stroke="#108A00" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M32 18H16C14.8954 18 14 18.8954 14 20V30C14 31.1046 14.8954 32 16 32H32C33.1046 32 34 31.1046 34 30V20C34 18.8954 33.1046 18 32 18Z"
                                        stroke="#108A00" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <defs>
                                        <linearGradient id="paint0_linear_782_4044" x1="0" y1="0"
                                            x2="48" y2="48" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#108A00" stop-opacity="0.1" />
                                            <stop offset="1" stop-color="#D2FF00" stop-opacity="0.2" />
                                        </linearGradient>
                                    </defs>
                                </svg>

                                {{-- right --}}
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13.3335 5.83301H18.3335V10.833" stroke="#108A00" stroke-width="1.66667"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M18.3332 5.83301L11.2498 12.9163L7.08317 8.74967L1.6665 14.1663"
                                        stroke="#108A00" stroke-width="1.66667" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>

                            </div>
                            <p class="text-b-1 text-neutral-600 mb-1">Active Projects</p>
                            <p class="text-h-3 font-bold text-neutral-900 mb-4">{{ $activeAgreements->count() }}</p>
                            <p class="text-b-3 {{ $activeProjectsIncrease >= 0 ? 'text-primary-500' : 'text-red-500' }}">
                                {{ $activeProjectsIncrease >= 0 ? '+' : '' }}{{ $activeProjectsIncrease }} from last month
                            </p>
                        </div>

                        <!-- Total Earnings -->
                        <div
                            class="bg-gradient-to-br from-primary-100 to-primary-200 rounded-2xl border-[3px] border-primary-400 p-6 relative overflow-hidden hover:shadow-lg transition">
                            <div class="flex items-center justify-between mb-2">
                                <div class="w-14 h-14 rounded-2xl bg-primary-500 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-auto text-white"
                                        fill="currentColor" viewBox="0 0 256 256">
                                        <path
                                            d="M128,88a40,40,0,1,0,40,40A40,40,0,0,0,128,88Zm0,64a24,24,0,1,1,24-24A24,24,0,0,1,128,152ZM240,56H16a8,8,0,0,0-8,8V192a8,8,0,0,0,8,8H240a8,8,0,0,0,8-8V64A8,8,0,0,0,240,56ZM193.65,184H62.35A56.78,56.78,0,0,0,24,145.65v-35.3A56.78,56.78,0,0,0,62.35,72h131.3A56.78,56.78,0,0,0,232,110.35v35.3A56.78,56.78,0,0,0,193.65,184ZM232,93.37A40.81,40.81,0,0,1,210.63,72H232ZM45.37,72A40.81,40.81,0,0,1,24,93.37V72ZM24,162.63A40.81,40.81,0,0,1,45.37,184H24ZM210.63,184A40.81,40.81,0,0,1,232,162.63V184Z">
                                        </path>
                                    </svg>
                                </div>

                                {{-- right --}}
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M3.33325 11.6662C3.17555 11.6668 3.02094 11.6226 2.88737 11.5387C2.75381 11.4549 2.64677 11.3349 2.5787 11.1926C2.51063 11.0504 2.48432 10.8917 2.50283 10.7351C2.52133 10.5785 2.5839 10.4304 2.68325 10.3079L10.9332 1.8079C10.9951 1.73647 11.0795 1.6882 11.1724 1.67101C11.2653 1.65382 11.3613 1.66874 11.4447 1.71332C11.528 1.7579 11.5937 1.82948 11.631 1.91632C11.6683 2.00317 11.675 2.10011 11.6499 2.19123L10.0499 7.2079C10.0027 7.33417 9.98689 7.47 10.0037 7.60374C10.0206 7.73748 10.0696 7.86513 10.1467 7.97575C10.2237 8.08638 10.3264 8.17666 10.446 8.23887C10.5656 8.30107 10.6984 8.33334 10.8332 8.3329H16.6666C16.8243 8.33236 16.9789 8.37658 17.1124 8.46042C17.246 8.54425 17.3531 8.66427 17.4211 8.80652C17.4892 8.94877 17.5155 9.10741 17.497 9.26402C17.4785 9.42062 17.4159 9.56877 17.3166 9.69123L9.06658 18.1912C9.00469 18.2627 8.92036 18.3109 8.82743 18.3281C8.73449 18.3453 8.63848 18.3304 8.55514 18.2858C8.4718 18.2412 8.40609 18.1697 8.3688 18.0828C8.33151 17.996 8.32485 17.899 8.34991 17.8079L9.94991 12.7912C9.99709 12.665 10.0129 12.5291 9.99609 12.3954C9.97924 12.2617 9.9302 12.134 9.85317 12.0234C9.77614 11.9128 9.67343 11.8225 9.55385 11.7603C9.43426 11.6981 9.30137 11.6658 9.16658 11.6662H3.33325Z"
                                        stroke="#108A00" stroke-width="1.66667" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>

                            </div>
                            <p class="text-b-1 text-primary-700 mb-1">Total Earnings</p>
                            <p class="text-h-3 font-bold text-primary-900 mb-4">Rp.{{ number_format($earnings, 0) }}</p>
                            <p class="text-b-3 {{ $earningsIncrease >= 0 ? 'text-primary-600' : 'text-red-600' }}">
                                {{ $earningsIncrease >= 0 ? '+' : '' }}Rp.{{ number_format(abs($earningsIncrease), 0) }} this month
                            </p>
                        </div>

                        <!-- Pending/Accepted Proposals -->
                        <a href="{{ route('developer.proposals.index') }}"
                            class="bg-white rounded-2xl border border-neutral-200 p-6 relative overflow-hidden hover:shadow-lg transition cursor-pointer group">
                            <div class="flex items-center justify-between mb-2">
                                {{-- left --}}
                                <svg class="w-14 h-auto" viewBox="0 0 48 48" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M0 14C0 6.26801 6.26801 0 14 0H34C41.732 0 48 6.26801 48 14V34C48 41.732 41.732 48 34 48H14C6.26801 48 0 41.732 0 34V14Z"
                                        fill="url(#paint0_linear_782_4059)" />
                                    <path
                                        d="M34 19L25.009 24.727C24.7039 24.9042 24.3573 24.9976 24.0045 24.9976C23.6517 24.9976 23.3051 24.9042 23 24.727L14 19"
                                        stroke="#2563EB" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M32 16H16C14.8954 16 14 16.8954 14 18V30C14 31.1046 14.8954 32 16 32H32C33.1046 32 34 31.1046 34 30V18C34 16.8954 33.1046 16 32 16Z"
                                        stroke="#2563EB" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <defs>
                                        <linearGradient id="paint0_linear_782_4059" x1="0" y1="0"
                                            x2="48" y2="48" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#2563EB" stop-opacity="0.1" />
                                            <stop offset="1" stop-color="#2563EB" stop-opacity="0.2" />
                                        </linearGradient>
                                    </defs>
                                </svg>

                                {{-- right --}}
                                <span
                                    class="px-4 py-2 bg-blue-100 text-blue-600 text-b-3 font-medium rounded-xl group-hover:bg-blue-200 transition">{{ __('View All') }}</span>
                            </div>
                            <p class="text-b-1 text-neutral-600 mb-1">Pending/Accepted Proposals</p>
                            <p class="text-h-3 font-bold text-neutral-900 mb-4">
                                {{ $myAgreements->whereIn('status', ['pending', 'accepted'])->count() }}</p>
                            <p class="text-b-3 text-blue-500">Click to view all proposals</p>
                        </a>

                        <!-- Profile Views -->
                        <div
                            class="bg-white rounded-2xl border border-neutral-200 p-6 relative overflow-hidden hover:shadow-lg transition">
                            <div class="flex items-center justify-between mb-2">
                                {{-- left --}}
                                <svg class="w-14 h-auto" viewBox="0 0 48 48" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M0 14C0 6.26801 6.26801 0 14 0H34C41.732 0 48 6.26801 48 14V34C48 41.732 41.732 48 34 48H14C6.26801 48 0 41.732 0 34V14Z"
                                        fill="url(#paint0_linear_782_4073)" />
                                    <path
                                        d="M14.062 24.3484C13.9787 24.1238 13.9787 23.8769 14.062 23.6524C14.8737 21.6842 16.2515 20.0014 18.0208 18.8173C19.79 17.6331 21.8711 17.001 24 17.001C26.129 17.001 28.21 17.6331 29.9792 18.8173C31.7485 20.0014 33.1263 21.6842 33.938 23.6524C34.0214 23.8769 34.0214 24.1238 33.938 24.3484C33.1263 26.3165 31.7485 27.9993 29.9792 29.1835C28.21 30.3676 26.129 30.9997 24 30.9997C21.8711 30.9997 19.79 30.3676 18.0208 29.1835C16.2515 27.9993 14.8737 26.3165 14.062 24.3484Z"
                                        stroke="#F59E0B" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M24 27C25.6569 27 27 25.6569 27 24C27 22.3431 25.6569 21 24 21C22.3431 21 21 22.3431 21 24C21 25.6569 22.3431 27 24 27Z"
                                        stroke="#F59E0B" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <defs>
                                        <linearGradient id="paint0_linear_782_4073" x1="0" y1="0"
                                            x2="48" y2="48" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#F59E0B" stop-opacity="0.1" />
                                            <stop offset="1" stop-color="#F59E0B" stop-opacity="0.2" />
                                        </linearGradient>
                                    </defs>
                                </svg>

                                {{-- right --}}
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13.3335 5.83301H18.3335V10.833" stroke="#F59E0B" stroke-width="1.66667"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M18.3332 5.83301L11.2498 12.9163L7.08317 8.74967L1.6665 14.1663"
                                        stroke="#F59E0B" stroke-width="1.66667" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>

                            </div>
                            <p class="text-b-1 text-neutral-600 mb-1">Profile Views</p>
                            <p class="text-h-3 font-bold text-neutral-900 mb-4">{{ $profileViews }}</p>
                            <p class="text-b-3 {{ $profileViewsIncrease >= 0 ? 'text-yellow-600' : 'text-red-600' }}">
                                {{ $profileViewsIncrease >= 0 ? '+' : '' }}{{ $profileViewsIncrease }} this week
                            </p>
                        </div>

                    </div>
                </div>

                <!-- ===== MY ACTIVE PROJECTS ===== -->
                <div class="p-8 bg-neutral-10/50" x-data="{
                    sortBy: 'default',
                    sortOpen: false,
                    agreements: {{ $activeAgreements->toJson() }},
                    get sortedAgreements() {
                        let sorted = [...this.agreements];
                        switch(this.sortBy) {
                            case 'payment_high':
                                return sorted.sort((a, b) => b.final_price - a.final_price);
                            case 'payment_low':
                                return sorted.sort((a, b) => a.final_price - b.final_price);
                            case 'progress_high':
                                return sorted.sort((a, b) => b.progress - a.progress);
                            case 'progress_low':
                                return sorted.sort((a, b) => a.progress - b.progress);
                            case 'az':
                                return sorted.sort((a, b) => a.project_title.localeCompare(b.project_title));
                            default:
                                return sorted;
                        }
                    },
                    getSortLabel() {
                        const labels = {
                            'default': 'Default',
                            'payment_high': 'Highest Paid',
                            'payment_low': 'Lowest Paid',
                            'progress_high': 'Highest Progress',
                            'progress_low': 'Lowest Progress',
                            'az': 'A to Z'
                        };
                        return labels[this.sortBy] || 'Sort By';
                    }
                }" @click.away="sortOpen = false">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h2 class="text-h-5 font-bold text-neutral-900">My Active and Complete Projects</h2>
                            <p class="text-b-1 text-neutral-600">Track your ongoing work, deadlines, and completed projects</p>
                        </div>
                        
                        <!-- Sort By Dropdown -->
                        <div class="relative">
                            <button @click="sortOpen = !sortOpen"
                                class="text-primary-500 text-b-1 font-medium hover:bg-primary-50 px-4 py-2 rounded-lg flex items-center gap-2 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4" />
                                </svg>
                                <span x-text="getSortLabel()">Sort By</span>
                                <svg class="w-4 h-4 transition-transform" :class="{'rotate-180': sortOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div x-show="sortOpen" 
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-neutral-200 py-2 z-10"
                                style="display: none;">
                                <button @click="sortBy = 'default'; sortOpen = false" 
                                    class="w-full text-left px-4 py-2 text-b-2 hover:bg-neutral-50 transition"
                                    :class="{'bg-primary-50 text-primary-600 font-medium': sortBy === 'default'}">
                                    Default
                                </button>
                                <button @click="sortBy = 'payment_high'; sortOpen = false" 
                                    class="w-full text-left px-4 py-2 text-b-2 hover:bg-neutral-50 transition"
                                    :class="{'bg-primary-50 text-primary-600 font-medium': sortBy === 'payment_high'}">
                                    Highest Paid
                                </button>
                                <button @click="sortBy = 'payment_low'; sortOpen = false" 
                                    class="w-full text-left px-4 py-2 text-b-2 hover:bg-neutral-50 transition"
                                    :class="{'bg-primary-50 text-primary-600 font-medium': sortBy === 'payment_low'}">
                                    Lowest Paid
                                </button>
                                <button @click="sortBy = 'progress_high'; sortOpen = false" 
                                    class="w-full text-left px-4 py-2 text-b-2 hover:bg-neutral-50 transition"
                                    :class="{'bg-primary-50 text-primary-600 font-medium': sortBy === 'progress_high'}">
                                    Highest Progress
                                </button>
                                <button @click="sortBy = 'progress_low'; sortOpen = false" 
                                    class="w-full text-left px-4 py-2 text-b-2 hover:bg-neutral-50 transition"
                                    :class="{'bg-primary-50 text-primary-600 font-medium': sortBy === 'progress_low'}">
                                    Lowest Progress
                                </button>
                                <button @click="sortBy = 'az'; sortOpen = false" 
                                    class="w-full text-left px-4 py-2 text-b-2 hover:bg-neutral-50 transition"
                                    :class="{'bg-primary-50 text-primary-600 font-medium': sortBy === 'az'}">
                                    A to Z
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <template x-for="agreement in sortedAgreements" :key="agreement.id">
                            <div class="bg-white rounded-2xl border border-neutral-200 p-6 hover:shadow-lg transition">
                                <div class="flex items-start justify-between gap-6">

                                    <!-- Left Content -->
                                    <div class="flex-1">
                                        <div class="flex items-start gap-3 mb-3">
                                            <img :src="agreement.consumer.avatar && agreement.consumer.avatar.startsWith('http') 
                                                    ? agreement.consumer.avatar 
                                                    : agreement.consumer.avatar 
                                                        ? '/storage/' + agreement.consumer.avatar 
                                                        : 'https://ui-avatars.com/api/?name=' + encodeURIComponent(agreement.consumer.name)"
                                                :alt="agreement.consumer.name"
                                                class="w-10 h-10 rounded-full object-cover">
                                            <div class="flex-1">
                                                <div class="flex items-center gap-2 mb-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary-500" fill="currentColor" viewBox="0 0 256 256">
                                                        <path d="M216,40H40A16,16,0,0,0,24,56V200a16,16,0,0,0,16,16H216a16,16,0,0,0,16-16V56A16,16,0,0,0,216,40Zm0,16V88H40V56Zm0,144H40V104H216v96Z"></path>
                                                    </svg>
                                                    <h3 class="text-b-1 font-semibold text-neutral-900" x-text="agreement.project_title"></h3>
                                                </div>
                                                <p class="text-b-3 text-neutral-600 flex items-center gap-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-neutral-500" fill="currentColor" viewBox="0 0 256 256">
                                                        <path d="M230.92,212c-15.23-26.33-38.7-45.21-66.09-54.16a72,72,0,1,0-73.66,0C63.78,166.78,40.31,185.66,25.08,212a8,8,0,1,0,13.85,8c18.84-32.56,52.14-52,89.07-52s70.23,19.44,89.07,52a8,8,0,1,0,13.85-8ZM72,96a56,56,0,1,1,56,56A56.06,56.06,0,0,1,72,96Z"></path>
                                                    </svg>
                                                    Client: <span x-text="agreement.consumer.name"></span>
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Progress Bar with Input (Only for Active Projects) -->
                                        <div x-show="agreement.status === 'active'" class="mb-3" x-data="{ 
                                            progress: agreement.progress,
                                            updating: false,
                                            async updateProgress(agreementId, value) {
                                                this.updating = true;
                                                try {
                                                    const response = await fetch(`/developer/agreements/${agreementId}/progress`, {
                                                        method: 'PATCH',
                                                        headers: {
                                                            'Content-Type': 'application/json',
                                                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                            'Accept': 'application/json'
                                                        },
                                                        body: JSON.stringify({ progress: value })
                                                    });
                                                    const data = await response.json();
                                                    if (data.success) {
                                                        this.progress = data.progress;
                                                        agreement.progress = data.progress;
                                                        this.$dispatch('notify', { message: 'Progress updated!', type: 'success' });
                                                    }
                                                } catch (error) {
                                                    console.error('Error:', error);
                                                    this.$dispatch('notify', { message: 'Failed to update progress', type: 'error' });
                                                } finally {
                                                    this.updating = false;
                                                }
                                            }
                                        }">
                                            <div class="flex items-center justify-between mb-2">
                                                <span class="text-b-3 text-neutral-600 flex items-center gap-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-primary-500" fill="currentColor" viewBox="0 0 256 256">
                                                        <path d="M176,104H152a8,8,0,0,1,0-16h24a8,8,0,0,1,0,16Zm-24,24h24a8,8,0,0,0,0-16H152a8,8,0,0,0,0,16Zm80-72V200a16,16,0,0,1-16,16H40a16,16,0,0,1-16-16V56A16,16,0,0,1,40,40H216A16,16,0,0,1,232,56ZM104,176V80a8,8,0,0,0-8-8H40V200H96A8,8,0,0,0,104,176Zm112,24V72H120V176a24,24,0,0,1-24,24H40v0H216Z"></path>
                                                    </svg>
                                                    Progress
                                                </span>
                                                <div class="flex items-center gap-2">
                                                    <input type="number" 
                                                        x-model="progress"
                                                        @change="updateProgress(agreement.id, $el.value)"
                                                        min="0" 
                                                        max="100" 
                                                        :disabled="updating"
                                                        class="w-16 px-2 py-1 border border-neutral-300 rounded-lg text-b-3 text-center focus:ring-2 focus:ring-primary-500 focus:border-transparent disabled:opacity-50"
                                                        :class="{ 'animate-pulse': updating }">
                                                    <span class="text-b-3 text-neutral-600">%</span>
                                                    <svg x-show="updating" class="w-4 h-4 text-primary-500 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="w-full bg-neutral-200 rounded-full h-2">
                                                <div class="bg-gradient-to-r from-primary-500 to-green-500 h-2 rounded-full transition-all duration-500"
                                                    :style="`width: ${progress}%`"></div>
                                            </div>
                                        </div>

                                        <!-- Meta Info -->
                                        <div class="flex items-center gap-4 text-b-3 text-neutral-600">
                                            <span class="flex items-center gap-1">
                                                <span
                                                    class="px-3 py-1 rounded-full text-b-4 font-medium"
                                                    :class="{
                                                        'bg-blue-100 text-blue-600': agreement.status === 'active',
                                                        'bg-green-100 text-green-600': agreement.status === 'completed'
                                                    }"
                                                    x-text="agreement.status === 'active' ? 'In Progress' : 'Completed'"></span>
                                            </span>
                                            <span class="flex items-center gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-neutral-500" fill="currentColor" viewBox="0 0 256 256">
                                                    <path d="M208,32H184V24a8,8,0,0,0-16,0v8H88V24a8,8,0,0,0-16,0v8H48A16,16,0,0,0,32,48V208a16,16,0,0,0,16,16H208a16,16,0,0,0,16-16V48A16,16,0,0,0,208,32ZM72,48v8a8,8,0,0,0,16,0V48h80v8a8,8,0,0,0,16,0V48h24V80H48V48ZM208,208H48V96H208V208Zm-96-88v64a8,8,0,0,1-16,0V132.94l-4.42,2.22a8,8,0,0,1-7.16-14.32l16-8A8,8,0,0,1,112,120Zm59.16,30.45L152,176h16a8,8,0,0,1,0,16H136a8,8,0,0,1-6.4-12.8l28.78-38.37A8,8,0,1,0,145.07,132a8,8,0,1,1-13.85-8A24,24,0,0,1,176,136,23.76,23.76,0,0,1,171.16,150.45Z"></path>
                                                </svg>
                                                <span x-text="new Date(agreement.start_date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })"></span>
                                            </span>
                                        </div>

                                        <!-- Review Section (Only for Completed Projects) -->
                                        <div x-show="agreement.status === 'completed' && agreement.review" class="mt-4 p-4 bg-gradient-to-br from-yellow-50 to-amber-50 rounded-xl border border-yellow-200">
                                            <div class="flex items-start gap-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 256 256">
                                                    <path d="M234.5,114.38l-45.1,39.36,13.51,58.6a16,16,0,0,1-23.84,17.34l-51.11-31-51,31a16,16,0,0,1-23.84-17.34L66.61,153.8,21.5,114.38a16,16,0,0,1,9.11-28.06l59.46-5.15,23.21-55.36a16,16,0,0,1,29.44,0h0L166,81.17l59.44,5.15a16,16,0,0,1,9.11,28.06Z"></path>
                                                </svg>
                                                <div class="flex-1">
                                                    <div class="flex items-center gap-2 mb-2">
                                                        <p class="text-b-2 font-semibold text-neutral-900">Client Review</p>
                                                        <div class="flex items-center gap-1">
                                                            <template x-for="i in 5" :key="i">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" :class="i <= (agreement.review?.rating || 0) ? 'text-yellow-500' : 'text-gray-300'" fill="currentColor" viewBox="0 0 256 256">
                                                                    <path d="M234.5,114.38l-45.1,39.36,13.51,58.6a16,16,0,0,1-23.84,17.34l-51.11-31-51,31a16,16,0,0,1-23.84-17.34L66.61,153.8,21.5,114.38a16,16,0,0,1,9.11-28.06l59.46-5.15,23.21-55.36a16,16,0,0,1,29.44,0h0L166,81.17l59.44,5.15a16,16,0,0,1,9.11,28.06Z"></path>
                                                                </svg>
                                                            </template>
                                                            <span class="text-b-3 text-neutral-700 ml-1" x-text="`(${agreement.review?.rating || 0}/5)`"></span>
                                                        </div>
                                                    </div>
                                                    <p class="text-b-3 text-neutral-700" x-text="agreement.review?.comment || 'No comment provided'"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Right Content -->
                                    <div class="flex flex-col items-end gap-3">
                                        <div class="text-right">
                                            <p class="text-h-5 font-bold text-neutral-900 flex items-center gap-1">
                                                Rp<span x-text="agreement.final_price.toLocaleString('id-ID')"></span>
                                            </p>
                                            <p class="text-b-3 text-neutral-600">Payment</p>
                                            <p class="text-b-3 text-neutral-600 flex items-center justify-end gap-1 mt-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 256 256">
                                                    <path d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm0,192a88,88,0,1,1,88-88A88.1,88.1,0,0,1,128,216Zm64-88a8,8,0,0,1-8,8H128a8,8,0,0,1-8-8V72a8,8,0,0,1,16,0v48h48A8,8,0,0,1,192,128Z"></path>
                                                </svg>
                                                <span x-text="new Date(agreement.end_date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })"></span>
                                            </p>
                                            <p class="text-b-4 text-neutral-500">Deadline</p>
                                        </div>

                                        <div class="flex gap-2">
                                            <a :href="`/user/${agreement.consumer.id}`"
                                                class="px-8 py-2 border border-primary-500 bg-primary-500 text-white text-b-3 font-medium rounded-lg hover:bg-white hover:text-primary-500 transition flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 256 256">
                                                    <path d="M216,48H40A16,16,0,0,0,24,64V224a15.85,15.85,0,0,0,9.24,14.5A16.13,16.13,0,0,0,40,240a15.89,15.89,0,0,0,10.25-3.78.69.69,0,0,0,.13-.11L82.5,208H216a16,16,0,0,0,16-16V64A16,16,0,0,0,216,48ZM40,224h0ZM216,192H82.5a16,16,0,0,0-10.3,3.75l-.12.11L40,224V64H216ZM88,112a8,8,0,0,1,8-8h64a8,8,0,0,1,0,16H96A8,8,0,0,1,88,112Zm0,32a8,8,0,0,1,8-8h64a8,8,0,1,1,0,16H96A8,8,0,0,1,88,144Z"></path>
                                                </svg>
                                                Chat
                                            </a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </template>
                        
                        <template x-if="sortedAgreements.length === 0">
                            <div class="bg-white rounded-2xl border border-neutral-200 p-12 text-center">
                                <div
                                    class="w-16 h-16 rounded-full bg-neutral-100 flex items-center justify-center mx-auto mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-neutral-400" fill="currentColor" viewBox="0 0 256 256">
                                        <path d="M216,40H40A16,16,0,0,0,24,56V200a16,16,0,0,0,16,16H216a16,16,0,0,0,16-16V56A16,16,0,0,0,216,40Zm0,16V88H40V56Zm0,144H40V104H216v96Z"></path>
                                    </svg>
                                </div>
                                <p class="text-b-1 text-neutral-600 mb-2">No active projects yet</p>
                                <p class="text-b-3 text-neutral-500">Send offers to get hired!</p>
                            </div>
                        </template>
                    </div>

                    <!-- View All Projects Button -->
                    <div class="mt-6">
                        <a href="{{ route('search.projects') }}"
                            class="w-full flex items-center justify-center gap-2 px-6 py-3 border-2 border-primary-500 text-primary-500 text-b-1 font-medium rounded-xl hover:bg-primary-50 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-auto text-primary-500"
                                fill="currentColor" viewBox="0 0 256 256">
                                <path
                                    d="M237.2,151.87v0a47.1,47.1,0,0,0-2.35-5.45L193.26,51.8a7.82,7.82,0,0,0-1.66-2.44,32,32,0,0,0-45.26,0A8,8,0,0,0,144,55V80H112V55a8,8,0,0,0-2.34-5.66,32,32,0,0,0-45.26,0,7.82,7.82,0,0,0-1.66,2.44L21.15,146.4a47.1,47.1,0,0,0-2.35,5.45v0A48,48,0,1,0,112,168V96h32v72a48,48,0,1,0,93.2-16.13ZM76.71,59.75a16,16,0,0,1,19.29-1v73.51a47.9,47.9,0,0,0-46.79-9.92ZM64,200a32,32,0,1,1,32-32A32,32,0,0,1,64,200ZM160,58.74a16,16,0,0,1,19.29,1l27.5,62.58A47.9,47.9,0,0,0,160,132.25ZM192,200a32,32,0,1,1,32-32A32,32,0,0,1,192,200Z">
                                </path>
                            </svg>

                            Search For Projects

                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.1665 10H15.8332" stroke="#108A00" stroke-width="1.66667"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M10 4.16699L15.8333 10.0003L10 15.8337" stroke="#108A00"
                                    stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>

                        </a>
                    </div>
                </div>

            </div>
        </div>

    </section>

    <!-- Toast Notification -->
    <div x-data="{ 
        show: false, 
        message: '', 
        type: 'success',
        init() {
            this.$watch('show', value => {
                if (value) {
                    setTimeout(() => { this.show = false }, 3000);
                }
            })
        }
    }" 
    @notify.window="show = true; message = $event.detail.message; type = $event.detail.type"
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform translate-y-2"
    x-transition:enter-end="opacity-100 transform translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 transform translate-y-0"
    x-transition:leave-end="opacity-0 transform translate-y-2"
    class="fixed bottom-4 right-4 z-50"
    style="display: none;">
        <div class="rounded-lg shadow-lg p-4 flex items-center gap-3 min-w-[300px]"
            :class="{
                'bg-green-500 text-white': type === 'success',
                'bg-red-500 text-white': type === 'error'
            }">
            <svg x-show="type === 'success'" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 256 256">
                <path d="M173.66,98.34a8,8,0,0,1,0,11.32l-56,56a8,8,0,0,1-11.32,0l-24-24a8,8,0,0,1,11.32-11.32L112,148.69l50.34-50.35A8,8,0,0,1,173.66,98.34ZM232,128A104,104,0,1,1,128,24,104.11,104.11,0,0,1,232,128Zm-16,0a88,88,0,1,0-88,88A88.1,88.1,0,0,0,216,128Z"></path>
            </svg>
            <svg x-show="type === 'error'" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 256 256">
                <path d="M165.66,101.66,139.31,128l26.35,26.34a8,8,0,0,1-11.32,11.32L128,139.31l-26.34,26.35a8,8,0,0,1-11.32-11.32L116.69,128,90.34,101.66a8,8,0,0,1,11.32-11.32L128,116.69l26.34-26.35a8,8,0,0,1,11.32,11.32ZM232,128A104,104,0,1,1,128,24,104.11,104.11,0,0,1,232,128Zm-16,0a88,88,0,1,0-88,88A88.1,88.1,0,0,0,216,128Z"></path>
            </svg>
            <span x-text="message" class="font-medium"></span>
        </div>
    </div>
</x-app-layout>
