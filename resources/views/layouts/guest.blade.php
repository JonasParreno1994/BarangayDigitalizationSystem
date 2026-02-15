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
        <style>
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            .animate-fade-in-up {
                animation: fadeInUp 0.8s ease-out forwards;
                opacity: 0; /* Start hidden */
            }
            
            /* Glassmorphism Card Details */
            .glass-card {
                background: rgba(255, 255, 255, 0.7); /* Slightly more transparent for single card look */
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
                border: 1px solid rgba(255, 255, 255, 0.4);
                box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.2);
            }
            .dark .glass-card {
                background: rgba(17, 24, 39, 0.7);
                border: 1px solid rgba(255, 255, 255, 0.1);
            }
            
            /* Animated Blobs */
            .blob {
                position: absolute;
                border-radius: 50%;
                filter: blur(80px);
                z-index: 0;
                opacity: 0.7;
                animation: float 20s infinite ease-in-out alternate;
            }
            .blob-1 {
                top: -10%;
                left: -10%;
                width: 50vw;
                height: 50vw;
                background: #4f46e5; /* Indigo */
                animation-delay: 0s;
            }
            .blob-2 {
                bottom: -10%;
                right: -10%;
                width: 60vw;
                height: 60vw;
                background: #06b6d4; /* Cyan */
                animation-delay: -5s;
            }
            .blob-3 {
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 40vw;
                height: 40vw;
                background: #ec4899; /* Pink */
                animation-delay: -10s;
                opacity: 0.5;
            }

            @keyframes float {
                0% { transform: translate(0, 0) scale(1); }
                33% { transform: translate(30px, -50px) scale(1.1); }
                66% { transform: translate(-20px, 20px) scale(0.9); }
                100% { transform: translate(0, 0) scale(1); }
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased overflow-hidden">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-slate-900 relative">
            
            <!-- Abstract Background Elements -->
            <div class="blob blob-1"></div>
            <div class="blob blob-2"></div>
            <div class="blob blob-3"></div>

            <!-- Content Wrapper -->
            <div class="relative z-10 w-full flex justify-center px-4">
                
                <!-- Single Unified Card -->
                <div class="w-full sm:max-w-md px-8 py-10 glass-card sm:rounded-3xl animate-fade-in-up flex flex-col items-center">
                    
                    <!-- Logo & Title Section -->
                    <div class="flex flex-col items-center mb-6">
                        <div class="p-3 bg-white/10 rounded-full backdrop-blur-md border border-white/20 shadow-xl mb-4">
                             <img src="{{ asset('newlogo.jfif') }}" alt="Logo" class="h-20 w-20 rounded-full shadow-lg">
                        </div>
                         <h1 class="text-3xl font-extrabold text-gray-800 dark:text-white tracking-tight drop-shadow-sm text-center">
                             iBarangay
                         </h1>
                         <p class="text-indigo-600 dark:text-indigo-300 mt-1 text-base font-medium tracking-wide">Management System</p>
                     </div>

                    <!-- Form Content -->
                    <div class="w-full">
                        {{ $slot }}
                    </div>

                    <!-- Footer Section -->
                    <footer class="mt-8 text-center text-gray-500 dark:text-gray-400 text-xs font-medium tracking-wide">
                        Powered by: TreeBytes Technology
                    </footer>

                </div>
            </div>
        </div>
    </body>
</html>
