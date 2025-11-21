@props([
    'href',
    'active' => false,
    'icon' => null,
    'badge' => null,
    'description' => '',
])

@php
    $base = 'w-full flex items-center gap-3 px-4 py-3 rounded-2xl transition mb-1';

    $wrapper = $active ?? false ? 'bg-primary-500 text-white' : 'bg-neutral-0 text-neutral-700 hover:bg-neutral-50';

    $iconWrap =
        $active ?? false
            ? 'bg-gradient-to-br from-white/20 to-white/10'
            : 'bg-gradient-to-br from-primary-500/10 to-secondary-500/20';

    // Tambahkan -copy jika TIDAK active
    $iconFile = $active ?? false ? $icon . '-copy' : $icon;

    $iconColor = $active ?? false ? 'text-white' : 'text-primary-500';
    $titleColor = $active ?? false ? 'text-white' : 'text-neutral-1000';
    $descColor = $active ?? false ? 'text-neutral-200' : 'text-neutral-500';
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => $base . ' ' . $wrapper]) }}>
    <div class="{{ $iconWrap }} p-3 rounded-xl transition">
        <img src="{{ asset('assets/vector/sidebar/' . $iconFile . '.svg') }}" alt="{{ $slot }}"
            class="w-6 h-auto {{ $iconColor }}">
    </div>

    <div class="flex flex-col justify-end items-start flex-1">
        <span class="text-b-2 font-medium transition {{ $titleColor }}">{{ $slot }}</span>
        <span class="text-b-4 transition {{ $descColor }}">{{ $description }}</span>
    </div>

    @if ($badge)
        <span
            class="ml-auto px-2 py-0.5 text-b-4 font-semibold rounded-full
                     {{ $active ? 'bg-white/20 text-white' : 'bg-white text-primary-500' }}">
            {{ $badge }}
        </span>
    @endif
</a>
