<x-admin-layout title="Admin Dashboard">

<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100" x-data="{ tab: '{{ request('tab','payments') }}' }">

    <div class="p-4 md:p-8 max-w-[1600px] mx-auto">
        
        {{-- Page Header --}}
        <div class="bg-white shadow-sm rounded-2xl p-6 md:p-8 mb-6 border border-gray-100">
            <div class="flex items-start justify-between">
                <div>
                    <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-2">
                        Admin Dashboard
                    </h1>
                    <p class="text-gray-600 text-base md:text-lg lg:text-xl">
                        Manage project validation, payments and user complaints
                    </p>
                </div>
                
                {{-- Quick Stats Badge --}}
                <div class="hidden md:flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-primary-500 to-secondary-500 text-white rounded-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    <span class="font-semibold text-sm">Active</span>
                </div>
            </div>
        </div>

        {{-- Summary Cards - Moved to To p --}}
        <div class="mb-6">
            @include('admin.components.summary-cards', ['stats' => $stats])
        </div>
        
        {{-- Main Content Card --}}
        <div class="bg-white shadow-sm rounded-2xl border border-gray-100 overflow-hidden">
            
            {{-- Tabs --}}
            <div class="px-6 pt-6 border-b border-gray-100">
                @include('admin.components.tabs')
            </div>

            {{-- TABLES --}}
            <div class="p-6">

                {{-- VALIDASI PEMBAYARAN --}}
                <div x-show="tab === 'payments'" x-transition>
                    @include('admin.components.filters-payments')
                    @include('admin.components.table-payments', ['items' => $payments])
                </div>

                {{-- KELUHAN PENGGUNA --}}
                <div x-show="tab === 'complaints'" x-transition>
                    @include('admin.components.filters-complaints')
                    @include('admin.components.table-complaints', ['items' => $complaints])
                </div>

            </div>

        </div>

    </div>

</div>

{{-- Reject Modal --}}
@include('admin.modals.reject-note')

</x-admin-layout>
