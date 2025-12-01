<aside class="w-[18rem] bg-neutral-0 border-r border-neutral-100 fixed left-0 top-0 h-screen flex flex-col pb-20 z-30 
              transition-transform duration-300 ease-in-out
              lg:translate-x-0"
       :class="mobileOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">

    <!-- Admin Profile Card -->
    <div class="p-4 mx-4 my-8 bg-gradient-to-br from-primary-500/5 to-secondary-500/10 rounded-2xl border border-primary-200">
        <div class="flex items-center gap-3 mb-2">
            <img src="https://ui-avatars.com/api/?name=Admin+Inofa&background=059669&color=fff&bold=true" 
                 alt="Admin Avatar" 
                 class="w-12 h-12 rounded-full object-cover border-2 border-primary-300">
                
            <div class="flex-1 min-w-0">
                <p class="text-b-2 font-semibold text-neutral-900 truncate">Admin Inofa</p>
                <p class="text-b-3 text-neutral-600 truncate">Administrator</p>
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 px-4 py-6 overflow-y-auto border-t border-neutral-100" @click="if (window.innerWidth < 1024) mobileOpen = false">

        {{-- Dashboard --}}
        <a href="{{ route('admin.dashboard') }}"
           class="flex items-start gap-3 px-4 py-3 mb-2 rounded-2xl transition group
                  {{ request()->routeIs('admin.dashboard') 
                     ? 'bg-gradient-to-r from-primary-500 to-secondary-500 text-white shadow-md' 
                     : 'text-neutral-700 hover:bg-neutral-100' }}">
            
            {{-- Icon --}}
            <div class="p-3 rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-white/20' : 'bg-primary-100/75' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-primary-500' }}" fill="currentColor" viewBox="0 0 256 256">
                    <path d="M93.82,116.64A12,12,0,0,0,100,106.15V40.74A12,12,0,0,0,83,29.83,108.26,108.26,0,0,0,20,128c0,3.37.16,6.76.47,10.1a12,12,0,0,0,17.76,9.38ZM76,62.06v37L44.81,116.36A84.39,84.39,0,0,1,76,62.06ZM128,20a12,12,0,0,0-12,12v89.53L39.18,166.27a12,12,0,0,0-4.3,16.46A108,108,0,1,0,128,20Zm0,192a84.47,84.47,0,0,1-65.57-31.5L134,138.79a12,12,0,0,0,6-10.37V44.85A84,84,0,0,1,128,212Z"/>
                </svg>
            </div>

            {{-- Label --}}
            <div class="flex flex-col justify-end items-start">
                <span class="text-b-1 font-medium">Dashboard</span>
                <span class="text-b-4 {{ request()->routeIs('admin.dashboard') ? 'text-white/80' : 'text-neutral-500' }}">
                    Manage Validation
                </span>
            </div>
        </a>

        {{-- User Management --}}
        <a href="{{ route('admin.users.index') }}"
           class="flex items-start gap-3 px-4 py-3 mb-2 rounded-2xl transition group
                  {{ request()->routeIs('admin.users.*') 
                     ? 'bg-gradient-to-r from-primary-500 to-secondary-500 text-white shadow-md' 
                     : 'text-neutral-700 hover:bg-neutral-100' }}">
            
            {{-- Icon --}}
            <div class="p-3 rounded-xl {{ request()->routeIs('admin.users.*') ? 'bg-white/20' : 'bg-primary-100/75' }}">
                <svg class="w-6 h-6 {{ request()->routeIs('admin.users.*') ? 'text-white' : 'text-primary-500' }}" 
                     fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" 
                          d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>

            {{-- Label --}}
            <div class="flex flex-col justify-end items-start">
                <span class="text-b-1 font-medium">User</span>
                <span class="text-b-4 {{ request()->routeIs('admin.users.*') ? 'text-white/80' : 'text-neutral-500' }}">
                    Manage User
                </span>
            </div>
        </a>

        {{-- Project Management --}}
        <a href="{{ route('admin.projects.index') }}"
           class="flex items-start gap-3 px-4 py-3 mb-2 rounded-2xl transition group
                  {{ request()->routeIs('admin.projects.*') 
                     ? 'bg-gradient-to-r from-primary-500 to-secondary-500 text-white shadow-md' 
                     : 'text-neutral-700 hover:bg-neutral-100' }}">
            
            {{-- Icon --}}
            <div class="p-3 rounded-xl {{ request()->routeIs('admin.projects.*') ? 'bg-white/20' : 'bg-primary-100/75' }}">
                <svg class="w-6 h-6 {{ request()->routeIs('admin.projects.*') ? 'text-white' : 'text-primary-500' }}" 
                     fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" 
                          d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                </svg>
            </div>

            {{-- Label --}}
            <div class="flex flex-col justify-end items-start">
                <span class="text-b-1 font-medium">Project</span>
                <span class="text-b-4 {{ request()->routeIs('admin.projects.*') ? 'text-white/80' : 'text-neutral-500' }}">
                    All Projects
                </span>
            </div>
        </a>

        {{-- Chat / Messages --}}
        <a href="{{ route('chat') }}"
           class="flex items-start gap-3 px-4 py-3 mb-2 rounded-2xl transition group
                  {{ request()->routeIs('chat') || request()->routeIs('user') || request()->routeIs('group')
                     ? 'bg-gradient-to-r from-primary-500 to-secondary-500 text-white shadow-md' 
                     : 'text-neutral-700 hover:bg-neutral-100' }}">
            
            {{-- Icon --}}
            <div class="p-3 rounded-xl {{ request()->routeIs('chat') || request()->routeIs('user') || request()->routeIs('group') ? 'bg-white/20' : 'bg-primary-100/75' }}">
                <svg class="w-6 h-6 {{ request()->routeIs('chat') || request()->routeIs('user') || request()->routeIs('group') ? 'text-white' : 'text-primary-500' }}" 
                     fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" 
                          d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
            </div>

            {{-- Label --}}
            <div class="flex flex-col justify-end items-start">
                <span class="text-b-1 font-medium">Chat</span>
                <span class="text-b-4 {{ request()->routeIs('chat') || request()->routeIs('user') || request()->routeIs('group') ? 'text-white/80' : 'text-neutral-500' }}">
                    Messages
                </span>
            </div>
        </a>
        
    </nav>

    <!-- Log Out -->
    <div class="p-4 border-t border-neutral-200">
        <a href="/"
           class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-red-500 hover:bg-red-50 transition group text-left">

            {{-- Icon --}}
            <div class="bg-red-100/75 p-3 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
            </div>

            {{-- Label --}}
            <div class="flex flex-col justify-end items-start">
                <span class="text-b-1 font-medium">Log Out</span>
                <span class="text-b-4 text-neutral-500">Return to homepage</span>
            </div>
        </a>
    </div>

</aside>

<!-- Mobile Overlay -->
<div x-show="mobileOpen"
     @click="mobileOpen = false"
     x-transition:enter="transition-opacity ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="lg:hidden fixed inset-0 bg-black/50 z-20"
     style="display: none;">
</div>
