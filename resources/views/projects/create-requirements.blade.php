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

    <!-- Preview Modal -->
    <div id="previewModal" class="fixed inset-0 bg-neutral-1000 bg-opacity-50 z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto">
            <!-- Modal Header -->
            <div class="sticky top-0 bg-white border-b border-neutral-200 px-8 py-6 rounded-t-xl">
                <div class="flex items-center justify-between">
                    <h2 class="text-h-5 text-neutral-1000">Your Project's Preview</h2>
                    <button type="button" onclick="closePreviewModal()" class="text-neutral-400 hover:text-neutral-600 transition-colors">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="px-8 py-6 space-y-6">
                <!-- Project Details -->
                <div class="bg-neutral-10 rounded-lg p-6">
                    <h3 class="text-h-6 text-neutral-1000 mb-4">Project Details</h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-b-2 font-semibold text-neutral-700 mb-1">Title</p>
                            <p id="previewTitle" class="text-b-1 text-neutral-1000"></p>
                        </div>
                        <div>
                            <p class="text-b-2 font-semibold text-neutral-700 mb-1">Description</p>
                            <p id="previewDescription" class="text-b-1 text-neutral-1000 whitespace-pre-wrap"></p>
                        </div>
                    </div>
                </div>

                <!-- Budget & Deadline -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-primary-100 rounded-lg p-6">
                        <div class="flex items-center mb-2">
                            <svg class="w-5 h-5 text-primary-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                            </svg>
                            <h3 class="text-b-1 font-semibold text-primary-700">Budget</h3>
                        </div>
                        <p id="previewBudget" class="text-h-5 text-primary-900 font-bold"></p>
                    </div>

                    <div class="bg-secondary-100 rounded-lg p-6">
                        <div class="flex items-center mb-2">
                            <svg class="w-5 h-5 text-secondary-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                            </svg>
                            <h3 class="text-b-1 font-semibold text-secondary-700">Deadline</h3>
                        </div>
                        <p id="previewDeadline" class="text-h-6 text-secondary-900 font-bold"></p>
                    </div>
                </div>

                <!-- Skills Required -->
                <div class="bg-neutral-10 rounded-lg p-6">
                    <h3 class="text-h-6 text-neutral-1000 mb-4">Required Skills</h3>
                    <div id="previewSkills" class="flex flex-wrap gap-2"></div>
                </div>

                <!-- Requirements -->
                <div class="bg-neutral-10 rounded-lg p-6">
                    <h3 class="text-h-6 text-neutral-1000 mb-4">Requirements</h3>
                    <div id="previewRequirements" class="space-y-3"></div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="sticky bottom-0 bg-neutral-10 border-t border-neutral-200 px-8 py-6 rounded-b-xl">
                <div class="flex items-center justify-end space-x-4">
                    <button type="button" onclick="closePreviewModal()"
                        class="px-6 py-3 border border-neutral-300 text-neutral-700 rounded-lg text-b-1 font-medium hover:bg-neutral-100 transition-colors">
                        Cancel
                    </button>
                    <button type="button" onclick="confirmAndSubmit()"
                        class="inline-flex items-center px-6 py-3 bg-primary-500 text-white rounded-lg text-b-1 font-medium hover:bg-primary-600 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Post Project
                    </button>
                </div>
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
                // Save requirements to session first
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
                    // Show preview modal
                    await showPreviewModal(requirements);
                } else {
                    alert('Error: ' + (data.message || 'Failed to save requirements'));
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            }
        });

        async function showPreviewModal(requirements) {
            try {
                // Fetch project data from session via API
                const sessionData = @json([
                    'details' => session('project.details'),
                    'skills' => session('project.skills'),
                    'budget' => session('project.budget')
                ]);

                // Populate modal with data
                document.getElementById('previewTitle').textContent = sessionData.details?.title || 'No title';
                document.getElementById('previewDescription').textContent = sessionData.details?.description || 'No description';
                
                // Format budget
                const budget = sessionData.budget?.budget || 0;
                document.getElementById('previewBudget').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(budget);
                
                // Format deadline
                const deadline = sessionData.budget?.deadline || '';
                const deadlineDate = new Date(deadline);
                const formattedDeadline = deadlineDate.toLocaleDateString('id-ID', { 
                    year: 'numeric', 
                    month: 'long', 
                    day: 'numeric' 
                });
                document.getElementById('previewDeadline').textContent = formattedDeadline;

                // Populate skills
                const skillsContainer = document.getElementById('previewSkills');
                skillsContainer.innerHTML = '';
                
                const levelLabels = ['', 'Beginner', 'Intermediate', 'Advanced', 'Expert'];
                const levelColors = ['', 'bg-blue-100 text-blue-700', 'bg-yellow-100 text-yellow-700', 'bg-secondary-100 text-secondary-700', 'bg-primary-100 text-primary-700'];
                
                if (sessionData.skills && sessionData.skills.length > 0) {
                    sessionData.skills.forEach(skill => {
                        const skillBadge = document.createElement('div');
                        skillBadge.className = 'inline-flex items-center space-x-2 px-4 py-2 bg-neutral-100 rounded-lg';
                        skillBadge.innerHTML = `
                            <span class="text-b-2 font-medium text-neutral-800">${skill.skill_name}</span>
                            <span class="px-2 py-1 ${levelColors[skill.required_level]} rounded text-b-3 font-medium">
                                ${levelLabels[skill.required_level]}
                            </span>
                        `;
                        skillsContainer.appendChild(skillBadge);
                    });
                } else {
                    skillsContainer.innerHTML = '<p class="text-b-2 text-neutral-500">No skills specified</p>';
                }

                // Populate requirements
                const requirementsContainer = document.getElementById('previewRequirements');
                requirementsContainer.innerHTML = '';
                
                const priorityColors = {
                    'must_have': 'bg-red-50 border-red-200 text-red-700',
                    'should_have': 'bg-yellow-50 border-yellow-200 text-yellow-700',
                    'nice_to_have': 'bg-green-50 border-green-200 text-green-700'
                };
                
                const priorityLabels = {
                    'must_have': 'Must Have',
                    'should_have': 'Should Have',
                    'nice_to_have': 'Nice to Have'
                };

                const typeLabels = {
                    'feature': 'Feature',
                    'technical': 'Technical',
                    'deliverable': 'Deliverable',
                    'other': 'Other'
                };
                
                if (requirements && requirements.length > 0) {
                    requirements.forEach((req, index) => {
                        const reqItem = document.createElement('div');
                        reqItem.className = `border ${priorityColors[req.priority]} rounded-lg p-4`;
                        reqItem.innerHTML = `
                            <div class="flex items-start justify-between mb-2">
                                <div class="flex items-center space-x-2">
                                    <span class="text-b-2 font-semibold text-neutral-800">${index + 1}. ${typeLabels[req.type]}</span>
                                    <span class="px-2 py-1 rounded text-b-3 font-medium ${priorityColors[req.priority]}">
                                        ${priorityLabels[req.priority]}
                                    </span>
                                </div>
                            </div>
                            <p class="text-b-2 text-neutral-700">${req.description}</p>
                        `;
                        requirementsContainer.appendChild(reqItem);
                    });
                } else {
                    requirementsContainer.innerHTML = '<p class="text-b-2 text-neutral-500">No requirements specified</p>';
                }

                // Show modal
                const modal = document.getElementById('previewModal');
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.style.overflow = 'hidden';

            } catch (error) {
                console.error('Error showing preview:', error);
                alert('Failed to load preview. Please try again.');
            }
        }

        function closePreviewModal() {
            const modal = document.getElementById('previewModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        async function confirmAndSubmit() {
            try {
                // Show loading state
                const submitBtn = event.target;
                const originalText = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<svg class="animate-spin h-5 w-5 mr-2 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Posting...';

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
                    // Show success message and redirect
                    window.location.href = "{{ route('dashboard') }}";
                } else {
                    alert('Error: ' + (finalData.message || 'Failed to create project'));
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        }

        // Close modal when clicking outside
        document.getElementById('previewModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closePreviewModal();
            }
        });
    </script>
</x-app-layout>