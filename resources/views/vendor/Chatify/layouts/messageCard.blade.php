<?php
$seenIcon = !!$seen ? '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-auto" fill="currentColor" viewBox="0 0 256 256"><path d="M149.61,85.71l-89.6,88a8,8,0,0,1-11.22,0L10.39,136a8,8,0,1,1,11.22-11.41L54.4,156.79l84-82.5a8,8,0,1,1,11.22,11.42Zm96.1-11.32a8,8,0,0,0-11.32-.1l-84,82.5-18.83-18.5a8,8,0,0,0-11.21,11.42l24.43,24a8,8,0,0,0,11.22,0l89.6-88A8,8,0,0,0,245.71,74.39Z"></path></svg>' : '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-auto" fill="currentColor" viewBox="0 0 256 256"><path d="M229.66,77.66l-128,128a8,8,0,0,1-11.32,0l-56-56a8,8,0,0,1,11.32-11.32L96,188.69,218.34,66.34a8,8,0,0,1,11.32,11.32Z"></path></svg>';
$timeAndSeen =
    "<span data-time='$created_at' class='message-time flex flex-row items-center gap-1 text-b-4 mt-2'>
        " .
    ($isSender ? "<span class='seen text-primary-500'>$seenIcon</span>" : '') .
    " 
        <span class='time text-neutral-500'>$timeAgo</span>
    </span>";
?>

@if (isset($metadata['type']) && $metadata['type'] == 'proposal')
    {{-- Proposal Attachment --}}
    <div class="proposal-wrapper mt-2">
        @include('vendor.Chatify.layouts.proposalCard', [
            'isSender' => $isSender,
            'message_id' => $id,
            'metadata' => $metadata,
            'status' => $metadata['status'] ?? 'pending',
            'agreement' => isset($metadata['agreement_id'])
                ? \App\Models\ProjectAgreement::find($metadata['agreement_id'])
                : null,
            'created_at_human' => isset($created_at)
                ? \Carbon\Carbon::parse($created_at)->locale('id')->diffForHumans()
                : '',
        ])
    </div>
@else
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

                    </div>
                    <div class="mx-2 flex {{ $isSender ? 'justify-end text-white' : 'justify-start text-gray-600' }}">
                        {!! $timeAndSeen !!}
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
@endif
