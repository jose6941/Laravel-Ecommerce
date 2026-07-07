<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'ClickMart') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800|outfit:400,500,600,700,800,900&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Alpine Plugins -->
        <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <!-- GSAP is loaded via npm in resources/js/app.js -->
        
        <style>
            .no-scrollbar::-webkit-scrollbar {
                display: none;
            }
            .no-scrollbar {
                -ms-overflow-style: none;
                scrollbar-width: none;
            }
        </style>
    </head>
    <body class="font-sans text-dark antialiased bg-white selection:bg-primary selection:text-dark" style="zoom: 0.8;">
        
        <div class="min-h-screen flex flex-col">
            
            <!-- Top Navigation -->
            @include('layouts.navigation')

            <!-- Flash messages -->
            @if (session('success'))
                <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 mt-4 relative z-50">
                    <div class="flex items-center gap-2 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl px-4 py-3 text-sm font-medium shadow-sm">
                        <svg class="h-5 w-5 shrink-0 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0Z" />
                        </svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 mt-4 relative z-50">
                    <div class="flex items-center gap-2 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl px-4 py-3 text-sm font-medium shadow-sm">
                        <svg class="h-5 w-5 shrink-0 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                        </svg>
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            <!-- Page Content -->
            <main class="flex-grow w-full">
                {{ $slot }}
            </main>
            
            <!-- Simple Footer -->
            <footer class="bg-dark text-white py-16 mt-auto">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-8 border-b border-gray-800 pb-12 mb-8">
                        <div class="md:col-span-2">
                            <h3 class="text-3xl font-display font-bold mb-4 tracking-tight">Heepzy<br><span class="text-primary text-xl">S N E A K E R S</span></h3>
                            <p class="text-gray-400 text-sm mb-6 max-w-xs">Built for every move, every mood. Experience the ultimate comfort and style.</p>
                            <div class="flex gap-4">
                                <a href="#" class="w-10 h-10 rounded-full bg-gray-900 flex items-center justify-center hover:bg-primary hover:text-dark transition">F</a>
                                <a href="#" class="w-10 h-10 rounded-full bg-gray-900 flex items-center justify-center hover:bg-primary hover:text-dark transition">T</a>
                                <a href="#" class="w-10 h-10 rounded-full bg-gray-900 flex items-center justify-center hover:bg-primary hover:text-dark transition">I</a>
                            </div>
                        </div>
                        <div>
                            <h4 class="font-semibold text-sm tracking-wider uppercase text-gray-500 mb-4">Shop</h4>
                            <ul class="space-y-3 text-sm text-gray-300">
                                <li><a href="#" class="hover:text-primary transition">All Sneakers</a></li>
                                <li><a href="#" class="hover:text-primary transition">Best Sellers</a></li>
                                <li><a href="#" class="hover:text-primary transition">New Arrivals</a></li>
                                <li><a href="#" class="hover:text-primary transition">Collections</a></li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-semibold text-sm tracking-wider uppercase text-gray-500 mb-4">Company</h4>
                            <ul class="space-y-3 text-sm text-gray-300">
                                <li><a href="#" class="hover:text-primary transition">Our Story</a></li>
                                <li><a href="#" class="hover:text-primary transition">Careers</a></li>
                                <li><a href="#" class="hover:text-primary transition">Sustainability</a></li>
                                <li><a href="#" class="hover:text-primary transition">Press</a></li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-semibold text-sm tracking-wider uppercase text-gray-500 mb-4">Newsletter</h4>
                            <p class="text-xs text-gray-400 mb-4">Get updates on new drops & offers.</p>
                            <form class="flex border border-gray-700 rounded overflow-hidden focus-within:border-primary transition">
                                <input type="email" placeholder="Enter your email" class="bg-transparent border-none text-sm px-4 py-2 w-full focus:ring-0 text-white placeholder-gray-500">
                                <button type="submit" class="px-4 text-primary hover:text-white transition">→</button>
                            </form>
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row justify-between items-center text-xs text-gray-500">
                        <p>&copy; 2024 Heepzy Sneakers. All rights reserved.</p>
                        <div class="flex gap-4 mt-4 md:mt-0">
                            <a href="#" class="hover:text-white transition">Privacy Policy</a>
                            <a href="#" class="hover:text-white transition">Terms of Service</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>