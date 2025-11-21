<?php
$seenIcon = !!$seen ? 'check-double' : 'check';
$timeAndSeen =
    "<span data-time='$created_at' class='message-time inline-flex items-center gap-1 text-b-4'>
        " .
    ($isSender ? "<span class='fas fa-$seenIcon seen text-primary-500'></span>" : '') .
    " 
        <span class='time text-neutral-500'>$timeAgo</span>
    </span>";
?>

<div class="message-card mb-4 flex {{ $isSender ? 'mc-sender justify-end' : 'justify-start' }}"
    data-id="{{ $id }}">
    <div class="max-w-[70%] {{ $isSender ? 'items-end' : 'items-start' }} flex flex-col">

        {{-- Message Content --}}
        <div class="relative group">

            {{-- Delete Button (for sender) --}}
            @if ($isSender)
                <div class="actions absolute -left-8 top-2 opacity-0 group-hover:opacity-100 transition">
                    <button class="delete-btn p-1.5 hover:bg-neutral-100 rounded-lg" data-id="{{ $id }}">
                        <i class="fas fa-trash text-neutral-400 text-xs"></i>
                    </button>
                </div>
            @endif

            {{-- Text Message --}}
            @if (@$attachment->type != 'image' || $message)
                <div
                    class="px-4 py-3 rounded-2xl {{ $isSender ? 'bg-primary-500 text-white rounded-br-sm' : 'bg-white text-neutral-900 rounded-bl-sm shadow-sm' }}">
                    <div class="text-b-2 break-words whitespace-normal">
                        {!! $message == null && $attachment != null && @$attachment->type != 'file'
                            ? $attachment->title
                            : nl2br($message) !!}
                    </div>

                    {{-- File Attachment --}}
                    @if (@$attachment->type == 'file')
                        <a href="{{ route(config('chatify.attachments.download_route_name'), ['fileName' => $attachment->file]) }}"
                            class="file-download mt-2 flex items-center gap-2 p-2 rounded-lg {{ $isSender ? 'bg-primary-600' : 'bg-neutral-50' }} hover:opacity-80 transition">
                            <span class="fas fa-file"></span>
                            <span class="text-b-3 truncate">{{ $attachment->title }}</span>
                        </a>
                    @endif

                    <div class="mt-1 flex {{ $isSender ? 'justify-end' : 'justify-start' }}">
                        {!! $timeAndSeen !!}
                    </div>
                </div>
            @endif

            {{-- Image Attachment --}}
            @if (@$attachment->type == 'image')
                <div class="image-wrapper">
                    <div class="image-file chat-image rounded-2xl overflow-hidden cursor-pointer hover:opacity-90 transition max-w-xs bg-cover bg-center"
                        style="background-image: url('{{ Chatify::getAttachmentUrl($attachment->file) }}'); height: 200px;">
                    </div>
                    <div class="mt-1 px-2 flex {{ $isSender ? 'justify-end' : 'justify-start' }}">
                        {!! $timeAndSeen !!}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
