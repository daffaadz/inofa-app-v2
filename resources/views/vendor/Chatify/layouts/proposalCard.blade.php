@php
    // Fallback agreement status - Try multiple sources
    $agreementId = $metadata['agreement_id'] ?? $project_agreement_id ?? null;
    $agreement = $agreementId ? \App\Models\ProjectAgreement::find($agreementId) : null;
    $status = $metadata['status'] ?? ($agreement ? $agreement->status : 'pending');
    
    // Debug: Log if agreementId is null
    if (!$agreementId) {
        \Log::warning('ProposalCard: agreementId is null', [
            'metadata' => $metadata ?? null,
            'project_agreement_id' => $project_agreement_id ?? null
        ]);
    }
    
    // Format timeline
    $startDate = isset($metadata['start_date']) ? \Carbon\Carbon::parse($metadata['start_date']) : \Carbon\Carbon::now();
    $endDate = isset($metadata['end_date']) ? \Carbon\Carbon::parse($metadata['end_date']) : \Carbon\Carbon::now()->addMonths(2);
    $timeline = $startDate->format('d M Y') . ' - ' . $endDate->format('d M Y');
    
    // Time and seen (sesuai dengan messageCard)
    $seenIcon = !!($seen ?? false) ? '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-auto" fill="currentColor" viewBox="0 0 256 256"><path d="M149.61,85.71l-89.6,88a8,8,0,0,1-11.22,0L10.39,136a8,8,0,1,1,11.22-11.41L54.4,156.79l84-82.5a8,8,0,1,1,11.22,11.42Zm96.1-11.32a8,8,0,0,0-11.32-.1l-84,82.5-18.83-18.5a8,8,0,0,0-11.21,11.42l24.43,24a8,8,0,0,0,11.22,0l89.6-88A8,8,0,0,0,245.71,74.39Z"></path></svg>' : '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-auto" fill="currentColor" viewBox="0 0 256 256"><path d="M229.66,77.66l-128,128a8,8,0,0,1-11.32,0l-56-56a8,8,0,0,1,11.32-11.32L96,188.69,218.34,66.34a8,8,0,0,1,11.32,11.32Z"></path></svg>';
    $timeAndSeen = "<span data-time='" . ($created_at ?? '') . "' class='message-time flex flex-row items-center gap-1 text-b-4 mt-2'>" .
        ($isSender ? "<span class='seen text-primary-500'>$seenIcon</span>" : '') . 
        " <span class='time text-neutral-500'>" . ($created_at_human ?? '') . "</span></span>";
@endphp

