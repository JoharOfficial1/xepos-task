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
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100" id="app">
            @include('layouts.navigation')
            
            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>

    <script type="text/javascript">
        $(document).ready(function() {
            activateCurrentNavRouter();
        });

        function activateCurrentNavRouter() {
            var navRouters = $('.nav-router-links');
            var currentPath = window.location.pathname;

            $.each(navRouters, function(index, router) {console.log()
                if(currentPath.includes($(router).attr('href'))) {
                    // Remove classes
                    $(router).attr('class', '');

                    // Add active classes
                    $(router).addClass('nav-router-links inline-flex items-center px-1 pt-1 border-b-2 border-indigo-400 text-sm font-medium leading-5 text-gray-900  focus:border-indigo-700 transition duration-150 ease-in-out');
                } else {
                    // Remove classes
                    $(router).attr('class', '');

                    // Add in-active classes
                    $(router).addClass('nav-router-links inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out');
                }
            });
            
        }
    </script>
</html>
