<x-guest-layout>
    {{-- PAGE WRAPPER --}}
    <div class="min-h-screen grid md:grid-cols-2">

        {{-- LEFT PANEL : ILLUSTRATION --}}
        <div
            class="hidden md:flex sticky top-0 items-center justify-center bg-gradient-to-br from-primary-200 via-primary-100 to-primary-200 max-h-screen p-6">

            {{-- Logo --}}
            <div class="absolute left-24 top-12 mb-10">
                <a href="{{ url('/') }}" class="flex items-center justify-center gap-4">
                    <img src="{{ asset('assets/vector/logo.svg') }}" alt="Inofa" class="h-8 w-auto">
                    <span class="text-neutral-800 text-h-5 font-sans">Inofa</span>
                </a>
            </div>

            <div class="max-w-xl text-center">
                <h2 class="font-sans text-h-3 text-start text-neutral-800 mb-3 tracking-tight">
                    Showcase Your<br>
                    Developer Skills!
                </h2>
                <p class="font-sans text-b-1 text-neutral-800 text-start mt-4">
                    Complete your developer profile to connect with clients and land exciting projects.
                </p>
            </div>

            {{-- FOOTER --}}
            <footer class="absolute left-1/4 bottom-6 py-6 text-center border-t border-neutral-200">
                <p class="font-sans text-b-2 text-neutral-500">
                    © 2025 Inofa. All rights reserved.
                    <a href="#" class="text-primary-500 hover:underline">Terms of Use</a> &
                    <a href="#" class="text-primary-500 hover:underline">Privacy Policy</a>
                </p>
            </footer>
        </div>

        {{-- RIGHT PANEL : FORM --}}
        <div class="flex items-center justify-center py-16 overflow-y-auto">
            <div class="w-full max-w-lg">

                {{-- Heading --}}
                <h1 class="font-sans text-h-5 text-neutral-800 mb-1">
                    Complete Your Developer Profile
                </h1>
                <p class="font-sans text-b-2 text-neutral-600 mb-4">Tell us about your skills and experience</p>

                {{-- FORM --}}
                <form method="POST" action="{{ route('developer.information.store') }}" id="developer-form" class="space-y-3">
                    @csrf

                    {{-- Professional Info Section --}}
                    <div class="pb-3 border-b border-neutral-200">
                        <h3 class="font-sans text-b-1 font-semibold text-neutral-800 mb-3">Professional Information</h3>

                        <div class="space-y-3">
                            {{-- Professional Headline --}}
                            <div>
                                <label for="headline" class="font-sans text-b-3 text-neutral-700">
                                    Professional Headline
                                </label>
                                <input type="text" name="headline" id="headline" value="{{ old('headline') }}"
                                    placeholder="e.g., Full-Stack Developer"
                                    class="mt-1 block w-full px-4 py-2 rounded-lg border border-neutral-300 font-sans text-b-1 placeholder-neutral-400 focus:ring-2 focus:ring-primary-500">
                                <x-input-error :messages="$errors->get('headline')" class="mt-1" />
                            </div>

                            {{-- Experience Years --}}
                            <div>
                                <label for="experience_years" class="font-sans text-b-3 text-neutral-700">
                                    Years of Experience
                                </label>
                                <input type="number" name="experience_years" id="experience_years"
                                    value="{{ old('experience_years', 0) }}" min="0" placeholder="0"
                                    class="mt-1 block w-full px-4 py-2 rounded-lg border border-neutral-300 font-sans text-b-1 placeholder-neutral-400 focus:ring-2 focus:ring-primary-500">
                                <x-input-error :messages="$errors->get('experience_years')" class="mt-1" />
                            </div>

                            {{-- Availability --}}
                            <div>
                                <label for="availability" class="font-sans text-b-3 text-neutral-700">
                                    Availability Status
                                </label>
                                <select name="availability" id="availability"
                                    class="mt-1 block w-full px-4 py-2 rounded-lg border border-neutral-300 font-sans text-b-1 focus:ring-2 focus:ring-primary-500 bg-white">
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

                            {{-- Rate Range --}}
                            <div class="flex flex-row justify-between w-full items-center">
                                <div>
                                    <label for="rate_min_byproject" class="font-sans text-b-3 text-neutral-700">
                                        Minimum Rate (per project)
                                    </label>
                                    <div class="relative mt-1">
                                        <span class="absolute left-3 top-1/2 -translate-y-1/2 font-sans text-b-2 text-neutral-500">Rp</span>
                                        <input type="number" name="rate_min_byproject" id="rate_min_byproject"
                                            value="{{ old('rate_min_byproject') }}" min="0" placeholder="1,000,000"
                                            class="block w-full pl-10 pr-4 py-2 rounded-lg border border-neutral-300 font-sans text-b-1 placeholder-neutral-400 focus:ring-2 focus:ring-primary-500">
                                    </div>
                                    <x-input-error :messages="$errors->get('rate_min_byproject')" class="mt-1" />
                                </div>
    
                                <div>
                                    <label for="rate_max_byproject" class="font-sans text-b-3 text-neutral-700">
                                        Maximum Rate (per project)
                                    </label>
                                    <div class="relative mt-1">
                                        <span class="absolute left-3 top-1/2 -translate-y-1/2 font-sans text-b-2 text-neutral-500">Rp</span>
                                        <input type="number" name="rate_max_byproject" id="rate_max_byproject"
                                            value="{{ old('rate_max_byproject') }}" min="0" placeholder="10,000,000"
                                            class="block w-full pl-10 pr-4 py-2 rounded-lg border border-neutral-300 font-sans text-b-1 placeholder-neutral-400 focus:ring-2 focus:ring-primary-500">
                                    </div>
                                    <x-input-error :messages="$errors->get('rate_max_byproject')" class="mt-1" />
                                </div>
                            </div>

                            {{-- Professional Experience --}}
                            <div>
                                <label for="experience" class="font-sans text-b-3 text-neutral-700">
                                    Professional Experience
                                </label>
                                <textarea name="experience" id="experience" rows="3"
                                    placeholder="Describe your work experience, projects, and achievements..."
                                    class="mt-1 block w-full px-4 py-2 rounded-lg border border-neutral-300 font-sans text-b-1 placeholder-neutral-400 focus:ring-2 focus:ring-primary-500 resize-none">{{ old('experience') }}</textarea>
                                <x-input-error :messages="$errors->get('experience')" class="mt-1" />
                            </div>
                        </div>
                    </div>

                    {{-- Skills Section --}}
                    <div class="pb-3 border-b border-neutral-200">
                        <h3 class="font-sans text-b-1 font-semibold text-neutral-800 mb-3">Skills & Technologies</h3>

                        {{-- Selected Skills Display --}}
                        <div id="selected-skills"
                            class="mb-3 min-h-[50px] p-3 bg-neutral-50 border border-neutral-200 rounded-lg">
                            <div class="flex flex-wrap gap-2" id="selected-skills-container">
                                <span class="font-sans text-b-3 text-neutral-500">No skills selected yet</span>
                            </div>
                        </div>

                        {{-- Add Custom Skill --}}
                        <div class="mb-3">
                            <label for="new-skill-input" class="font-sans text-b-3 text-neutral-700">
                                Add Custom Skill
                            </label>
                            <div class="flex gap-2 mt-1">
                                <input type="text" id="new-skill-input"
                                    placeholder="Type skill name"
                                    class="flex-1 px-4 py-2 border border-neutral-300 rounded-lg font-sans text-b-1 placeholder-neutral-400 focus:ring-2 focus:ring-primary-500">
                                <button type="button" id="add-skill-btn"
                                    class="px-4 py-2 bg-primary-500 text-white font-sans text-b-2 font-semibold rounded-lg hover:bg-primary-600 whitespace-nowrap">
                                    Add
                                </button>
                            </div>
                            <p class="mt-1 font-sans text-b-3 text-neutral-600">Add skills not listed below</p>
                        </div>

                        {{-- Existing Skills --}}
                        <div>
                            <label class="font-sans text-b-3 text-neutral-700 mb-2 block">
                                Select from Existing Skills
                            </label>
                            <div
                                class="grid grid-cols-2 gap-2 max-h-48 overflow-y-auto p-3 bg-neutral-50 border border-neutral-200 rounded-lg">
                                @foreach ($skills->take(10) as $skill)
                                    <label
                                        class="flex items-center gap-2 font-sans text-b-3 text-neutral-700 cursor-pointer hover:text-neutral-900">
                                        <input type="checkbox" name="skills[]" value="{{ $skill->id }}"
                                            class="w-4 h-4 text-primary-500 border-neutral-300 rounded focus:ring-primary-500 cursor-pointer skill-checkbox"
                                            data-skill-name="{{ $skill->name }}"
                                            data-skill-id="{{ $skill->id }}">
                                        <span>{{ $skill->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <x-input-error :messages="$errors->get('skills')" class="mt-1" />

                        {{-- Hidden inputs for custom skills --}}
                        <div id="custom-skills-container"></div>
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit"
                        class="w-full px-4 py-2 rounded-lg bg-primary-500 font-sans text-b-2 text-white font-semibold hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-500 mt-1">
                        Complete Registration
                    </button>
                    
                    {{-- Helper Text --}}
                    <p class="font-sans text-b-3 text-neutral-600 text-center">
                        You can update this later from your profile
                    </p>
                </form>
            </div>
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
                    '<span class="font-sans text-b-3 text-neutral-500">No skills selected yet</span>';
            } else {
                selectedSkillsContainer.innerHTML = '';
                selectedSkills.forEach(skill => {
                    const badge = document.createElement('span');
                    badge.className =
                        'inline-flex items-center gap-2 bg-primary-100 text-primary-700 px-3 py-1 rounded-md font-sans text-b-3 font-medium';
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
