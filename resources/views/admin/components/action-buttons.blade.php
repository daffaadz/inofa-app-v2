
@props(['approveUrl' => '#', 'rejectUrl' => '#', 'viewUrl' => '#'])
<div class="flex items-center justify-center gap-2">
    <a href="{{ $viewUrl }}" 
       class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg border-2 border-gray-300 text-gray-700 text-xs font-medium
              hover:bg-gray-50 hover:border-gray-400 transition-all duration-200"
       title="View Details">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
        </svg>
        View
    </a>
    
    <form method="POST" action="{{ $approveUrl }}" class="inline">
        @csrf
        <button type="submit"
                class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-gradient-to-r from-green-500 to-green-600 
                       text-white text-xs font-medium hover:from-green-600 hover:to-green-700 
                       hover:shadow-lg transition-all duration-200"
                title="Approve">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            Approve
        </button>
    </form>
    
    <button @click="window.dispatchEvent(new CustomEvent('open-reject', { detail: { url: '{{ $rejectUrl }}' } }))" 
            class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-gradient-to-r from-red-500 to-red-600 
                   text-white text-xs font-medium hover:from-red-600 hover:to-red-700 
                   hover:shadow-lg transition-all duration-200"
            title="Reject">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
        Reject
    </button>
</div>
