<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <!-- CSS -->
    @stack('styles')

     <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js']) 
    {{-- JavaScript使用のためのコード --}}
    @stack('scripts')
</head>
<body>
<div id="app">
    @yield('navbar')

    <main class="py-4">
        @yield('content')
    </main>
</div>
</body>
</html>