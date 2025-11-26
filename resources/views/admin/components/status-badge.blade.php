
@props(['status'])
@php
    $map = [
        'pending' => 'bg-yellow-100 text-yellow-800',
        'in_progress' => 'bg-blue-100 text-blue-800',
        'approved' => 'bg-green-100 text-green-800',
        'completed' => 'bg-green-100 text-green-800',
        'confirmed' => 'bg-green-100 text-green-800',
        'unpaid' => 'bg-red-100 text-red-800',
        'resolved' => 'bg-green-100 text-green-800',
        'review' => 'bg-blue-100 text-blue-800',
        'rejected' => 'bg-red-100 text-red-800',
    ];
    $cls = $map[$status] ?? 'bg-gray-100 text-gray-800';
    $label = ucfirst(str_replace('_',' ', $status));
@endphp
<span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $cls }}">{{ $label }}</span>
