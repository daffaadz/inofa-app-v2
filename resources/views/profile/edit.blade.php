<x-app-layout>
    <x-slot:title>{{ __('My Profile - Inofa') }}</x-slot:title>
    <section class="min-h-screen flex bg-neutral-10">

        <!-- ===== SIDEBAR ===== -->
        @include('partials.global-sidebar')

        <!-- ===== MAIN CONTENT ===== -->
        <div class="flex-1 ml-[18rem]">
            <div class="max-w-7xl mx-auto mt-16">
                <!-- Header Section -->
                <div class="bg-primary-100 rounded-lg p-6 mb-6">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-full bg-primary-500 flex items-center justify-center">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-h-5 text-neutral-1000">{{ Auth::user()->name }}</h1>
                            <p class="text-b-2 text-neutral-500">Manage your profile, settings, and preferences</p>
                        </div>
                    </div>
                </div>

                <!-- Tab Navigation -->
                <div class="bg-white rounded-lg shadow-sm mb-6">
                    <div class="flex border-b border-neutral-100">
                        <button onclick="switchTab('profile')" id="tab-profile"
                            class="tab-btn px-6 py-4 text-b-1 font-medium text-white bg-primary-500 border-b-2 border-primary-500 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Profile
                        </button>

                        @if (Auth::user()->role === 'developer')
                            <button onclick="switchTab('skills')" id="tab-skills"
                                class="tab-btn px-6 py-4 text-b-1 font-medium text-neutral-500 hover:text-neutral-700 hover:bg-neutral-10 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                                </svg>
                                Skills & Expertise
                            </button>

                            <button onclick="switchTab('portfolio')" id="tab-portfolio"
                                class="tab-btn px-6 py-4 text-b-1 font-medium text-neutral-500 hover:text-neutral-700 hover:bg-neutral-10 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                                Portfolio
                            </button>
                        @endif

                        <button onclick="switchTab('security')" id="tab-security"
                            class="tab-btn px-6 py-4 text-b-1 font-medium text-neutral-500 hover:text-neutral-700 hover:bg-neutral-10 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            Security
                        </button>

                        <button onclick="switchTab('preferences')" id="tab-preferences"
                            class="tab-btn px-6 py-4 text-b-1 font-medium text-neutral-500 hover:text-neutral-700 hover:bg-neutral-10 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            Preferences
                        </button>
                    </div>
                </div>

                <!-- Content Area -->
                <div class="flex gap-6">
                    <!-- Left Sidebar - User Card -->
                    <div class="w-80 flex-shrink-0">
                        @include('profile.partials.user-card')
                    </div>

                    <!-- Right Content -->
                    <div class="flex-1">
                        <!-- Profile Tab -->
                        <div id="content-profile" class="tab-content">
                            @include('profile.partials.update-profile-information-form')
                        </div>

                        @if (Auth::user()->role === 'developer')
                            <!-- Skills Tab -->
                            <div id="content-skills" class="tab-content hidden">
                                @include('profile.partials.update-skills-form')
                            </div>

                            <!-- Portfolio Tab -->
                            <div id="content-portfolio" class="tab-content hidden">
                                @include('profile.partials.portfolio-form')
                            </div>
                        @endif

                        <!-- Security Tab -->
                        <div id="content-security" class="tab-content hidden">
                            @include('profile.partials.update-password-form')
                        </div>

                        <!-- Preferences Tab -->
                        <div id="content-preferences" class="tab-content hidden">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function switchTab(tabName) {
            // Hide all content
            document.querySelectorAll('.tab-content').forEach(el => {
                el.classList.add('hidden');
            });

            // Reset all tabs
            document.querySelectorAll('.tab-btn').forEach(el => {
                el.classList.remove('text-white', 'bg-primary-500', 'border-b-2', 'border-primary-500');
                el.classList.add('text-neutral-500', 'hover:text-neutral-700', 'hover:bg-neutral-10');
            });

            // Show selected content
            document.getElementById('content-' + tabName).classList.remove('hidden');

            // Highlight selected tab
            const selectedTab = document.getElementById('tab-' + tabName);
            selectedTab.classList.remove('text-neutral-500', 'hover:text-neutral-700', 'hover:bg-neutral-10');
            selectedTab.classList.add('text-white', 'bg-primary-500', 'border-b-2', 'border-primary-500');
        }
    </script>
</x-app-layout>
