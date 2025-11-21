@props(['items' => []])

<ul class="space-y-2">
    @foreach ($items as $item)
        <li class="flex items-start gap-3 text-neutral-700">
            <svg class="w-5 h-5 text-green-500 mt-0.5" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
            <span>{{ $item }}</span>
        </li>
    @endforeach
</ul>
