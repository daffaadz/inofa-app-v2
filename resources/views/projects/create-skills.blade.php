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
                        <span class="text-b-2 text-neutral-500 mt-6">Requirements</span>
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-lg shadow-sm p-8 mb-6">
                <h2 class="text-h-5 text-neutral-1000 mb-2">Skills & Expertise</h2>
                <p class="text-b-2 text-neutral-500 mb-8">Select the skills required for your project</p>

                <form id="projectSkillsForm" action="{{ route('consumer.project.storeSkills') }}" method="POST">
                    @csrf

                    <!-- Selected Skills -->
                    <div class="mb-6">
                        <h3 class="text-b-1 font-medium text-neutral-800 mb-3">Selected Skills (<span
                                id="selectedCount">0</span>)</h3>
                        <div id="selectedSkills" class="flex flex-wrap gap-2 min-h-[50px]">
                            <p class="text-b-2 text-neutral-400 w-full" id="emptyMessage">No skills selected yet</p>
                        </div>
                    </div>

                    <!-- Search & Add Skills -->
                    <div class="mb-6">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="flex-1 relative">
                                <input type="text" id="searchSkills" placeholder="Search or add new skill..."
                                    class="w-full px-4 py-3 pl-10 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent text-b-1 text-neutral-800 placeholder-neutral-400">
                                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-neutral-400"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </div>

                        <!-- Skills Grid -->
                        <div id="skillsGrid" class="grid grid-cols-3 gap-3 max-h-96 overflow-y-auto">
                            @foreach ($skills as $skill)
                                <button type="button" data-skill-id="{{ $skill->id }}"
                                    data-skill-name="{{ $skill->name }}"
                                    class="skill-btn px-4 py-3 border border-neutral-300 rounded-lg text-b-2 text-neutral-700 hover:border-primary-500 hover:bg-primary-50 transition-colors text-left"
                                    onclick="showLevelModal({{ $skill->id }}, '{{ $skill->name }}')">
                                    {{ $skill->name }}
                                </button>
                            @endforeach
                        </div>

                        <!-- No Results Message -->
                        <div id="noResults" class="hidden text-center py-8">
                            <p class="text-b-2 text-neutral-500 mb-3">Skill not found</p>
                            <button type="button" id="addNewSkillBtn"
                                class="inline-flex items-center px-4 py-2 bg-primary-500 text-white rounded-lg text-b-2 font-medium hover:bg-primary-600 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Add "<span id="newSkillName"></span>" as new skill
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
                                    understand your project requirements. Can't find a skill? Just type it and add as
                                    new!</p>
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
                            class="inline-flex items-center px-6 py-3 bg-primary-500 text-white rounded-lg text-b-1 font-medium hover:bg-primary-600 transition-colors disabled:bg-neutral-300 disabled:cursor-not-allowed"
                            id="submitBtn" disabled>
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

    <!-- Level Selection Modal -->
    <div id="levelModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-8 max-w-md w-full mx-4">
            <h3 class="text-h-6 text-neutral-1000 mb-4">Select Required Level</h3>
            <p class="text-b-2 text-neutral-500 mb-6">Choose the minimum skill level required for <strong
                    id="modalSkillName"></strong></p>

            <div class="space-y-3 mb-6">
                <label class="block cursor-pointer">
                    <input type="radio" name="level" value="1" class="peer sr-only">
                    <div
                        class="p-4 border-2 border-neutral-300 rounded-lg peer-checked:border-primary-500 peer-checked:bg-primary-50 hover:border-neutral-400 transition-colors">
                        <p class="text-b-1 font-semibold text-neutral-800">Beginner</p>
                        <p class="text-b-3 text-neutral-500">Basic understanding</p>
                    </div>
                </label>
                <label class="block cursor-pointer">
                    <input type="radio" name="level" value="2" class="peer sr-only" checked>
                    <div
                        class="p-4 border-2 border-neutral-300 rounded-lg peer-checked:border-primary-500 peer-checked:bg-primary-50 hover:border-neutral-400 transition-colors">
                        <p class="text-b-1 font-semibold text-neutral-800">Intermediate</p>
                        <p class="text-b-3 text-neutral-500">Practical experience</p>
                    </div>
                </label>
                <label class="block cursor-pointer">
                    <input type="radio" name="level" value="3" class="peer sr-only">
                    <div
                        class="p-4 border-2 border-neutral-300 rounded-lg peer-checked:border-primary-500 peer-checked:bg-primary-50 hover:border-neutral-400 transition-colors">
                        <p class="text-b-1 font-semibold text-neutral-800">Advanced</p>
                        <p class="text-b-3 text-neutral-500">Deep expertise</p>
                    </div>
                </label>
                <label class="block cursor-pointer">
                    <input type="radio" name="level" value="4" class="peer sr-only">
                    <div
                        class="p-4 border-2 border-neutral-300 rounded-lg peer-checked:border-primary-500 peer-checked:bg-primary-50 hover:border-neutral-400 transition-colors">
                        <p class="text-b-1 font-semibold text-neutral-800">Expert</p>
                        <p class="text-b-3 text-neutral-500">Industry leader level</p>
                    </div>
                </label>
            </div>

            <div class="flex gap-3">
                <button type="button" onclick="closeLevelModal()"
                    class="flex-1 px-4 py-2 border border-neutral-300 text-neutral-700 rounded-lg hover:bg-neutral-50 transition-colors">
                    Cancel
                </button>
                <button type="button" onclick="confirmAddSkill()"
                    class="flex-1 px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors">
                    Add Skill
                </button>
            </div>
        </div>
    </div>

    <script>
        let selectedSkills = [];
        let currentSkillId = null;
        let currentSkillName = null;
        const allSkills = @json($skills);

        // Search functionality
        const searchInput = document.getElementById('searchSkills');
        const skillsGrid = document.getElementById('skillsGrid');
        const noResults = document.getElementById('noResults');
        const newSkillNameSpan = document.getElementById('newSkillName');
        const addNewSkillBtn = document.getElementById('addNewSkillBtn');

        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();

            if (query === '') {
                // Show all skills
                Array.from(skillsGrid.children).forEach(btn => btn.classList.remove('hidden'));
                noResults.classList.add('hidden');
                return;
            }

            let hasResults = false;

            Array.from(skillsGrid.children).forEach(btn => {
                const skillName = btn.dataset.skillName.toLowerCase();
                if (skillName.includes(query)) {
                    btn.classList.remove('hidden');
                    hasResults = true;
                } else {
                    btn.classList.add('hidden');
                }
            });

            if (!hasResults) {
                noResults.classList.remove('hidden');
                newSkillNameSpan.textContent = this.value;
            } else {
                noResults.classList.add('hidden');
            }
        });

        // Add new skill button
        addNewSkillBtn.addEventListener('click', function() {
            const skillName = searchInput.value.trim();
            if (skillName) {
                showLevelModal(0, skillName); // 0 = new skill
            }
        });

        function showLevelModal(skillId, skillName) {
            // Check if already selected
            if (selectedSkills.find(s => s.skill_name === skillName)) {
                alert('This skill is already selected!');
                return;
            }

            currentSkillId = skillId;
            currentSkillName = skillName;
            document.getElementById('modalSkillName').textContent = skillName;
            document.getElementById('levelModal').classList.remove('hidden');
            document.getElementById('levelModal').classList.add('flex');
        }

        function closeLevelModal() {
            document.getElementById('levelModal').classList.add('hidden');
            document.getElementById('levelModal').classList.remove('flex');
            currentSkillId = null;
            currentSkillName = null;
            // Reset to intermediate
            document.querySelector('input[name="level"][value="2"]').checked = true;
        }

        function confirmAddSkill() {
            const level = parseInt(document.querySelector('input[name="level"]:checked').value);

            selectedSkills.push({
                skill_id: currentSkillId,
                skill_name: currentSkillName,
                required_level: level
            });

            updateSelectedSkills();
            closeLevelModal();
            searchInput.value = '';
            searchInput.dispatchEvent(new Event('input'));
        }

        function removeSkill(skillName) {
            selectedSkills = selectedSkills.filter(s => s.skill_name !== skillName);
            updateSelectedSkills();
        }

        function updateSelectedSkills() {
            const container = document.getElementById('selectedSkills');
            const emptyMessage = document.getElementById('emptyMessage');
            const submitBtn = document.getElementById('submitBtn');

            if (selectedSkills.length === 0) {
                if (!emptyMessage) {
                    container.innerHTML =
                        '<p class="text-b-2 text-neutral-400 w-full" id="emptyMessage">No skills selected yet</p>';
                }
                submitBtn.disabled = true;
            } else {
                container.innerHTML = '';
                selectedSkills.forEach(skill => {
                    const levelNames = ['', 'Beginner', 'Intermediate', 'Advanced', 'Expert'];
                    const span = document.createElement('span');
                    span.className =
                        'inline-flex items-center px-4 py-2 bg-primary-500 text-white rounded-full text-b-2 font-medium';
                    span.innerHTML = `
                    ${skill.skill_name} <span class="text-b-3 opacity-80 ml-1">(${levelNames[skill.required_level]})</span>
                    <button type="button" class="ml-2 hover:text-neutral-200" onclick="removeSkill('${skill.skill_name}')">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                `;
                    container.appendChild(span);
                });
                submitBtn.disabled = false;
            }

            document.getElementById('selectedCount').textContent = selectedSkills.length;
        }

        // Form submission
        document.getElementById('projectSkillsForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            if (selectedSkills.length === 0) {
                alert('Please select at least one skill');
                return;
            }

            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        skills: selectedSkills
                    })
                });

                const data = await response.json();

                if (data.status) {
                    window.location.href = "{{ route('consumer.project.createBudget') }}";
                } else {
                    alert('Error: ' + (data.message || 'Failed to save skills'));
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            }
        });
    </script>
</x-app-layout>
