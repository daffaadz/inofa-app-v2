{{-- Search Bar for Complaints --}}
<div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-3 sm:p-4 mb-3 sm:mb-4">
    <form method="GET" action="{{ route('admin.dashboard') }}" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-4">
        <input type="hidden" name="tab" value="complaints" />
        <div class="flex-1">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Search by user name, email, or description..."
                class="w-full px-3 sm:px-4 py-2.5 bg-gray-50 border-2 border-gray-200 rounded-xl text-sm
                       focus:ring-4 focus:ring-primary-100 focus:border-primary-500 focus:outline-none
                       transition-all hover:border-gray-300">
        </div>
        <button type="submit"
            class="flex items-center justify-center gap-2 px-4 sm:px-6 py-2.5 bg-gradient-to-r from-primary-500 to-secondary-500 text-white rounded-xl text-sm font-medium
                   hover:shadow-lg hover:scale-105 transition-all duration-200 w-full sm:w-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            Search
        </button>
    </form>
</div>

{{-- Advanced Filters for Complaints --}}
<div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-4 sm:p-6 mb-4 sm:mb-6">
    {{-- Header --}}
    <div class="flex items-center gap-2 mb-6">
        <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
        </svg>
        <h3 class="text-lg font-semibold text-gray-800">Advanced Filters</h3>
    </div>

    <form method="GET" action="{{ route('admin.dashboard') }}"
          class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">

        <input type="hidden" name="tab" value="complaints" />

        {{-- STATUS --}}
        <div class="flex flex-col">
            <label class="text-xs font-semibold text-gray-600 mb-2 uppercase tracking-wide">Status</label>
            <select name="status"
                class="px-4 py-2.5 bg-white border-2 border-gray-200 rounded-xl text-sm
                       focus:ring-4 focus:ring-primary-100 focus:border-primary-500 focus:outline-none
                       transition-all cursor-pointer hover:border-gray-300">
                <option value="">All Status</option>
                <option value="in_progress" @selected(request('status')==='in_progress')>In Progress</option>
                <option value="resolved" @selected(request('status')==='resolved')>Resolved</option>
                <option value="rejected" @selected(request('status')==='rejected')>Rejected</option>
            </select>
        </div>

        {{-- RAISED BY ROLE --}}
        <div class="flex flex-col">
            <label class="text-xs font-semibold text-gray-600 mb-2 uppercase tracking-wide">Raised By Role</label>
            <select name="raiser_role"
                    class="px-4 py-2.5 bg-white border-2 border-gray-200 rounded-xl text-sm
                           focus:ring-4 focus:ring-primary-100 focus:border-primary-500 focus:outline-none
                           transition-all cursor-pointer hover:border-gray-300">
                <option value="">All Roles</option>
                <option value="consumer" @selected(request('raiser_role')==='consumer')>Consumer</option>
                <option value="developer" @selected(request('raiser_role')==='developer')>Developer</option>
            </select>
        </div>

        {{-- DATE FROM --}}
        <div class="flex flex-col">
            <label class="text-xs font-semibold text-gray-600 mb-2 uppercase tracking-wide">Date From</label>
            <input type="date" name="date_from" value="{{ request('date_from') }}"
                   class="px-4 py-2.5 bg-white border-2 border-gray-200 rounded-xl text-sm
                          focus:ring-4 focus:ring-primary-100 focus:border-primary-500 focus:outline-none
                          transition-all hover:border-gray-300">
        </div>

        {{-- DATE TO --}}
        <div class="flex flex-col">
            <label class="text-xs font-semibold text-gray-600 mb-2 uppercase tracking-wide">Date To</label>
            <input type="date" name="date_to" value="{{ request('date_to') }}"
                   class="px-4 py-2.5 bg-white border-2 border-gray-200 rounded-xl text-sm
                          focus:ring-4 focus:ring-primary-100 focus:border-primary-500 focus:outline-none
                          transition-all hover:border-gray-300">
        </div>

        {{-- SORT --}}
        <div class="flex flex-col">
            <label class="text-xs font-semibold text-gray-600 mb-2 uppercase tracking-wide">Sort By</label>
            <select name="sort"
                class="px-4 py-2.5 bg-white border-2 border-gray-200 rounded-xl text-sm
                       focus:ring-4 focus:ring-primary-100 focus:border-primary-500 focus:outline-none
                       transition-all cursor-pointer hover:border-gray-300">
                <option value="newest" @selected(request('sort','newest')==='newest')>Newest Complaint</option>
                <option value="oldest" @selected(request('sort')==='oldest')>Oldest Complaint</option>
            </select>
        </div>

        {{-- ACTION BUTTONS --}}
        <div class="sm:col-span-2 lg:col-span-3 xl:col-span-5 flex flex-col sm:flex-row justify-end items-stretch sm:items-center gap-3 mt-4 pt-4 border-t border-gray-100">

            <a href="{{ route('admin.dashboard') }}?tab=complaints"
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
