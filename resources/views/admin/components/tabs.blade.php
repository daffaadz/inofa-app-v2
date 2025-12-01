{{-- resources/views/admin/components/tabs.blade.php --}}
<div class="flex gap-2 md:gap-8 overflow-x-auto pb-2 scrollbar-hide">
    <button @click="tab='payments'" 
            class="relative pb-4 px-4 text-sm md:text-base font-medium whitespace-nowrap transition-all duration-200
                   hover:text-primary-600"
            :class="tab==='payments' ? 'text-primary-600' : 'text-gray-600'">
        <div class="flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
            </svg>
            <span>Payment Validation</span>
        </div>
        <span x-show="tab==='payments'" 
              x-transition:enter="transition-all duration-300"
              x-transition:enter-start="w-0 opacity-0"
              x-transition:enter-end="w-full opacity-100"
              class="absolute left-0 bottom-0 h-1 bg-gradient-to-r from-primary-500 to-secondary-500 rounded-full">
        </span>
    </button>
    
    <button @click="tab='complaints'" 
            class="relative pb-4 px-4 text-sm md:text-base font-medium whitespace-nowrap transition-all duration-200
                   hover:text-primary-600"
            :class="tab==='complaints' ? 'text-primary-600' : 'text-gray-600'">
        <div class="flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>User Complaints</span>
        </div>
        <span x-show="tab==='complaints'" 
              x-transition:enter="transition-all duration-300"
              x-transition:enter-start="w-0 opacity-0"
              x-transition:enter-end="w-full opacity-100"
              class="absolute left-0 bottom-0 h-1 bg-gradient-to-r from-primary-500 to-secondary-500 rounded-full">
        </span>
    </button>
</div>
