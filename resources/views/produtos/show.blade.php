<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <!-- Breadcrumb -->
        <nav class="text-xs font-bold text-gray-400 tracking-widest uppercase mb-10">
            <ol class="list-none p-0 inline-flex items-center">
                <li><a href="{{ route('home') }}" class="hover:text-dark transition">Home</a></li>
                <li class="mx-3 text-gray-300">/</li>
                <li><a href="{{ route('produtos.index') }}" class="hover:text-dark transition">{{ $produto->categoria->nome ?? 'Sneakers' }}</a></li>
                <li class="mx-3 text-gray-300">/</li>
                <li class="text-dark">{{ $produto->nome }}</li>
            </ol>
        </nav>

        <div class="flex flex-col lg:flex-row gap-16 items-start">
            
            <!-- Product Images (Left side) -->
            <div class="lg:w-1/2 flex flex-col-reverse md:flex-row gap-6 w-full gsap-hero-image">
                <!-- Thumbnails -->
                <div class="flex md:flex-col gap-4 overflow-x-auto no-scrollbar md:w-24 shrink-0">
                    <div class="bg-gray-50 rounded-2xl aspect-square flex items-center justify-center p-2 cursor-pointer border-2 border-dark">
                         @if ($produto->imagemPrincipal)
                            <img src="{{ $produto->imagemPrincipal->url }}" alt="{{ $produto->nome }}" class="max-h-full max-w-full object-contain">
                        @endif
                    </div>
                    <!-- Mock additional thumbnails -->
                    <div class="bg-gray-50 rounded-2xl aspect-square flex items-center justify-center p-2 cursor-pointer border-2 border-transparent hover:border-gray-200 transition">
                         @if ($produto->imagemPrincipal)
                            <img src="{{ $produto->imagemPrincipal->url }}" alt="{{ $produto->nome }}" class="max-h-full max-w-full object-contain opacity-60">
                        @endif
                    </div>
                    <div class="bg-gray-50 rounded-2xl aspect-square flex items-center justify-center p-2 cursor-pointer border-2 border-transparent hover:border-gray-200 transition">
                         @if ($produto->imagemPrincipal)
                            <img src="{{ $produto->imagemPrincipal->url }}" alt="{{ $produto->nome }}" class="max-h-full max-w-full object-contain opacity-60">
                        @endif
                    </div>
                </div>

                <!-- Main Image -->
                <div class="flex-1 bg-gray-50 rounded-3xl flex items-center justify-center p-12 aspect-square relative group overflow-hidden">
                    @if ($produto->imagemPrincipal)
                        <img src="{{ $produto->imagemPrincipal->url }}" alt="{{ $produto->nome }}" class="max-h-full max-w-full object-contain drop-shadow-2xl group-hover:scale-105 transition-transform duration-500 ease-out">
                    @else
                        <div class="text-gray-300 font-medium">Sem imagem</div>
                    @endif
                    
                    <button class="absolute top-6 right-6 w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-md text-gray-400 hover:text-primary hover:bg-dark transition-all">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Product Details (Right side) -->
            <div class="lg:w-1/2 flex flex-col justify-center max-w-lg">
                <div class="flex items-center gap-3 mb-4 gsap-hero-text">
                    <span class="bg-primary text-dark text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide">
                        {{ $produto->estoque > 0 ? 'In Stock' : 'Out of Stock' }}
                    </span>
                    <div class="flex items-center gap-1 text-sm font-medium">
                        <svg class="w-4 h-4 text-dark fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        4.8 <span class="text-gray-400 font-normal ml-1">(150 Reviews)</span>
                    </div>
                </div>

                <h1 class="text-4xl lg:text-5xl font-display font-bold text-dark mb-4 leading-tight gsap-hero-text">{{ $produto->nome }}</h1>
                
                <!-- Price -->
                <div class="text-3xl font-bold text-dark mb-8 flex items-end gap-3 gsap-hero-text">
                    @if ($produto->preco_promocional)
                        R$ {{ number_format($produto->preco_promocional, 2, ',', '.') }}
                        <span class="text-xl text-gray-400 line-through font-medium mb-1">R$ {{ number_format($produto->preco, 2, ',', '.') }}</span>
                    @else
                        R$ {{ number_format($produto->preco, 2, ',', '.') }}
                    @endif
                </div>

                <!-- Description -->
                <p class="text-gray-500 text-sm mb-10 leading-relaxed gsap-hero-text">
                    {{ $produto->descricao ?: 'Engineered for everyday comfort and style. Featuring breathable materials, lightweight cushioning, and a durable outsole to keep you moving.' }}
                </p>

                <!-- Options -->
                <div class="space-y-8 mb-10 gsap-hero-text">
                    <!-- Sizes -->
                    <div>
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-sm font-bold text-dark uppercase tracking-wide">Select Size</span>
                            <a href="#" class="text-xs text-gray-400 underline hover:text-dark">Size Guide</a>
                        </div>
                        <div class="grid grid-cols-5 gap-3">
                            <button class="h-12 rounded-xl border border-gray-200 text-sm font-medium text-gray-600 hover:border-dark hover:text-dark transition">US 7</button>
                            <button class="h-12 rounded-xl border border-gray-200 text-sm font-medium text-gray-600 hover:border-dark hover:text-dark transition">US 8</button>
                            <button class="h-12 rounded-xl bg-dark text-white border border-dark text-sm font-medium shadow-lg">US 9</button>
                            <button class="h-12 rounded-xl border border-gray-200 text-sm font-medium text-gray-600 hover:border-dark hover:text-dark transition">US 10</button>
                            <button class="h-12 rounded-xl border border-gray-200 text-sm font-medium text-gray-600 hover:border-dark hover:text-dark transition">US 11</button>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row items-center gap-4 mb-10 gsap-hero-text">
                    <!-- Quantity Control -->
                    <div x-data="{ count: 1 }" class="flex items-center bg-gray-50 rounded-full h-14 px-2 w-full sm:w-auto shrink-0">
                        <button @click="count = Math.max(1, count - 1)" class="w-10 h-10 rounded-full flex items-center justify-center hover:bg-white hover:shadow transition text-xl font-medium">-</button>
                        <input type="text" x-model="count" class="w-12 h-full border-none bg-transparent text-center focus:ring-0 font-bold text-lg" readonly>
                        <button @click="count++" class="w-10 h-10 rounded-full flex items-center justify-center bg-white shadow-sm hover:shadow-md transition text-xl font-medium">+</button>
                    </div>
                    
                    <!-- Add to Cart Form -->
                    <form method="POST" action="{{ route('carrinho.store', $produto) }}" class="flex-1 w-full">
                        @csrf
                        <input type="hidden" name="quantidade" value="1" x-bind:value="count">
                        <button type="submit" class="w-full h-14 bg-primary text-dark rounded-full font-bold text-lg hover:bg-dark hover:text-white transition-all shadow-[0_0_20px_rgba(226,232,240,0.5)] hover:shadow-xl flex items-center justify-center gap-2 group">
                            Add To Cart
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>
                    </form>
                </div>
                
                <!-- Features List -->
                <div class="border border-gray-100 rounded-3xl p-6 bg-gray-50/50 space-y-4 gsap-hero-text">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center shrink-0 shadow-sm">
                            <svg class="w-5 h-5 text-dark" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm text-dark mb-1">Free & Fast Delivery</h4>
                            <p class="text-xs text-gray-500">Enter postal code for Delivery Availability</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center shrink-0 shadow-sm">
                            <svg class="w-5 h-5 text-dark" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm text-dark mb-1">Return Delivery</h4>
                            <p class="text-xs text-gray-500">Free 30 Days Delivery Returns.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        
    </div>

    <!-- GSAP Initialization -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof gsap !== 'undefined') {
                gsap.from('.gsap-hero-text', {
                    y: 30,
                    opacity: 0,
                    duration: 0.8,
                    stagger: 0.1,
                    ease: 'power3.out',
                    delay: 0.1
                });
                
                gsap.from('.gsap-hero-image', {
                    scale: 0.95,
                    opacity: 0,
                    duration: 1,
                    ease: 'power3.out',
                    delay: 0.2
                });
            }
        });
    </script>
</x-app-layout>
