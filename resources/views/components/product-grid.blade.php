@props(['produtos'])

<div class="pb-12 lg:pb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if ($produtos->isEmpty())
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-10 text-center">
                <p class="text-gray-700 font-medium">Nenhum produto encontrado.</p>
                <p class="text-gray-500 text-sm mt-1">Tente buscar por outro termo ou remover os filtros aplicados.</p>
            </div>
        @else
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3 sm:gap-4 lg:gap-5 gsap-products-grid">
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
