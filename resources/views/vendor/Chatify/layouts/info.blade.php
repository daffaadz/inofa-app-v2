{{-- User info and avatar --}}
<div class="flex flex-col items-center mb-6">
    <div class="avatar av-l w-24 h-24 rounded-full bg-neutral-200 mb-4"></div>
    <p class="info-name text-h-6 text-neutral-900 text-center">{{ config('chatify.name') }}</p>
    <p class="text-b-2 text-neutral-500">Online</p>
</div>

{{-- Action Buttons --}}
<div class="messenger-infoView-btns space-y-3 mb-6">
    <button class="danger delete-conversation w-full px-4 py-3 bg-red-50 hover:bg-red-100 text-red-600 rounded-xl transition text-b-2 font-medium">
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