{{-- Main Proposal Card --}}
<div class="proposal-message max-w-sm rounded-2xl overflow-hidden shadow-md bg-white border border-neutral-100" 
     data-agreement-id="{{ $agreementId ?? '' }}" 
     data-status="{{ $status }}">
        
        {{-- Green Header with Icon & Title --}}
        <div class="bg-white px-4 py-3">
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0 bg-gradient-to-br from-primary-500/10 to-secondary-500/20 p-2 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-auto text-primary-500" fill="currentColor" viewBox="0 0 256 256"><path d="M216.49,79.52l-56-56A12,12,0,0,0,152,20H56A20,20,0,0,0,36,40V216a20,20,0,0,0,20,20H200a20,20,0,0,0,20-20V88A12,12,0,0,0,216.49,79.52ZM160,57l23,23H160ZM60,212V44h76V92a12,12,0,0,0,12,12h48V212Zm112-80a12,12,0,0,1-12,12H96a12,12,0,0,1,0-24h64A12,12,0,0,1,172,132Zm0,40a12,12,0,0,1-12,12H96a12,12,0,0,1,0-24h64A12,12,0,0,1,172,172Z"></path></svg>
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="text-neutral-800 font-semibold text-b-1 leading-tight">
                        {{ $metadata['project_title'] ?? 'Pengembangan E-Commerce Mobile App' }}
                    </h3>
                    <p class="text-neutral-500 text-b-3 mt-2 leading-snug">
                        {{ $metadata['description'] ?? 'Aplikasi e-commerce dengan React Native, payment gateway integration, dan backend Node.js' }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Card Body --}}
        <div class="px-4 py-3 space-y-2.5">
            
            {{-- Price --}}
            <div class="flex items-center gap-3">
                <div class="flex-shrink-0 w-5 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-auto h-5" fill="currentColor" viewBox="0 0 256 256">
                        <path d="M128,88a40,40,0,1,0,40,40A40,40,0,0,0,128,88Zm0,64a24,24,0,1,1,24-24A24,24,0,0,1,128,152ZM240,56H16a8,8,0,0,0-8,8V192a8,8,0,0,0,8,8H240a8,8,0,0,0,8-8V64A8,8,0,0,0,240,56ZM193.65,184H62.35A56.78,56.78,0,0,0,24,145.65v-35.3A56.78,56.78,0,0,0,62.35,72h131.3A56.78,56.78,0,0,0,232,110.35v35.3A56.78,56.78,0,0,0,193.65,184ZM232,93.37A40.81,40.81,0,0,1,210.63,72H232ZM45.37,72A40.81,40.81,0,0,1,24,93.37V72ZM24,162.63A40.81,40.81,0,0,1,45.37,184H24ZM210.63,184A40.81,40.81,0,0,1,232,162.63V184Z"></path>
                    </svg>
                </div>
                <div class="flex items-baseline gap-1.5">
                    <span class="text-neutral-500 text-b-3">Price :</span>
                    <span class="text-neutral-900 font-semibold text-b-2">
                        Rp {{ number_format($metadata['proposed_price'] ?? ($metadata['final_price'] ?? 25000000), 0, ',', '.') }}
                    </span>
                </div>
            </div>

            {{-- Timeline --}}
            <div class="flex items-center gap-3">
                <div class="flex-shrink-0 w-5 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-auto h-5" fill="currentColor" viewBox="0 0 256 256">
                        <path d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm0,192a88,88,0,1,1,88-88A88.1,88.1,0,0,1,128,216Zm64-88a8,8,0,0,1-8,8H128a8,8,0,0,1-8-8V72a8,8,0,0,1,16,0v48h48A8,8,0,0,1,192,128Z"></path>
                    </svg>
                </div>
                <div class="flex items-baseline gap-1.5">
                    <span class="text-neutral-500 text-b-3">Timeline:</span>
                    <span class="text-neutral-900 font-semibold text-b-3">
                        {{ $timeline }}
                    </span>
                </div>
            </div>

        </div>

        {{-- Action Buttons or Status --}}
        <div class="px-4 pb-3">
            <div class="proposal-action-area">
                @if (!$isSender && $status == 'pending')
                    {{-- Client sees Reject and Details buttons --}}
                    <div class="flex gap-3">
                        <button type="button" 
                            class="flex-1 px-6 py-2.5 text-b-2 font-medium text-neutral-700 bg-white border border-neutral-300 rounded-2xl hover:bg-neutral-50 transition-colors reject-proposal-btn"
                            data-agreement-id="{{ $agreementId ?? '' }}"
                            @if(!$agreementId) disabled @endif>
                            Reject
                        </button>
                        @if($agreementId)
                        <a href="{{ route('consumer.payments.agreement-detail', ['agreement' => $agreementId]) }}" 
                            class="flex-1 px-6 py-2.5 text-b-2 font-medium text-white bg-primary-500 rounded-2xl hover:bg-primary-600 transition-colors text-center">
                            Details
                        </a>
                        @else
                        <button type="button" 
                            class="flex-1 px-6 py-2.5 text-b-2 font-medium text-white bg-primary-500 rounded-2xl hover:bg-primary-600 transition-colors"
                            disabled>
                            Details
                        </button>
                        @endif
                    </div>
                @elseif ($status == 'pending')
                    {{-- Developer sees waiting status --}}
                    <div class="flex items-center gap-2 px-4 py-2.5 bg-yellow-100 text-yellow-800 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-auto h-4" fill="currentColor" viewBox="0 0 256 256">
                            <path d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm0,192a88,88,0,1,1,88-88A88.1,88.1,0,0,1,128,216Zm64-88a8,8,0,0,1-8,8H128a8,8,0,0,1-8-8V72a8,8,0,0,1,16,0v48h48A8,8,0,0,1,192,128Z"></path>
                        </svg>
                        <span class="text-b-3 font-medium">Waiting respond from client</span>
                    </div>
                @elseif($status == 'accepted')
                    @if (!$isSender)
                        {{-- Client sees payment button --}}
                        @if($agreementId)
                        <a href="{{ route('consumer.payments.agreement-detail', ['agreement' => $agreementId]) }}"
                            class="flex items-center justify-center gap-2 w-full px-4 py-2.5 text-b-2 font-medium text-white bg-primary-500 rounded-lg hover:bg-primary-600 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-auto h-4" fill="currentColor" viewBox="0 0 256 256">
                                <path d="M224,48H32A16,16,0,0,0,16,64V192a16,16,0,0,0,16,16H224a16,16,0,0,0,16-16V64A16,16,0,0,0,224,48Zm0,16V88H32V64Zm0,128H32V104H224v88Zm-16-24a8,8,0,0,1-8,8H168a8,8,0,0,1,0-16h32A8,8,0,0,1,208,168Zm-64,0a8,8,0,0,1-8,8H120a8,8,0,0,1,0-16h16A8,8,0,0,1,144,168Z"></path>
                            </svg>
                            Lanjut ke Pembayaran
                        </a>
                        @endif
                    @else
                        {{-- Developer sees waiting payment status --}}
                        <div class="flex items-center gap-2 px-4 py-2.5 bg-blue-100 text-blue-800 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-auto h-4" fill="currentColor" viewBox="0 0 256 256">
                                <path d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm0,192a88,88,0,1,1,88-88A88.1,88.1,0,0,1,128,216Zm64-88a8,8,0,0,1-8,8H128a8,8,0,0,1-8-8V72a8,8,0,0,1,16,0v48h48A8,8,0,0,1,192,128Z"></path>
                            </svg>
                            <span class="text-b-3 font-medium">Menunggu Pembayaran dari Client</span>
                        </div>
                    @endif
                @elseif($status == 'active' || $status == 'completed')
                    {{-- Payment completed status --}}
                    <div class="flex items-center gap-2 px-4 py-2.5 bg-green-100 text-green-800 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-auto h-4" fill="currentColor" viewBox="0 0 256 256">
                            <path d="M173.66,98.34a8,8,0,0,1,0,11.32l-56,56a8,8,0,0,1-11.32,0l-24-24a8,8,0,0,1,11.32-11.32L112,148.69l50.34-50.35A8,8,0,0,1,173.66,98.34ZM232,128A104,104,0,1,1,128,24,104.11,104.11,0,0,1,232,128Zm-16,0a88,88,0,1,0-88,88A88.1,88.1,0,0,0,216,128Z"></path>
                        </svg>
                        <span class="text-b-3 font-medium">✓ Pembayaran Selesai - Project Aktif</span>
                    </div>
                @elseif($status == 'rejected' || $status == 'terminated')
                    <div class="flex items-center gap-2 px-4 py-2.5 bg-red-100 text-red-800 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-auto h-4" fill="currentColor" viewBox="0 0 256 256">
                            <path d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm0,192a88,88,0,1,1,88-88A88.1,88.1,0,0,1,128,216Zm-8-80V80a8,8,0,0,1,16,0v56a8,8,0,0,1-16,0Zm20,36a12,12,0,1,1-12-12A12,12,0,0,1,140,172Z"></path>
                        </svg>
                        <span class="text-b-3 font-medium">Proposal Ditolak</span>
                    </div>
                @endif
            </div>
        </div>

</div>

{{-- Time and Seen (outside card) --}}
<div class="mx-2 flex {{ $isSender ? 'justify-end' : 'justify-start' }}">
    {!! $timeAndSeen !!}
</div>
