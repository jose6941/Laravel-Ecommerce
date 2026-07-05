<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Breadcrumb -->
        <nav class="text-sm text-gray-500 mb-8">
            <ol class="list-none p-0 inline-flex">
                <li class="flex items-center">
                    <a href="{{ route('home') }}" class="hover:text-black transition">Account</a>
                    <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
                </li>
                <li class="flex items-center">
                    <a href="{{ route('produtos.index') }}" class="hover:text-black transition">{{ $produto->categoria->nome ?? 'Categoria' }}</a>
                    <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
                </li>
                <li>
                    <span class="text-black">{{ $produto->nome }}</span>
                </li>
            </ol>
        </nav>

        <div class="flex flex-col md:flex-row gap-12">
            
            <!-- Product Images (Left side) -->
            <div class="md:w-1/2 flex gap-4">
                <!-- Thumbnails (mock) -->
                <div class="hidden sm:flex flex-col gap-4 w-32 shrink-0">
                    <div class="bg-[#F5F5F5] rounded-xl aspect-square flex items-center justify-center p-2 cursor-pointer border-2 border-black">
                         @if ($produto->imagemPrincipal)
                            <img src="{{ $produto->imagemPrincipal->url }}" alt="{{ $produto->nome }}" class="max-h-full max-w-full object-contain mix-blend-multiply">
                        @endif
                    </div>
                    <!-- Mock additional thumbnails -->
                    <div class="bg-[#F5F5F5] rounded-xl aspect-square flex items-center justify-center p-2 cursor-pointer border border-transparent hover:border-gray-300">
                         @if ($produto->imagemPrincipal)
                            <img src="{{ $produto->imagemPrincipal->url }}" alt="{{ $produto->nome }}" class="max-h-full max-w-full object-contain mix-blend-multiply opacity-50">
                        @endif
                    </div>
                </div>

                <!-- Main Image -->
                <div class="flex-1 bg-[#F5F5F5] rounded-xl flex items-center justify-center p-8 aspect-square relative">
                    @if ($produto->imagemPrincipal)
                        <img src="{{ $produto->imagemPrincipal->url }}" alt="{{ $produto->nome }}" class="max-h-full max-w-full object-contain mix-blend-multiply drop-shadow-xl">
                    @else
                        <div class="text-gray-400">Sem imagem</div>
                    @endif
                    <button class="absolute top-4 right-4 text-black bg-white rounded-full p-2 shadow-sm hover:text-red-500 transition">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Product Details (Right side) -->
            <div class="md:w-1/2 flex flex-col justify-center">
                <h1 class="text-3xl font-display font-bold text-gray-900 mb-2">{{ $produto->nome }}</h1>
                
                <!-- Ratings -->
                <div class="flex items-center gap-4 mb-4">
                    <div class="flex items-center text-yellow-400">
                        @for ($i = 0; $i < 5; $i++)
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>
                    <span class="text-sm text-gray-400">(150 Reviews)</span>
                    <span class="text-gray-300">|</span>
                    <span class="text-sm text-emerald-500 font-medium">
                        {{ $produto->estoque > 0 ? 'In Stock' : 'Out of Stock' }}
                    </span>
                </div>

                <!-- Price -->
                <div class="text-2xl font-display text-gray-900 mb-6">
                    @if ($produto->preco_promocional)
                        R$ {{ number_format($produto->preco_promocional, 2, ',', '.') }}
                        <span class="text-lg text-gray-400 line-through ml-2">R$ {{ number_format($produto->preco, 2, ',', '.') }}</span>
                    @else
                        R$ {{ number_format($produto->preco, 2, ',', '.') }}
                    @endif
                </div>

                <!-- Description -->
                <p class="text-gray-600 text-sm mb-6 leading-relaxed">
                    {{ $produto->descricao ?: 'Produto de qualidade para o dia a dia. Confira as especificações e avaliações de outros clientes.' }}
                </p>

                <hr class="border-gray-200 mb-6">

                <!-- Mock Options (Colors) -->
                <div class="flex items-center gap-4 mb-6">
                    <span class="text-gray-900 font-medium w-16">Colours:</span>
                    <div class="flex gap-2">
                        <button class="w-6 h-6 rounded-full bg-blue-500 ring-2 ring-offset-2 ring-black focus:outline-none"></button>
                        <button class="w-6 h-6 rounded-full bg-red-500 hover:ring-2 ring-offset-2 ring-black focus:outline-none transition"></button>
                        <button class="w-6 h-6 rounded-full bg-gray-900 hover:ring-2 ring-offset-2 ring-black focus:outline-none transition"></button>
                    </div>
                </div>

                <!-- Mock Options (Sizes) -->
                <div class="flex items-center gap-4 mb-8">
                    <span class="text-gray-900 font-medium w-16">Size:</span>
                    <div class="flex gap-3">
                        <button class="w-10 h-8 rounded border border-gray-300 text-sm font-medium hover:bg-black hover:text-white hover:border-black transition">XS</button>
                        <button class="w-10 h-8 rounded border border-gray-300 text-sm font-medium hover:bg-black hover:text-white hover:border-black transition">S</button>
                        <button class="w-10 h-8 rounded bg-black text-white border border-black text-sm font-medium">M</button>
                        <button class="w-10 h-8 rounded border border-gray-300 text-sm font-medium hover:bg-black hover:text-white hover:border-black transition">L</button>
                        <button class="w-10 h-8 rounded border border-gray-300 text-sm font-medium hover:bg-black hover:text-white hover:border-black transition">XL</button>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center gap-4 mb-8">
                    <!-- Quantity Control -->
                    <div x-data="{ count: 1 }" class="flex items-center border border-gray-300 rounded h-12">
                        <button @click="count = Math.max(1, count - 1)" class="w-10 h-full flex items-center justify-center hover:bg-black hover:text-white transition rounded-l border-r border-gray-300 text-xl font-medium">-</button>
                        <input type="text" x-model="count" class="w-14 h-full border-none text-center focus:ring-0 font-medium text-lg" readonly>
                        <button @click="count++" class="w-10 h-full flex items-center justify-center bg-black text-white hover:bg-gray-800 transition rounded-r border-l border-gray-300 text-xl font-medium">+</button>
                    </div>
                    
                    <!-- Add to Cart Form -->
                    <form method="POST" action="{{ route('carrinho.store', $produto) }}" class="flex-1">
                        @csrf
                        <input type="hidden" name="quantidade" value="1" x-bind:value="count">
                        <button type="submit" class="w-full h-12 bg-black text-white rounded font-medium hover:bg-gray-800 transition px-8 flex items-center justify-center">
                            Add To Cart
                        </button>
                    </form>
                </div>
                
                <!-- Delivery Info Mock -->
                <div class="border border-gray-300 rounded divide-y divide-gray-300">
                    <div class="flex items-center gap-4 p-4">
                        <svg class="w-8 h-8 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/></svg>
                        <div>
                            <h4 class="font-medium text-gray-900">Free Delivery</h4>
                            <p class="text-xs text-gray-500 mt-1"><a href="#" class="underline">Enter your postal code for Delivery Availability</a></p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 p-4">
                        <svg class="w-8 h-8 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        <div>
                            <h4 class="font-medium text-gray-900">Return Delivery</h4>
                            <p class="text-xs text-gray-500 mt-1">Free 30 Days Delivery Returns. <a href="#" class="underline">Details</a></p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        
    </div>
</x-app-layout>
