<div class="messenger-sendCard bg-white border-t border-neutral-100 px-6 py-4">
    <form id="message-form" method="POST" action="{{ route('send.message') }}" enctype="multipart/form-data"
        class="flex items-end gap-3">
        @csrf

        {{-- Attachment Button --}}
        <label class="flex-shrink-0 cursor-pointer p-2.5 hover:bg-neutral-50 rounded-xl transition group">
            <svg class="w-6 h-6 text-neutral-400 group-hover:text-primary-500 transition" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <input disabled='disabled' type="file" class="upload-attachment hidden" name="file"
                accept=".{{ implode(', .', config('chatify.attachments.allowed_images')) }}, .{{ implode(', .', config('chatify.attachments.allowed_files')) }}" />
        </label>

        {{-- Message Input --}}
        <div
            class="flex-1 bg-neutral-10 rounded-2xl border border-neutral-200 focus-within:border-primary-500 focus-within:ring-2 focus-within:ring-primary-100 transition overflow-hidden">
            <textarea readonly='readonly' name="message"
                class="m-send w-full px-4 py-3 text-b-2 bg-transparent border-0 focus:outline-none focus:ring-0 resize-none"
                placeholder="Type a message.." rows="1" style="max-height: 120px;"></textarea>
        </div>

        {{-- Emoji Button --}}
        <button type="button" class="emoji-button flex-shrink-0 p-2.5 hover:bg-neutral-50 rounded-xl transition group">
            <svg class="w-6 h-6 text-neutral-400 group-hover:text-secondary-500 transition" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </button>

        {{-- Send Button --}}
        <button disabled='disabled'
            class="send-button flex-shrink-0 p-2.5 bg-primary-500 hover:bg-primary-600 disabled:bg-neutral-200 disabled:cursor-not-allowed rounded-xl transition group">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
            </svg>
        </button>
    </form>
</div>
