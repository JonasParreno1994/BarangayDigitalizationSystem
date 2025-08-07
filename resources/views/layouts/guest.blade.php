<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

       
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
           
            ::-webkit-scrollbar {
                width: 8px;
                background: #e5e7eb;
            }
            ::-webkit-scrollbar-thumb {
                background: #a1a1aa;
                border-radius: 4px;
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900 relative overflow-hidden">
           

          
            <div class="relative z-10 flex flex-col items-center mb-4">
                <img src="{{ asset('newlogo.jfif') }}" alt="Logo" class="h-16 w-16 rounded-full shadow-lg mb-2 border-4 border-white/80 dark:border-gray-800/80">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white tracking-wide drop-shadow">Welcome to {{ config('app.name', 'Laravel') }}</h1>
            </div>

            <div class="relative z-10 w-full sm:max-w-md mt-4 px-8 py-6 bg-white/80 dark:bg-gray-800/80 shadow-xl overflow-hidden sm:rounded-2xl backdrop-blur-lg border border-gray-200 dark:border-gray-700">
                {{ $slot }}
            </div>

           
            <footer class="relative z-10 mt-8 text-center text-gray-600 dark:text-gray-400 text-xs">
                &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.
            </footer>
        </div>
    </body>
</html>
