<div class="grid grid-cols-2 md:grid-cols-4 gap-6">

    {{-- OPEN --}}
    <div class="p-6 bg-white rounded-2xl border shadow-sm flex items-center gap-4 min-h-[120px]">
        <div class="w-14 h-14 rounded-xl bg-orange-100 flex items-center justify-center">
            <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path d="M12 6v6l4 2"/>
            </svg>
        </div>
        <div>
            <div class="text-sm text-gray-500">Open</div>
            <div class="text-3xl font-bold mt-1">{{ $stats['pending'] ?? 0 }}</div>
        </div>
    </div>

    {{-- IN PROGRESS --}}
    <div class="p-6 bg-white rounded-2xl border shadow-sm flex items-center gap-4 min-h-[120px]">
        <div class="w-14 h-14 rounded-xl bg-blue-100 flex items-center justify-center">
            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path d="M4 12h16M4 6h16M4 18h10"/>
            </svg>
        </div>
        <div>
            <div class="text-sm text-gray-500">In Progress</div>
            <div class="text-3xl font-bold mt-1">{{ $stats['progress'] ?? 0 }}</div>
        </div>
    </div>

    {{-- RESOLVED --}}
    <div class="p-6 bg-white rounded-2xl border shadow-sm flex items-center gap-4 min-h-[120px]">
        <div class="w-14 h-14 rounded-xl bg-green-100 flex items-center justify-center">
            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <div>
            <div class="text-sm text-gray-500">Resolved</div>
            <div class="text-3xl font-bold mt-1">{{ $stats['approved'] ?? 0 }}</div>
        </div>
    </div>

    {{-- TOTAL ITEMS --}}
    <div class="p-6 bg-white rounded-2xl border shadow-sm flex items-center gap-4 min-h-[120px]">
        <div class="w-14 h-14 rounded-xl bg-gray-100 flex items-center justify-center">
            <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path d="M3 3h18v4H3zM3 11h18v10H3z"/>
            </svg>
        </div>
        <div>
            <div class="text-sm text-gray-500">Total Items</div>
            <div class="text-3xl font-bold mt-1">{{ $stats['total'] ?? 0 }}</div>
        </div>
    </div>

</div>
