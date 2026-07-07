<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Heepzy') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800|outfit:400,500,600,700,800,900&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-[#f0f0ee]" style="zoom: 0.8;">
        <div class="min-h-screen flex items-center justify-center px-4 py-8">
            <div class="w-full max-w-md">
                <!-- Logo / Brand -->
                <div class="text-center mb-8">
                    <a href="{{ route('home') }}" class="font-display font-black text-4xl tracking-tighter text-[#1a1a1a]">
                        Heepzy<span class="text-gray-400 text-2xl relative -top-1.5">.</span>
                    </a>
                </div>

                <!-- Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100/50 p-8 sm:p-10">
                    <div class="mb-6 text-center">
                        <h2 class="font-display font-bold text-xl text-[#1a1a1a]">
                            {{ $heading }}
                        </h2>
                        <p class="text-sm font-medium text-gray-500 mt-1.5">
                            {{ $subheading }}
                        </p>
                    </div>

                    <div class="w-full">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
