<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 md:gap-6">

    {{-- PENDING PAYMENTS --}}
    <div
        class="group relative overflow-hidden bg-gradient-to-br from-orange-50 to-orange-100/50 rounded-2xl border border-orange-200 
                shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
        <div class="p-5 sm:p-6 md:p-8">
            <div class="flex items-center justify-between mb-4">
                <div
                    class="w-14 h-14 md:w-16 md:h-16 rounded-2xl bg-gradient-to-br from-orange-400 to-orange-500 
                            flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor" stroke-width="2.5"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2" />
                        <circle cx="12" cy="12" r="9" />
                    </svg>
                </div>
                <div class="text-orange-500 opacity-50">
                    <svg class="w-8 h-8 md:w-10 md:h-10" fill="currentColor" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="3" />
                        <circle cx="12" cy="4" r="2" />
                        <circle cx="12" cy="20" r="2" />
                    </svg>
                </div>
            </div>
            <div class="text-sm md:text-base font-medium text-orange-700 mb-1">Pending Payments</div>
            <div class="text-3xl md:text-4xl font-bold text-orange-900">{{ $stats['pending_payments'] ?? 0 }}</div>
            <div class="mt-2 text-xs text-orange-600">Awaiting confirmation</div>
        </div>
        <div class="absolute bottom-0 right-0 w-20 h-20 bg-orange-300/20 rounded-tl-full"></div>
    </div>

    {{-- CONFIRMED PAYMENTS --}}
    <div
        class="group relative overflow-hidden bg-gradient-to-br from-green-50 to-green-100/50 rounded-2xl border border-green-200 
                shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
        <div class="p-5 sm:p-6 md:p-8">
            <div class="flex items-center justify-between mb-4">
                <div
                    class="w-14 h-14 md:w-16 md:h-16 rounded-2xl bg-gradient-to-br from-green-400 to-green-600 
                            flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor"
                        stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div class="text-green-500 opacity-50">
                    <svg class="w-8 h-8 md:w-10 md:h-10" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="text-sm md:text-base font-medium text-green-700 mb-1">Confirmed Payments</div>
            <div class="text-3xl md:text-4xl font-bold text-green-900">{{ $stats['confirmed_payments'] ?? 0 }}</div>
            <div class="mt-2 text-xs text-green-600">Successfully processed</div>
        </div>
        <div class="absolute bottom-0 right-0 w-20 h-20 bg-green-300/20 rounded-tl-full"></div>
    </div>

    {{-- COMPLAINTS --}}
    <div
        class="group relative overflow-hidden bg-gradient-to-br from-red-50 to-red-100/50 rounded-2xl border border-red-200 
                shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
        <div class="p-5 sm:p-6 md:p-8">
            <div class="flex items-center justify-between mb-4">
                <div
                    class="w-14 h-14 md:w-16 md:h-16 rounded-2xl bg-gradient-to-br from-red-400 to-red-600 
                            flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor"
                        stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div class="text-red-500 opacity-50">
                    <svg class="w-8 h-8 md:w-10 md:h-10" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z" />
                    </svg>
                </div>
            </div>
            <div class="text-sm md:text-base font-medium text-red-700 mb-1">Complaints</div>
            <div class="text-3xl md:text-4xl font-bold text-red-900">{{ $stats['complaints'] ?? 0 }}</div>
            <div class="mt-2 text-xs text-red-600">Reported issues</div>
        </div>
        <div class="absolute bottom-0 right-0 w-20 h-20 bg-red-300/20 rounded-tl-full"></div>
    </div>

    {{-- TOTAL USERS --}}
    <a href="{{ route('admin.users.index') }}"
        class="group relative overflow-hidden bg-gradient-to-br from-purple-50 to-purple-100/50 rounded-2xl border border-purple-200 
                shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1 cursor-pointer">
        <div class="p-5 sm:p-6 md:p-8">
            <div class="flex items-center justify-between mb-4">
                <div
                    class="w-14 h-14 md:w-16 md:h-16 rounded-2xl bg-gradient-to-br from-purple-400 to-purple-600 
                            flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor"
                        stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div class="text-purple-500 opacity-50">
                    <svg class="w-8 h-8 md:w-10 md:h-10" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                    </svg>
                </div>
            </div>
            <div class="text-sm md:text-base font-medium text-purple-700 mb-1">Total Users</div>
            <div class="text-3xl md:text-4xl font-bold text-purple-900">{{ $stats['total_users'] ?? 0 }}</div>
            <div class="mt-2 text-xs text-purple-600">Registered users</div>
        </div>
        <div class="absolute bottom-0 right-0 w-20 h-20 bg-purple-300/20 rounded-tl-full"></div>
    </a>

</div>
