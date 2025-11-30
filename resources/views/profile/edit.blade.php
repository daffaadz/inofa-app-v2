<x-app-layout>
    <x-slot:title>{{ __('My Profile - Inofa') }}</x-slot:title>
    <section class="min-h-screen">

        <!-- ===== SIDEBAR ===== -->
        @include('partials.global-sidebar')

        <!-- ===== MAIN CONTENT ===== -->
        <div class="ml-[18rem] pt-8">
            <div class="max-w-7xl mx-auto mt-16">
                <!-- Header Section with Tab Navigation -->
                <div class="mb-6">
                    <div class="flex flex-col items-start justify-between mb-2 gap-6 px-6">
                        <div class="flex items-center gap-4">
                            <div class="bg-gradient-to-br from-primary-500/10 to-secondary-500/20 p-3 rounded-xl">
                                <img src="{{ asset('assets/vector/sidebar/akun-saya.svg') }}" alt="akun saya"
                                    class="w-8 h-auto text-primary-500">
                            </div>

                            <div>
                                <h1 class="text-h-7 font-normal text-neutral-1000 mb-1">Akun Saya</h1>
                                <p class="text-b-1 text-neutral-500">Manage your profile, settings, and preferences</p>
                            </div>
                        </div>

                        <!-- Tab Navigation -->
                        <div class="flex gap-4">
                            <button onclick="switchTab('profile')" id="tab-profile"
                                class="tab-btn px-4 py-2 text-b-1 font-medium rounded-xl border  border-primary-500 bg-primary-500 shadow-xl text-neutral-10 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke= "currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Profile
                            </button>

                            <div class="flex gap-4">
                                @if (Auth::user()->role === 'developer')
                                    <button onclick="switchTab('skills')" id="tab-skills"
                                        class="tab-btn px-4 py-2 text-b-1 font-medium rounded-xl border border-neutral-500 text-neutral-500 hover:text-neutral-700 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                                        </svg>
                                        Skills & Expertise
                                    </button>

                                    <button onclick="switchTab('portfolio')" id="tab-portfolio"
                                        class="tab-btn px-4 py-2 text-b-1 font-medium rounded-xl border border-neutral-500 text-neutral-500 hover:text-neutral-700 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                        Portfolio
                                    </button>
                                @endif

                                <button onclick="switchTab('security')" id="tab-security"
                                    class="tab-btn px-4 py-2 text-b-1 font-medium rounded-xl border border-neutral-500 text-neutral-500 hover:text-neutral-700 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                    Security
                                </button>

                                <button onclick="switchTab('preferences')" id="tab-preferences"
                                    class="tab-btn px-4 py-2 text-b-1 font-medium rounded-xl border border-neutral-500 text-neutral-500 hover:text-neutral-700 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
                                    Preferences
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Border separator -->
                <div class="bg-white rounded-t-lg shadow-sm border-b border-neutral-100 h-1"></div>

                <!-- Toast Notification Container -->
                <div id="toast-container" class="fixed top-24 right-8 z-50 space-y-3" style="max-width: 400px;"></div>

                <!-- Content Area -->
                <div class="bg-neutral-10 rounded-b-lg shadow-sm pb-8">
                    <div class="flex gap-8 p-8">
                        <!-- Left Sidebar - User Card -->
                        <div class="w-96 flex-shrink-0">
                            @include('profile.partials.user-card')
                        </div>

                        <!-- Right Content -->
                        <div class="flex-1 bg-white rounded-xl shadow-sm p-6">
                            <!-- Profile Tab -->
                            <div id="content-profile" class="tab-content">
                                @include('profile.partials.update-profile-information-form')
                            </div>

                            <!-- Security Tab -->
                            <div id="content-security" class="tab-content hidden">
                                @include('profile.partials.update-password-form')
                            </div>

                            <!-- Preferences Tab -->
                            <div id="content-preferences" class="tab-content hidden">
                                @include('profile.partials.delete-user-form')
                            </div>

                            @if (Auth::user()->role === 'developer')
                                <!-- Portfolio Tab -->
                                <div id="content-portfolio" class="tab-content hidden">
                                    @include('profile.partials.portfolio-form')
                                </div>

                                <!-- Skills Tab -->
                                <div id="content-skills" class="tab-content hidden">
                                    @include('profile.partials.update-skills-form')
                                </div>
                            @endif
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
                el.classList.remove('text-neutral-10', 'border-primary-500', 'shadow-xl', 'bg-primary-500');
                el.classList.add('text-neutral-500', 'hover:text-neutral-700', 'border-neutral-500', 'bg-white',
                    'shadow-none');
            });

            // Show selected content
            document.getElementById('content-' + tabName).classList.remove('hidden');

            // Highlight selected tab
            const selectedTab = document.getElementById('tab-' + tabName);
            selectedTab.classList.remove('text-neutral-500', 'hover:text-neutral-700', 'border-neutral-500', 'bg-white', 'shadow-none');
            selectedTab.classList.add('text-neutral-10', 'border-primary-500', 'shadow-xl', 'bg-primary-500');

            // Update camera button visibility
            if (typeof updateCameraButtonVisibility === 'function') {
                updateCameraButtonVisibility();
            }
        }

        // Toast notification system
        function showToast(message, type = 'success') {
            const toastContainer = document.getElementById('toast-container');
            const toast = document.createElement('div');

            const bgColors = {
                'success': 'bg-green-50 border-green-200 text-green-700',
                'error': 'bg-red-50 border-red-200 text-red-700',
                'info': 'bg-primary-50 border-primary-200 text-primary-700'
            };

            const icons = {
                'success': '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>',
                'error': '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>',
                'info': '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>'
            };

            toast.className =
                `${bgColors[type]} rounded-xl p-4 border shadow-lg transform transition-all duration-300 ease-out translate-x-full opacity-0`;
            toast.innerHTML = `
                <div class="flex items-center gap-3">
                    ${icons[type]}
                    <span class="font-medium flex-1">${message}</span>
                    <button onclick="this.parentElement.parentElement.remove()" class="hover:opacity-70 transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            `;

            toastContainer.appendChild(toast);

            // Trigger animation
            setTimeout(() => {
                toast.classList.remove('translate-x-full', 'opacity-0');
            }, 10);

            // Auto dismiss after 5 seconds
            setTimeout(() => {
                toast.classList.add('translate-x-full', 'opacity-0');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }, 5000);
        }

        // Show initial toast if there's a session status
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('status'))
                @if (session('status') === 'avatar-updated')
                    showToast('Avatar updated successfully!', 'success');
                @elseif (session('status') === 'profile-updated')
                    showToast('Profile updated successfully!', 'success');
                @elseif (session('status') === 'password-updated')
                    showToast('Password updated successfully!', 'success');
                @endif
            @endif

            @if ($errors->any())
                showToast('{{ $errors->first() }}', 'error');
            @endif
        });
    </script>
</x-app-layout>
