<x-app-layout>
    <div class="bg-gradient-to-br from-violet-50 via-white to-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20">
            <p class="text-sm font-semibold uppercase tracking-widest text-violet-600">Bem-vindo à AcmeStore</p>
            <h1 class="mt-3 font-display text-4xl sm:text-5xl font-semibold text-gray-900 max-w-2xl leading-tight">
                Tudo o que você precisa, <em class="not-italic text-violet-600">num só lugar</em>.
            </h1>
            <p class="mt-4 text-gray-600 max-w-xl">
                Eletrônicos, moda, casa, esporte e muito mais &mdash; com preços justos e entrega para todo o Brasil.
            </p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ route('produtos.index') }}">
                    <x-primary-button class="px-6 py-3 text-sm">Explorar produtos</x-primary-button>
                </a>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-12">

            {{-- Categorias --}}
            @if ($categorias->isNotEmpty())
                <section class="px-4 sm:px-0">
                    <h3 class="font-display text-xl font-semibold text-gray-900 mb-4">Categorias</h3>
                    <div class="flex flex-wrap gap-3">
                        @foreach ($categorias as $categoria)
                            <a href="{{ route('produtos.index', ['categoria' => $categoria->slug]) }}"
                               class="inline-flex items-center rounded-full border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:border-violet-300 hover:bg-violet-50 hover:text-violet-700 transition">
                                {{ $categoria->nome }}
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- Produtos em destaque --}}
            <section class="px-4 sm:px-0">
                <div class="flex items-baseline justify-between mb-4">
                    <h3 class="font-display text-xl font-semibold text-gray-900">Produtos em destaque</h3>
                    <a href="{{ route('produtos.index') }}" class="text-sm font-medium text-violet-600 hover:text-violet-800">
                        Ver todos &rarr;
                    </a>
                </div>

                @if ($produtosDestaque->isEmpty())
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-10 text-center text-gray-500">
                        Nenhum produto em destaque no momento.
                    </div>
                @else
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5">
                        @foreach ($produtosDestaque as $produto)
                            <x-product-card :produto="$produto" />
                        @endforeach
                    </div>
                @endif
            </section>
        </div>
    </div>
</x-app-layout>
