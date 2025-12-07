<div class="space-y-6">
    <!-- Toast Notification Container -->
    <div id="toast-container" class="fixed top-4 right-4 z-[100] space-y-2"></div>

    <!-- Skills & Technologies -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center gap-2 mb-4">
            <div class="w-10 h-10 bg-primary-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                </svg>
            </div>
            <h3 class="text-h-6 text-neutral-1000">Skills & Technologies</h3>
        </div>

        <!-- Add Skill Form -->
        <form id="add-skill-form" class="mb-4">
            @csrf
            <div class="flex gap-2">
                <div class="flex-1 relative">
                    <input type="text" 
                        id="skill_name" 
                        name="skill_name" 
                        placeholder="Add a new skill or search existing..."
                        class="w-full px-4 py-2.5 text-b-1 border border-neutral-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                        autocomplete="off"
                        required>
                    
                    <!-- Dropdown Suggestions -->
                    <div id="skill-suggestions" 
                        class="absolute z-50 w-full mt-1 bg-white border border-neutral-200 rounded-lg shadow-lg hidden max-h-60 overflow-y-auto">
                    </div>
                </div>
                
                <select id="proficiency_level" name="proficiency_level"
                    class="px-4 py-2.5 text-b-1 border border-neutral-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                    <option value="1">Beginner</option>
                    <option value="2" selected>Intermediate</option>
                    <option value="3">Advanced</option>
                    <option value="4">Expert</option>
                </select>
                <button type="submit" id="add-skill-btn"
                    class="px-6 py-2.5 bg-primary-500 text-white text-b-1 font-medium rounded-lg hover:bg-primary-600 transition flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    <span id="add-skill-text">Add</span>
                </button>
            </div>
            <p id="skill-error" class="mt-1 text-b-3 text-red-500 hidden"></p>
        </form>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const skillInput = document.getElementById('skill_name');
                const proficiencySelect = document.getElementById('proficiency_level');
                const suggestionsBox = document.getElementById('skill-suggestions');
                const addSkillForm = document.getElementById('add-skill-form');
                const addSkillBtn = document.getElementById('add-skill-btn');
                const addSkillText = document.getElementById('add-skill-text');
                const skillError = document.getElementById('skill-error');
                const skillsContainer = document.getElementById('skills-container');
                const toastContainer = document.getElementById('toast-container');
                let debounceTimer;

                console.log('Skill autocomplete initialized');

                // Show Toast Notification
                function showToast(message, type = 'success') {
                    const toast = document.createElement('div');
                    const bgColor = type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500';
                    
                    toast.className = `${bgColor} text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-3 transform transition-all duration-300 translate-x-full`;
                    toast.innerHTML = `
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            ${type === 'success' 
                                ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>' 
                                : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>'}
                        </svg>
                        <span class="text-b-2 font-medium">${message}</span>
                    `;
                    
                    toastContainer.appendChild(toast);
                    
                    // Animate in
                    setTimeout(() => toast.classList.remove('translate-x-full'), 100);
                    
                    // Auto remove after 3 seconds
                    setTimeout(() => {
                        toast.classList.add('translate-x-full');
                        setTimeout(() => toast.remove(), 300);
                    }, 3000);
                }

                // Capitalize each word
                function capitalizeWords(str) {
                    return str.replace(/\b\w/g, char => char.toUpperCase());
                }

                // Get proficiency level text
                function getProficiencyText(level) {
                    const levels = {1: 'Beginner', 2: 'Intermediate', 3: 'Advanced', 4: 'Expert'};
                    return levels[level] || 'Intermediate';
                }

                // Add skill to DOM
                function addSkillToDOM(skill, proficiencyLevel) {
                    const skillTag = document.createElement('div');
                    skillTag.className = 'px-4 py-2 bg-primary-100 text-primary-700 text-b-2 font-medium rounded-full flex items-center gap-2';
                    skillTag.innerHTML = `
                        ${skill.name}
                        <span class="text-b-4 opacity-75">(${getProficiencyText(proficiencyLevel)})</span>
                        <form method="POST" action="/profile/skills/${skill.id}" class="inline delete-skill-form">
                            <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="hover:text-primary-900">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </form>
                    `;
                    
                    // Remove empty state if exists
                    const emptyState = skillsContainer.querySelector('p.text-neutral-500');
                    if (emptyState) emptyState.remove();
                    
                    skillsContainer.appendChild(skillTag);
                    
                    // Add delete handler
                    const deleteForm = skillTag.querySelector('.delete-skill-form');
                    deleteForm.addEventListener('submit', handleDeleteSkill);
                }

                // Handle form submission
                addSkillForm.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    
                    const skillName = capitalizeWords(skillInput.value.trim());
                    const proficiencyLevel = proficiencySelect.value;
                    
                    if (!skillName) return;
                    
                    // Disable button
                    addSkillBtn.disabled = true;
                    addSkillText.textContent = 'Adding...';
                    skillError.classList.add('hidden');
                    
                    try {
                        const response = await fetch('{{ route("skills.store") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                skill_name: skillName,
                                proficiency_level: proficiencyLevel
                            })
                        });
                        
                        const data = await response.json();
                        
                        if (response.ok) {
                            addSkillToDOM(data.skill, proficiencyLevel);
                            showToast('Skill added successfully!', 'success');
                            skillInput.value = '';
                            proficiencySelect.value = '2';
                        } else {
                            skillError.textContent = data.message || 'Failed to add skill';
                            skillError.classList.remove('hidden');
                            showToast(data.message || 'Failed to add skill', 'error');
                        }
                    } catch (error) {
                        console.error('Error adding skill:', error);
                        skillError.textContent = 'An error occurred. Please try again.';
                        skillError.classList.remove('hidden');
                        showToast('An error occurred. Please try again.', 'error');
                    } finally {
                        addSkillBtn.disabled = false;
                        addSkillText.textContent = 'Add';
                    }
                });

                // Handle skill deletion
                async function handleDeleteSkill(e) {
                    e.preventDefault();
                    
                    const form = e.target;
                    const skillTag = form.closest('.px-4');
                    
                    try {
                        const response = await fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            },
                            body: new FormData(form)
                        });
                        
                        if (response.ok) {
                            skillTag.remove();
                            showToast('Skill removed successfully!', 'success');
                            
                            // Show empty state if no skills left
                            if (skillsContainer.children.length === 0) {
                                skillsContainer.innerHTML = '<p class="text-b-2 text-neutral-500">No skills added yet. Add your first skill above!</p>';
                            }
                        } else {
                            showToast('Failed to remove skill', 'error');
                        }
                    } catch (error) {
                        console.error('Error removing skill:', error);
                        showToast('An error occurred. Please try again.', 'error');
                    }
                }

                // Attach delete handlers to existing skills
                document.querySelectorAll('.delete-skill-form').forEach(form => {
                    form.addEventListener('submit', handleDeleteSkill);
                });

                // Fetch skills from API
                async function fetchSkills(query) {
                    if (query.length < 1) {
                        suggestionsBox.classList.add('hidden');
                        return;
                    }

                    console.log('Fetching skills for:', query);

                    try {
                        const url = `{{ route('skills.search') }}?q=${encodeURIComponent(query)}`;
                        console.log('Request URL:', url);
                        
                        const response = await fetch(url);
                        const skills = await response.json();
                        
                        console.log('Skills received:', skills);
                        displaySuggestions(skills);
                    } catch (error) {
                        console.error('Error fetching skills:', error);
                    }
                }

                // Display suggestions
                function displaySuggestions(skills) {
                    if (skills.length === 0) {
                        suggestionsBox.classList.add('hidden');
                        return;
                    }

                    suggestionsBox.innerHTML = skills.map(skill => `
                        <div class="px-4 py-2.5 hover:bg-primary-50 cursor-pointer text-b-1 text-neutral-800 transition"
                            data-skill-name="${skill.name}">
                            ${skill.name}
                        </div>
                    `).join('');

                    suggestionsBox.classList.remove('hidden');
                }

                // Input event listener with debounce
                skillInput.addEventListener('input', function(e) {
                    clearTimeout(debounceTimer);
                    const value = e.target.value.trim();

                    debounceTimer = setTimeout(() => {
                        fetchSkills(value);
                    }, 300);
                });

                // Click on suggestion
                suggestionsBox.addEventListener('click', function(e) {
                    const suggestionItem = e.target.closest('[data-skill-name]');
                    if (suggestionItem) {
                        const skillName = suggestionItem.getAttribute('data-skill-name');
                        skillInput.value = skillName;
                        suggestionsBox.classList.add('hidden');
                    }
                });

                // Capitalize on blur
                skillInput.addEventListener('blur', function(e) {
                    setTimeout(() => {
                        if (e.target.value) {
                            e.target.value = capitalizeWords(e.target.value.trim());
                        }
                        suggestionsBox.classList.add('hidden');
                    }, 200);
                });

                // Close suggestions when clicking outside
                document.addEventListener('click', function(e) {
                    if (!skillInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
                        suggestionsBox.classList.add('hidden');
                    }
                });

                // Keyboard navigation
                let selectedIndex = -1;
                skillInput.addEventListener('keydown', function(e) {
                    const suggestions = suggestionsBox.querySelectorAll('[data-skill-name]');
                    
                    if (e.key === 'ArrowDown') {
                        e.preventDefault();
                        selectedIndex = Math.min(selectedIndex + 1, suggestions.length - 1);
                        updateSelectedSuggestion(suggestions);
                    } else if (e.key === 'ArrowUp') {
                        e.preventDefault();
                        selectedIndex = Math.max(selectedIndex - 1, -1);
                        updateSelectedSuggestion(suggestions);
                    } else if (e.key === 'Enter' && selectedIndex >= 0) {
                        e.preventDefault();
                        const selected = suggestions[selectedIndex];
                        if (selected) {
                            skillInput.value = selected.getAttribute('data-skill-name');
                            suggestionsBox.classList.add('hidden');
                            selectedIndex = -1;
                        }
                    } else if (e.key === 'Escape') {
                        suggestionsBox.classList.add('hidden');
                        selectedIndex = -1;
                    }
                });

                function updateSelectedSuggestion(suggestions) {
                    suggestions.forEach((item, index) => {
                        if (index === selectedIndex) {
                            item.classList.add('bg-primary-100');
                            item.scrollIntoView({ block: 'nearest' });
                        } else {
                            item.classList.remove('bg-primary-100');
                        }
                    });
                }
            });
        </script>

        <!-- Skills Tags -->
        <div id="skills-container" class="flex flex-wrap gap-2">
            @forelse($user->skills ?? [] as $skill)
                <div
                    class="px-4 py-2 bg-primary-100 text-primary-700 text-b-2 font-medium rounded-full flex items-center gap-2">
                    {{ $skill->name }}
                    <span class="text-b-4 opacity-75">
                        @switch($skill->pivot->proficiency_level)
                            @case(1)
                                (Beginner)
                            @break

                            @case(2)
                                (Intermediate)
                            @break

                            @case(3)
                                (Advanced)
                            @break

                            @case(4)
                                (Expert)
                            @break
                        @endswitch
                    </span>
                    <form method="POST" action="{{ route('skills.destroy', $skill) }}" class="inline delete-skill-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="hover:text-primary-900">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </form>
                </div>
                @empty
                    <p class="text-b-2 text-neutral-500">No skills added yet. Add your first skill above!</p>
                @endforelse
            </div>
        </div>

        <!-- Education History -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center gap-2 mb-4">
                <div class="w-10 h-10 bg-secondary-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-secondary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <h3 class="text-h-6 text-neutral-1000">Education History</h3>
            </div>

            <!-- Add Education Form -->
            <form id="add-education-form" class="mb-4">
                @csrf
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <input type="text" 
                            id="degree" 
                            name="degree" 
                            placeholder="Degree (e.g., Computer Science)"
                            class="w-full px-4 py-2.5 text-b-1 border border-neutral-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                            required>
                    </div>
                    
                    <div>
                        <input type="text" 
                            id="institution" 
                            name="institution" 
                            placeholder="Institution (e.g., Harvard University)"
                            class="w-full px-4 py-2.5 text-b-1 border border-neutral-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                            required>
                    </div>

                    <div>
                        <input type="number" 
                            id="start_year" 
                            name="start_year" 
                            placeholder="Start Year"
                            min="1950"
                            max="2100"
                            class="w-full px-4 py-2.5 text-b-1 border border-neutral-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                            required>
                    </div>

                    <div class="flex gap-2">
                        <input type="number" 
                            id="end_year" 
                            name="end_year" 
                            placeholder="End Year (or expected)"
                            min="1950"
                            max="2100"
                            class="flex-1 px-4 py-2.5 text-b-1 border border-neutral-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                            required>
                        
                        <button type="submit" id="add-education-btn"
                            class="px-6 py-2.5 bg-primary-500 text-white text-b-1 font-medium rounded-lg hover:bg-primary-600 transition flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            <span id="add-education-text">Add</span>
                        </button>
                    </div>
                </div>
                <p id="education-error" class="mt-1 text-b-3 text-red-500 hidden"></p>
            </form>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const addEducationForm = document.getElementById('add-education-form');
                    const addEducationBtn = document.getElementById('add-education-btn');
                    const addEducationText = document.getElementById('add-education-text');
                    const educationError = document.getElementById('education-error');
                    const educationContainer = document.getElementById('education-container');
                    const toastContainer = document.getElementById('toast-container');

                    // Show Toast Notification (reuse from skills section)
                    function showToast(message, type = 'success') {
                        const toast = document.createElement('div');
                        const bgColor = type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500';
                        
                        toast.className = `${bgColor} text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-3 transform transition-all duration-300 translate-x-full`;
                        toast.innerHTML = `
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                ${type === 'success' 
                                    ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>' 
                                    : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>'}
                            </svg>
                            <span class="text-b-2 font-medium">${message}</span>
                        `;
                        
                        toastContainer.appendChild(toast);
                        setTimeout(() => toast.classList.remove('translate-x-full'), 100);
                        setTimeout(() => {
                            toast.classList.add('translate-x-full');
                            setTimeout(() => toast.remove(), 300);
                        }, 3000);
                    }

                    // Add education to DOM
                    function addEducationToDOM(education) {
                        const educationCard = document.createElement('div');
                        educationCard.className = 'p-4 bg-neutral-50 rounded-lg border border-neutral-200 flex justify-between items-start';
                        educationCard.innerHTML = `
                            <div>
                                <h4 class="text-b-1 font-semibold text-neutral-1000">${education.degree}</h4>
                                <p class="text-b-2 text-neutral-700">${education.institution}</p>
                                <p class="text-b-3 text-neutral-500 mt-1">${education.start_year} - ${education.end_year}</p>
                            </div>
                            <button type="button" class="delete-education-btn text-neutral-400 hover:text-red-500 transition" data-index="${education.index}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        `;
                        
                        // Remove empty state if exists
                        const emptyState = educationContainer.querySelector('p.text-neutral-500');
                        if (emptyState) emptyState.remove();
                        
                        educationContainer.appendChild(educationCard);
                        
                        // Add delete handler
                        const deleteBtn = educationCard.querySelector('.delete-education-btn');
                        deleteBtn.addEventListener('click', () => handleDeleteEducation(education.index, educationCard));
                    }

                    // Handle form submission
                    addEducationForm.addEventListener('submit', async function(e) {
                        e.preventDefault();
                        
                        const degree = document.getElementById('degree').value.trim();
                        const institution = document.getElementById('institution').value.trim();
                        const startYear = document.getElementById('start_year').value;
                        const endYear = document.getElementById('end_year').value;
                        
                        if (!degree || !institution || !startYear || !endYear) return;
                        
                        // Disable button
                        addEducationBtn.disabled = true;
                        addEducationText.textContent = 'Adding...';
                        educationError.classList.add('hidden');
                        
                        try {
                            const response = await fetch('{{ route("education.store") }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify({
                                    degree: degree,
                                    institution: institution,
                                    start_year: startYear,
                                    end_year: endYear
                                })
                            });
                            
                            const data = await response.json();
                            
                            if (response.ok) {
                                addEducationToDOM(data.education);
                                showToast('Education added successfully!', 'success');
                                addEducationForm.reset();
                            } else {
                                educationError.textContent = data.message || 'Failed to add education';
                                educationError.classList.remove('hidden');
                                showToast(data.message || 'Failed to add education', 'error');
                            }
                        } catch (error) {
                            console.error('Error adding education:', error);
                            educationError.textContent = 'An error occurred. Please try again.';
                            educationError.classList.remove('hidden');
                            showToast('An error occurred. Please try again.', 'error');
                        } finally {
                            addEducationBtn.disabled = false;
                            addEducationText.textContent = 'Add';
                        }
                    });

                    // Handle education deletion
                    async function handleDeleteEducation(index, educationCard) {
                        try {
                            const response = await fetch(`/profile/education/${index}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'Accept': 'application/json'
                                }
                            });
                            
                            if (response.ok) {
                                educationCard.remove();
                                showToast('Education removed successfully!', 'success');
                                
                                // Show empty state if no education left
                                if (educationContainer.children.length === 0) {
                                    educationContainer.innerHTML = '<p class="text-b-2 text-neutral-500">No education history added yet. Add your first education above!</p>';
                                }
                            } else {
                                showToast('Failed to remove education', 'error');
                            }
                        } catch (error) {
                            console.error('Error removing education:', error);
                            showToast('An error occurred. Please try again.', 'error');
                        }
                    }

                    // Attach delete handlers to existing education
                    document.querySelectorAll('.delete-education-btn').forEach(btn => {
                        const index = btn.getAttribute('data-index');
                        const card = btn.closest('.p-4');
                        btn.addEventListener('click', () => handleDeleteEducation(index, card));
                    });
                });
            </script>

            <!-- Education List -->
            <div id="education-container" class="space-y-3">
                @php
                    $educationList = Auth::user()->developerProfile?->education ?? [];
                    if (is_string($educationList)) {
                        $educationList = json_decode($educationList, true) ?? [];
                    }
                @endphp
                @forelse($educationList as $index => $edu)
                    <div class="p-4 bg-neutral-50 rounded-lg border border-neutral-200 flex justify-between items-start">
                        <div>
                            <h4 class="text-b-1 font-semibold text-neutral-1000">{{ $edu['degree'] ?? '' }}</h4>
                            <p class="text-b-2 text-neutral-700">{{ $edu['institution'] ?? '' }}</p>
                            <p class="text-b-3 text-neutral-500 mt-1">{{ $edu['start_year'] ?? '' }} - {{ $edu['end_year'] ?? '' }}</p>
                        </div>
                        <button type="button" class="delete-education-btn text-neutral-400 hover:text-red-500 transition" data-index="{{ $index }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                @empty
                    <p class="text-b-2 text-neutral-500">No education history added yet. Add your first education above!</p>
                @endforelse
            </div>
        </div>

        <!-- Certifications & Awards -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center gap-2 mb-4">
                <div class="w-10 h-10 bg-secondary-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-secondary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                    </svg>
                </div>
                <h3 class="text-h-6 text-neutral-1000">Certifications & Awards</h3>
            </div>

            <!-- Add Certification Form -->
            <form id="add-certification-form" class="mb-4" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-2 gap-3 mb-3">
                    <div>
                        <input type="text" 
                            id="cert_title" 
                            name="title" 
                            placeholder="Certification Title (e.g., AWS Certified Developer)"
                            class="w-full px-4 py-2.5 text-b-1 border border-neutral-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                            required>
                    </div>
                    
                    <div>
                        <input type="text" 
                            id="cert_issuer" 
                            name="issuer" 
                            placeholder="Issuing Organization (e.g., Amazon Web Services)"
                            class="w-full px-4 py-2.5 text-b-1 border border-neutral-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                            required>
                    </div>

                    <div>
                        <input type="number" 
                            id="cert_year" 
                            name="year" 
                            placeholder="Year Obtained"
                            min="1950"
                            max="2100"
                            class="w-full px-4 py-2.5 text-b-1 border border-neutral-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                            required>
                    </div>

                    <div>
                        <label for="cert_file" class="block w-full px-4 py-2.5 text-b-1 border border-neutral-200 rounded-lg cursor-pointer hover:bg-neutral-50 transition text-center">
                            <span id="file-label" class="text-neutral-500 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 256 256">
                                    <path d="M209.66,122.34a8,8,0,0,1,0,11.32l-82.05,82a56,56,0,0,1-79.2-79.21L147.67,35.73a40,40,0,1,1,56.61,56.55L105,193A24,24,0,1,1,71,159L154.3,74.38A8,8,0,1,1,165.7,85.6L82.39,170.31a8,8,0,1,0,11.27,11.36L192.93,81A24,24,0,1,0,159,47L59.76,147.68a40,40,0,1,0,56.53,56.62l82.06-82A8,8,0,0,1,209.66,122.34Z"></path>
                                </svg>
                                Upload Certificate (PDF/Image)
                            </span>
                            <input type="file" 
                                id="cert_file" 
                                name="file" 
                                accept=".pdf,.jpg,.jpeg,.png"
                                class="hidden"
                                required>
                        </label>
                    </div>
                </div>

                <!-- File Preview -->
                <div id="file-preview" class="hidden mb-3 p-3 bg-neutral-50 border border-neutral-200 rounded-lg">
                    <div class="flex items-center gap-3">
                        <div id="preview-icon" class="w-12 h-12 flex items-center justify-center bg-white rounded border border-neutral-300">
                            <!-- Icon will be inserted here -->
                        </div>
                        <div class="flex-1">
                            <p id="preview-name" class="text-b-2 font-medium text-neutral-800"></p>
                            <p id="preview-size" class="text-b-3 text-neutral-500"></p>
                        </div>
                        <button type="button" id="remove-file" class="text-neutral-400 hover:text-red-500 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit" id="add-certification-btn"
                    class="w-full px-6 py-2.5 bg-primary-500 text-white text-b-1 font-medium rounded-lg hover:bg-primary-600 transition flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    <span id="add-certification-text">Add Certification</span>
                </button>
                <p id="certification-error" class="mt-1 text-b-3 text-red-500 hidden"></p>
            </form>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const addCertificationForm = document.getElementById('add-certification-form');
                    const addCertificationBtn = document.getElementById('add-certification-btn');
                    const addCertificationText = document.getElementById('add-certification-text');
                    const certificationError = document.getElementById('certification-error');
                    const certificationContainer = document.getElementById('certification-container');
                    const toastContainer = document.getElementById('toast-container');
                    const certFileInput = document.getElementById('cert_file');
                    const fileLabel = document.getElementById('file-label');
                    const filePreview = document.getElementById('file-preview');
                    const previewIcon = document.getElementById('preview-icon');
                    const previewName = document.getElementById('preview-name');
                    const previewSize = document.getElementById('preview-size');
                    const removeFileBtn = document.getElementById('remove-file');

                    // Show Toast Notification
                    function showToast(message, type = 'success') {
                        const toast = document.createElement('div');
                        const bgColor = type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500';
                        
                        toast.className = `${bgColor} text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-3 transform transition-all duration-300 translate-x-full`;
                        toast.innerHTML = `
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                ${type === 'success' 
                                    ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>' 
                                    : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>'}
                            </svg>
                            <span class="text-b-2 font-medium">${message}</span>
                        `;
                        
                        toastContainer.appendChild(toast);
                        setTimeout(() => toast.classList.remove('translate-x-full'), 100);
                        setTimeout(() => {
                            toast.classList.add('translate-x-full');
                            setTimeout(() => toast.remove(), 300);
                        }, 3000);
                    }

                    // Format file size
                    function formatFileSize(bytes) {
                        if (bytes === 0) return '0 Bytes';
                        const k = 1024;
                        const sizes = ['Bytes', 'KB', 'MB'];
                        const i = Math.floor(Math.log(bytes) / Math.log(k));
                        return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
                    }

                    // File input change handler
                    certFileInput.addEventListener('change', function(e) {
                        const file = e.target.files[0];
                        if (file) {
                            // Validate file size (5MB)
                            if (file.size > 5 * 1024 * 1024) {
                                showToast('File size must not exceed 5MB', 'error');
                                certFileInput.value = '';
                                return;
                            }

                            // Show preview
                            previewName.textContent = file.name;
                            previewSize.textContent = formatFileSize(file.size);
                            
                            // Set icon based on file type
                            const fileType = file.type;
                            if (fileType === 'application/pdf') {
                                previewIcon.innerHTML = `
                                    <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                `;
                            } else if (fileType.startsWith('image/')) {
                                const reader = new FileReader();
                                reader.onload = function(e) {
                                    previewIcon.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover rounded" alt="Preview">`;
                                };
                                reader.readAsDataURL(file);
                            }

                            filePreview.classList.remove('hidden');
                            fileLabel.innerHTML = `
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 256 256">
                                    <path d="M209.66,122.34a8,8,0,0,1,0,11.32l-82.05,82a56,56,0,0,1-79.2-79.21L147.67,35.73a40,40,0,1,1,56.61,56.55L105,193A24,24,0,1,1,71,159L154.3,74.38A8,8,0,1,1,165.7,85.6L82.39,170.31a8,8,0,1,0,11.27,11.36L192.93,81A24,24,0,1,0,159,47L59.76,147.68a40,40,0,1,0,56.53,56.62l82.06-82A8,8,0,0,1,209.66,122.34Z"></path>
                                </svg>
                                File Selected
                            `;
                        }
                    });

                    // Remove file button
                    removeFileBtn.addEventListener('click', function() {
                        certFileInput.value = '';
                        filePreview.classList.add('hidden');
                        fileLabel.innerHTML = `
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 256 256">
                                <path d="M209.66,122.34a8,8,0,0,1,0,11.32l-82.05,82a56,56,0,0,1-79.2-79.21L147.67,35.73a40,40,0,1,1,56.61,56.55L105,193A24,24,0,1,1,71,159L154.3,74.38A8,8,0,1,1,165.7,85.6L82.39,170.31a8,8,0,1,0,11.27,11.36L192.93,81A24,24,0,1,0,159,47L59.76,147.68a40,40,0,1,0,56.53,56.62l82.06-82A8,8,0,0,1,209.66,122.34Z"></path>
                            </svg>
                            Upload Certificate (PDF/Image)
                        `;
                    });

                    // Add certification to DOM
                    function addCertificationToDOM(certification) {
                        const certCard = document.createElement('div');
                        certCard.className = 'p-4 bg-neutral-50 rounded-lg border border-neutral-200 flex justify-between items-start';
                        
                        const fileIcon = certification.file_type === 'pdf' 
                            ? `<svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>`
                            : `<svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>`;

                        certCard.innerHTML = `
                            <div class="flex gap-3 flex-1">
                                <div class="w-10 h-10 flex items-center justify-center bg-white rounded border border-neutral-300">
                                    ${fileIcon}
                                </div>
                                <div>
                                    <h4 class="text-b-1 font-semibold text-neutral-1000">${certification.title}</h4>
                                    <p class="text-b-2 text-neutral-700">${certification.issuer}</p>
                                    <p class="text-b-3 text-neutral-500 mt-1">${certification.year}</p>
                                    <a href="${certification.file_url}" target="_blank" class="text-b-3 text-primary-500 hover:text-primary-600 underline mt-1 inline-block">View Certificate</a>
                                </div>
                            </div>
                            <button type="button" class="delete-certification-btn text-neutral-400 hover:text-red-500 transition" data-index="${certification.index}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        `;
                        
                        // Remove empty state if exists
                        const emptyState = certificationContainer.querySelector('p.text-neutral-500, .flex.flex-col');
                        if (emptyState) emptyState.remove();
                        
                        certificationContainer.appendChild(certCard);
                        
                        // Add delete handler
                        const deleteBtn = certCard.querySelector('.delete-certification-btn');
                        deleteBtn.addEventListener('click', () => handleDeleteCertification(certification.index, certCard));
                    }

                    // Handle form submission
                    addCertificationForm.addEventListener('submit', async function(e) {
                        e.preventDefault();
                        
                        const formData = new FormData(addCertificationForm);
                        
                        // Disable button
                        addCertificationBtn.disabled = true;
                        addCertificationText.textContent = 'Uploading...';
                        certificationError.classList.add('hidden');
                        
                        try {
                            const response = await fetch('{{ route("certifications.store") }}', {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'Accept': 'application/json'
                                },
                                body: formData
                            });
                            
                            const data = await response.json();
                            
                            if (response.ok) {
                                addCertificationToDOM(data.certification);
                                showToast('Certification added successfully!', 'success');
                                addCertificationForm.reset();
                                filePreview.classList.add('hidden');
                                fileLabel.innerHTML = `
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 256 256">
                                        <path d="M209.66,122.34a8,8,0,0,1,0,11.32l-82.05,82a56,56,0,0,1-79.2-79.21L147.67,35.73a40,40,0,1,1,56.61,56.55L105,193A24,24,0,1,1,71,159L154.3,74.38A8,8,0,1,1,165.7,85.6L82.39,170.31a8,8,0,1,0,11.27,11.36L192.93,81A24,24,0,1,0,159,47L59.76,147.68a40,40,0,1,0,56.53,56.62l82.06-82A8,8,0,0,1,209.66,122.34Z"></path>
                                    </svg>
                                    Upload Certificate (PDF/Image)
                                `;
                            } else {
                                certificationError.textContent = data.message || 'Failed to add certification';
                                certificationError.classList.remove('hidden');
                                showToast(data.message || 'Failed to add certification', 'error');
                            }
                        } catch (error) {
                            console.error('Error adding certification:', error);
                            certificationError.textContent = 'An error occurred. Please try again.';
                            certificationError.classList.remove('hidden');
                            showToast('An error occurred. Please try again.', 'error');
                        } finally {
                            addCertificationBtn.disabled = false;
                            addCertificationText.textContent = 'Add Certification';
                        }
                    });

                    // Handle certification deletion
                    async function handleDeleteCertification(index, certCard) {
                        if (!confirm('Are you sure you want to delete this certification?')) {
                            return;
                        }

                        try {
                            const response = await fetch(`/profile/certifications/${index}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'Accept': 'application/json'
                                }
                            });
                            
                            if (response.ok) {
                                certCard.remove();
                                showToast('Certification removed successfully!', 'success');
                                
                                // Show empty state if no certifications left
                                if (certificationContainer.children.length === 0) {
                                    certificationContainer.innerHTML = `
                                        <div class="flex flex-col items-center justify-center py-12 border-2 border-dashed border-neutral-200 rounded-lg">
                                            <div class="w-16 h-16 bg-neutral-100 rounded-full flex items-center justify-center mb-4">
                                                <svg class="w-8 h-8 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                </svg>
                                            </div>
                                            <p class="text-b-1 text-neutral-500 mb-1">No certifications added yet</p>
                                            <p class="text-b-3 text-neutral-400">Add your first certification above</p>
                                        </div>
                                    `;
                                }
                            } else {
                                showToast('Failed to remove certification', 'error');
                            }
                        } catch (error) {
                            console.error('Error removing certification:', error);
                            showToast('An error occurred. Please try again.', 'error');
                        }
                    }

                    // Attach delete handlers to existing certifications
                    document.querySelectorAll('.delete-certification-btn').forEach(btn => {
                        const index = btn.getAttribute('data-index');
                        const card = btn.closest('.p-4');
                        btn.addEventListener('click', () => handleDeleteCertification(index, card));
                    });
                });
            </script>

            <!-- Certifications List -->
            <div id="certification-container" class="space-y-3">
                @php
                    $certificationList = Auth::user()->developerProfile?->certifications ?? [];
                    if (is_string($certificationList)) {
                        $certificationList = json_decode($certificationList, true) ?? [];
                    }
                @endphp
                @forelse($certificationList as $index => $cert)
                    <div class="p-4 bg-neutral-50 rounded-lg border border-neutral-200 flex justify-between items-start">
                        <div class="flex gap-3 flex-1">
                            <div class="w-10 h-10 flex items-center justify-center bg-white rounded border border-neutral-300">
                                @if(($cert['file_type'] ?? '') === 'pdf')
                                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                @else
                                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <h4 class="text-b-1 font-semibold text-neutral-1000">{{ $cert['title'] ?? '' }}</h4>
                                <p class="text-b-2 text-neutral-700">{{ $cert['issuer'] ?? '' }}</p>
                                <p class="text-b-3 text-neutral-500 mt-1">{{ $cert['year'] ?? '' }}</p>
                                @if(isset($cert['file_path']))
                                    <a href="{{ Storage::url($cert['file_path']) }}" target="_blank" class="text-b-3 text-primary-500 hover:text-primary-600 underline mt-1 inline-block">View Certificate</a>
                                @endif
                            </div>
                        </div>
                        <button type="button" class="delete-certification-btn text-neutral-400 hover:text-red-500 transition" data-index="{{ $index }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center py-12 border-2 border-dashed border-neutral-200 rounded-lg">
                        <div class="w-16 h-16 bg-neutral-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <p class="text-b-1 text-neutral-500 mb-1">No certifications added yet</p>
                        <p class="text-b-3 text-neutral-400">Add your first certification above</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
