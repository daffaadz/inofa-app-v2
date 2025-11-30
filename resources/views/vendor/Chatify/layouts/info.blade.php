{{-- User info and avatar --}}
<div class="flex flex-col items-center mb-6">
    <div class="avatar av-l w-24 h-24 rounded-full bg-neutral-200 mb-4"></div>
    <p class="info-name text-b-1 text-neutral-900 text-center">{{ config('chatify.name') }}</p>
    <p class="text-b-3 text-neutral-500 conversation-title-display">
        @if (!$conversation)
            No conversation
        @else
            {{ $conversation->title ?? 'No conversation title' }}
        @endif
    </p>
</div>

{{-- Edit Conversation Title --}}
@if(auth()->user()->role === 'consumer')
<div class="mb-6" x-data="{ editing: false }">
    <div x-show="!editing" class="flex items-center justify-between gap-2 px-4 py-3 bg-neutral-50 rounded-xl">
        <div class="flex-1 min-w-0">
            <p class="text-b-4 text-neutral-500 mb-1">Conversation Title</p>
            <p class="text-b-2 font-medium text-neutral-900 truncate conversation-title-text">
                {{ $conversation->title ?? 'No title set' }}
            </p>
        </div>
        <button @click="editing = true" class="flex-shrink-0 text-primary-600 hover:text-primary-700 transition">
            <i class="fas fa-edit"></i>
        </button>
    </div>

    <div x-show="editing" class="space-y-2" style="display: none;">
        <input type="text" id="conversationTitleInput"
            class="w-full px-4 py-3 border border-neutral-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-b-2"
            placeholder="Enter conversation title" value="{{ $conversation->title ?? '' }}">
        <div class="flex gap-2">
            <button @click="updateConversationTitle()"
                class="flex-1 px-4 py-2 bg-primary-500 hover:bg-primary-600 text-white rounded-lg transition text-b-3 font-medium">
                Save
            </button>
            <button @click="editing = false"
                class="px-4 py-2 bg-neutral-200 hover:bg-neutral-300 text-neutral-700 rounded-lg transition text-b-3 font-medium">
                Cancel
            </button>
        </div>
    </div>
</div>
@else
<div class="mb-6">
    <div class="flex items-center justify-between gap-2 px-4 py-3 bg-neutral-50 rounded-xl">
        <div class="flex-1 min-w-0">
            <p class="text-b-4 text-neutral-500 mb-1">Conversation Title</p>
            <p class="text-b-2 font-medium text-neutral-900 truncate conversation-title-text">
                {{ $conversation->title ?? 'No title set' }}
            </p>
        </div>
    </div>
</div>
@endif

{{-- Action Buttons --}}
<div class="messenger-infoView-btns space-y-3 mb-6">
    <button
        class="danger delete-conversation w-full px-4 py-3 bg-red-50 hover:bg-red-100 text-red-600 rounded-xl transition text-b-2 font-medium">
        <i class="fas fa-trash mr-2"></i>
        Delete Conversation
    </button>
</div>

{{-- Shared Photos --}}
<div class="messenger-infoView-shared">
    <p class="messenger-title text-b-1 font-semibold text-neutral-900 mb-3">
        <span>Shared Photos</span>
    </p>
    <div class="shared-photos-list grid grid-cols-3 gap-2"></div>
</div>

<script>
    function updateConversationTitle() {
        const conversationId = "{{ $conversation->id ?? '' }}";
        const title = document.getElementById('conversationTitleInput').value;

        if (!conversationId) {
            alert('No active conversation');
            return;
        }

        fetch(`/chat/update-conversation-title/${conversationId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    title: title
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update displayed title
                    document.querySelectorAll('.conversation-title-text').forEach(el => {
                        el.textContent = data.title || 'No conversation title';
                    });
                    document.querySelectorAll('.conversation-title-display').forEach(el => {
                        el.textContent = data.title || 'No conversation title';
                    });

                    // Close editing mode
                    Alpine.store('editing', false);
                    alert('Conversation title updated successfully');
                } else {
                    alert(data.message || 'Failed to update conversation title');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while updating the conversation title');
            });
    }
</script>
