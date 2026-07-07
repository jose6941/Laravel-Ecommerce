<x-app-layout>
    <!-- Seção de Filtros (Busca + Categorias) - estilo editorial igual à home -->
    <div class="py-10 lg:py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="gsap-fade-up">
                <div class="flex items-center gap-3 mb-4">
                    <span class="w-8 h-[2px] bg-gray-400"></span>
                    <span class="text-xs font-bold text-[#1a1a1a] tracking-[0.25em] uppercase font-display">Produtos</span>
                </div>
                <h2 class="text-4xl sm:text-5xl lg:text-6xl font-display font-black text-dark leading-[0.9] uppercase tracking-tighter mb-6">
                    CATÁLOGO<br class="sm:hidden"> COMPLETO
                </h2>
            </div>

            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 mb-8 gsap-fade-up">
                <form method="GET" action="{{ route('produtos.index') }}" class="flex items-center bg-white border border-gray-300 focus-within:border-[#1a1a1a] focus-within:shadow-sm rounded-full overflow-hidden transition-all duration-300 w-full sm:w-auto">
                    @if (request('categoria'))
                        <input type="hidden" name="categoria" value="{{ request('categoria') }}">
                    @endif
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar produtos..."
                           class="text-base bg-transparent border-none px-6 py-3.5 text-dark placeholder-gray-400 focus:outline-none focus:ring-0 w-full sm:w-64 md:w-80 transition-all">
                    <button type="submit" class="px-4 text-gray-400 hover:text-[#1a1a1a] transition-colors duration-300 shrink-0">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </button>
                </form>
                <a href="{{ route('produtos.index') }}" class="inline-flex items-center gap-2 bg-dark text-white px-8 py-3.5 text-base font-bold tracking-widest uppercase rounded-full hover:bg-gray-800 transition-all duration-300 hover:shadow-lg shrink-0">
                    TODOS OS PRODUTOS
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                </a>
            </div>

            @if ($categorias->isNotEmpty())
                <div class="flex flex-wrap justify-start gap-2.5 gsap-category-grid">
                    <a href="{{ route('produtos.index', array_filter(['q' => request('q')])) }}"
                       class="gsap-category-chip group inline-flex items-center gap-2.5 px-6 py-3 rounded-full text-sm font-bold tracking-wider transition-all duration-400 ease-out whitespace-nowrap
                              {{ !request('categoria')
                                  ? 'bg-black/80 border-2 border-black/80 text-white shadow-md hover:bg-white hover:text-dark hover:scale-105 hover:shadow-lg'
                                  : 'bg-white border-2 border-gray-200 text-dark hover:bg-dark hover:text-white hover:border-dark hover:scale-105 hover:shadow-lg' }}">
                        Todas
                        <span class="inline-block transition-transform duration-400 ease-out group-hover:translate-x-1 opacity-60">&rarr;</span>
                    </a>
                    @foreach ($categorias as $categoria)
                        <a href="{{ route('produtos.index', array_filter(['categoria' => $categoria->slug, 'q' => request('q')])) }}"
                           class="gsap-category-chip group inline-flex items-center gap-2.5 px-6 py-3 rounded-full text-sm font-bold tracking-wider transition-all duration-400 ease-out whitespace-nowrap
                                  {{ request('categoria') === $categoria->slug
                                      ? 'bg-black/80 border-2 border-black/80 text-white shadow-md hover:bg-white hover:text-dark hover:scale-105 hover:shadow-lg'
                                      : 'bg-white border-2 border-gray-200 text-dark hover:bg-dark hover:text-white hover:border-dark hover:scale-105 hover:shadow-lg' }}">
                            {{ $categoria->nome }}
                            <span class="inline-block transition-transform duration-400 ease-out group-hover:translate-x-1 opacity-60">&rarr;</span>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Gradiente de transição (mesmo espaçamento da home) -->
    <div class="h-4 lg:h-6 bg-gradient-to-b from-gray-50 to-gray-200"></div>

    <!-- Seção de Produtos - Grid -->    
    <div class="pb-12 lg:pb-16 bg-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if ($produtos->isEmpty())
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-10 text-center">
                    <p class="text-gray-700 font-medium">Nenhum produto encontrado.</p>
                    <p class="text-gray-500 text-sm mt-1">Tente buscar por outro termo ou remover os filtros aplicados.</p>
                </div>
            @else
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4 gsap-products-grid">
                    @foreach ($produtos as $produto)
                        <div class="gsap-product-card">
                            <x-product-card :produto="$produto" />
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $produtos->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- GSAP Stagger Animation (mesmo padrão da home) -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof gsap !== 'undefined') {
                const initProductsGsap = () => {
                    if (typeof ScrollTrigger === 'undefined') {
                        setTimeout(initProductsGsap, 200);
                        return;
                    }

                    // Category chips stagger — apenas movimento, sem opacity (sempre visíveis)
                    const categoryChips = document.querySelectorAll('.gsap-category-chip');
                    const categoryGrid = document.querySelector('.gsap-category-grid');
                    if (categoryChips.length && categoryGrid) {
                        gsap.from(categoryChips, {
                            scrollTrigger: {
                                trigger: categoryGrid,
                                start: 'top 88%',
                                toggleActions: 'play none none none'
                            },
                            y: 15,
                            duration: 0.6,
                            stagger: 0.05,
                            ease: 'power2.out'
                        });
                    }

                    // Fade-up sections — movimento suave (sempre visíveis)
                    const fadeUpElements = document.querySelectorAll('.gsap-fade-up');
                    fadeUpElements.forEach(el => {
                        gsap.from(el, {
                            scrollTrigger: {
                                trigger: el,
                                start: 'top 85%',
                                toggleActions: 'play none none none'
                            },
                            y: 40,
                            duration: 1.0,
                            ease: 'power3.out'
                        });
                    });

                    // Product cards stagger (mesmo da home)
                    const productsGrid = document.querySelector('.gsap-products-grid');
                    if (productsGrid) {
                        gsap.from('.gsap-product-card', {
                            scrollTrigger: {
                                trigger: productsGrid,
                                start: 'top 83%',
                                toggleActions: 'play none none none'
                            },
                            y: 80,
                            opacity: 0,
                            scale: 0.92,
                            duration: 1.1,
                            stagger: 0.12,
                            ease: 'power3.out'
                        });
                    }
                };

                initProductsGsap();
            }
        });
    </script>
</x-app-layout>
