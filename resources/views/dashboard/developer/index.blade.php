<x-app-layout>
    <x-slot:title>{{ __('Dashboard Anda - Inofa') }}</x-slot:title>
    <section class="min-h-screen flex">

        <!-- ===== SIDEBAR ===== -->
        @include('partials.developer-sidebar')

        <!-- ===== MAIN CONTENT ===== -->
        <div class="flex-1 ml-[18rem]">

            <!-- MAIN CONTENT AREA -->
            <div class="mt-16">

                <!-- HEADER SECTION -->
                <div
                    class="p-8 pb-16 flex flex-row items-center justify-between border-b-[0.5px] border-neutral-100 bg-neutral-0">
                    <div>
                        <h1 class="text-h-3 font-bold text-neutral-900">Developer Dashboard</h1>
                        <p class="mt-1 text-b-1 text-neutral-600">Welcome back! Here's what's happening with your
                            projects
                        </p>
                    </div>

                    <div>
                        <a href="{{ route('search.developers.show', auth()->user()->id) }}" target="_blank"
                            class="inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-primary-500 text-neutral-0
                                hover:bg-primary-600 hover:scale-[1.02] active:scale-[0.98]
                                [box-shadow:inset_0_2px_4px_0_rgba(0,0,0,0.06),0_4px_12px_rgba(16,138,0,0.25)]
                                transition-all duration-200 group">

                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 20 20">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.66667"
                                    d="M1.72 10.29c-.07-.19-.07-.4 0-.59C2.4 8.07 3.54 6.67 5.02 5.68c1.47-.99 3.2-1.51 4.98-1.51s3.51.52 4.98 1.51c1.48.99 2.62 2.39 3.3 4.02.07.19.07.4 0 .59-.68 1.63-1.82 3.03-3.3 4.02-1.47.99-3.2 1.51-4.98 1.51s-3.51-.52-4.98-1.51C3.54 13.32 2.4 11.92 1.72 10.29z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.66667"
                                    d="M10 12.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" />
                            </svg>

                            {{-- Label --}}
                            <span class="text-b-1 font-light">View Public Profile</span>
                        </a>
                    </div>
                </div>

                <!-- ===== KEY STATS GRID ===== -->
                <div class="p-8 bg-neutral-10/50">
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
                            <p class="text-b-3 text-primary-500">+2 from last month</p>
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
                            <p class="text-b-3 text-primary-600">+Rp.2,100 this month</p>
                        </div>

                        <!-- Pending Inquiries -->
                        <div
                            class="bg-white rounded-2xl border border-neutral-200 p-6 relative overflow-hidden hover:shadow-lg transition">
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
                                    class="px-4 py-2 bg-blue-100 text-blue-600 text-b-3 font-medium rounded-xl">{{ __('New') }}</span>
                            </div>
                            <p class="text-b-1 text-neutral-600 mb-1">Pending Inquiries</p>
                            <p class="text-h-3 font-bold text-neutral-900 mb-4">
                                {{ $myOffers->where('status', 'pending')->count() }}</p>
                            <p class="text-b-3 text-blue-500">Respond quickly to win!</p>
                        </div>

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
                            <p class="text-b-3 text-yellow-600">+127 this week</p>
                        </div>

                    </div>
                </div>

                <!-- ===== MY ACTIVE PROJECTS ===== -->
                <div class="p-8 bg-neutral-10/50">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h2 class="text-h-5 font-bold text-neutral-900">My Active Projects</h2>
                            <p class="text-b-1 text-neutral-600">Track your ongoing work and deadlines</p>
                        </div>
                        <a href="{{ route('developer.agreements.index') }}"
                            class="text-primary-500 text-b-1 font-medium hover:underline flex items-center gap-1">
                            View All
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>

                    <div class="space-y-4">
                        @forelse($activeAgreements as $agreement)
                            <div class="bg-white rounded-2xl border border-neutral-200 p-6 hover:shadow-lg transition">
                                <div class="flex items-start justify-between gap-6">

                                    <!-- Left Content -->
                                    <div class="flex-1">
                                        <div class="flex items-start gap-3 mb-3">
                                            <img src="{{ $agreement->consumer->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($agreement->consumer->name) }}"
                                                alt="{{ $agreement->consumer->name }}"
                                                class="w-10 h-10 rounded-full object-cover">
                                            <div>
                                                <h3 class="text-b-1 font-semibold text-neutral-900">
                                                    {{ $agreement->project->title }}</h3>
                                                <p class="text-b-3 text-neutral-600">Client:
                                                    {{ $agreement->consumer->name }}</p>
                                            </div>
                                        </div>

                                        <!-- Progress Bar -->
                                        <div class="mb-3">
                                            <div class="flex items-center justify-between mb-1">
                                                <span class="text-b-3 text-neutral-600">Progress:
                                                    {{ $agreement->project->progress ?? 65 }}%</span>
                                                <span class="text-b-3 text-neutral-600">Next:
                                                    {{ $agreement->milestones[0]['name'] ?? 'Homepage redesign' }}</span>
                                            </div>
                                            <div class="w-full bg-neutral-200 rounded-full h-2">
                                                <div class="bg-primary-500 h-2 rounded-full transition-all"
                                                    style="width: {{ $agreement->project->progress ?? 65 }}%"></div>
                                            </div>
                                        </div>

                                        <!-- Meta Info -->
                                        <div class="flex items-center gap-4 text-b-3 text-neutral-600">
                                            <span class="flex items-center gap-1">
                                                <span
                                                    class="px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-b-4 font-medium">In
                                                    Progress</span>
                                            </span>
                                            <span class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                    <circle cx="12" cy="12" r="8" />
                                                </svg>
                                                Mar {{ $agreement->end_date->format('d, Y') }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Right Content -->
                                    <div class="flex flex-col items-end gap-3">
                                        <div class="text-right">
                                            <p class="text-h-5 font-bold text-neutral-900">
                                                ${{ number_format($agreement->final_price, 0) }}</p>
                                            <p class="text-b-3 text-neutral-600">Payment</p>
                                            <p
                                                class="text-b-3 text-neutral-600 flex items-center justify-end gap-1 mt-2">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                    <circle cx="12" cy="12" r="8" />
                                                </svg>
                                                {{ $agreement->end_date->format('M d, Y') }}
                                            </p>
                                            <p class="text-b-4 text-neutral-500">Deadline</p>
                                        </div>

                                        <div class="flex gap-2">
                                            <a href="{{ route('landing', ['id' => $agreement->consumer->id]) }}"
                                                class="px-4 py-2 bg-primary-500 text-white text-b-3 font-medium rounded-lg hover:bg-primary-600 transition flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                    <circle cx="12" cy="12" r="8" />
                                                </svg>
                                                Chat
                                            </a>
                                            <a href="{{ route('developer.agreements.show', $agreement) }}"
                                                class="px-4 py-2 border-2 border-primary-500 text-primary-500 text-b-3 font-medium rounded-lg hover:bg-primary-50 transition flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                    <circle cx="12" cy="12" r="8" />
                                                </svg>
                                                View
                                            </a>
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
                                <p class="text-b-1 text-neutral-600 mb-2">No active projects yet</p>
                                <p class="text-b-3 text-neutral-500">Send offers to get hired!</p>
                            </div>
                        @endforelse
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
</x-app-layout>
