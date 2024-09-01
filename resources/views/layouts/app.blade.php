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
        @vite(['resources/css/app.css',
        'resources/js/app.js',
        'resources/js/flatpickr.js'
        ])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased bg-cover bg-center" style="background-image: url(/images/sky.jpg);">

        <x-banner />
        <div class="min-h-screen bg-opacity-50">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-sky-200 bg-opacity-50 shadow">
                    <div class="max-w-7xl mx-auto pt-5 pb-2 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif
            <!-- Page Content -->
            <main >
                {{ $slot }}
            </main>

            <!-- Page Footer -->
            <div class="text-xs text-right pb-1 sm:px-6 lg:px-8">
                Copyright © 2024 Kodomo club.
            </div>
        </div>

        @stack('modals')
        @livewireScripts
    </body>
</html>
