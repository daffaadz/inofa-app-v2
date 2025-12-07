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

            @if (isset($metadata['type']) && $metadata['type'] == 'proposal')
                {{-- Proposal Attachment --}}
                @include('vendor.Chatify.layouts.proposalCard', [
                    'isSender' => $isSender,
                    'message_id' => $id,
                    'metadata' => $metadata,
                    'project_agreement_id' => $project_agreement_id ?? null,
                    'status' => $metadata['status'] ?? 'pending',
                    'agreement' => isset($metadata['agreement_id'])
                        ? \App\Models\ProjectAgreement::find($metadata['agreement_id'])
                        : null,
                    'created_at' => $created_at ?? null,
                    'created_at_human' => isset($created_at)
                        ? \Carbon\Carbon::parse($created_at)->locale('id')->diffForHumans()
                        : '',
                    'seen' => $seen ?? false,
                ])
            @elseif (isset($metadata['type']) && $metadata['type'] == 'agreement_request')
                {{-- Agreement Request Message --}}
                @php
                    // Check if agreement already exists for this conversation/project
                    $hasAgreement = false;
                    $agreementCreated = false;
                    
                    if (isset($metadata['to_id']) && isset($metadata['project_id'])) {
                        // Get current conversation participants
                        $currentUserId = Auth::id();
                        $toUserId = $metadata['to_id'];
                        
                        // Check if any agreement exists between these users for this project
                        $existingAgreement = \App\Models\ProjectAgreement::where('project_id', $metadata['project_id'])
                            ->where(function($query) use ($currentUserId, $toUserId) {
                                $query->where(function($q) use ($currentUserId, $toUserId) {
                                    $q->where('developer_id', $currentUserId)
                                      ->where('consumer_id', $toUserId);
                                })->orWhere(function($q) use ($currentUserId, $toUserId) {
                                    $q->where('developer_id', $toUserId)
                                      ->where('consumer_id', $currentUserId);
                                });
                            })
                            ->first();
                        
                        if ($existingAgreement) {
                            $hasAgreement = true;
                            $agreementCreated = true;
                        }
                    }
                @endphp
                
                <div
                    class="px-4 py-3 rounded-2xl {{ $isSender ? 'bg-primary-500 text-white rounded-br-sm' : 'bg-white text-neutral-900 rounded-bl-sm shadow-sm border border-neutral-200' }}">
                    
                    @if (isset($metadata['to_id']))
                        @if ($agreementCreated)
                            {{-- Show disabled button with message if agreement already created --}}
                            <button type="button"
                                disabled
                                class="inline-flex items-center gap-2 bg-neutral-300 text-neutral-500 rounded-xl px-4 py-2.5 text-b-2 font-semibold cursor-not-allowed opacity-60">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Agreement Sudah Dibuat
                            </button>
                        @else
                            {{-- Show active button if no agreement yet --}}
                            <button type="button"
                                onclick="showAgreementRequestModal('{{ route('proposals.create', ['to_id' => $metadata['to_id'], 'project_id' => $metadata['project_id'] ?? null]) }}')"
                                class="inline-flex items-center gap-2 bg-primary-500 hover:bg-primary-600 text-white rounded-xl px-4 py-2.5 text-b-2 font-semibold transition shadow-sm agreement-request-btn">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                {{ $metadata['button_text'] ?? 'Buat Agreement' }}
                            </button>
                        @endif
                    @endif
                </div>
                <div class="mx-2 flex {{ $isSender ? 'justify-end text-white' : 'justify-start text-gray-600' }}">
                    {!! $timeAndSeen !!}
                </div>
            @elseif (isset($metadata['type']) && $metadata['type'] == 'complaint_button')
                {{-- Complaint Button Message --}}
                <div
                    class="px-4 py-3 rounded-2xl {{ $isSender ? 'bg-primary-500 text-white rounded-br-sm' : 'bg-white text-neutral-900 rounded-bl-sm shadow-sm border border-neutral-200' }}">
                    @if ($message)
                        <div class="text-b-2 break-words whitespace-normal mb-3">
                            {!! nl2br($message) !!}
                        </div>
                    @endif
                    
                    <button type="button"
                        class="open-complaint-modal inline-flex items-center gap-2 bg-primary-500 hover:bg-primary-600 text-white rounded-xl px-4 py-2.5 text-b-2 font-semibold transition shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        {{ $metadata['button_text'] ?? 'Buat Pengaduan' }}
                    </button>
                </div>
                <div class="mx-2 flex {{ $isSender ? 'justify-end text-white' : 'justify-start text-gray-600' }}">
                    {!! $timeAndSeen !!}
                </div>
            @elseif (isset($metadata['type']) && $metadata['type'] == 'termination_request')
                {{-- Termination Request Message --}}
                <div
                    class="px-4 py-3 rounded-2xl {{ $isSender ? 'bg-red-500 text-white rounded-br-sm' : 'bg-white text-neutral-900 rounded-bl-sm shadow-sm border-2 border-red-200' }}">
                    @if ($message)
                        <div class="text-b-2 break-words whitespace-normal {{ !$isSender && isset($metadata['requires_action']) && $metadata['requires_action'] ? 'mb-3' : '' }} {{ $isSender ? 'text-white' : 'text-neutral-700' }}">
                            {!! nl2br($message) !!}
                        </div>
                    @endif
                    
                    @if (!$isSender && isset($metadata['requires_action']) && $metadata['requires_action'])
                        @php
                            // Check if current user is developer
                            $isDeveloper = Auth::user()->role === 'developer';
                            $showButton = !isset($metadata['show_to_role']) || $metadata['show_to_role'] === Auth::user()->role;
                        @endphp
                        
                        @if ($isDeveloper && $showButton)
                            <button type="button"
                                onclick="event.stopPropagation(); event.preventDefault(); window.showTerminationModal('{{ $metadata['agreement_id'] ?? '' }}'); return false;"
                                class="termination-confirm-btn inline-flex items-center gap-2 bg-red-500 hover:bg-white border border-red-500 hover:text-red-500 text-white rounded-xl px-4 py-2.5 text-b-2 font-semibold transition shadow-sm"
                                data-agreement-id="{{ $metadata['agreement_id'] ?? '' }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                {{ $metadata['button_text'] ?? 'Confirm Stop Project' }}
                            </button>
                        @endif
                    @endif
                </div>
                <div class="mx-2 flex {{ $isSender ? 'justify-end text-white' : 'justify-start text-gray-600' }}">
                    {!! $timeAndSeen !!}
                </div>
            @else
                {{-- Text Message --}}
                @if ((@$attachment->type != 'image' && @$attachment->type != 'file') || $message)
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

                {{-- File Attachment (non-image) --}}
                @if (@$attachment->type == 'file')
                    <div class="inline-block max-w-sm">
                        <div class="px-4 py-3 rounded-2xl {{ $isSender ? 'bg-primary-500 text-white rounded-br-sm' : 'bg-white text-neutral-900 rounded-bl-sm shadow-sm' }}">
                            <a href="{{ route(config('chatify.attachments.download_route_name'), ['fileName' => $attachment->file]) }}" 
                               class="flex items-center gap-3 hover:opacity-80 transition {{ $isSender ? 'text-white' : 'text-neutral-900' }}" 
                               download>
                                {{-- File Icon --}}
                                <div class="flex-shrink-0 p-2.5 rounded-lg {{ $isSender ? 'bg-white/20' : 'bg-primary-50' }}">
                                    @php
                                        $fileExtension = pathinfo($attachment->old_name ?? $attachment->file, PATHINFO_EXTENSION);
                                        $iconClass = 'fas fa-file';
                                        $iconColor = $isSender ? 'text-white' : 'text-primary-500';
                                        
                                        if (in_array(strtolower($fileExtension), ['pdf'])) {
                                            $iconClass = 'fas fa-file-pdf';
                                            $iconColor = $isSender ? 'text-white' : 'text-red-500';
                                        } elseif (in_array(strtolower($fileExtension), ['doc', 'docx'])) {
                                            $iconClass = 'fas fa-file-word';
                                            $iconColor = $isSender ? 'text-white' : 'text-blue-600';
                                        } elseif (in_array(strtolower($fileExtension), ['xls', 'xlsx', 'csv'])) {
                                            $iconClass = 'fas fa-file-excel';
                                            $iconColor = $isSender ? 'text-white' : 'text-green-600';
                                        } elseif (in_array(strtolower($fileExtension), ['ppt', 'pptx'])) {
                                            $iconClass = 'fas fa-file-powerpoint';
                                            $iconColor = $isSender ? 'text-white' : 'text-orange-600';
                                        } elseif (in_array(strtolower($fileExtension), ['zip', 'rar', '7z', 'tar', 'gz'])) {
                                            $iconClass = 'fas fa-file-archive';
                                            $iconColor = $isSender ? 'text-white' : 'text-yellow-600';
                                        } elseif (in_array(strtolower($fileExtension), ['txt', 'log'])) {
                                            $iconClass = 'fas fa-file-alt';
                                            $iconColor = $isSender ? 'text-white' : 'text-gray-600';
                                        }
                                    @endphp
                                    <i class="{{ $iconClass }} {{ $iconColor }} text-xl"></i>
                                </div>
                                
                                {{-- File Info --}}
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold truncate">
                                        {{ $attachment->old_name ?? basename($attachment->file) }}
                                    </p>
                                    <p class="text-xs {{ $isSender ? 'text-white/70' : 'text-neutral-500' }} mt-0.5">
                                        {{ strtoupper($fileExtension) }} File
                                    </p>
                                </div>
                                
                                {{-- Download Icon --}}
                                <div class="flex-shrink-0">
                                    <i class="fas fa-download text-sm {{ $isSender ? 'text-white/70' : 'text-neutral-400' }}"></i>
                                </div>
                            </a>
                        </div>
                        <div class="mt-1 px-2 flex {{ $isSender ? 'justify-end' : 'justify-start' }}">
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
            @endif
        </div>
    </div>
</div>
