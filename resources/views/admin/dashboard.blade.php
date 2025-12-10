<x-admin-layout title="Admin Dashboard">

<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100" x-data="{ tab: '{{ request('tab','payments') }}' }">

    <div class="p-4 md:p-8 max-w-[1600px] mx-auto pt-20 lg:pt-4">
        
        {{-- Page Header --}}
        <div class="bg-white shadow-sm rounded-2xl p-4 sm:p-6 md:p-8 mb-4 md:mb-6 border border-gray-100">
            <div class="flex items-start justify-between gap-4">
                <div class="flex-1 min-w-0">
                    <h1 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl xl:text-5xl font-bold text-gray-900 mb-1 md:mb-2">
                        Admin Dashboard
                    </h1>
                    <p class="text-gray-600 text-sm sm:text-base md:text-lg lg:text-xl">
                        Manage project validation, payments and user complaints
                    </p>
                </div>
                
                {{-- Quick Stats Badge --}}
                <div class="hidden sm:flex items-center gap-2 px-3 md:px-4 py-2 bg-gradient-to-r from-primary-500 to-secondary-500 text-white rounded-xl flex-shrink-0">
                    <svg class="w-4 md:w-5 h-4 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    <span class="font-semibold text-xs md:text-sm">Active</span>
                </div>
            </div>
        </div>

        {{-- Summary Cards - Moved to Top --}}
        <div class="mb-4 md:mb-6">
            @include('admin.components.summary-cards', ['stats' => $stats])
        </div>
        
        {{-- Main Content Card --}}
        <div class="bg-white shadow-sm rounded-2xl border border-gray-100 overflow-hidden">
            
            {{-- Tabs --}}
            <div class="px-4 sm:px-6 pt-4 sm:pt-6 border-b border-gray-100">
                @include('admin.components.tabs')
            </div>

            {{-- TABLES --}}
            <div class="p-4 sm:p-6">

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
