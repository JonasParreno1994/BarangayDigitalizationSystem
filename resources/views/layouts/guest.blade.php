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
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900 relative">
            <video autoplay muted loop class="absolute inset-0 w-full h-full object-cover z-0">
                <source src="{{ asset('design/1.mp4') }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
           

            <div class="relative z-10 w-full sm:max-w-md mt-6 px-6 py-4 bg-white/70 dark:bg-gray-800/70 shadow-md overflow-hidden sm:rounded-lg backdrop-blur">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
