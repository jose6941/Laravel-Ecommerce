<nav x-data="{ open: false, scrolled: false }" x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 10 })"
     :class="scrolled ? 'shadow-md border-b border-transparent bg-white/95 backdrop-blur-md' : 'shadow-none border-b border-gray-100 bg-white'"
     class="sticky top-0 z-40 text-dark transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-[5.5rem]">
            
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('home') }}" class="font-display font-black text-3xl tracking-tighter text-[#1a1a1a]">
                    Heepzy<span class="text-gray-400 text-xl relative -top-2">.</span>
                </a>
            </div>

            <!-- Centered Links (Desktop) -->
            <div class="hidden md:flex items-center justify-center flex-1 space-x-10">
                <a href="{{ route('home') }}" class="nav-link relative text-xs font-bold tracking-[0.15em] uppercase pb-1 transition {{ request()->routeIs('home') ? 'text-[#1a1a1a] nav-link-active' : 'text-gray-500 hover:text-[#1a1a1a]' }}">Home</a>
                <a href="{{ route('produtos.index') }}" class="nav-link relative text-xs font-bold tracking-[0.15em] uppercase pb-1 transition {{ request()->routeIs('produtos.*') ? 'text-[#1a1a1a] nav-link-active' : 'text-gray-500 hover:text-[#1a1a1a]' }}">Produtos</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="nav-link relative text-xs font-bold tracking-[0.15em] uppercase pb-1 transition {{ request()->routeIs('dashboard') || request()->routeIs('admin.dashboard') ? 'text-[#1a1a1a] nav-link-active' : 'text-gray-500 hover:text-[#1a1a1a]' }}">Painel</a>
                @endauth
            </div>

            <!-- Actions (Right) -->
            <div class="flex items-center gap-5">
                <!-- Cart Icon with Badge -->
                <a href="{{ route('carrinho.index') }}" class="relative flex items-center justify-center w-11 h-11 rounded-full border-2 border-[#1a1a1a]/20 hover:bg-gray-100 hover:border-[#1a1a1a]/50 transition-all duration-300 group">
                    <svg class="w-5 h-5 text-[#1a1a1a]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    </svg>
                    @if(($quantidadeCarrinho ?? 0) > 0)
                        <span class="absolute -top-1.5 -right-1.5 bg-[#1a1a1a] text-white text-[9px] font-bold w-[18px] h-[18px] rounded-full flex items-center justify-center shadow-sm">
                            {{ min($quantidadeCarrinho, 99) }}
                        </span>
                    @endif
                </a>

                <!-- User Profile / Login -->
                @auth
                    <div x-data="{ dropdownOpen: false }" class="relative">
                        <button @click="dropdownOpen = !dropdownOpen" class="flex items-center justify-center h-10 w-10 rounded-full border-2 border-[#1a1a1a]/20 text-dark hover:bg-gray-100 hover:border-[#1a1a1a]/50 transition-all duration-300 focus:outline-none">
                            <span class="text-xs font-bold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        </button>

                        <div x-show="dropdownOpen" @click.away="dropdownOpen = false" class="absolute right-0 mt-2 w-48 bg-white border border-gray-100 rounded-2xl shadow-xl py-1 z-50 text-dark overflow-hidden" style="display: none;">
                            @if (Auth::user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm hover:bg-gray-50">Painel Admin</a>
                            @endif
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm hover:bg-gray-50">Meu Perfil</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-50">Sair</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="hidden md:inline-flex items-center justify-center px-5 py-2.5 text-xs font-bold tracking-[0.15em] uppercase text-[#1a1a1a] hover:bg-[#1a1a1a] hover:text-white hover:shadow-lg transition-all duration-300 border-2 border-[#1a1a1a] rounded-full">
                        LOGIN
                    </a>
                @endauth

                <!-- Mobile menu button -->
                <button @click="open = ! open" class="md:hidden text-dark focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <style>
        .nav-link::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -2px;
            width: 100%;
            height: 2px;
            background-color: #1a1a1a;
            transform: scaleX(0);
            transform-origin: right;
            transition: transform 0.3s ease;
        }
        .nav-link:hover::after,
        .nav-link-active::after {
            transform: scaleX(1);
            transform-origin: left;
        }
    </style>

    <!-- Mobile Menu -->
    <div x-show="open" class="md:hidden border-t border-gray-100 bg-white" style="display: none;">
        <div class="pt-2 pb-4 space-y-1 px-4">
            <a href="{{ route('home') }}" class="block px-2 py-3 text-base font-medium {{ request()->routeIs('home') ? 'text-dark' : 'text-gray-500' }} border-b border-gray-50">Home</a>
            <a href="{{ route('produtos.index') }}" class="block px-2 py-3 text-base font-medium {{ request()->routeIs('produtos.*') ? 'text-dark' : 'text-gray-500' }} border-b border-gray-50">Produtos</a>
            @auth
                <a href="{{ route('dashboard') }}" class="block px-2 py-3 text-base font-medium text-gray-500 border-b border-gray-50">Painel do Usuário</a>
            @endauth
            @guest
                <a href="{{ route('login') }}" class="block px-2 py-3 text-base font-bold text-[#1a1a1a] mt-2">Login / Cadastro</a>
            @endguest
        </div>
    </div>
</nav>