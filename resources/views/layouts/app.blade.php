<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Inofa – Bring Your Digital Projects to Life')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased text-gray-800">
    @auth
        @include('partials.navbar-auth')
    @else
        @include('partials.navbar')
    @endauth

    <main>
        @yield('content')
    </main>

    @guest
        @include('partials.footer')
    @endguest
</body>

</html>
</html>
