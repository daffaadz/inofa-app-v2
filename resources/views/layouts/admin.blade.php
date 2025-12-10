<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Admin Dashboard' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased text-gray-800 bg-gray-50 min-h-screen" x-data="{ mobileOpen: false }">

    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        @include('partials.admin-sidebar')

        {{-- Slot halaman admin --}}
        <main class="flex-1 lg:ml-[18rem] transition-all duration-300">
            {{-- Mobile Menu Button --}}
            <div class="lg:hidden fixed top-4 left-4 z-40">
                <button @click="mobileOpen = !mobileOpen" 
                        class="p-3 bg-white rounded-xl shadow-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                    <svg x-show="!mobileOpen" class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="mobileOpen" class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            {{ $slot }}
        </main>
    </div>

</body>
</html>
