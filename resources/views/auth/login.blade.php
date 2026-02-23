<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:300,400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Figtree', sans-serif;
        }

        .theme-primary {
            background-color: #0f172a;
        }

        .text-theme-primary {
            color: #0f172a;
        }

        .border-theme-primary {
            border-color: #0f172a;
        }

        .bg-custom-gray {
            background-color: #fafafa;
        }

        .btn-shadow {
            box-shadow: 0 4px 14px 0 rgba(15, 23, 42, 0.2);
        }
    </style>
</head>

<body class="antialiased overflow-hidden m-0 p-0 bg-custom-gray text-gray-800">

    <div class="flex h-screen w-full">

        <!-- Left Side (Black Banner with Abstract Pattern) -->
        <div class="hidden lg:flex w-1/2 theme-primary relative overflow-hidden flex-col justify-center px-12 xl:px-24">

            <!-- Abstract background styling -->
            <!-- Top Left Dots Matrix -->
            <div class="absolute top-[10%] left-[8%] grid grid-cols-4 gap-4 opacity-50 z-0 text-white fill-current">
                @for ($i = 0; $i < 16; $i++)
                    <svg width="6" height="6" viewBox="0 0 4 4">
                        <circle cx="2" cy="2" r="2" />
                    </svg>
                @endfor
            </div>

            <!-- Top Large Outlined Circle -->
            <div class="absolute top-[-50px] left-[25%] w-[150px] h-[150px] border-[3px] border-white/20 rounded-full">
            </div>

            <!-- Top Middle Pill Outline -->
            <div class="absolute top-[80px] left-[50%] w-[35px] h-[120px] rounded-full border-[3px] border-white/30">
            </div>

            <!-- Top Right Small Dot -->
            <div class="absolute top-[15%] right-[15%] w-[16px] h-[16px] bg-white rounded-full opacity-70"></div>

            <!-- Top Right Circled Dot -->
            <div
                class="absolute top-[25%] right-[30%] flex items-center justify-center w-[50px] h-[50px] rounded-full border-[2px] border-white/40">
                <div class="w-[14px] h-[14px] bg-white rounded-full"></div>
            </div>

            <!-- Main Text -->
            <div class="z-10 text-white leading-tight mt-10">
                <h1 class="text-[42px] xl:text-[48px] font-bold mb-6 tracking-wide drop-shadow-sm uppercase">
                    iBarangay<br>Management System
                </h1>
                <p class="text-[20px] xl:text-[22px] text-white/90 font-light tracking-wide leading-relaxed">
                    Streamline your community processes<br>with our digital solutions
                </p>
            </div>

            <!-- Bottom Left Glowing Sphere -->
            <div
                class="absolute bottom-[20%] left-[10%] w-[40px] h-[40px] bg-gradient-to-tr from-gray-600 to-gray-400 rounded-full shadow-xl">
            </div>

            <!-- Bottom Left Dots Matrix -->
            <div class="absolute bottom-[10%] left-[10%] grid grid-cols-4 gap-4 opacity-30 z-0 text-white fill-current">
                @for ($i = 0; $i < 16; $i++)
                    <svg width="6" height="6" viewBox="0 0 4 4">
                        <circle cx="2" cy="2" r="2" />
                    </svg>
                @endfor
            </div>

            <!-- Bottom Right Circles Array -->
            <div
                class="absolute bottom-[-10%] right-[-5%] w-[350px] h-[350px] flex items-end justify-center rounded-full border-[3px] border-white/80 pb-6 z-0">
                <!-- Inner solid white circle -->
                <div class="w-[160px] h-[160px] bg-white rounded-full relative bottom-6 right-4"></div>
                <!-- Small brand dot on border -->
                <div
                    class="absolute top-[25%] left-[-15px] w-[35px] h-[35px] bg-gradient-to-br from-gray-700 to-gray-500 rounded-full shadow-lg z-10">
                </div>
            </div>

        </div>

        <!-- Right Side (Login Form) -->
        <div class="w-full lg:w-1/2 flex items-center justify-center relative bg-custom-gray px-6">
            <div class="w-full max-w-[420px]">

                <!-- Logo Block -->
                <div class="flex flex-col items-center mb-10">
                    <div class="p-2 bg-white/10 rounded-full border border-gray-200 shadow-sm mb-4">
                        <img src="{{ asset('newlogo.jfif') }}" alt="iBarangay Logo"
                            class="w-[85px] h-[85px] rounded-full object-cover">
                    </div>
                    <h2 class="text-[24px] font-medium tracking-tight text-gray-800">Welcome Back !</h2>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <!-- Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email field -->
                    <div>
                        <label for="email"
                            class="block text-[14px] font-semibold text-gray-600 mb-1.5 ml-1">Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-[18px] w-[18px] text-theme-primary"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                autofocus
                                class="pl-[42px] pr-4 py-[14px] block w-full border border-gray-200 rounded-lg text-sm bg-white placeholder-gray-300 focus:outline-none focus:ring-1 focus:ring-theme-primary focus:border-theme-primary shadow-sm transition-colors"
                                placeholder="Enter your email address" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password field -->
                    <div>
                        <label for="password"
                            class="block text-[14px] font-semibold text-gray-600 mb-1.5 ml-1">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-[18px] w-[18px] text-theme-primary"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input id="password" type="password" name="password" required
                                class="pl-[42px] pr-4 py-[14px] block w-full border border-gray-200 rounded-lg text-sm bg-white placeholder-gray-300 focus:outline-none focus:ring-1 focus:ring-theme-primary focus:border-theme-primary shadow-sm tracking-[0.2em] transition-colors"
                                placeholder="••••••••" />
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Checkbox & Link -->
                    <div class="flex items-center justify-between mt-5 mb-8 px-1">
                        <div class="flex items-center">
                            <input id="remember_me" type="checkbox" name="remember"
                                class="h-[14px] w-[14px] bg-white border-gray-300 rounded-sm text-theme-primary focus:ring-theme-primary cursor-pointer">
                            <label for="remember_me"
                                class="ml-2 block text-[13px] font-medium text-gray-700 cursor-pointer">
                                Remember me
                            </label>
                        </div>
                        @if (Route::has('password.request'))
                            <div class="text-[13px]">
                                <a href="{{ route('password.request') }}"
                                    class="font-medium text-theme-primary hover:text-black transition-colors underline-offset-2 hover:underline">
                                    Reset Password!
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Login Button -->
                    <div class="mt-8">
                        <button type="submit"
                            class="w-full flex justify-center py-[14px] px-4 border border-transparent rounded-lg text-[15px] font-medium text-white theme-primary hover:bg-[#1e293b] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-theme-primary transition-all btn-shadow">
                            Login
                        </button>
                    </div>
                </form>

                <!-- Footer Link -->
                <p class="mt-8 text-center text-[13px] text-gray-500 font-medium tracking-wide">
                    Powered by
                    <a href="https://treebyte.vercel.app/" target="_blank" rel="noopener noreferrer"
                        class="text-theme-primary hover:underline ml-1 font-semibold">
                        TreeByte Software Development Services
                    </a>
                </p>

            </div>
        </div>
    </div>
</body>

</html>
