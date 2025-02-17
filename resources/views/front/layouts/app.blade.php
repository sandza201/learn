<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script type="module" src="{{ URL::asset('front/common.js') }}"></script>
</head>
<body class="font-sans text-gray-900 antialiased">
<div class="bg-white">
    <header class="fixed inset-x-0 top-0 z-50">
        @include('.front._partials.navbar')
        @include('.front._partials.mobile-menu')
    </header>

    <div class="relative max-w-2xl mx-auto min-h-screen py-16">
        @yield('content')
    </div>
</div>

</body>
</html>
