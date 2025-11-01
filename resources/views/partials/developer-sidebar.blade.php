<aside class="w-[18rem] bg-neutral-0 border-r border-neutral-100 fixed left-0 top-0 h-screen flex flex-col mt-16 pb-20">

    <!-- User Profile Card -->
    <div
        class="p-4 mx-4 my-8 bg-gradient-to-br from-primary-500/5 to-secondary-500/10 rounded-2xl border border-primary-200">
        <div class="flex items-center gap-3 mb-2">
            <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) }}"
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
        <button type="button" x-data="{ active: window.location.pathname === '{{ parse_url(route('landing'), PHP_URL_PATH) }}' }" @click="active = !active"
            :class="active ?
                'bg-primary-500 text-white' :
                'bg-neutral-0 text-neutral-700 hover:bg-neutral-50'"
            class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl transition mb-1">
            <div :class="active ?
                'bg-gradient-to-br from-white/20 to-white/10' :
                'bg-gradient-to-br from-primary-500/10 to-secondary-500/20'"
                class="p-3 rounded-xl transition">
                <svg class="w-6 h-auto" :class="active ? 'text-white' : 'text-primary-500'" viewBox="0 0 20 20"
                    fill="none">
                    <path
                        d="M15.8332 17.5V15.8333C15.8332 14.9493 15.482 14.1014 14.8569 13.4763C14.2317 12.8512 13.3839 12.5 12.4998 12.5H7.49984C6.61578 12.5 5.76794 12.8512 5.14281 13.4763C4.51769 14.1014 4.1665 14.9493 4.1665 15.8333V17.5"
                        stroke="currentColor" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round" />
                    <path
                        d="M9.99984 9.16667C11.8408 9.16667 13.3332 7.67428 13.3332 5.83333C13.3332 3.99238 11.8408 2.5 9.99984 2.5C8.15889 2.5 6.6665 3.99238 6.6665 5.83333C6.6665 7.67428 8.15889 9.16667 9.99984 9.16667Z"
                        stroke="currentColor" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>
            <div class="flex flex-col justify-end items-start">
                <span :class="active ? 'text-white' : 'text-neutral-1000'" class="text-b-2 font-medium transition">Akun
                    Saya</span>
                <span :class="active ? 'text-neutral-200' : 'text-neutral-500'" class="text-b-4 transition">Profile and
                    settings</span>
            </div>
        </button>

        {{-- My Projects (Active) --}}
        <button type="button" x-data="{ active: window.location.pathname === '{{ parse_url(route('dashboard'), PHP_URL_PATH) }}' }"
            @click="active = !active; window.location='{{ route('dashboard') }}'"
            :class="active ?
                'bg-primary-500 text-white' :
                'bg-neutral-0 text-neutral-700 hover:bg-neutral-50'"
            class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl transition mb-1">
            <div :class="active ?
                'bg-gradient-to-br from-white/20 to-white/10' :
                'bg-gradient-to-br from-primary-500/10 to-secondary-500/20'"
                class="p-3 rounded-xl transition">
                <svg class="w-6 h-auto" :class="active ? 'text-white' : 'text-primary-500'" viewBox="0 0 20 20"
                    fill="none">
                    <path
                        d="M4.99984 11.6667L6.24984 9.25008C6.38573 8.9802 6.59244 8.75233 6.84785 8.59087C7.10325 8.4294 7.39775 8.34041 7.69984 8.33341H16.6665M16.6665 8.33341C16.9211 8.33297 17.1724 8.39086 17.4012 8.50265C17.63 8.61444 17.8301 8.77715 17.9861 8.9783C18.1422 9.17945 18.2502 9.41369 18.3017 9.66304C18.3531 9.91239 18.3468 10.1702 18.2832 10.4167L16.9998 15.4167C16.907 15.7764 16.6967 16.0947 16.4023 16.3212C16.1079 16.5476 15.7463 16.6693 15.3748 16.6667H3.33317C2.89114 16.6667 2.46722 16.4912 2.15466 16.1786C1.8421 15.866 1.6665 15.4421 1.6665 15.0001V4.16675C1.6665 3.72472 1.8421 3.3008 2.15466 2.98824C2.46722 2.67567 2.89114 2.50008 3.33317 2.50008H6.58317C6.86191 2.49735 7.13688 2.56457 7.38292 2.6956C7.62896 2.82662 7.8382 3.01727 7.9915 3.25008L8.6665 4.25008C8.81826 4.48052 9.02486 4.66968 9.26776 4.80058C9.51065 4.93148 9.78225 5.00003 10.0582 5.00008H14.9998C15.4419 5.00008 15.8658 5.17567 16.1783 5.48824C16.4909 5.8008 16.6665 6.22472 16.6665 6.66675V8.33341Z"
                        stroke="currentColor" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>
            <div class="flex flex-col justify-end items-start">
                <span :class="active ? 'text-white' : 'text-neutral-1000'" class="text-b-2 font-medium transition">My
                    Projects</span>
                <p :class="active ? 'text-neutral-200' : 'text-neutral-500'" class="text-b-4 transition">Manage projects
                </p>
                @if ($activeAgreements->count() > 0)
                    <span :class="active ? 'bg-white/20 text-white' : 'bg-white text-primary-500'"
                        class="ml-auto px-2 py-0.5 text-b-4 font-semibold rounded-full transition">
                        {{ $activeAgreements->count() }}
                    </span>
                @endif
            </div>
        </button>

        {{-- Notifikasi --}}
        <button type="button" x-data="{ active: window.location.pathname === '{{ parse_url(route('landing'), PHP_URL_PATH) }}' }" @click="active = !active"
            :class="active ?
                'bg-primary-500 text-white' :
                'bg-neutral-0 text-neutral-700 hover:bg-neutral-50'"
            class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl transition mb-1">
            <div :class="active ?
                'bg-gradient-to-br from-white/20 to-white/10' :
                'bg-gradient-to-br from-primary-500/10 to-secondary-500/20'"
                class="p-3 rounded-xl transition">
                <svg class="w-6 h-auto" :class="active ? 'text-white' : 'text-primary-500'" viewBox="0 0 20 20"
                    fill="none">
                    <path
                        d="M8.55664 17.5C8.70293 17.7533 8.91332 17.9637 9.16668 18.11C9.42003 18.2563 9.70743 18.3333 9.99997 18.3333C10.2925 18.3333 10.5799 18.2563 10.8333 18.11C11.0866 17.9637 11.297 17.7533 11.4433 17.5"
                        stroke="currentColor" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round" />
                    <path
                        d="M2.71821 12.772C2.60935 12.8913 2.53751 13.0397 2.51143 13.1991C2.48534 13.3585 2.50615 13.522 2.5713 13.6698C2.63646 13.8176 2.74316 13.9433 2.87843 14.0316C3.01369 14.1198 3.1717 14.1669 3.33321 14.167H16.6665C16.828 14.167 16.9861 14.1202 17.1214 14.0321C17.2568 13.944 17.3636 13.8184 17.429 13.6708C17.4943 13.5231 17.5153 13.3596 17.4894 13.2001C17.4635 13.0407 17.3919 12.8923 17.2832 12.7728C16.1749 11.6303 14.9999 10.4162 14.9999 6.66699C14.9999 5.34091 14.4731 4.06914 13.5354 3.13146C12.5977 2.19378 11.326 1.66699 9.99988 1.66699C8.6738 1.66699 7.40203 2.19378 6.46435 3.13146C5.52666 4.06914 4.99988 5.34091 4.99988 6.66699C4.99988 10.4162 3.82405 11.6303 2.71821 12.772Z"
                        stroke="currentColor" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>
            <div class="flex flex-col justify-end items-start">
                <span :class="active ? 'text-white' : 'text-neutral-1000'"
                    class="text-b-2 font-medium transition">Notifikasi</span>
                <span :class="active ? 'text-neutral-200' : 'text-neutral-500'" class="text-b-4 transition">All
                    notifications</span>
            </div>
        </button>

        {{-- Chat --}}
        <button type="button" x-data="{ active: window.location.pathname === '{{ parse_url(route('landing'), PHP_URL_PATH) }}' }" @click="active = !active"
            :class="active ?
                'bg-primary-500 text-white' :
                'bg-neutral-0 text-neutral-700 hover:bg-neutral-50'"
            class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl transition mb-1">
            <div :class="active ?
                'bg-gradient-to-br from-white/20 to-white/10' :
                'bg-gradient-to-br from-primary-500/10 to-secondary-500/20'"
                class="p-3 rounded-xl transition">
                <svg class="w-6 h-auto" :class="active ? 'text-white' : 'text-primary-500'" viewBox="0 0 20 20"
                    fill="none">
                    <path
                        d="M18.3332 14.1667C18.3332 14.6087 18.1576 15.0326 17.845 15.3452C17.5325 15.6577 17.1085 15.8333 16.6665 15.8333H5.68984C5.24785 15.8334 4.82399 16.0091 4.5115 16.3217L2.6765 18.1567C2.59376 18.2394 2.48834 18.2957 2.37358 18.3186C2.25882 18.3414 2.13986 18.3297 2.03176 18.2849C1.92366 18.2401 1.83126 18.1643 1.76624 18.067C1.70123 17.9697 1.66652 17.8553 1.6665 17.7383V4.16667C1.6665 3.72472 1.8421 3.30072 2.15466 2.98816C2.46722 2.67559 2.89114 2.5 3.33317 2.5H16.6665C17.1085 2.5 17.5325 2.67559 17.845 2.98816C18.1576 3.30072 18.3332 3.72464 18.3332 4.16667V14.1667Z"
                        stroke="currentColor" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>
            <div class="flex flex-col justify-end items-start">
                <span :class="active ? 'text-white' : 'text-neutral-1000'"
                    class="text-b-2 font-medium transition">Chat</span>
                <span :class="active ? 'text-neutral-200' : 'text-neutral-500'"
                    class="text-b-4 transition">Messages</span>
            </div>
        </button>

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
