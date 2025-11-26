@php $tab = $tab ?? request('tab','projects'); @endphp

<div class="bg-white border rounded-2xl shadow-sm p-6 mt-4">
    
    {{-- Header --}}
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-700">Filters</h3>
    </div>

    <form method="GET" action="{{ url()->current() }}" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4">
        <input type="hidden" name="tab" value="{{ $tab }}">

        {{-- Status --}}
        <div class="flex flex-col">
            <label class="text-xs font-medium text-gray-600 mb-1">Status</label>
            <select name="status"
                class="rounded-lg border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                <option value="">Semua</option>
                <option value="pending" @selected(request('status')==='pending')>Pending</option>
                <option value="in_progress" @selected(request('status')==='in_progress')>In Progress</option>
                <option value="approved" @selected(request('status')==='approved')>Approved</option>
                <option value="confirmed" @selected(request('status')==='confirmed')>Confirmed</option>
                <option value="resolved" @selected(request('status')==='resolved')>Resolved</option>
                <option value="rejected" @selected(request('status')==='rejected')>Rejected</option>
            </select>
        </div>

        {{-- Date --}}
        <div class="flex flex-col">
            <label class="text-xs font-medium text-gray-600 mb-1">Tanggal Dari</label>
            <input type="date" name="date_from" value="{{ request('date_from') }}"
                class="rounded-lg border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
        </div>

        <div class="flex flex-col">
            <label class="text-xs font-medium text-gray-600 mb-1">Tanggal Hingga</label>
            <input type="date" name="date_to" value="{{ request('date_to') }}"
                class="rounded-lg border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
        </div>

        {{-- Amount --}}
        @if(in_array($tab,['projects','payments']))
            <div class="flex flex-col">
                <label class="text-xs font-medium text-gray-600 mb-1">Harga Min</label>
                <input type="number" name="amount_min" value="{{ request('amount_min') }}"
                    class="rounded-lg border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
            </div>

            <div class="flex flex-col">
                <label class="text-xs font-medium text-gray-600 mb-1">Harga Max</label>
                <input type="number" name="amount_max" value="{{ request('amount_max') }}"
                    class="rounded-lg border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
            </div>
        @endif

        {{-- Priority Complaints --}}
        @if($tab==='complaints')
            <div class="flex flex-col">
                <label class="text-xs font-medium text-gray-600 mb-1">Priority</label>
                <select name="priority"
                    class="rounded-lg border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                    <option value="">Semua</option>
                    <option value="low" @selected(request('priority')==='low')>Low</option>
                    <option value="normal" @selected(request('priority')==='normal')>Normal</option>
                    <option value="high" @selected(request('priority')==='high')>High</option>
                    <option value="critical" @selected(request('priority')==='critical')>Critical</option>
                </select>
            </div>
        @endif

        {{-- Sort --}}
        <div class="flex flex-col">
            <label class="text-xs font-medium text-gray-600 mb-1">Sort</label>
            <select name="sort"
                class="rounded-lg border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                <option value="newest" @selected(request('sort','newest')==='newest')>Newest</option>
                <option value="oldest" @selected(request('sort')==='oldest')>Oldest</option>

                @if(in_array($tab,['projects','payments']))
                <option value="highest" @selected(request('sort')==='highest')>Highest Amount</option>
                <option value="lowest" @selected(request('sort')==='lowest')>Lowest Amount</option>
                @endif
            </select>
        </div>

        {{-- Actions --}}
        <div class="md:col-span-3 lg:col-span-6 flex justify-end items-center gap-3 mt-2">
            <a href="{{ url()->current() }}?tab={{ $tab }}"
                class="px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-100 text-sm">
                Reset
            </a>

            <button
                class="px-4 py-2 bg-gray-800 text-white rounded-lg text-sm hover:bg-gray-700">
                Terapkan
            </button>

            <a href="{{ route('admin.export', ['tab' => $tab]) }}?{{ http_build_query(request()->query()) }}"
                class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm hover:bg-green-500">
                Export
            </a>
        </div>
    </form>
</div>
