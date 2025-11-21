@props([
    'type' => 'info', // info, success, warning, danger
])

@php
$styles = [
    'info' => 'bg-primary-50 border-primary-200 text-primary-700',
    'success' => 'bg-green-50 border-green-200 text-green-700',
    'warning' => 'bg-amber-50 border-amber-200 text-amber-700',
    'danger' => 'bg-red-50 border-red-200 text-red-700',
];
@endphp

<div {{ $attributes->merge([
    'class' => "rounded-xl p-4 border " . ($styles[$type] ?? $styles['info'])
]) }}>
    {{ $slot }}
</div>
