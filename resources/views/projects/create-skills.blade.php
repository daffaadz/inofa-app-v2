<x-app-layout>
    <x-slot name="title">Post a New Project - Skills</x-slot>

    <div class="min-h-screen bg-neutral-10 py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8 mt-16">
                <h1 class="text-h-3 text-neutral-1000 mb-2">Post a New Project</h1>
                <p class="text-b-1 text-neutral-500">Tell us about your project and we'll help you find the perfect
                    developer</p>
            </div>

            <!-- Progress Steps -->
            <div class="mb-12">
                <div class="flex items-start justify-between max-w-2xl mx-auto">
                    <!-- Step 1 - Completed -->
                    <div class="flex flex-col items-center">
                        <div
                            class="w-12 h-12 rounded-full bg-primary-500 text-white flex items-center justify-center mb-2">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <span class="text-b-2 font-medium text-primary-500">Details</span>
                    </div>

                    <div class="flex-1 h-1 bg-primary-500 mx-4 mt-6"></div>

                    <!-- Step 2 - Active -->
                    <div class="flex flex-col items-center">
                        <div
                            class="w-12 h-12 rounded-full bg-primary-500 text-white flex items-center justify-center text-b-1 font-semibold mb-2">
                            2
                        </div>
                        <span class="text-b-2 font-medium text-primary-500">Skills</span>
                    </div>

                    <div class="flex-1 h-1 bg-neutral-200 mx-4 mt-6"></div>

                    <!-- Step 3 -->
                    <div class="flex flex-col items-center">
                        <div
                            class="w-12 h-12 rounded-full bg-neutral-200 text-neutral-500 flex items-center justify-center text-b-1 font-semibold mb-2">
                            3
                        </div>
                        <span class="text-b-2 text-neutral-500">Budget</span>
                    </div>

                    <div class="flex-1 h-1 bg-neutral-200 mx-4 mt-6"></div>

                    <!-- Step 4 -->
                    <div class="flex flex-col items-center">
                        <div
                            class="w-12 h-12 rounded-full bg-neutral-200 text-neutral-500 flex items-center justify-center text-b-1 font-semibold mb-2">
                            4
                        </div>
                        <span class="text-b-2 text-neutral-500 mt-6">Attachments</span>
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-lg shadow-sm p-8 mb-6">
                <h2 class="text-h-5 text-neutral-1000 mb-2">Skills & Expertise</h2>
                <p class="text-b-2 text-neutral-500 mb-8">Select the skills required for your project</p>

                <form id="projectkillsForm" action="{{ route('consumer.project.storeSkills') }}" method="POST">
                    @csrf

                    <!-- Selected Skills -->
                    <div class="mb-6">
                        <h3 class="text-b-1 font-medium text-neutral-800 mb-3">Selected Skills (<span
                                id="selectedCount">3</span>)</h3>
                        <div id="selectedSkills" class="flex flex-wrap gap-2">
                            <span
                                class="inline-flex items-center px-4 py-2 bg-primary-500 text-white rounded-full text-b-2 font-medium">
                                React
                                <button type="button" class="ml-2 hover:text-neutral-200" onclick="removeSkill(this)">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </span>
                            <span
                                class="inline-flex items-center px-4 py-2 bg-primary-500 text-white rounded-full text-b-2 font-medium">
                                Python
                                <button type="button" class="ml-2 hover:text-neutral-200" onclick="removeSkill(this)">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </span>
                            <span
                                class="inline-flex items-center px-4 py-2 bg-primary-500 text-white rounded-full text-b-2 font-medium">
                                Vue.js
                                <button type="button" class="ml-2 hover:text-neutral-200" onclick="removeSkill(this)">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </span>
                        </div>
                    </div>

                    <!-- Search & Add Skills -->
                    <div class="mb-6">
                        <h3 class="text-b-1 font-medium text-neutral-800 mb-3">Search & Add Skills</h3>
                        <input type="text" id="searchSkills" placeholder="Search for skills..."
                            class="w-full px-4 py-3 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent text-b-1 text-neutral-800 placeholder-neutral-400 mb-4">

                        <!-- Skills Grid -->
                        <div class="grid grid-cols-3 gap-3">
                            <button type="button"
                                class="px-4 py-3 border border-neutral-300 rounded-lg text-b-2 text-neutral-700 hover:border-primary-500 hover:bg-primary-50 transition-colors text-left"
                                onclick="addSkill(this)">
                                React
                            </button>
                            <button type="button"
                                class="px-4 py-3 border border-neutral-300 rounded-lg text-b-2 text-neutral-700 hover:border-primary-500 hover:bg-primary-50 transition-colors text-left"
                                onclick="addSkill(this)">
                                Node.js
                            </button>
                            <button type="button"
                                class="px-4 py-3 border border-neutral-300 rounded-lg text-b-2 text-neutral-700 hover:border-primary-500 hover:bg-primary-50 transition-colors text-left"
                                onclick="addSkill(this)">
                                Python
                            </button>
                            <button type="button"
                                class="px-4 py-3 border border-neutral-300 rounded-lg text-b-2 text-neutral-700 hover:border-primary-500 hover:bg-primary-50 transition-colors text-left"
                                onclick="addSkill(this)">
                                TypeScript
                            </button>
                            <button type="button"
                                class="px-4 py-3 border border-neutral-300 rounded-lg text-b-2 text-neutral-700 hover:border-primary-500 hover:bg-primary-50 transition-colors text-left"
                                onclick="addSkill(this)">
                                Vue.js
                            </button>
                            <button type="button"
                                class="px-4 py-3 border border-neutral-300 rounded-lg text-b-2 text-neutral-700 hover:border-primary-500 hover:bg-primary-50 transition-colors text-left"
                                onclick="addSkill(this)">
                                Angular
                            </button>
                            <button type="button"
                                class="px-4 py-3 border border-neutral-300 rounded-lg text-b-2 text-neutral-700 hover:border-primary-500 hover:bg-primary-50 transition-colors text-left"
                                onclick="addSkill(this)">
                                Django
                            </button>
                            <button type="button"
                                class="px-4 py-3 border border-neutral-300 rounded-lg text-b-2 text-neutral-700 hover:border-primary-500 hover:bg-primary-50 transition-colors text-left"
                                onclick="addSkill(this)">
                                AWS
                            </button>
                            <button type="button"
                                class="px-4 py-3 border border-neutral-300 rounded-lg text-b-2 text-neutral-700 hover:border-primary-500 hover:bg-primary-50 transition-colors text-left"
                                onclick="addSkill(this)">
                                Docker
                            </button>
                            <button type="button"
                                class="px-4 py-3 border border-neutral-300 rounded-lg text-b-2 text-neutral-700 hover:border-primary-500 hover:bg-primary-50 transition-colors text-left"
                                onclick="addSkill(this)">
                                MongoDB
                            </button>
                            <button type="button"
                                class="px-4 py-3 border border-neutral-300 rounded-lg text-b-2 text-neutral-700 hover:border-primary-500 hover:bg-primary-50 transition-colors text-left"
                                onclick="addSkill(this)">
                                PostgreSQL
                            </button>
                            <button type="button"
                                class="px-4 py-3 border border-neutral-300 rounded-lg text-b-2 text-neutral-700 hover:border-primary-500 hover:bg-primary-50 transition-colors text-left"
                                onclick="addSkill(this)">
                                GraphQL
                            </button>
                            <button type="button"
                                class="px-4 py-3 border border-neutral-300 rounded-lg text-b-2 text-neutral-700 hover:border-primary-500 hover:bg-primary-50 transition-colors text-left"
                                onclick="addSkill(this)">
                                Next.js
                            </button>
                            <button type="button"
                                class="px-4 py-3 border border-neutral-300 rounded-lg text-b-2 text-neutral-700 hover:border-primary-500 hover:bg-primary-50 transition-colors text-left"
                                onclick="addSkill(this)">
                                Tailwind CSS
                            </button>
                            <button type="button"
                                class="px-4 py-3 border border-neutral-300 rounded-lg text-b-2 text-neutral-700 hover:border-primary-500 hover:bg-primary-50 transition-colors text-left"
                                onclick="addSkill(this)">
                                REST API
                            </button>
                            <button type="button"
                                class="px-4 py-3 border border-neutral-300 rounded-lg text-b-2 text-neutral-700 hover:border-primary-500 hover:bg-primary-50 transition-colors text-left"
                                onclick="addSkill(this)">
                                Flutter
                            </button>
                            <button type="button"
                                class="px-4 py-3 border border-neutral-300 rounded-lg text-b-2 text-neutral-700 hover:border-primary-500 hover:bg-primary-50 transition-colors text-left"
                                onclick="addSkill(this)">
                                React Native
                            </button>
                            <button type="button"
                                class="px-4 py-3 border border-neutral-300 rounded-lg text-b-2 text-neutral-700 hover:border-primary-500 hover:bg-primary-50 transition-colors text-left"
                                onclick="addSkill(this)">
                                Kubernetes
                            </button>
                            <button type="button"
                                class="px-4 py-3 border border-neutral-300 rounded-lg text-b-2 text-neutral-700 hover:border-primary-500 hover:bg-primary-50 transition-colors text-left"
                                onclick="addSkill(this)">
                                Firebase
                            </button>
                            <button type="button"
                                class="px-4 py-3 border border-neutral-300 rounded-lg text-b-2 text-neutral-700 hover:border-primary-500 hover:bg-primary-50 transition-colors text-left"
                                onclick="addSkill(this)">
                                Laravel
                            </button>
                        </div>
                    </div>

                    <!-- Tips Box -->
                    <div class="bg-yellow-100 border border-yellow-200 rounded-lg p-6 mb-8">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-yellow-600 mr-2 mt-0.5 flex-shrink-0" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd" />
                            </svg>
                            <div>
                                <h3 class="text-b-1 font-semibold text-neutral-800 mb-1">Tip</h3>
                                <p class="text-b-2 text-neutral-700">Add 3-5 relevant skills to help developers
                                    understand your project requirements. You can always add more later.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex items-center justify-between">
                        <a href="{{ route('consumer.project.create') }}"
                            class="inline-flex items-center px-6 py-3 border border-primary-500 text-primary-500 rounded-lg text-b-1 font-medium hover:bg-primary-50 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                            Back
                        </a>

                        <button type="submit"
                            class="inline-flex items-center px-6 py-3 bg-primary-500 text-white rounded-lg text-b-1 font-medium hover:bg-primary-600 transition-colors">
                            Next
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Step Indicator -->
            <div class="text-center">
                <p class="text-b-2 text-neutral-500">Step 2 of 4</p>
            </div>
        </div>
    </div>

    <script>
        function addSkill(button) {
            // Implementation for adding skill
            console.log('Adding skill:', button.textContent);
        }

        function removeSkill(button) {
            button.closest('span').remove();
            updateSelectedCount();
        }

        function updateSelectedCount() {
            const count = document.querySelectorAll('#selectedSkills span').length;
            document.getElementById('selectedCount').textContent = count;
        }

        // Form submission
        document.getElementById('projectkillsForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            window.location.href = "{{ route('consumer.project.createBudget') }}";
        });
    </script>
</x-app-layout>
