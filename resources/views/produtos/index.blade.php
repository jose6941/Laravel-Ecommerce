<x-app-layout>
    <x-slot name="header">
        <h2 class="font-display font-semibold text-2xl text-gray-900">
            {{ __('Produtos') }}
        </h2>
    </x-slot>

    <div class="py-10 bg-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="px-4 sm:px-0 space-y-5 mb-8">
                <form method="GET" action="{{ route('produtos.index') }}" class="flex gap-3">
                    @if (request('categoria'))
                        <input type="hidden" name="categoria" value="{{ request('categoria') }}">
                    @endif
                    <div class="relative flex-1">
                        <svg class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.34-4.34M19 11a8 8 0 1 1-16 0 8 8 0 0 1 16 0Z" />
                        </svg>
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar produtos..."
                            class="w-full pl-10 border-gray-300 rounded-none shadow-sm focus:ring-0 focus:border-dark transition">
                    </div>
                    <button type="submit" class="bg-dark text-white rounded-none px-6 text-xs font-bold tracking-widest uppercase hover:bg-gray-800 transition">BUSCAR</button>
                </form>

                @if ($categorias->isNotEmpty())
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('produtos.index', array_filter(['q' => request('q')])) }}"
                           class="inline-flex items-center rounded-full px-5 py-2.5 text-xs font-bold tracking-widest uppercase transition-all duration-300 border
                                  {{ request('categoria') ? 'bg-white text-dark border-gray-200 hover:bg-primary hover:text-white hover:border-primary hover:scale-105 hover:shadow-lg' : 'bg-dark text-white border-dark scale-105 shadow-lg' }}">
                            Todas
                        </a>
                        @foreach ($categorias as $categoria)
                            <a href="{{ route('produtos.index', array_filter(['categoria' => $categoria->slug, 'q' => request('q')])) }}"
                               class="inline-flex items-center rounded-full px-5 py-2.5 text-xs font-bold tracking-widest uppercase transition-all duration-300 border
                                      {{ request('categoria') === $categoria->slug ? 'bg-dark text-white border-dark scale-105 shadow-lg' : 'bg-white text-dark border-gray-200 hover:bg-primary hover:text-white hover:border-primary hover:scale-105 hover:shadow-lg' }}">
                                {{ $categoria->nome }}
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            @if ($produtos->isEmpty())
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-10 text-center mx-4 sm:mx-0">
                    <p class="text-gray-700 font-medium">Nenhum produto encontrado.</p>
                    <p class="text-gray-500 text-sm mt-1">Tente buscar por outro termo ou remover os filtros aplicados.</p>
                </div>
            @else
                <div class="bg-gray-200 rounded-2xl p-4 sm:p-8 mx-4 sm:mx-0">
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-5 sm:gap-6 gsap-products-grid">
                        @foreach ($produtos as $produto)
                            <div class="gsap-product-card">
                                <x-product-card :produto="$produto" />
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-8 px-4 sm:px-0">
                    {{ $produtos->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- GSAP Stagger Animation for Product Grid -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof gsap !== 'undefined') {
                const productsGrid = document.querySelector('.gsap-products-grid');
                if (productsGrid && typeof ScrollTrigger !== 'undefined') {
                    gsap.from('.gsap-product-card', {
                        scrollTrigger: {
                            trigger: productsGrid,
                            start: 'top 85%',
                            toggleActions: 'play none none reverse'
                        },
                        y: 60,
                        opacity: 0,
                        scale: 0.95,
                        duration: 0.7,
                        stagger: 0.1,
                        ease: 'power3.out'
                    });
                }
            }
        });
    </script>
</x-app-layout>