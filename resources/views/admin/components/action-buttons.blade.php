
@props(['approveUrl' => '#', 'rejectUrl' => '#', 'viewUrl' => '#'])
<div class="flex items-center gap-2">
    <a href="{{ $viewUrl }}" class="px-2 py-1.5 rounded-lg border text-xs hover:bg-gray-50">View</a>
    <form method="POST" action="{{ $approveUrl }}" class="inline">
        @csrf
        <button class="px-2 py-1.5 rounded-lg bg-green-600 text-white text-xs hover:bg-green-700">Approve</button>
    </form>
    <button @click="window.dispatchEvent(new CustomEvent('open-reject', { detail: { url: '{{ $rejectUrl }}' } }))" class="px-2 py-1.5 rounded-lg bg-red-600 text-white text-xs hover:bg-red-700">Reject</button>
</div>
