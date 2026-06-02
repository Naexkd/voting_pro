<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-black text-white">
        <div class="min-h-screen bg-blue-950">
            @include('layouts.navigation')

            <div class="bg-blue-900/80 border-b border-blue-800 text-sm text-blue-100">
                <div class="mx-auto max-w-7xl px-4 py-2 sm:px-6 lg:px-8">
                    {{ __('Navigation is restricted to app links. The browser back button is disabled, so please use the menu and buttons to move between pages.') }}
                </div>
            </div>

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-blue-950 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <script>
            // Prevent browser back button navigation and keep users on the current page.
            history.pushState(null, document.title, location.href);
            window.addEventListener('popstate', function () {
                history.pushState(null, document.title, location.href);
            });
        </script>
    </body>
</html>
