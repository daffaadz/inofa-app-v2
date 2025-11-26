@php
    // Fallback agreement status
    $agreement = \App\Models\ProjectAgreement::find($metadata['agreement_id'] ?? null);
    $status = $metadata['status'] ?? ($agreement ? $agreement->status : 'pending');

    // Gunakan from_id yang dipassing dari include, atau fallback ke metadata
    $senderId = $from_id ?? ($metadata['from_user_id'] ?? 0);
    $isSender = auth()->id() == $senderId;
@endphp

<div class="message-card proposal-message {{ $isSender ? 'owner' : 'client' }}" data-id="{{ $message_id ?? '' }}">
    <div class="card shadow-sm {{ $isSender ? 'border-start border-success border-3' : '' }}">

        <div class="card-header {{ $isSender ? 'bg-light' : 'bg-success text-white' }} py-2">
            <div class="d-flex align-items-center">
                <div class="icon-wrapper me-2"><i class="fas fa-file-contract"></i></div>
                <div class="flex-grow-1">
                    <h6 class="mb-0 fw-bold" style="font-size: 14px;">{{ $metadata['project_title'] ?? 'Proposal' }}</h6>
                    <small class="{{ $isSender ? 'text-muted' : 'text-white-50' }}" style="font-size: 11px;">
                        {{ $isSender ? 'Proposal Anda' : 'Tawaran Masuk' }}
                    </small>
                </div>
            </div>
        </div>

        <div class="card-body pt-2 pb-2">
            <div class="mb-2" style="font-size: 13px;">
                <strong>Project:</strong> {{ $metadata['project_title'] ?? '-' }}
            </div>
            <div class="mb-3 border-top pt-2">
                <span class="text-muted" style="font-size: 12px;">Total:</span>
                <strong class="text-success fs-6">Rp
                    {{ number_format($metadata['proposed_price'] ?? ($metadata['final_price'] ?? 0), 0, ',', '.') }}</strong>
            </div>

            @if (!$isSender && $status == 'pending')
                <div class="d-flex gap-2 mt-2">
                    <button type="button" class="btn btn-outline-danger flex-fill reject-proposal-btn"
                        style="font-size: 12px; padding: 6px;"
                        data-agreement-id="{{ $agreement ? $agreement->id : '' }}">
                        <i class="fas fa-times"></i> Tolak
                    </button>
                    <button type="button" class="btn btn-success flex-fill accept-proposal-btn"
                        style="font-size: 12px; padding: 6px;"
                        data-agreement-id="{{ $agreement ? $agreement->id : '' }}">
                        <i class="fas fa-check"></i> Terima
                    </button>
                </div>
            @else
                @if ($status == 'pending')
                    <div class="alert alert-info mb-0 p-2" style="font-size: 12px;"><i
                            class="fas fa-hourglass-half"></i> Menunggu</div>
                @elseif($status == 'accepted')
                    <div class="alert alert-success mb-0 p-2" style="font-size: 12px;"><i
                            class="fas fa-check-circle"></i> Diterima</div>
                    @if (!$isSender && $agreement)
                        <a href="{{ route('payments.create', ['agreement' => $agreement->id]) }}"
                            class="btn btn-success btn-sm w-100 mt-2">Bayar</a>
                    @endif
                @else
                    <div class="alert alert-danger mb-0 p-2" style="font-size: 12px;"><i
                            class="fas fa-times-circle"></i> Ditolak</div>
                @endif
            @endif
        </div>

        <div class="card-footer bg-transparent border-top-0 text-end py-1">
            <small class="text-muted" style="font-size: 10px;">
                {{ $created_at_human ?? '' }}
            </small>
        </div>
    </div>
</div>
