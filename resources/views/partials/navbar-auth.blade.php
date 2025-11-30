<nav class="fixed bg-neutral-0 z-20 w-full">
    <div class="w-screen mx-auto px-8 flex items-center justify-between h-16">

        {{-- Left cluster : Logo + nav links --}}
        <div class="flex items-center gap-8">
            {{-- Logo --}}
            <a href="{{ url('/') }}" class="flex items-center gap-4">
                <img src="{{ asset('assets/vector/logo.svg') }}" alt="Inofa logo" class="h-8 w-auto">
                <span class="text-neutral-800 font-sans text-h-7">Inofa</span>
            </a>

            {{-- Desktop links --}}
            <div class="hidden md:flex items-center gap-6 text-sm font-semibold text-neutral-800">
                {{-- “Find Talent” dropdown --}}
                <div class="relative" x-data="{ open: false }" @click.away="open=false">
                    <button @click="open=!open"
                        class="flex items-center gap-1 hover:text-primary-500  font-sans text-b-1 transition">
                        Find Talent
                        <svg class="w-4 h-4 mt-0.5" :class="open ? 'rotate-180' : ''" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    {{-- Dropdown panel --}}
                    <div x-show="open" x-transition
                        class="absolute top-full left-0 mt-2 p-4 w-72 bg-neutral-0 rounded-lg shadow-lg ring-1 ring-neutral-200 z-50">
                        <a href="#"
                            class="flex flex-row justify-center items-start gap-4 px-4 py-3 w-full text-neutral-800 hover:bg-neutral-10 text-h-7 rounded-t-lg">
                            <div>
                                <svg class="w-8 h-auto pt-2" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M16 8V5L19 2L20 4L22 5L19 8H16ZM16 8L12 11.9999M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2M17 12C17 14.7614 14.7614 17 12 17C9.23858 17 7 14.7614 7 12C7 9.23858 9.23858 7 12 7"
                                        stroke="black" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </div>

                            <div>
                                <h6>How to Hire</h6>
                                <p class="text-b-3">
                                    Learn our simple, secure process to find and hire expert developers.
                                </p>
                            </div>
                        </a>
                        <a href="#"
                            class="flex flex-row justify-center items-start gap-4 px-4 py-3 w-full text-neutral-800 hover:bg-neutral-10 text-h-7">
                            <div>
                                <svg class="w-8 h-auto pt-2" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M13 2L4.09346 12.6879C3.74465 13.1064 3.57024 13.3157 3.56758 13.4925C3.56526 13.6461 3.63373 13.7923 3.75326 13.8889C3.89075 14 4.16318 14 4.70803 14H12L11 22L19.9065 11.3121C20.2554 10.8936 20.4298 10.6843 20.4324 10.5075C20.4347 10.3539 20.3663 10.2077 20.2467 10.1111C20.1093 10 19.8368 10 19.292 10H12L13 2Z"
                                        stroke="black" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </div>

                            <div>
                                <h6>Why Inofa</h6>
                                <p class="text-b-3">
                                    See how our secure payments and vetted talent ensure your project's success.
                                </p>
                            </div>
                        </a>
                        <a href="#"
                            class="flex flex-row justify-center items-start gap-4 px-4 py-3 w-full text-neutral-800 hover:bg-neutral-10 text-h-7 rounded-b-lg">
                            <div>
                                <svg class="w-8 h-auto pt-2" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12 15L9 12M12 15C13.3968 14.4687 14.7369 13.7987 16 13M12 15V20C12 20 15.03 19.45 16 18C17.08 16.38 16 13 16 13M9 12C9.53214 10.6194 10.2022 9.29607 11 8.05C12.1652 6.18699 13.7876 4.65305 15.713 3.5941C17.6384 2.53514 19.8027 1.98637 22 2C22 4.72 21.22 9.5 16 13M9 12H4C4 12 4.55 8.97 6 8C7.62 6.92 11 8 11 8M4.5 16.5C3 17.76 2.5 21.5 2.5 21.5C2.5 21.5 6.24 21 7.5 19.5C8.21 18.66 8.2 17.37 7.41 16.59C7.02131 16.219 6.50929 16.0046 5.97223 15.988C5.43516 15.9714 4.91088 16.1537 4.5 16.5Z"
                                        stroke="black" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </div>

                            <div>
                                <h6>Post a Project</h6>
                                <p class="text-b-3">
                                    Describe your needs and get matched with the right professionals instantly.
                                </p>
                            </div>
                        </a>
                    </div>
                </div>

                {{-- “Find Work” dropdown --}}
                <div class="relative" x-data="{ open: false }" @click.away="open=false">
                    <button @click="open=!open"
                        class="flex items-center gap-1 hover:text-primary-500  font-sans text-b-1 transition">
                        Find Work
                        <svg class="w-4 h-4 mt-0.5" :class="open ? 'rotate-180' : ''" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    {{-- Dropdown panel --}}
                    <div x-show="open" x-transition
                        class="absolute top-full left-0 mt-2 p-4 w-72 bg-neutral-0 rounded-lg shadow-lg ring-1 ring-neutral-200 z-50">
                        <a href="#"
                            class="flex flex-row justify-center items-start gap-4 px-4 py-3 w-full text-neutral-800 hover:bg-neutral-10 text-h-7 rounded-t-lg">
                            <div>
                                <svg class="w-8 h-auto pt-2" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M14 2.26953V6.40007C14 6.96012 14 7.24015 14.109 7.45406C14.2049 7.64222 14.3578 7.7952 14.546 7.89108C14.7599 8.00007 15.0399 8.00007 15.6 8.00007H19.7305M16 13H8M16 17H8M10 9H8M14 2H8.8C7.11984 2 6.27976 2 5.63803 2.32698C5.07354 2.6146 4.6146 3.07354 4.32698 3.63803C4 4.27976 4 5.11984 4 6.8V17.2C4 18.8802 4 19.7202 4.32698 20.362C4.6146 20.9265 5.07354 21.3854 5.63803 21.673C6.27976 22 7.11984 22 8.8 22H15.2C16.8802 22 17.7202 22 18.362 21.673C18.9265 21.3854 19.3854 20.9265 19.673 20.362C20 19.7202 20 18.8802 20 17.2V8L14 2Z"
                                        stroke="black" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </div>

                            <div>
                                <h6>How to apply</h6>
                                <p class="text-b-3">
                                    Build your profile, showcase your work, and start getting quality projects.
                                </p>
                            </div>
                        </a>
                        <a href="#"
                            class="flex flex-row justify-center items-start gap-4 px-4 py-3 w-full text-neutral-800 hover:bg-neutral-10 text-h-7">
                            <div>
                                <svg class="w-8 h-auto pt-2" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M2.49954 9H21.4995M9.99954 3L7.99954 9L11.9995 20.5L15.9995 9L13.9995 3M12.6141 20.2625L21.5727 9.51215C21.7246 9.32995 21.8005 9.23885 21.8295 9.13717C21.8551 9.04751 21.8551 8.95249 21.8295 8.86283C21.8005 8.76114 21.7246 8.67005 21.5727 8.48785L17.2394 3.28785C17.1512 3.18204 17.1072 3.12914 17.0531 3.09111C17.0052 3.05741 16.9518 3.03238 16.8953 3.01717C16.8314 3 16.7626 3 16.6248 3H7.37424C7.2365 3 7.16764 3 7.10382 3.01717C7.04728 3.03238 6.99385 3.05741 6.94596 3.09111C6.89192 3.12914 6.84783 3.18204 6.75966 3.28785L2.42633 8.48785C2.2745 8.67004 2.19858 8.76114 2.16957 8.86283C2.144 8.95249 2.144 9.04751 2.16957 9.13716C2.19858 9.23885 2.2745 9.32995 2.42633 9.51215L11.385 20.2625C11.596 20.5158 11.7015 20.6424 11.8279 20.6886C11.9387 20.7291 12.0603 20.7291 12.1712 20.6886C12.2975 20.6424 12.4031 20.5158 12.6141 20.2625Z"
                                        stroke="black" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </div>

                            <div>
                                <h6>Developer Benefit</h6>
                                <p class="text-b-3">
                                    Get consistent projects, secure payments, and grow your professional reputation.
                                </p>
                            </div>
                        </a>
                        <a href="#"
                            class="flex flex-row justify-center items-start gap-4 px-4 py-3 w-full text-neutral-800 hover:bg-neutral-10 text-h-7 rounded-b-lg">
                            <div>
                                <svg class="w-8 h-auto pt-2" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M6.5 13L7.28446 14.5689C7.54995 15.0999 7.68269 15.3654 7.86003 15.5954C8.01739 15.7996 8.20041 15.9826 8.40455 16.14C8.63462 16.3173 8.9001 16.4501 9.43108 16.7155L11 17.5L9.43108 18.2845C8.9001 18.5499 8.63462 18.6827 8.40455 18.86C8.20041 19.0174 8.01739 19.2004 7.86003 19.4046C7.68269 19.6346 7.54995 19.9001 7.28446 20.4311L6.5 22L5.71554 20.4311C5.45005 19.9001 5.31731 19.6346 5.13997 19.4046C4.98261 19.2004 4.79959 19.0174 4.59545 18.86C4.36538 18.6827 4.0999 18.5499 3.56892 18.2845L2 17.5L3.56892 16.7155C4.0999 16.4501 4.36538 16.3173 4.59545 16.14C4.79959 15.9826 4.98261 15.7996 5.13997 15.5954C5.31731 15.3654 5.45005 15.0999 5.71554 14.5689L6.5 13Z"
                                        stroke="black" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M15 2L16.1786 5.06442C16.4606 5.79765 16.6016 6.16426 16.8209 6.47264C17.0153 6.74595 17.254 6.98475 17.5274 7.17909C17.8357 7.39836 18.2024 7.53937 18.9356 7.82138L22 9L18.9356 10.1786C18.2024 10.4606 17.8357 10.6016 17.5274 10.8209C17.254 11.0153 17.0153 11.254 16.8209 11.5274C16.6016 11.8357 16.4606 12.2024 16.1786 12.9356L15 16L13.8214 12.9356C13.5394 12.2024 13.3984 11.8357 13.1791 11.5274C12.9847 11.254 12.746 11.0153 12.4726 10.8209C12.1643 10.6016 11.7976 10.4606 11.0644 10.1786L8 9L11.0644 7.82138C11.7976 7.53937 12.1643 7.39836 12.4726 7.17909C12.746 6.98475 12.9847 6.74595 13.1791 6.47264C13.3984 6.16426 13.5394 5.79765 13.8214 5.06442L15 2Z"
                                        stroke="black" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </div>

                            <div>
                                <h6>Success Stories</h6>
                                <p class="text-b-3">
                                    See how developers launched and grew their freelance careers on Inofa.
                                </p>
                            </div>
                        </a>
                    </div>
                </div>

                <a href="{{ url('#why-inofa') }}" class="hover:text-primary-500  font-sans text-b-1 transition">Why
                    Inofa</a>
            </div>
        </div>

        {{-- Search & User Menu --}}
        <div class="flex items-center justify-end md:w-2/5 gap-2">

            {{-- Search --}}
            <div class="hidden lg:flex flex-1 max-w-sm mx-4 items-center" x-data="searchComponent()">
                <div class="relative w-full">
                    {{-- Search icon --}}
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-neutral-500 pointer-events-none"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>

                    {{-- input --}}
                    <input type="text" 
                        x-model="query"
                        @input="handleInput()"
                        @keydown.enter="performSearch()"
                        @focus="showResults = true"
                        @click.away="showResults = false"
                        placeholder="Search"
                        class="w-full pl-10 pr-4 py-2 rounded-lg border border-neutral-300
                      font-sans text-b-3 text-neutral-800
                      placeholder:text-neutral-400
                      focus:outline-none focus:ring-1 focus:ring-primary-500">
                    
                    {{-- Search hint/instruction --}}
                    <div x-show="query.length > 0 && !showResults" 
                         class="absolute right-3 top-1/2 -translate-y-1/2 text-neutral-400 text-xs">
                        Press Enter to search
                    </div>
                </div>
            </div>

            {{-- User Menu --}}
            <div class="flex items-center gap-2 font-semibold">
                {{-- Notifications --}}
                <button class="relative p-2 rounded-lg hover:bg-neutral-100 transition">
                    <svg class="w-6 h-6 text-neutral-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </button>

                {{-- User dropdown --}}
                <div class="relative" x-data="{ open: false }" @click.away="open=false">
                    <button @click="open=!open"
                        class="flex items-center gap-2 hover:bg-neutral-100 px-3 py-2 rounded-lg transition">

                        @php
                            $avatarSrc = Auth::user()->getRawOriginal('avatar')
                                ? (filter_var(Auth::user()->getRawOriginal('avatar'), FILTER_VALIDATE_URL)
                                    ? Auth::user()->getRawOriginal('avatar')
                                    : asset('storage/' . Auth::user()->getRawOriginal('avatar')))
                                : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name);
                        @endphp
                        <img src="{{ $avatarSrc }}" alt="Avatar" class="w-8 h-8 rounded-full object-cover">
                        <svg class="w-4 h-4 text-neutral-600 mt-0.5" :class="open ? 'rotate-180' : ''" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    {{-- Dropdown menu --}}
                    <div x-show="open" x-transition
                        class="absolute top-full right-0 mt-2 w-64 bg-neutral-0 rounded-lg shadow-lg ring-1 ring-neutral-200 z-50">

                        {{-- Menu items --}}
                        <div class="py-2">
                            <a href="{{ route('dashboard') }}"
                                class="flex items-center gap-3 px-4 py-3 text-neutral-800 hover:bg-neutral-10 font-sans text-b-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                </svg>
                                Dashboard
                            </a>

                            <a href="{{ route('profile.edit') }}"
                                class="flex items-center gap-3 px-4 py-3 text-neutral-800 hover:bg-neutral-10 font-sans text-b-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                My Profile
                            </a>
                        </div>

                        {{-- Logout --}}
                        <div class="border-t border-neutral-200 py-2">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="flex items-center gap-3 w-full px-4 py-3 text-red-500 hover:bg-red-50 font-sans text-b-2 rounded-b-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Log out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</nav>

{{-- Alpine CDN (drop-in, no bundle) --}}
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

{{-- Search Component --}}
<script>
    function searchComponent() {
        return {
            query: '',
            showResults: false,
            searchTimeout: null,
            
            handleInput() {
                // Clear previous timeout
                clearTimeout(this.searchTimeout);
                
                // Reset untuk tidak auto-search, hanya menunggu user tekan Enter
                // Bisa ditambahkan live suggestions di sini jika diperlukan
            },
            
            performSearch() {
                const searchQuery = this.query.trim();
                
                if (searchQuery.length === 0) {
                    return;
                }
                
                // Deteksi role user
                @auth
                    const userRole = '{{ Auth::user()->role ?? "guest" }}';
                @else
                    const userRole = 'guest';
                @endauth
                
                let searchUrl = '';
                
                // Tentukan URL berdasarkan role
                if (userRole === 'developer') {
                    searchUrl = '{{ route("search.projects") }}';
                } else {
                    // customer atau guest mengarah ke developers
                    searchUrl = '{{ route("search.developers") }}';
                }
                
                // Redirect ke halaman search dengan query parameter
                window.location.href = searchUrl + '?q=' + encodeURIComponent(searchQuery);
            }
        }
    }
</script>
