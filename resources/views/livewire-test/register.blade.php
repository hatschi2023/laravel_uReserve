<html>
    <head>
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body>
        livewireテスト <span class="text-blue-400">resgister</span>
        {{-- <livewire:counter /> --}}
        @livewire('register')
        @livewireScripts
    </body>
</html>


