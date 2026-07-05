<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'ClickMart') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800|poppins:500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Alpine Plugins -->
        <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        
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
    <body class="font-sans text-gray-900 antialiased bg-[#f8f9fa] selection:bg-black selection:text-white">
        
        <!-- Top Banner / Notice -->
        <div class="bg-black text-white text-xs text-center py-2 px-4 sm:flex sm:justify-between sm:items-center">
            <div class="max-w-7xl mx-auto w-full flex justify-between items-center">
                <span class="hidden sm:inline">Summer Sale For All Swim Suits And Free Express Delivery - OFF 50%! <a href="#" class="font-bold underline ml-1">Shop Now</a></span>
                <span class="sm:hidden text-center w-full">Summer Sale - 50% OFF!</span>
                <div class="hidden sm:flex items-center gap-4">
                    <a href="#" class="hover:text-gray-300">English</a>
                </div>
            </div>
        </div>

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
            <main class="flex-grow pt-4 pb-12 w-full">
                {{ $slot }}
            </main>
            
            <!-- Simple Footer -->
            <footer class="bg-black text-white py-12 mt-auto">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div>
                        <h3 class="text-xl font-bold mb-4">ClickMart</h3>
                        <p class="text-gray-400 text-sm">A melhor loja para suas compras online.</p>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-4">Suporte</h4>
                        <ul class="space-y-2 text-sm text-gray-400">
                            <li><a href="#" class="hover:text-white">Central de Ajuda</a></li>
                            <li><a href="#" class="hover:text-white">Opções de Entrega</a></li>
                            <li><a href="#" class="hover:text-white">Devoluções</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-4">Conta</h4>
                        <ul class="space-y-2 text-sm text-gray-400">
                            <li><a href="{{ route('profile.edit') }}" class="hover:text-white">Minha Conta</a></li>
                            <li><a href="{{ route('carrinho.index') }}" class="hover:text-white">Carrinho</a></li>
                            <li><a href="{{ route('produtos.index') }}" class="hover:text-white">Lista de Desejos</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-4">Baixe o App</h4>
                        <div class="flex gap-2">
                            <div class="w-32 h-10 bg-gray-800 rounded flex items-center justify-center text-xs border border-gray-700">App Store</div>
                            <div class="w-32 h-10 bg-gray-800 rounded flex items-center justify-center text-xs border border-gray-700">Google Play</div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>