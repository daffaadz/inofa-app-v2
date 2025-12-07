<div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 mt-4">

    {{-- Header --}}
    <div class="flex items-center gap-2 mb-6">
        <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
        </svg>
        <h3 class="text-lg font-semibold text-gray-800">Advanced Filters</h3>
    </div>

    <form method="GET" action="{{ url()->current() }}"
          class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">

        <input type="hidden" name="tab" value="{{ $tab }}" />

        {{-- STATUS --}}
        <div class="flex flex-col">
            <label class="text-xs font-semibold text-gray-600 mb-2 uppercase tracking-wide">Status</label>
            <select name="status"
                class="px-4 py-2.5 bg-white border-2 border-gray-200 rounded-xl text-sm
                       focus:ring-4 focus:ring-primary-100 focus:border-primary-500 focus:outline-none
                       transition-all cursor-pointer hover:border-gray-300">
                @if($tab === 'payments')
                    <option value="">All Status</option>
                    <option value="pending" @selected(request('status')==='pending')>Pending</option>
                    <option value="confirmed" @selected(request('status')==='confirmed')>Confirmed</option>
                    <option value="transferred" @selected(request('status')==='transferred')>Transferred</option>
                    <option value="failed" @selected(request('status')==='failed')>Failed</option>
                    <option value="refunded" @selected(request('status')==='refunded')>Refunded</option>
                @elseif($tab === 'complaints')
                    <option value="">All Status</option>
                    <option value="in_progress" @selected(request('status')==='in_progress')>In Progress</option>
                    <option value="resolved" @selected(request('status')==='resolved')>Resolved</option>
                    <option value="rejected" @selected(request('status')==='rejected')>Rejected</option>
                @else
                    <option value="">All Status</option>
                    <option value="pending" @selected(request('status')==='pending')>Pending</option>
                    <option value="accepted" @selected(request('status')==='accepted')>Accepted</option>
                    <option value="active" @selected(request('status')==='active')>Active</option>
                    <option value="completed" @selected(request('status')==='completed')>Completed</option>
                    <option value="cancelled" @selected(request('status')==='cancelled')>Cancelled</option>
                    <option value="rejected" @selected(request('status')==='rejected')>Rejected</option>
                @endif
            </select>
        </div>

        {{-- DATE --}}
        <div class="flex flex-col">
            <label class="text-xs font-semibold text-gray-600 mb-2 uppercase tracking-wide">Date From</label>
            <input type="date" name="date_from" value="{{ request('date_from') }}"
                   class="px-4 py-2.5 bg-white border-2 border-gray-200 rounded-xl text-sm
                          focus:ring-4 focus:ring-primary-100 focus:border-primary-500 focus:outline-none
                          transition-all hover:border-gray-300">
        </div>

        <div class="flex flex-col">
            <label class="text-xs font-semibold text-gray-600 mb-2 uppercase tracking-wide">Date To</label>
            <input type="date" name="date_to" value="{{ request('date_to') }}"
                   class="px-4 py-2.5 bg-white border-2 border-gray-200 rounded-xl text-sm
                          focus:ring-4 focus:ring-primary-100 focus:border-primary-500 focus:outline-none
                          transition-all hover:border-gray-300">
        </div>

        {{-- PAYMENT TYPE --}}
        @if($tab === 'payments')
            <div class="flex flex-col">
                <label class="text-xs font-semibold text-gray-600 mb-2 uppercase tracking-wide">Payment Type</label>
                <select name="payment_type"
                        class="px-4 py-2.5 bg-white border-2 border-gray-200 rounded-xl text-sm
                               focus:ring-4 focus:ring-primary-100 focus:border-primary-500 focus:outline-none
                               transition-all cursor-pointer hover:border-gray-300">
                    <option value="">All</option>
                    <option value="deposit" @selected(request('payment_type')==='deposit')>Deposit</option>
                    <option value="milestone" @selected(request('payment_type')==='milestone')>Milestone</option>
                    <option value="final" @selected(request('payment_type')==='final')>Final</option>
                    <option value="refund" @selected(request('payment_type')==='refund')>Refund</option>
                </select>
            </div>
        @endif

        {{-- BUDGET/AMOUNT FOR PROJECTS --}}
        @if($tab === 'projects')
            <div class="flex flex-col">
                <label class="text-xs font-semibold text-gray-600 mb-2 uppercase tracking-wide">Min Budget</label>
                <input type="number" name="amount_min" value="{{ request('amount_min') }}"
                       placeholder="Rp 0"
                       class="px-4 py-2.5 bg-white border-2 border-gray-200 rounded-xl text-sm
                              focus:ring-4 focus:ring-primary-100 focus:border-primary-500 focus:outline-none
                              transition-all hover:border-gray-300">
            </div>

            <div class="flex flex-col">
                <label class="text-xs font-semibold text-gray-600 mb-2 uppercase tracking-wide">Max Budget</label>
                <input type="number" name="amount_max" value="{{ request('amount_max') }}"
                       placeholder="Rp 0"
                       class="px-4 py-2.5 bg-white border-2 border-gray-200 rounded-xl text-sm
                              focus:ring-4 focus:ring-primary-100 focus:border-primary-500 focus:outline-none
                              transition-all hover:border-gray-300">
            </div>
        @endif

        {{-- RAISER ROLE FILTER FOR COMPLAINTS --}}
        @if($tab === 'complaints')
            <div class="flex flex-col">
                <label class="text-xs font-semibold text-gray-600 mb-2 uppercase tracking-wide">Raised By Role</label>
                <select name="raiser_role"
                        class="px-4 py-2.5 bg-white border-2 border-gray-200 rounded-xl text-sm
                               focus:ring-4 focus:ring-primary-100 focus:border-primary-500 focus:outline-none
                               transition-all cursor-pointer hover:border-gray-300">
                    <option value="">All</option>
                    <option value="consumer" @selected(request('raiser_role')==='consumer')>Consumer</option>
                    <option value="developer" @selected(request('raiser_role')==='developer')>Developer</option>
                </select>
            </div>
        @endif

        {{-- SORT --}}
        <div class="flex flex-col">
            <label class="text-xs font-semibold text-gray-600 mb-2 uppercase tracking-wide">Sort</label>
            <select name="sort"
                class="px-4 py-2.5 bg-white border-2 border-gray-200 rounded-xl text-sm
                       focus:ring-4 focus:ring-primary-100 focus:border-primary-500 focus:outline-none
                       transition-all cursor-pointer hover:border-gray-300">
                @if($tab === 'payments')
                    <option value="newest" @selected(request('sort','newest')==='newest')>Newest Payment</option>
                    <option value="oldest" @selected(request('sort')==='oldest')>Oldest Payment</option>
                    <option value="highest_amount" @selected(request('sort')==='highest_amount')>Highest Amount</option>
                    <option value="lowest_amount" @selected(request('sort')==='lowest_amount')>Lowest Amount</option>
                @elseif($tab === 'complaints')
                    <option value="newest" @selected(request('sort','newest')==='newest')>Newest Complaint</option>
                    <option value="oldest" @selected(request('sort')==='oldest')>Oldest Complaint</option>
                @elseif($tab === 'projects')
                    <option value="newest" @selected(request('sort','newest')==='newest')>Newest Project</option>
                    <option value="oldest" @selected(request('sort')==='oldest')>Oldest Project</option>
                    <option value="highest" @selected(request('sort')==='highest')>Highest Budget</option>
                    <option value="lowest" @selected(request('sort')==='lowest')>Lowest Budget</option>
                @else
                    <option value="newest" @selected(request('sort','newest')==='newest')>Newest</option>
                    <option value="oldest" @selected(request('sort')==='oldest')>Oldest</option>
                @endif
            </select>
        </div>

        {{-- ACTION --}}
        <div class="sm:col-span-2 lg:col-span-3 xl:col-span-6 flex flex-col sm:flex-row justify-end items-stretch sm:items-center gap-3 mt-4 pt-4 border-t border-gray-100">

            <a href="{{ url()->current() }}?tab={{ $tab }}"
               class="flex items-center justify-center gap-2 text-gray-700 px-6 py-2.5 border-2 border-gray-300 rounded-xl text-sm font-medium
                      hover:bg-gray-50 hover:border-gray-400 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
               Reset
            </a>

            <button type="submit"
                class="flex items-center justify-center gap-2 px-6 py-2.5 bg-gradient-to-r from-primary-500 to-secondary-500 text-white rounded-xl text-sm font-medium
                       hover:shadow-lg hover:scale-105 transition-all duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Apply Filters
            </button>
        </div>
    </form>
</div>
