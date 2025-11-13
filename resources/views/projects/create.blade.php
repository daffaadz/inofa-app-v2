<x-app-layout>
    <x-slot name="title">Post a New Project</x-slot>

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
                    <!-- Step 1 - Active -->
                    <div class="flex flex-col items-center">
                        <div
                            class="w-12 h-12 rounded-full bg-primary-500 text-white flex items-center justify-center text-b-1 font-semibold mb-2">
                            1
                        </div>
                        <span class="text-b-2 font-medium text-primary-500">Details</span>
                    </div>

                    <div class="flex-1 h-1 bg-neutral-200 mx-4 mt-6"></div>

                    <!-- Step 2 -->
                    <div class="flex flex-col items-center">
                        <div
                            class="w-12 h-12 rounded-full bg-neutral-200 text-neutral-500 flex items-center justify-center text-b-1 font-semibold mb-2">
                            2
                        </div>
                        <span class="text-b-2 text-neutral-500">Skills</span>
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
                        <span class="text-b-2 text-neutral-500">Requirements</span>
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-lg shadow-sm p-8 mb-6">
                <h2 class="text-h-5 text-neutral-1000 mb-2">Project Details</h2>
                <p class="text-b-2 text-neutral-500 mb-8">Provide the basic information about your project</p>

                <form id="projectDetailsForm" action="{{ route('consumer.project.storeDetails') }}" method="POST">
                    @csrf

                    <!-- Project Title -->
                    <div class="mb-6">
                        <label for="title" class="block text-b-1 font-medium text-neutral-800 mb-2">
                            Project Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="title" name="title"
                            placeholder="e.g., Build a modern e-commerce website"
                            class="w-full px-4 py-3 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent text-b-1 text-neutral-800 placeholder-neutral-400"
                            required>
                    </div>

                    <!-- Project Description -->
                    <div class="mb-6">
                        <label for="description" class="block text-b-1 font-medium text-neutral-800 mb-2">
                            Project Description <span class="text-red-500">*</span>
                        </label>
                        <textarea id="description" name="description" rows="6"
                            placeholder="Describe your project in detail. Include the goals, features, and any specific requirements you have..."
                            class="w-full px-4 py-3 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent text-b-1 text-neutral-800 placeholder-neutral-400 resize-none"
                            required></textarea>
                        <p class="text-b-3 text-neutral-400 mt-1">0 characters</p>
                    </div>

                    <!-- Tips Box -->
                    <div class="bg-green-100 border border-green-200 rounded-lg p-6 mb-8">
                        <h3 class="text-b-1 font-semibold text-neutral-800 mb-3">Tips for a great project description:
                        </h3>
                        <ul class="space-y-2">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-primary-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-b-2 text-neutral-700">Be specific about what you want to
                                    achieve</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-primary-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-b-2 text-neutral-700">Include any design preferences or
                                    examples</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-primary-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-b-2 text-neutral-700">Mention any existing systems to integrate
                                    with</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex items-center justify-between">
                        <a href="{{ route('consumer.dashboard') }}"
                            class="inline-flex items-center px-6 py-3 border border-neutral-300 rounded-lg text-b-1 font-medium text-neutral-700 bg-white hover:bg-neutral-50 transition-colors">
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
                <p class="text-b-2 text-neutral-500">Step 1 of 4</p>
            </div>
        </div>
    </div>

    <script>
        // Character counter
        const description = document.getElementById('description');
        const counter = description.nextElementSibling;

        description.addEventListener('input', function() {
            counter.textContent = `${this.value.length} characters`;
        });

        // Form submission
        document.getElementById('projectDetailsForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json',
                    },
                    body: formData
                });

                const data = await response.json();

                if (data.status) {
                    window.location.href = "{{ route('consumer.project.createSkills') }}";
                }
            } catch (error) {
                console.error('Error:', error);
            }
        });
    </script>
</x-app-layout>
