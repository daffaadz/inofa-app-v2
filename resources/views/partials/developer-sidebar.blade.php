<aside class="w-[18rem] bg-neutral-0 border-r border-neutral-100 fixed left-0 top-0 h-screen flex flex-col mt-16 pb-20">

    <!-- User Profile Card -->
    <div
        class="p-4 mx-4 my-8 bg-gradient-to-br from-primary-500/5 to-secondary-500/10 rounded-2xl border border-primary-200">
        <div class="flex items-center gap-3 mb-2">
            @php
                $src = Str::startsWith(Auth::user()->avatar, 'http')
                    ? Auth::user()->avatar
                    : asset('storage/' . Auth::user()->avatar);
            @endphp
            <img src="{{ Auth::user()->avatar ? $src : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) }}"
                alt="Avatar" class="w-12 h-12 rounded-full object-cover border-2 border-primary-300">
            <div class="flex-1 min-w-0">
                <p class="text-b-2 font-semibold text-neutral-900 truncate">{{ Auth::user()->name }}</p>
                <p class="text-b-3 text-neutral-600 truncate">{{ Auth::user()->email }}</p>
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 px-4 py-6 overflow-y-auto border-t border-neutral-100">

        {{-- Akun Saya --}}
        <x-sidebar-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')" icon="akun-saya" description="Profile and settings">
            Akun Saya
        </x-sidebar-link>

        {{-- My Projects --}}
        <x-sidebar-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" icon="my-projects" description="Manage projects">
            My Projects
        </x-sidebar-link>

        {{-- Notifikasi --}}
        <x-sidebar-link :href="route('landing')" :active="request()->routeIs('notifications.index')" icon="notifikasi" :badge="$activeAgreements->count() ?: null"
            description="All notifications">
            Notifikasi
        </x-sidebar-link>

        {{-- Chat --}}
        <x-sidebar-link :href="route('chat.conversations')" :active="request()->routeIs('chat.conversations')" icon="chat" description="Messages">
            Chat
        </x-sidebar-link>

    </nav>

    <!-- Exit Dashboard -->
    <div class="p-4 border-t border-neutral-200">
        <form action="{{ route('logout') }}" method="POST" class="block">
            @csrf
            <button type="submit"
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
                    <span class="text-b-1 font-medium">Exit Dashboard</span>
                    <span class="text-b-4 text-neutral-500">Return to homepage</span>
                </div>
            </button>
        </form>
    </div>

</aside>
