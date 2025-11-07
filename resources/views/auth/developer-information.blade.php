<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-neutral-10 py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-3xl">
            <!-- Header -->
            <div class="text-center mb-8">
                <h2 class="text-h-3 text-neutral-900 mb-2">Complete Your Developer Profile</h2>
                <p class="text-b-1 text-neutral-600">Tell us about your skills and experience</p>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-lg shadow-md border border-neutral-200 p-8">
                <form method="POST" action="{{ route('developer.information.store') }}" id="developer-form">
                    @csrf

                    <!-- Professional Info Section -->
                    <div class="mb-8">
                        <h3 class="text-h-6 text-neutral-900 mb-4 pb-2 border-b border-neutral-200">Professional
                            Information</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Headline -->
                            <div class="md:col-span-2">
                                <label for="headline" class="block text-b-1 font-medium text-neutral-900 mb-2">
                                    Professional Headline
                                </label>
                                <input type="text" name="headline" id="headline" value="{{ old('headline') }}"
                                    placeholder="e.g., Full-Stack Developer"
                                    class="w-full px-4 py-3 border border-neutral-300 rounded-lg text-b-1 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors">
                                <x-input-error :messages="$errors->get('headline')" class="mt-1" />
                            </div>

                            <!-- Experience Years -->
                            <div>
                                <label for="experience_years" class="block text-b-1 font-medium text-neutral-900 mb-2">
                                    Years of Experience
                                </label>
                                <input type="number" name="experience_years" id="experience_years"
                                    value="{{ old('experience_years', 0) }}" min="0" placeholder="0"
                                    class="w-full px-4 py-3 border border-neutral-300 rounded-lg text-b-1 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors">
                                <x-input-error :messages="$errors->get('experience_years')" class="mt-1" />
                            </div>

                            <!-- Availability -->
                            <div>
                                <label for="availability" class="block text-b-1 font-medium text-neutral-900 mb-2">
                                    Availability Status
                                </label>
                                <select name="availability" id="availability"
                                    class="w-full px-4 py-3 border border-neutral-300 rounded-lg text-b-1 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors bg-white">
                                    <option value="available"
                                        {{ old('availability') === 'available' ? 'selected' : '' }}>Available for Work
                                    </option>
                                    <option value="busy" {{ old('availability') === 'busy' ? 'selected' : '' }}>
                                        Currently Busy</option>
                                    <option value="unavailable"
                                        {{ old('availability') === 'unavailable' ? 'selected' : '' }}>Not Available
                                    </option>
                                </select>
                                <x-input-error :messages="$errors->get('availability')" class="mt-1" />
                            </div>

                            <!-- Rate Range -->
                            <div>
                                <label for="rate_min_byproject"
                                    class="block text-b-1 font-medium text-neutral-900 mb-2">
                                    Minimum Rate (per project)
                                </label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-neutral-500">Rp</span>
                                    <input type="number" name="rate_min_byproject" id="rate_min_byproject"
                                        value="{{ old('rate_min_byproject') }}" min="0" placeholder="1,000,000"
                                        class="w-full pl-12 pr-4 py-3 border border-neutral-300 rounded-lg text-b-1 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors">
                                </div>
                                <x-input-error :messages="$errors->get('rate_min_byproject')" class="mt-1" />
                            </div>

                            <div>
                                <label for="rate_max_byproject"
                                    class="block text-b-1 font-medium text-neutral-900 mb-2">
                                    Maximum Rate (per project)
                                </label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-neutral-500">Rp</span>
                                    <input type="number" name="rate_max_byproject" id="rate_max_byproject"
                                        value="{{ old('rate_max_byproject') }}" min="0" placeholder="10,000,000"
                                        class="w-full pl-12 pr-4 py-3 border border-neutral-300 rounded-lg text-b-1 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors">
                                </div>
                                <x-input-error :messages="$errors->get('rate_max_byproject')" class="mt-1" />
                            </div>

                            <!-- Experience -->
                            <div class="md:col-span-2">
                                <label for="experience" class="block text-b-1 font-medium text-neutral-900 mb-2">
                                    Professional Experience
                                </label>
                                <textarea name="experience" id="experience" rows="4"
                                    placeholder="Describe your work experience, projects, and achievements..."
                                    class="w-full px-4 py-3 border border-neutral-300 rounded-lg text-b-1 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors resize-none">{{ old('experience') }}</textarea>
                                <x-input-error :messages="$errors->get('experience')" class="mt-1" />
                            </div>
                        </div>
                    </div>

                    <!-- Education & Certifications -->
                    <div class="mb-8">
                        <h3 class="text-h-6 text-neutral-900 mb-4 pb-2 border-b border-neutral-200">Education &
                            Certifications</h3>

                        <div class="grid grid-cols-1 gap-6">
                            <!-- Education -->
                            <div>
                                <label for="education" class="block text-b-1 font-medium text-neutral-900 mb-2">
                                    Education
                                </label>
                                <input type="text" name="education" id="education" value="{{ old('education') }}"
                                    placeholder="e.g., Bachelor's in Computer Science - University of Indonesia"
                                    class="w-full px-4 py-3 border border-neutral-300 rounded-lg text-b-1 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors">
                                <x-input-error :messages="$errors->get('education')" class="mt-1" />
                            </div>

                            <!-- Certifications -->
                            <div>
                                <label for="certifications" class="block text-b-1 font-medium text-neutral-900 mb-2">
                                    Certifications
                                </label>
                                <textarea name="certifications" id="certifications" rows="3"
                                    placeholder="List your certifications (one per line)&#10;e.g., AWS Certified Developer&#10;Google Cloud Professional"
                                    class="w-full px-4 py-3 border border-neutral-300 rounded-lg text-b-1 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors resize-none">{{ old('certifications') }}</textarea>
                                <x-input-error :messages="$errors->get('certifications')" class="mt-1" />
                            </div>

                            <!-- Portfolio Links -->
                            <div>
                                <label for="portfolio_links" class="block text-b-1 font-medium text-neutral-900 mb-2">
                                    Portfolio Links
                                </label>
                                <textarea name="portfolio_links" id="portfolio_links" rows="3"
                                    placeholder="Add links to your portfolio, GitHub, LinkedIn, etc. (comma separated)&#10;e.g., https://github.com/username, https://portfolio.com"
                                    class="w-full px-4 py-3 border border-neutral-300 rounded-lg text-b-1 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors resize-none">{{ old('portfolio_links') }}</textarea>
                                <x-input-error :messages="$errors->get('portfolio_links')" class="mt-1" />
                            </div>
                        </div>
                    </div>

                    <!-- Skills Section -->
                    <div class="mb-8">
                        <h3 class="text-h-6 text-neutral-900 mb-4 pb-2 border-b border-neutral-200">Skills &
                            Technologies</h3>

                        <!-- Selected Skills Display -->
                        <div id="selected-skills"
                            class="mb-4 min-h-[60px] p-4 bg-neutral-50 border border-neutral-200 rounded-lg">
                            <div class="flex flex-wrap gap-2" id="selected-skills-container">
                                <span class="text-b-2 text-neutral-500">No skills selected yet. Add skills
                                    below.</span>
                            </div>
                        </div>

                        <!-- Add New Skill -->
                        <div class="mb-4">
                            <label for="new-skill-input" class="block text-b-1 font-medium text-neutral-900 mb-2">
                                Add Custom Skill
                            </label>
                            <div class="flex gap-2">
                                <input type="text" id="new-skill-input"
                                    placeholder="Type skill name and press Add"
                                    class="flex-1 px-4 py-3 border border-neutral-300 rounded-lg text-b-1 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors">
                                <button type="button" id="add-skill-btn"
                                    class="px-6 py-3 bg-primary-500 text-white text-b-2 font-medium rounded-lg hover:bg-primary-600 transition-colors whitespace-nowrap">
                                    Add Skill
                                </button>
                            </div>
                            <p class="mt-1 text-b-3 text-neutral-600">Add skills that aren't listed below</p>
                        </div>

                        <!-- Existing Skills -->
                        <div>
                            <label class="block text-b-1 font-medium text-neutral-900 mb-3">
                                Select from Existing Skills
                            </label>
                            <div
                                class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 max-h-64 overflow-y-auto p-4 bg-neutral-50 border border-neutral-200 rounded-lg">
                                @foreach ($skills as $skill)
                                    <label
                                        class="flex items-center gap-2 text-b-2 text-neutral-700 cursor-pointer hover:text-neutral-900 group">
                                        <input type="checkbox" name="skills[]" value="{{ $skill->id }}"
                                            class="w-4 h-4 text-primary-500 border-neutral-300 rounded focus:ring-primary-500 cursor-pointer skill-checkbox"
                                            data-skill-name="{{ $skill->name }}"
                                            data-skill-id="{{ $skill->id }}">
                                        <span
                                            class="group-hover:font-medium transition-all">{{ $skill->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <x-input-error :messages="$errors->get('skills')" class="mt-2" />

                        <!-- Hidden inputs for custom skills -->
                        <div id="custom-skills-container"></div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex gap-4">
                        <button type="submit"
                            class="flex-1 px-6 py-3.5 bg-primary-500 text-white text-b-1 font-semibold rounded-lg hover:bg-primary-600 transition-colors shadow-sm hover:shadow-md">
                            Complete Registration
                        </button>
                    </div>
                </form>
            </div>

            <!-- Helper Text -->
            <p class="text-center text-b-2 text-neutral-600 mt-6">
                You can update this information later from your profile settings
            </p>
        </div>
    </div>

    <script>
        // Skills Management
        const selectedSkills = new Set();
        const selectedSkillsContainer = document.getElementById('selected-skills-container');
        const customSkillsContainer = document.getElementById('custom-skills-container');
        const newSkillInput = document.getElementById('new-skill-input');
        const addSkillBtn = document.getElementById('add-skill-btn');
        const skillCheckboxes = document.querySelectorAll('.skill-checkbox');

        // Initialize from old input if validation fails
        const oldSkills = @json(old('skills', []));
        const oldCustomSkills = @json(old('custom_skills', []));

        function updateSelectedDisplay() {
            if (selectedSkills.size === 0) {
                selectedSkillsContainer.innerHTML =
                    '<span class="text-b-2 text-neutral-500">No skills selected yet. Add skills below.</span>';
            } else {
                selectedSkillsContainer.innerHTML = '';
                selectedSkills.forEach(skill => {
                    const badge = document.createElement('span');
                    badge.className =
                        'inline-flex items-center gap-2 bg-primary-100 text-primary-700 px-3 py-1.5 rounded-md text-b-2 font-medium';
                    badge.innerHTML = `
                        ${skill.name}
                        <button type="button" class="hover:text-primary-900 transition-colors" onclick="removeSkill('${skill.id}', '${skill.type}')">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    `;
                    selectedSkillsContainer.appendChild(badge);
                });
            }
        }

        function removeSkill(skillId, skillType) {
            // Find and remove from Set
            let skillToRemove = null;
            selectedSkills.forEach(skill => {
                if (skill.id === skillId && skill.type === skillType) {
                    skillToRemove = skill;
                }
            });

            if (skillToRemove) {
                selectedSkills.delete(skillToRemove);
            }

            // Update checkbox if it's an existing skill
            if (skillType === 'existing') {
                const checkbox = document.querySelector(`input[data-skill-id="${skillId}"]`);
                if (checkbox) {
                    checkbox.checked = false;
                }
            } else {
                // Remove hidden input for custom skill
                const hiddenInput = document.querySelector(`input[name="custom_skills[]"][value="${skillToRemove.name}"]`);
                if (hiddenInput) {
                    hiddenInput.remove();
                }
            }

            updateSelectedDisplay();
        }

        // Make removeSkill globally accessible
        window.removeSkill = removeSkill;

        // Handle existing skill checkboxes
        skillCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const skillName = this.dataset.skillName;
                const skillId = this.dataset.skillId;

                if (this.checked) {
                    selectedSkills.add({
                        id: skillId,
                        name: skillName,
                        type: 'existing'
                    });
                } else {
                    let skillToRemove = null;
                    selectedSkills.forEach(skill => {
                        if (skill.id === skillId && skill.type === 'existing') {
                            skillToRemove = skill;
                        }
                    });
                    if (skillToRemove) {
                        selectedSkills.delete(skillToRemove);
                    }
                }

                updateSelectedDisplay();
            });

            // Initialize from old input
            if (oldSkills.includes(parseInt(checkbox.value))) {
                checkbox.checked = true;
                selectedSkills.add({
                    id: checkbox.dataset.skillId,
                    name: checkbox.dataset.skillName,
                    type: 'existing'
                });
            }
        });

        // Handle adding custom skills
        function addCustomSkill() {
            const skillName = newSkillInput.value.trim();

            if (!skillName) {
                return;
            }

            // Check if skill already exists in selected
            let alreadyExists = false;
            selectedSkills.forEach(skill => {
                if (skill.name.toLowerCase() === skillName.toLowerCase()) {
                    alreadyExists = true;
                }
            });

            if (alreadyExists) {
                alert('This skill is already added!');
                return;
            }

            // Create unique ID for custom skill
            const customId = 'custom_' + Date.now();

            // Add to selected skills
            selectedSkills.add({
                id: customId,
                name: skillName,
                type: 'custom'
            });

            // Create hidden input for custom skill
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'custom_skills[]';
            hiddenInput.value = skillName;
            customSkillsContainer.appendChild(hiddenInput);

            // Clear input
            newSkillInput.value = '';

            updateSelectedDisplay();
        }

        addSkillBtn.addEventListener('click', addCustomSkill);

        newSkillInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                addCustomSkill();
            }
        });

        // Initialize old custom skills if validation fails
        if (oldCustomSkills.length > 0) {
            oldCustomSkills.forEach(skillName => {
                const customId = 'custom_' + Date.now() + '_' + Math.random();
                selectedSkills.add({
                    id: customId,
                    name: skillName,
                    type: 'custom'
                });

                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'custom_skills[]';
                hiddenInput.value = skillName;
                customSkillsContainer.appendChild(hiddenInput);
            });
        }

        // Initial display update
        updateSelectedDisplay();
    </script>
</x-guest-layout>
