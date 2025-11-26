<x-admin-layout title="Admin Dashboard">

<div class="p-8" x-data="{ tab: '{{ request('tab','projects') }}' }">

    
        {{-- Page Title --}}
        <div class="bg-white shadoe rounded-xl p-6 mb-6">
            <h1 class="text-5xl font-bold">Admin Dashboard</h1>
            <p class="text-gray-500 mt-1 text-xl">
                Manage project validation, payments and user complaints
            </p>
        </div>
        
    <div class="bg-white shadoe rounded-xl p-6">
        {{-- Tabs --}}
        <div class="mt-6">
            @include('admin.components.tabs')
        </div>

        {{-- Search Bar --}}
        <div class="mt-4">
            @include('admin.components.searchbar', ['tab' => request('tab','projects')])
        </div>

        {{-- Filters --}}
        <div class="mt-4">
            @include('admin.components.filters')
        </div>

        {{-- TABLES --}}
        <div class="mt-6">

            {{-- VALIDASI PROYEK --}}
            <div x-show="tab === 'projects'">
                @include('admin.components.table-projects', ['items' => $projects])
            </div>

            {{-- VALIDASI PEMBAYARAN --}}
            <div x-show="tab === 'payments'">
                @include('admin.components.table-payments', ['items' => $payments])
            </div>

            {{-- KELUHAN PENGGUNA --}}
            <div x-show="tab === 'complaints'">
                @include('admin.components.table-complaints', ['items' => $complaints])
            </div>

        </div>
        

        {{-- Summary Cards --}}
        <div class="mt-8">
            @include('admin.components.summary-cards', ['stats' => $stats])
        </div>

        {{-- Reject Modal --}}
        @include('admin.modals.reject-note')

@include('admin.modals.reject-note')

</div>
</x-admin-layout>
