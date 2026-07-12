<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Store') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link rel="preconnect" href="https://api.fontshare.com">
        <link href="https://fonts.bunny.net/css?family=open-sans:300,400,500,600,700,800&display=swap" rel="stylesheet" />
        <link href="https://api.fontshare.com/v2/css?f[]=clash-display@400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased min-h-screen bg-[#f0f0ee] flex items-center justify-center px-4 py-6">

        <div class="w-full max-w-sm">
            <!-- Brand -->
            <div class="text-center mb-5">
                <a href="{{ route('home') }}" class="inline-flex items-center justify-center w-12 h-12 bg-[#1a1a1a] text-white rounded-xl shadow-lg hover:bg-gray-800 transition-all duration-300">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.986 3.51A9.004 9.004 0 0012 3.01C7.583 3.01 4.026 6.342 4.026 10.488c0 .714.143 1.39.394 2.017.136.344.04.699-.155.978-.492.701-1.616 2.15-1.616 2.15s2.44 1.073 3.754 1.302c.201.035.387.089.556.16a.796.796 0 00.36.07c.204 0 .398-.058.566-.153 1.11-.634 1.95-.868 2.515-.868.706 0 1.766.31 2.914.868a.8.8 0 00.565.153.766.766 0 00.36-.07c.17-.071.355-.125.556-.16 1.313-.23 3.754-1.303 3.754-1.303s-1.124-1.448-1.616-2.15c-.196-.279-.291-.634-.155-.978.252-.627.394-1.303.394-2.017 0-.81-.183-1.578-.507-2.26" />
                    </svg>
                </a>
            </div>

            <!-- Card -->
            <div class="bg-white rounded-2xl shadow-[0_0_0_1px_rgba(0,0,0,0.08),0_8px_24px_-4px_rgba(0,0,0,0.10)] p-6 sm:p-7">
                <div class="mb-5 text-center">
                    <h2 class="font-display font-bold text-xl text-[#1a1a1a] tracking-tight">
                        {{ $heading }}
                    </h2>
                    <p class="text-xs text-gray-400 font-medium mt-1.5">
                        {{ $subheading }}
                    </p>
                </div>

                <div class="w-full">
                    {{ $slot }}
                </div>
            </div>
        </div>

    </body>
</html>
