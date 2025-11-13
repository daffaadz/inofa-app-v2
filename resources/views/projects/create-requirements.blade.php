<x-app-layout>
    <x-slot name="title">Post a New Project - Requirements</x-slot>

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

                    <!-- Step 2 - Completed -->
                    <div class="flex flex-col items-center">
                        <div
                            class="w-12 h-12 rounded-full bg-primary-500 text-white flex items-center justify-center mb-2">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <span class="text-b-2 font-medium text-primary-500">Skills</span>
                    </div>

                    <div class="flex-1 h-1 bg-primary-500 mx-4 mt-6"></div>

                    <!-- Step 3 - Completed -->
                    <div class="flex flex-col items-center">
                        <div
                            class="w-12 h-12 rounded-full bg-primary-500 text-white flex items-center justify-center mb-2">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <span class="text-b-2 font-medium text-primary-500">Budget</span>
                    </div>

                    <div class="flex-1 h-1 bg-primary-500 mx-4 mt-6"></div>

                    <!-- Step 4 - Active -->
                    <div class="flex flex-col items-center">
                        <div
                            class="w-12 h-12 rounded-full bg-primary-500 text-white flex items-center justify-center text-b-1 font-semibold mb-2">
                            4
                        </div>
                        <span class="text-b-2 font-medium text-primary-500 mt-6">Requirements</span>
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-lg shadow-sm p-8 mb-6">
                <h2 class="text-h-5 text-neutral-1000 mb-2">Project Requirements</h2>
                <p class="text-b-2 text-neutral-500 mb-8">Define specific requirements for your project (optional but recommended)</p>

                <form id="projectRequirementsForm" action="{{ route('consumer.project.storeRequirements') }}"
                    method="POST">
                    @csrf

                    <!-- Requirements List -->
                    <div id="requirementsList" class="space-y-4 mb-6">
                        <!-- Requirements will be added here dynamically -->
                    </div>

                    <!-- Add Requirement Button -->
                    <button type="button" id="addRequirementBtn"
                        class="inline-flex items-center px-4 py-2 border-2 border-dashed border-neutral-300 text-neutral-600 rounded-lg text-b-1 font-medium hover:border-primary-500 hover:text-primary-500 hover:bg-primary-50 transition-colors mb-8">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Add Requirement
                    </button>

                    <!-- Tips Box -->
                    <div class="bg-green-100 border border-green-200 rounded-lg p-6 mb-8">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-primary-500 mr-3 mt-0.5 flex-shrink-0" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd" />
                            </svg>
                            <div>
                                <h3 class="text-b-1 font-semibold text-neutral-800 mb-3">Tips for good requirements:</h3>
                                <ul class="space-y-2">
                                    <li class="flex items-start">
                                        <svg class="w-5 h-5 text-primary-500 mr-2 mt-0.5 flex-shrink-0"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span class="text-b-2 text-neutral-700">Be specific and clear about what you need</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-5 h-5 text-primary-500 mr-2 mt-0.5 flex-shrink-0"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span class="text-b-2 text-neutral-700">Prioritize requirements (Must have, Should have, Nice to have)</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-5 h-5 text-primary-500 mr-2 mt-0.5 flex-shrink-0"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span class="text-b-2 text-neutral-700">Include technical specifications if needed</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex items-center justify-between">
                        <a href="{{ route('consumer.project.createBudget') }}"
                            class="inline-flex items-center px-6 py-3 border border-primary-500 text-primary-500 rounded-lg text-b-1 font-medium hover:bg-primary-50 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                            Back
                        </a>

                        <button type="submit"
                            class="inline-flex items-center px-6 py-3 bg-primary-500 text-white rounded-lg text-b-1 font-medium hover:bg-primary-600 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                            Post Project
                        </button>
                    </div>
                </form>
            </div>

            <!-- Step Indicator -->
            <div class="text-center">
                <p class="text-b-2 text-neutral-500">Step 4 of 4</p>
            </div>
        </div>
    </div>

    <script>
        let requirementIndex = 0;
        const requirementsList = document.getElementById('requirementsList');
        const addRequirementBtn = document.getElementById('addRequirementBtn');

        // Add initial requirement
        addRequirement();

        // Add requirement button click
        addRequirementBtn.addEventListener('click', () => {
            addRequirement();
        });

        function addRequirement() {
            const requirementItem = document.createElement('div');
            requirementItem.className = 'requirement-item bg-neutral-50 border border-neutral-200 rounded-lg p-6';
            requirementItem.dataset.index = requirementIndex;
            
            requirementItem.innerHTML = `
                <div class="flex items-start justify-between mb-4">
                    <h3 class="text-b-1 font-semibold text-neutral-800">Requirement ${requirementIndex + 1}</h3>
                    <button type="button" onclick="removeRequirement(${requirementIndex})" class="text-neutral-400 hover:text-red-500 transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
                
                <div class="space-y-4">
                    <!-- Type -->
                    <div>
                        <label class="block text-b-2 font-medium text-neutral-700 mb-2">Type</label>
                        <select name="requirements[${requirementIndex}][type]" required
                            class="w-full px-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            <option value="">Select type</option>
                            <option value="feature">Feature</option>
                            <option value="technical">Technical Specification</option>
                            <option value="deliverable">Deliverable</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-b-2 font-medium text-neutral-700 mb-2">Description</label>
                        <textarea name="requirements[${requirementIndex}][description]" rows="3" required maxlength="500"
                            placeholder="Describe this requirement in detail..."
                            class="w-full px-4 py-3 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent resize-none"></textarea>
                        <p class="text-b-3 text-neutral-500 mt-1">Maximum 500 characters</p>
                    </div>

                    <!-- Priority -->
                    <div>
                        <label class="block text-b-2 font-medium text-neutral-700 mb-2">Priority</label>
                        <div class="flex space-x-3">
                            <label class="flex-1 cursor-pointer">
                                <input type="radio" name="requirements[${requirementIndex}][priority]" value="must_have" required class="peer sr-only">
                                <div class="px-4 py-2 border-2 border-neutral-300 rounded-lg text-center peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:text-red-700 hover:border-neutral-400 transition-colors">
                                    <span class="text-b-2 font-medium">Must Have</span>
                                </div>
                            </label>
                            <label class="flex-1 cursor-pointer">
                                <input type="radio" name="requirements[${requirementIndex}][priority]" value="should_have" class="peer sr-only">
                                <div class="px-4 py-2 border-2 border-neutral-300 rounded-lg text-center peer-checked:border-yellow-500 peer-checked:bg-yellow-50 peer-checked:text-yellow-700 hover:border-neutral-400 transition-colors">
                                    <span class="text-b-2 font-medium">Should Have</span>
                                </div>
                            </label>
                            <label class="flex-1 cursor-pointer">
                                <input type="radio" name="requirements[${requirementIndex}][priority]" value="nice_to_have" class="peer sr-only">
                                <div class="px-4 py-2 border-2 border-neutral-300 rounded-lg text-center peer-checked:border-green-500 peer-checked:bg-green-50 peer-checked:text-green-700 hover:border-neutral-400 transition-colors">
                                    <span class="text-b-2 font-medium">Nice to Have</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            `;

            requirementsList.appendChild(requirementItem);
            requirementIndex++;
        }

        function removeRequirement(index) {
            const item = document.querySelector(`.requirement-item[data-index="${index}"]`);
            if (item) {
                item.remove();
            }
            
            // Renumber remaining requirements
            const items = document.querySelectorAll('.requirement-item');
            items.forEach((item, i) => {
                const title = item.querySelector('h3');
                if (title) {
                    title.textContent = `Requirement ${i + 1}`;
                }
            });
        }

        // Form submission
        document.getElementById('projectRequirementsForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const requirements = [];

            // Collect all requirements
            const items = document.querySelectorAll('.requirement-item');
            items.forEach((item, index) => {
                const type = item.querySelector(`select[name*="[type]"]`)?.value;
                const description = item.querySelector(`textarea[name*="[description]"]`)?.value;
                const priority = item.querySelector(`input[name*="[priority]"]:checked`)?.value;

                if (type && description && priority) {
                    requirements.push({
                        type,
                        description,
                        priority
                    });
                }
            });

            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ requirements })
                });

                const data = await response.json();

                if (data.status) {
                    // Final submit to store all data
                    const finalResponse = await fetch("{{ route('consumer.project.store') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                        }
                    });

                    const finalData = await finalResponse.json();

                    if (finalData.status) {
                        // Redirect to success page or project list
                        window.location.href = "{{ route('consumer.project.index') }}";
                    } else {
                        alert('Error: ' + (finalData.message || 'Failed to create project'));
                    }
                } else {
                    alert('Error: ' + (data.message || 'Failed to save requirements'));
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            }
        });
    </script>
</x-app-layout>