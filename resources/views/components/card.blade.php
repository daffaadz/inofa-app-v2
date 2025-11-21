@props(['class' => ''])

<div {{ $attributes->merge([
    'class' => "
        bg-neutral-0
        rounded-2xl
        border
        border-neutral-200
        shadow-sm
        p-6
        transition
        hover:shadow-lg
        hover:border-neutral-300
        $class
    "
]) }}>
    {{ $slot }}
</div>
