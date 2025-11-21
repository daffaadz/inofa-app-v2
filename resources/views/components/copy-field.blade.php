@props(['value'])

<div class="flex items-center justify-between p-3 bg-neutral-0 border border-neutral-300 rounded-lg">
    <span class="font-mono tracking-wide text-b-2 text-neutral-800">{{ $value }}</span>

    <button
        onclick="navigator.clipboard.writeText('{{ $value }}')"
        class="p-2 rounded-lg hover:bg-neutral-100 transition"
        title="Copy"
    >
        <svg class="w-5 h-5 text-neutral-700" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M8 7H6a2 2 0 00-2 2v9a2 2 0 002 2h9a2 2 0 002-2v-2M9 5h9a2 2 0 012 2v9a2 2 0 01-2 2h-2" />
        </svg>
    </button>
</div>
