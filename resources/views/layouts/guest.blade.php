<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'ClickMart') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-50">
        <div class="min-h-screen max-w-md mx-auto sm:max-w-xl bg-white flex flex-col pt-12 sm:pt-20 px-8 relative overflow-hidden shadow-xl sm:shadow-none sm:border sm:border-gray-100 sm:my-10 sm:rounded-3xl sm:min-h-[80vh]">
            
            <!-- Back button (mock) -->
            <a href="{{ route('home') }}" class="absolute top-6 left-6 h-10 w-10 rounded-full bg-white border border-gray-100 flex items-center justify-center shadow-sm text-gray-600 hover:bg-gray-50 z-10">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </a>

            <div class="flex-1 flex flex-col justify-center pb-20">
                <div class="mb-10 text-center">
                    <h1 class="font-display font-extrabold text-3xl text-gray-900 tracking-tight">ClickMart</h1>
                    <p class="text-sm font-medium text-gray-500 mt-2">Welcome! Please login or register to continue.</p>
                </div>

                <div class="w-full">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
