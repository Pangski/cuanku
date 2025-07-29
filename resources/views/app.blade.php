<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'CuanKu💲') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    <link rel="alternate icon" href="/favicon.ico">

    <!-- Theme Color (dynamic via theme.js) -->
    <meta name="theme-color" id="theme-color-meta" content="#ffffff" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts & Styles -->
    @routes
    @viteReactRefresh
    @vite(['resources/js/app.jsx', "resources/js/Pages/{$page['component']}.jsx"])
    @inertiaHead

    <!-- Load theme early to prevent flash -->
    <script src="/js/theme.js"></script>
</head>
<body class="font-sans antialiased rounded-xl dark:bg-background">
    @inertia
</body>
</html>
