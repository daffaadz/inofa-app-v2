<aside class="w-64 bg-white border-r p-4 relative">

    {{-- Admin Profile --}}
    <div class="flex items-center gap-3 p-3 bg-white rounded-xl shadow-sm mb-8">
        <img src="{{ asset('images/admin-avatar.png') }}" class="w-12 h-12 rounded-full" />
        <div>
            <div class="font-semibold">Admin Inofa</div>
            <div class="text-xs text-gray-500">Administrator</div>
        </div>
    </div>

    {{-- Menu --}}
    <nav class="flex flex-col gap-3 text-sm">

        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center gap-3 p-3 rounded-xl 
                  {{ request()->routeIs('admin.dashboard') ? 'bg-green-600 text-white shadow' : 'hover:bg-gray-100' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-green-600' }}" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path d="M3 13h8V3H3v10zm10 8h8v-6h-8v6zm0-8h8V3h-8v10zM3 21h8v-6H3v6z"/>
            </svg>
            <div>
                <div class="font-medium">Dashboard</div>
                <div class="text-xs">Manage Validation</div>
            </div>
        </a>

        <a href="{{ route('admin.users.index') }}"
           class="flex items-center gap-3 p-3 rounded-xl 
                  {{ request()->routeIs('admin.users.*') ? 'bg-green-600 text-white shadow' : 'hover:bg-gray-100' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('admin.users.*') ? 'text-white' : 'text-green-600' }}" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <circle cx="12" cy="7" r="4"/>
                <path d="M5.5 21a6.5 6.5 0 0113 0"/>
            </svg>
            <div>
                <div class="font-medium">User</div>
                <div class="text-xs text-gray-500">Manage User</div>
            </div>
        </a>

        <a href="{{ route('admin.projects.index') }}"
           class="flex items-center gap-3 p-3 rounded-xl 
                  {{ request()->routeIs('admin.projects.*') ? 'bg-green-600 text-white shadow' : 'hover:bg-gray-100' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('admin.projects.*') ? 'text-white' : 'text-green-600' }}" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path d="M3 7h6l2 2h10v11H3z"/>
            </svg>
            <div>
                <div class="font-medium">Project</div>
                <div class="text-xs text-gray-500">All Projects</div>
            </div>
        </a>

    </nav>

    {{-- Exit --}}
<div class="sticky bottom-4 mt-6">
    <a href="/"
       class="flex items-center gap-3 px-5 py-3 rounded-full 
              bg-red-50 text-red-600 border border-red-100
              shadow-sm hover:bg-red-100 hover:border-red-200
              transition-all duration-200 ease-out">

        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24">
            <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
        </svg>

        <span class="font-medium text-sm">Exit Dashboard</span>
    </a>
</div>



</aside>
