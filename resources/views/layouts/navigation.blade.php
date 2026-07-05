<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 sticky top-0 z-40 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            
            <!-- Logo & Links -->
            <div class="flex items-center gap-12">
                <a href="{{ route('home') }}" class="font-display font-extrabold text-2xl tracking-tight text-black">
                    ClickMart
                </a>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-sm font-medium {{ request()->routeIs('home') ? 'text-black font-semibold' : 'text-gray-500 hover:text-black' }}">Home</a>
                    <a href="{{ route('produtos.index') }}" class="text-sm font-medium {{ request()->routeIs('produtos.*') ? 'text-black font-semibold' : 'text-gray-500 hover:text-black' }}">Contact</a>
                    <a href="#" class="text-sm font-medium text-gray-500 hover:text-black">About</a>
                    @guest
                        <a href="{{ route('register') }}" class="text-sm font-medium text-gray-500 hover:text-black">Sign Up</a>
                    @endguest
                </div>
            </div>

            <!-- Search & Actions -->
            <div class="flex items-center gap-6">
                
                <!-- Search Bar (Desktop) -->
                <div class="hidden md:block relative w-64">
                    <input type="text" placeholder="What are you looking for?" class="w-full bg-[#F5F5F5] border-none rounded-md py-2.5 pl-4 pr-10 text-sm focus:ring-1 focus:ring-black placeholder-gray-400">
                    <button class="absolute inset-y-0 right-0 flex items-center pr-3">
                        <svg class="w-5 h-5 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </div>

                <div class="flex items-center gap-4">
                    <!-- Wishlist / Heart -->
                    <a href="{{ route('produtos.index') }}" class="text-black hover:text-gray-600 transition">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </a>

                    <!-- Cart -->
                    <a href="{{ route('carrinho.index') }}" class="text-black hover:text-gray-600 transition relative">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 0a2 2 0 100 4 2 2 0 000-4z" />
                        </svg>
                        @if(isset($quantidadeCarrinho) && $quantidadeCarrinho > 0)
                            <span class="absolute -top-1.5 -right-2 bg-red-500 text-white text-[10px] font-bold h-4 w-4 flex items-center justify-center rounded-full">
                                {{ $quantidadeCarrinho }}
                            </span>
                        @endif
                    </a>

                    <!-- User Profile Dropdown -->
                    @auth
                        <div x-data="{ dropdownOpen: false }" class="relative">
                            <button @click="dropdownOpen = !dropdownOpen" class="flex items-center justify-center h-8 w-8 rounded-full bg-red-500 text-white hover:bg-red-600 transition focus:outline-none">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </button>

                            <div x-show="dropdownOpen" @click.away="dropdownOpen = false" class="absolute right-0 mt-2 w-48 bg-gray-900/90 backdrop-blur-md rounded-md shadow-lg py-1 z-50 text-white" style="display: none;">
                                @if (Auth::user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm hover:bg-gray-700">Painel Admin</a>
                                @endif
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm hover:bg-gray-700">Meu Perfil</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-700">Sair</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-black hover:text-gray-600 transition">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <button @click="open = ! open" class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu (Hidden by default) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden border-t border-gray-100 bg-white">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('home') }}" class="block px-4 py-2 text-base font-medium text-gray-700 hover:bg-gray-50">Home</a>
            <a href="{{ route('produtos.index') }}" class="block px-4 py-2 text-base font-medium text-gray-700 hover:bg-gray-50">Contact</a>
            <a href="#" class="block px-4 py-2 text-base font-medium text-gray-700 hover:bg-gray-50">About</a>
        </div>
    </div>
</nav>
