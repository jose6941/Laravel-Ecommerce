<x-app-layout>
    <div class="bg-gray-50 min-h-screen pb-24">
        
        <!-- Top Header -->
        <div class="px-6 py-4 flex items-center justify-between sticky top-0 bg-gray-50/90 backdrop-blur z-20">
            <a href="{{ route('home') }}" class="h-10 w-10 rounded-full bg-white border border-gray-100 flex items-center justify-center shadow-sm text-gray-600 hover:bg-gray-50">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 class="font-display font-bold text-lg text-gray-900">
                Cart ({{ $carrinho ? $carrinho->itens->count() : 0 }})
            </h1>
            <button class="h-10 w-10 flex items-center justify-center text-gray-600 hover:text-black">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </button>
        </div>

        <div class="max-w-md mx-auto sm:max-w-xl px-6 pt-2">
            
            @if (! $carrinho || $carrinho->itens->isEmpty())
                <div class="bg-white border border-gray-100 shadow-sm rounded-3xl p-12 text-center mt-6">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-gray-50 text-gray-400 mb-4">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <p class="text-gray-900 font-bold text-lg">Your cart is empty.</p>
                    <p class="text-gray-500 text-sm mt-1 mb-6">Explore our products and add them to your cart.</p>
                    <a href="{{ route('produtos.index') }}" class="inline-block bg-black text-white px-6 py-3 rounded-full font-semibold text-sm hover:bg-gray-800 transition shadow-md">
                        Shop Now
                    </a>
                </div>
            @else
                <div class="space-y-4">
                    @foreach ($carrinho->itens as $item)
                        <div class="bg-white rounded-3xl p-4 flex gap-4 shadow-sm border border-gray-100 items-center relative group">
                            <!-- Image -->
                            <div class="h-24 w-24 shrink-0 rounded-2xl bg-[#F5F5F5] overflow-hidden">
                                @if ($item->produto?->imagemPrincipal)
                                    <img src="{{ $item->produto->imagemPrincipal->url }}" alt="{{ $item->produto->nome }}" class="h-full w-full object-cover mix-blend-multiply">
                                @endif
                            </div>

                            <!-- Info -->
                            <div class="flex-1 min-w-0 py-1">
                                <h3 class="font-bold text-gray-900 truncate pr-6">{{ $item->produto->nome }}</h3>
                                <p class="text-xs text-gray-500 mt-0.5">Color: Black</p> <!-- Mocked color -->
                                
                                <div class="mt-3 flex items-center justify-between">
                                    <p class="font-bold text-lg text-gray-900">
                                        R$ {{ number_format($item->preco_unitario, 2, ',', '.') }}
                                    </p>
                                    
                                    <!-- Quantity -->
                                    <div class="flex items-center gap-3 bg-gray-50 rounded-full px-2 py-1 border border-gray-100">
                                        <form method="POST" action="{{ route('carrinho.update', $item) }}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="quantidade" value="{{ max(1, $item->quantidade - 1) }}">
                                            <button type="submit" class="w-6 h-6 flex items-center justify-center text-gray-500 hover:text-black hover:bg-white rounded-full transition">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4" /></svg>
                                            </button>
                                        </form>
                                        
                                        <span class="font-semibold text-sm w-4 text-center">{{ $item->quantidade }}</span>
                                        
                                        <form method="POST" action="{{ route('carrinho.update', $item) }}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="quantidade" value="{{ $item->quantidade + 1 }}">
                                            <button type="submit" class="w-6 h-6 flex items-center justify-center text-gray-500 hover:text-black hover:bg-white rounded-full transition">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Remove Button -->
                            <form method="POST" action="{{ route('carrinho.destroy', $item) }}" class="absolute top-4 right-4">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-400 hover:text-red-500 transition">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.158-3.21c-1.33-.21-2.67-.39-4.01-.54m-4.01.54c-1.34.15-2.68.33-4.01.54m0 0C7.13 5.37 6.5 5.56 5.88 5.77m10.15-1.5a2.25 2.25 0 00-4.05 0" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>

        @if ($carrinho && $carrinho->itens->isNotEmpty())
            <!-- Fixed Bottom Checkout -->
            <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-100 p-4 sm:p-6 z-50 flex items-center justify-between gap-4 rounded-t-3xl shadow-[0_-4px_20px_-10px_rgba(0,0,0,0.1)]">
                <div class="hidden sm:block">
                    <p class="text-xs text-gray-500 font-medium">Subtotal</p>
                    <p class="font-display font-bold text-xl text-gray-900">
                        R$ {{ number_format($carrinho->itens->sum(fn ($i) => $i->preco_unitario * $i->quantidade), 2, ',', '.') }}
                    </p>
                </div>
                
                @auth
                    <a href="{{ route('checkout.index') }}" class="flex-1 bg-black text-white rounded-full py-4 text-center font-semibold text-sm hover:bg-gray-800 transition shadow-lg shadow-gray-400/20">
                        Checkout ({{ $carrinho->itens->count() }}) - R$ {{ number_format($carrinho->itens->sum(fn ($i) => $i->preco_unitario * $i->quantidade), 2, ',', '.') }}
                    </a>
                @else
                    <a href="{{ route('login') }}" class="flex-1 bg-black text-white rounded-full py-4 text-center font-semibold text-sm hover:bg-gray-800 transition shadow-lg shadow-gray-400/20">
                        Login para Checkout
                    </a>
                @endauth
            </div>
        @endif
    </div>
</x-app-layout>
