@php
    $placeholder = match($tab ?? 'projects') {
        'projects'   => 'Search project name, client, or developer…',
        'payments'   => 'Search payment, project, or client…',
        'complaints' => 'Search user complaints, project, or category…',
        default      => 'Search…',
    };
@endphp

<form method="GET" action="{{ url()->current() }}" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
    <input type="hidden" name="tab" value="{{ $tab }}" />

    {{-- Search Input --}}
    <div class="flex items-center gap-3 flex-1 bg-white border-2 border-gray-200 rounded-xl px-4 py-3 
                focus-within:border-primary-500 focus-within:ring-4 focus-within:ring-primary-100 transition-all">
        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
             viewBox="0 0 24 24">
            <circle cx="11" cy="11" r="7"/>
            <path d="M21 21l-4.3-4.3"/>
        </svg>

        <input name="search"
               value="{{ request('search', '') }}"
               placeholder="{{ $placeholder }}"
               class="w-full bg-transparent focus:outline-none text-sm text-gray-700 placeholder-gray-400" />
    </div>

    @if($tab !== 'complaints')
    {{-- Status Dropdown --}}
    <div class="relative" x-data="{open:false}">
        <button type="button"
                @click="open=!open"
                class="flex items-center justify-center gap-2 text-sm px-5 py-3 border-2 border-gray-200 rounded-xl 
                       bg-white hover:border-primary-300 hover:bg-primary-50 transition-all w-full sm:w-auto">
            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path d="M3 5h18M6 12h12M10 19h4"/>
            </svg>
            <span class="text-gray-700 font-medium">Status</span>
            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        <div x-show="open"
             @click.outside="open=false"
             x-transition
             class="absolute right-0 mt-2 w-56 bg-white shadow-2xl border border-gray-200 rounded-2xl p-2 text-sm z-40">

            @php
                $statusOptions = match($tab) {
                    'payments' => [
                        '' => 'All',
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'transferred' => 'Transferred',
                        'failed' => 'Failed',
                        'refunded' => 'Refunded'
                    ],
                    default => [
                        '' => 'All',
                        'pending' => 'Pending',
                        'in_progress' => 'In Progress',
                        'approved' => 'Approved',
                        'resolved' => 'Resolved',
                        'rejected' => 'Rejected'
                    ],
                };
            @endphp

            @foreach($statusOptions as $val => $label)
                <label class="flex items-center gap-2 px-3 py-2 rounded-xl hover:bg-primary-50 cursor-pointer transition">
                    <input type="radio" name="status" value="{{ $val }}"
                           class="text-primary-600 focus:ring-primary-500"
                           {{ request('status')===$val ? 'checked' : '' }}>
                    <span>{{ $label }}</span>
                </label>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Search Button --}}
    <button class="px-6 py-3 bg-gradient-to-r from-primary-500 to-secondary-500 text-white text-sm font-medium 
                   rounded-xl hover:shadow-lg hover:scale-105 transition-all duration-200 w-full sm:w-auto">
        <span class="flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="7"/>
                <path d="M21 21l-4.3-4.3"/>
            </svg>
            Search
        </span>
    </button>

</form>
