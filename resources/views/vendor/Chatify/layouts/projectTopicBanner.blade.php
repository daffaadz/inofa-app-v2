{{-- Project Topic Banner Component --}}
@if (auth()->user()->role === 'consumer' && isset($conversation) && $conversation->type == 'project')
    <div class="project-topic-banner bg-primary-100 border-b border-primary-200 shadow-xl" x-data="{ dropdownOpen: false }">
        <div class="px-6 py-3 flex items-center justify-between gap-6">
            <div class="flex items-center gap-3 flex-1 min-w-0">
                <svg class="w-5 h-5 text-primary-500 flex-shrink-0" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>

                <div class="flex-1 min-w-0 relative">
                    <div class="flex items-center gap-2">
                        <span class="text-b-3 text-primary-700 font-medium">Project Topic:</span>
                        <button @click="dropdownOpen = !dropdownOpen" type="button"
                            class="current-project-title text-b-2 font-semibold text-neutral-900 hover:text-primary-600 transition truncate flex items-center gap-1">
                            <span class="truncate" id="currentProjectTitle">
                                {{ $currentProject ? $currentProject->title : 'New Project Discussion' }}
                            </span>
                            <svg class="w-4 h-4 flex-shrink-0 transition-transform"
                                :class="{ 'rotate-180': dropdownOpen }" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                    </div>
                    @if ($currentProject)
                        <p class="text-b-3 text-neutral-600 truncate mt-0.5">
                            {{ Str::limit($currentProject->description, 60) }}</p>
                    @else
                        <p class="text-b-3 text-neutral-600 truncate mt-0.5">Discussing a new project idea</p>
                    @endif

                    {{-- Dropdown Menu --}}
                    <div x-show="dropdownOpen" @click.away="dropdownOpen = false"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-95"
                        class="absolute left-0 top-full mt-2 w-96 bg-white rounded-lg shadow-lg border border-neutral-200 overflow-hidden z-50"
                        style="display: none;">

                        <div class="p-3 border-b border-neutral-100 bg-neutral-50">
                            <p class="text-b-3 text-neutral-600 font-medium">Select Project Topic</p>
                        </div>

                        <div class="max-h-80 overflow-y-auto">
                            {{-- New Project Option --}}
                            <button type="button" onclick="changeProjectTopic(null)"
                                class="w-full px-4 py-3 hover:bg-primary-50 transition text-left border-b border-neutral-100 {{ !$currentProject ? 'bg-primary-50' : '' }}">
                                <div class="flex items-start gap-3">
                                    <div
                                        class="w-8 h-8 bg-primary-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                        <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v16m8-8H4" />
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-b-2 font-semibold text-neutral-900">New Project Discussion</p>
                                        <p class="text-b-3 text-neutral-500 mt-0.5">Start a conversation about a new
                                            project idea</p>
                                    </div>
                                </div>
                            </button>

                            {{-- User's Projects --}}
                            @forelse($userProjects as $project)
                                <button type="button" onclick="changeProjectTopic({{ $project->id }})"
                                    class="w-full px-4 py-3 hover:bg-neutral-50 transition text-left border-b border-neutral-100 last:border-0 {{ $currentProject && $currentProject->id === $project->id ? 'bg-primary-50' : '' }}">
                                    <div class="flex items-start gap-3">
                                        <div
                                            class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-b-2 font-semibold text-neutral-900 truncate">
                                                {{ $project->title }}</p>
                                            <p class="text-b-3 text-neutral-500 line-clamp-2 mt-0.5">
                                                {{ Str::limit($project->description, 80) }}</p>
                                            <div class="flex items-center gap-2 mt-1">
                                                <span
                                                    class="text-b-4 px-2 py-0.5 rounded bg-neutral-100 text-neutral-600">{{ ucfirst($project->status) }}</span>
                                                @if ($project->budget)
                                                    <span class="text-b-4 text-neutral-500">• Rp
                                                        {{ number_format($project->budget, 0, ',', '.') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </button>
                            @empty
                                <div class="px-4 py-6 text-center">
                                    <p class="text-b-2 text-neutral-500">You don't have any projects yet</p>
                                    <a href="{{ route('consumer.project.create') }}"
                                        class="text-b-3 text-primary-600 hover:text-primary-700 mt-1 inline-block">
                                        Create your first project
                                    </a>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            @if ($currentProject)
                <a href="{{ route('consumer.project.show', $currentProject->id) }}"
                    class="ml-4 text-b-3 text-primary-600 hover:text-primary-700 font-medium whitespace-nowrap flex items-center gap-1 transition hover:underline">
                    Project Details
                </a>
            @endif

            {{-- Ask Developer to Create Agreement Button --}}
            <button type="button" onclick="askForAgreement()"
                class="bg-primary-500 hover:bg-primary-600 text-white text-b-2 font-semibold py-2.5 px-4 rounded-lg transition flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Ask Dev to Create Agreement
            </button>
        </div>
    </div>

    <script>
        function changeProjectTopic(projectId) {
            const conversationId = "{{ $conversation->id ?? '' }}";

            if (!conversationId) {
                alert('No active conversation found');
                return;
            }

            fetch(`/chat/update-project-topic/${conversationId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        project_id: projectId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Reload page to reflect changes
                        location.reload();
                    } else {
                        alert(data.message || 'Failed to update project topic');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while updating the project topic');
                });
        }

        function askForAgreement() {
            const conversationId = "{{ $conversation->id ?? '' }}";
            const projectTitle = document.getElementById('currentProjectTitle')?.textContent.trim() || 'this project';
            const hasProject = "{{ $currentProject ? 'true' : 'false' }}";

            if (!conversationId) {
                alert('No active conversation found');
                return;
            }

            let message;
            if (hasProject === 'true') {
                message = `Hi! I would like to request a formal agreement for the project: "${projectTitle}". Could you please create and send me the agreement proposal? Thank you!`;
            } else {
                message = `Hi! I'm interested in discussing a new project. Could you please help me create a formal agreement proposal for this project? Thank you!`;
            }

            if (!confirm('Send agreement request to developer?')) {
                return;
            }

            // Show loading state
            const button = event.target.closest('button');
            const originalContent = button.innerHTML;
            button.disabled = true;
            button.innerHTML = '<svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Sending...';

            fetch(`/chat/send-agreement-request/${conversationId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        message: message
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Append message to chat
                        const messagesContainer = document.querySelector('.messages');
                        if (messagesContainer && data.messageHtml) {
                            messagesContainer.insertAdjacentHTML('beforeend', data.messageHtml);
                            messagesContainer.scrollTop = messagesContainer.scrollHeight;
                        }
                        
                        // Show success notification
                        alert('Agreement request sent successfully!');
                    } else {
                        alert(data.message || 'Failed to send agreement request');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while sending the agreement request');
                })
                .finally(() => {
                    // Restore button state
                    button.disabled = false;
                    button.innerHTML = originalContent;
                });
        }
    </script>
@endif
