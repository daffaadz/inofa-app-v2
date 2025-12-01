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
            {{ $slot }}
        </main>
    </div>

</body>
</html>
