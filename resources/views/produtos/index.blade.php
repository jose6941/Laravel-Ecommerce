<x-app-layout>
    <!-- Seção de Filtros (Busca + Categorias) - estilo editorial igual à home -->
    <div class="py-10 lg:py-12">
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
                <form method="GET" action="{{ route('produtos.index') }}" class="flex items-center bg-white border border-gray-200 focus-within:border-[#1a1a1a] focus-within:shadow-[0_0_0_2px_rgba(0,0,0,0.08),0_4px_16px_rgba(0,0,0,0.08)] rounded-full overflow-hidden transition-all duration-300 w-full sm:w-auto shadow-[0_0_0_1px_rgba(0,0,0,0.06),0_2px_8px_rgba(0,0,0,0.06)]">
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
                       style="opacity: 1"
                       class="gsap-category-chip group inline-flex items-center gap-2.5 px-6 py-3 rounded-full text-sm font-bold tracking-wider transition-[color,background-color,border-color,box-shadow] duration-400 ease-out whitespace-nowrap
                              {{ !request('categoria')
                                  ? 'bg-black/80 border-2 border-black text-white shadow-[0_0_0_2px_rgba(0,0,0,0.15),0_6px_20px_-4px_rgba(0,0,0,0.18)] hover:bg-white hover:text-dark hover:scale-105 hover:shadow-xl'
                                  : 'bg-white border-2 border-gray-200 text-dark shadow-[0_0_0_2px_rgba(0,0,0,0.08),0_6px_20px_-4px_rgba(0,0,0,0.12)] hover:bg-dark hover:text-white hover:border-dark hover:scale-105 hover:shadow-xl' }}">
                        Todas
                        <span class="inline-block transition-[transform,opacity] duration-400 ease-out group-hover:translate-x-1 opacity-60">&rarr;</span>
                    </a>
                    @foreach ($categorias as $categoria)
                        <a href="{{ route('produtos.index', array_filter(['categoria' => $categoria->slug, 'q' => request('q')])) }}"
                           style="opacity: 1"
                           class="gsap-category-chip group inline-flex items-center gap-2.5 px-6 py-3 rounded-full text-sm font-bold tracking-wider transition-[color,background-color,border-color,box-shadow] duration-400 ease-out whitespace-nowrap
                                  {{ request('categoria') === $categoria->slug
                                      ? 'bg-black/80 border-2 border-black text-white shadow-[0_0_0_2px_rgba(0,0,0,0.15),0_6px_20px_-4px_rgba(0,0,0,0.18)] hover:bg-white hover:text-dark hover:scale-105 hover:shadow-xl'
                                      : 'bg-white border-2 border-gray-200 text-dark shadow-[0_0_0_2px_rgba(0,0,0,0.08),0_6px_20px_-4px_rgba(0,0,0,0.12)] hover:bg-dark hover:text-white hover:border-dark hover:scale-105 hover:shadow-xl' }}">
                            {{ $categoria->nome }}
                            <span class="inline-block transition-[transform,opacity] duration-400 ease-out group-hover:translate-x-1 opacity-60">&rarr;</span>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <x-product-grid :produtos="$produtos" />

    <!-- GSAP Stagger Animation (mesmo padrão da home) -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof gsap !== 'undefined') {
                const initProductsGsap = () => {
                    if (typeof ScrollTrigger === 'undefined') {
                        setTimeout(initProductsGsap, 200);
                        return;
                    }

                    // Category chips stagger — animação suave, sem tremor
                    const categoryChips = document.querySelectorAll('.gsap-category-chip');
                    const categoryGrid = document.querySelector('.gsap-category-grid');
                    if (categoryChips.length && categoryGrid) {
                        gsap.set(categoryChips, { opacity: 0, y: 30 });

                        gsap.to(categoryChips, {
                            scrollTrigger: {
                                trigger: categoryGrid,
                                start: 'top 85%',
                                once: true,
                            },
                            y: 0,
                            opacity: 1,
                            duration: 0.9,
                            stagger: { each: 0.08, from: 'start' },
                            ease: 'power3.out',
                            clearProps: 'all'
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

                    // Product cards stagger — animação suave e sem tremor
                    const productsGrid = document.querySelector('.gsap-products-grid');
                    if (productsGrid) {
                        const productCards = document.querySelectorAll('.gsap-product-card');

                        gsap.set(productCards, { opacity: 0, y: 80, scale: 0.92 });

                        gsap.to(productCards, {
                            scrollTrigger: {
                                trigger: productsGrid,
                                start: 'top 83%',
                                once: true,
                            },
                            y: 0,
                            opacity: 1,
                            scale: 1,
                            duration: 1.1,
                            stagger: { each: 0.12, from: 'start' },
                            ease: 'power3.out',
                            clearProps: 'all'
                        });
                    }
                };

                initProductsGsap();
            }
        });
    </script>
</x-app-layout>
