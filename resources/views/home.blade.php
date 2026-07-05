<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
        
        <div class="flex flex-col md:flex-row gap-8">
            
            <!-- Sidebar Categories -->
            <div class="hidden md:block w-64 shrink-0 border-r border-gray-200 pr-4 pt-4">
                <h3 class="font-bold text-gray-900 mb-4 px-2">Categorias</h3>
                <ul class="space-y-1">
                    @foreach ($categorias as $categoria)
                        <li>
                            <a href="{{ route('produtos.index', ['categoria' => $categoria->slug]) }}" class="flex items-center justify-between px-2 py-2 text-sm text-gray-600 hover:text-black hover:bg-gray-100 rounded-md transition">
                                {{ $categoria->nome }}
                                <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </li>
                    @endforeach
                    <!-- Mock categories to fill space like reference image -->
                    <li><a href="#" class="flex items-center justify-between px-2 py-2 text-sm text-gray-600 hover:text-black hover:bg-gray-100 rounded-md transition">Woman's Fashion <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg></a></li>
                    <li><a href="#" class="flex items-center justify-between px-2 py-2 text-sm text-gray-600 hover:text-black hover:bg-gray-100 rounded-md transition">Men's Fashion <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg></a></li>
                    <li><a href="#" class="flex items-center justify-between px-2 py-2 text-sm text-gray-600 hover:text-black hover:bg-gray-100 rounded-md transition">Electronics</a></li>
                    <li><a href="#" class="flex items-center justify-between px-2 py-2 text-sm text-gray-600 hover:text-black hover:bg-gray-100 rounded-md transition">Home & Lifestyle</a></li>
                    <li><a href="#" class="flex items-center justify-between px-2 py-2 text-sm text-gray-600 hover:text-black hover:bg-gray-100 rounded-md transition">Sports & Outdoor</a></li>
                </ul>
            </div>

            <!-- Main Content Area -->
            <div class="flex-1 overflow-hidden pt-4">
                
                <!-- Hero Carousel -->
                @if ($produtosDestaque->isNotEmpty())
                    <div x-data="{
                        activeSlide: 0,
                        slides: {{ $produtosDestaque->take(3)->map(function($p) {
                            return [
                                'id' => $p->id,
                                'nome' => $p->nome,
                                'url' => route('produtos.show', $p),
                                'imagem' => $p->imagemPrincipal ? $p->imagemPrincipal->url : null
                            ];
                        })->toJson() }},
                        next() { this.activeSlide = this.activeSlide === this.slides.length - 1 ? 0 : this.activeSlide + 1; },
                        prev() { this.activeSlide = this.activeSlide === 0 ? this.slides.length - 1 : this.activeSlide - 1; },
                        start() { setInterval(() => { this.next() }, 5000); }
                    }" x-init="start()" class="relative bg-black text-white rounded-none sm:rounded-xl overflow-hidden shadow-lg flex items-center h-64 sm:h-80 md:h-[400px]">
                        
                        <template x-for="(slide, index) in slides" :key="slide.id">
                            <div x-show="activeSlide === index" 
                                 x-transition:enter="transition ease-out duration-500" 
                                 x-transition:enter-start="opacity-0 translate-x-full" 
                                 x-transition:enter-end="opacity-100 translate-x-0"
                                 x-transition:leave="transition ease-in duration-500 absolute inset-0"
                                 x-transition:leave-start="opacity-100 translate-x-0" 
                                 x-transition:leave-end="opacity-0 -translate-x-full"
                                 class="w-full h-full flex flex-col md:flex-row items-center justify-between px-10 py-8">
                                
                                <div class="md:w-1/2 z-10">
                                    <div class="flex items-center gap-2 mb-4">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10 10-4.486 10-10S17.514 2 12 2zm0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8z"/><path d="M13 7h-2v5.414l3.293 3.293 1.414-1.414L13 11.586z"/></svg>
                                        <span class="font-medium text-sm">Oferta Especial</span>
                                    </div>
                                    <h2 class="text-3xl md:text-5xl font-bold leading-tight mb-6" x-text="slide.nome"></h2>
                                    <a :href="slide.url" class="inline-flex items-center gap-2 text-white border-b border-white pb-1 hover:text-gray-300 hover:border-gray-300 transition">
                                        Shop Now 
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                    </a>
                                </div>
                                
                                <div class="md:w-1/2 h-full flex items-center justify-center p-4">
                                    <img x-show="slide.imagem" :src="slide.imagem" alt="Produto" class="max-h-full max-w-full object-contain filter drop-shadow-2xl">
                                </div>
                            </div>
                        </template>

                        <!-- Dots -->
                        <div class="absolute bottom-4 left-0 right-0 flex justify-center gap-2 z-20">
                            <template x-for="(slide, index) in slides" :key="'dot-'+slide.id">
                                <button @click="activeSlide = index" :class="activeSlide === index ? 'bg-red-500 border-red-500' : 'bg-gray-500 border-gray-500'" class="w-3 h-3 rounded-full border-2 hover:bg-red-400 transition"></button>
                            </template>
                        </div>
                    </div>
                @endif

                <!-- Flash Sales Section -->
                <div class="mt-16 mb-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-4 h-8 bg-red-500 rounded-sm"></div>
                        <h2 class="text-red-500 font-bold text-sm">Today's</h2>
                    </div>
                    
                    <div class="flex items-end justify-between mb-8">
                        <h3 class="text-3xl font-bold tracking-tight">Flash Sales</h3>
                        <!-- Navigation arrows mock -->
                        <div class="flex gap-2">
                            <button class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center hover:bg-gray-200"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg></button>
                            <button class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center hover:bg-gray-200"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg></button>
                        </div>
                    </div>

                    @if ($produtosDestaque->isEmpty())
                        <div class="text-center text-sm text-gray-500 py-10 border border-dashed rounded-lg">
                            Nenhum produto em destaque.
                        </div>
                    @else
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @foreach ($produtosDestaque as $produto)
                                <x-product-card :produto="$produto" />
                            @endforeach
                        </div>
                        <div class="text-center mt-10">
                            <a href="{{ route('produtos.index') }}" class="inline-block bg-red-500 text-white font-medium px-10 py-3 rounded text-sm hover:bg-red-600 transition shadow-sm">
                                View All Products
                            </a>
                        </div>
                    @endif
                </div>
                
                <hr class="border-gray-200 my-16">

                <!-- Featured Section mock -->
                <div class="mb-16">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-4 h-8 bg-red-500 rounded-sm"></div>
                        <h2 class="text-red-500 font-bold text-sm">Featured</h2>
                    </div>
                    <h3 class="text-3xl font-bold tracking-tight mb-8">New Arrival</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 h-[500px]">
                        <!-- Big Item -->
                        <div class="bg-black rounded border border-gray-800 p-8 flex flex-col justify-end relative overflow-hidden group">
                            <div class="absolute inset-0 flex items-center justify-center p-8">
                                <!-- Mock image (PS5) -->
                                <div class="w-full h-full bg-gray-900 rounded-lg shadow-2xl flex items-center justify-center text-white text-xl font-bold">PS5 Mockup</div>
                            </div>
                            <div class="relative z-10 text-white w-3/4">
                                <h4 class="font-display font-semibold text-2xl mb-2">PlayStation 5</h4>
                                <p class="text-sm text-gray-300 mb-4">Black and White version of the PS5 coming out on sale.</p>
                                <a href="#" class="inline-flex items-center font-medium border-b border-white pb-1 hover:text-gray-300">Shop Now</a>
                            </div>
                        </div>
                        
                        <!-- Smaller Items Grid -->
                        <div class="grid grid-rows-2 gap-6">
                            <div class="bg-black rounded border border-gray-800 p-6 flex flex-col justify-end relative overflow-hidden group">
                                <div class="absolute right-0 top-0 bottom-0 w-1/2 flex items-center justify-end">
                                   <div class="w-full h-full bg-gray-800 rounded-l-full"></div>
                                </div>
                                <div class="relative z-10 text-white w-2/3">
                                    <h4 class="font-display font-semibold text-xl mb-2">Women's Collections</h4>
                                    <p class="text-sm text-gray-300 mb-4">Featured woman collections that give you another vibe.</p>
                                    <a href="#" class="inline-flex items-center font-medium border-b border-white pb-1 hover:text-gray-300">Shop Now</a>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-6">
                                <div class="bg-black rounded border border-gray-800 p-6 flex flex-col justify-end relative">
                                    <div class="absolute inset-0 flex items-center justify-center p-4">
                                        <div class="w-20 h-20 bg-gray-700 rounded-full"></div>
                                    </div>
                                    <div class="relative z-10 text-white">
                                        <h4 class="font-display font-semibold text-lg mb-1">Speakers</h4>
                                        <a href="#" class="inline-flex items-center font-medium border-b border-white pb-1 hover:text-gray-300 text-sm">Shop Now</a>
                                    </div>
                                </div>
                                <div class="bg-black rounded border border-gray-800 p-6 flex flex-col justify-end relative">
                                    <div class="absolute inset-0 flex items-center justify-center p-4">
                                        <div class="w-20 h-20 bg-gray-700 rounded-full"></div>
                                    </div>
                                    <div class="relative z-10 text-white">
                                        <h4 class="font-display font-semibold text-lg mb-1">Perfume</h4>
                                        <a href="#" class="inline-flex items-center font-medium border-b border-white pb-1 hover:text-gray-300 text-sm">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Features Service mock -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center my-16">
                    <div class="flex flex-col items-center">
                        <div class="w-16 h-16 bg-gray-300 rounded-full flex items-center justify-center mb-4">
                            <div class="w-12 h-12 bg-black text-white rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/></svg>
                            </div>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-1">FREE AND FAST DELIVERY</h4>
                        <p class="text-sm text-gray-500">Free delivery for all orders over $140</p>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="w-16 h-16 bg-gray-300 rounded-full flex items-center justify-center mb-4">
                            <div class="w-12 h-12 bg-black text-white rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            </div>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-1">24/7 CUSTOMER SERVICE</h4>
                        <p class="text-sm text-gray-500">Friendly 24/7 customer support</p>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="w-16 h-16 bg-gray-300 rounded-full flex items-center justify-center mb-4">
                            <div class="w-12 h-12 bg-black text-white rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-1">MONEY BACK GUARANTEE</h4>
                        <p class="text-sm text-gray-500">We return money within 30 days</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
