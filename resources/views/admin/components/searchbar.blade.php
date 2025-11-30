@php
    $placeholder = match($tab ?? 'projects') {
        'projects'   => 'Cari nama proyek, klien, atau developer…',
        'payments'   => 'Cari pembayaran, proyek, atau klien…',
        'complaints' => 'Cari keluhan pengguna, proyek, atau kategori…',
        default      => 'Cari…',
    };
@endphp

<div class="bg-white border rounded-2xl shadow-sm p-4 mt-4">
<form method="GET" action="{{ url()->current() }}" class="flex items-center gap-4">
    <input type="hidden" name="tab" value="{{ $tab }}" />

    {{-- Search Input --}}
    <div class="flex items-center gap-3 flex-1 bg-gray-50 border border-gray-200 rounded-xl px-4 py-2 focus-within:ring-2 focus-within:ring-green-500">
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

    {{-- Status Dropdown --}}
    <div class="relative" x-data="{open:false}">
        <button type="button"
                @click="open=!open"
                class="flex items-center gap-2 text-sm px-4 py-2 border border-gray-200 rounded-xl bg-white hover:bg-gray-50 transition">
            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path d="M3 5h18M6 12h12M10 19h4"/>
            </svg>
            <span class="text-gray-700">Status</span>
        </button>

        <div x-show="open"
             @click.outside="open=false"
             x-transition
             class="absolute right-0 mt-2 w-48 bg-white shadow-xl border border-gray-200 rounded-xl p-2 text-sm z-40">

            @foreach([
                '' => 'Semua',
                'pending' => 'Pending',
                'in_progress' => 'In Progress',
                'approved' => 'Approved',
                'resolved' => 'Resolved',
                'rejected' => 'Rejected'
            ] as $val => $label)
                <label class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-50 cursor-pointer">
                    <input type="radio" name="status" value="{{ $val }}"
                           class="text-green-600"
                           {{ request('status')===$val ? 'checked' : '' }}>
                    <span>{{ $label }}</span>
                </label>
            @endforeach
        </div>
    </div>

    {{-- Search Button --}}
    <button class="px-6 py-2 bg-green-600 text-white text-sm rounded-xl hover:bg-green-500 transition">
        Cari
    </button>

</form>
</div>
