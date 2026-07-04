<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bem-vindo à loja') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">

            {{-- Categorias --}}
            @if ($categorias->isNotEmpty())
                <section>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Categorias</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                        @foreach ($categorias as $categoria)
                            <a href="{{ route('produtos.index', ['categoria' => $categoria->slug]) }}"
                               class="bg-white rounded-lg shadow-sm p-4 text-center hover:shadow-md transition">
                                <span class="block text-sm font-medium text-gray-700">{{ $categoria->nome }}</span>
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- Produtos em destaque --}}
            <section>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Produtos em destaque</h3>

                @if ($produtosDestaque->isEmpty())
                    <div class="bg-white rounded-lg shadow-sm p-6 text-gray-500">
                        Nenhum produto em destaque no momento.
                    </div>
                @else
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach ($produtosDestaque as $produto)
                            <a href="{{ route('produtos.show', $produto) }}"
                               class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition flex flex-col">
                                <div class="aspect-square bg-gray-100 flex items-center justify-center text-gray-400 text-sm">
                                    @if ($produto->imagens->isNotEmpty())
                                        <img src="{{ $produto->imagens->first()->url }}" alt="{{ $produto->nome }}" class="w-full h-full object-cover">
                                    @else
                                        Sem imagem
                                    @endif
                                </div>
                                <div class="p-4 flex-1 flex flex-col">
                                    <span class="text-xs text-gray-500">{{ $produto->categoria?->nome }}</span>
                                    <span class="font-medium text-gray-900 mt-1">{{ $produto->nome }}</span>
                                    <span class="mt-auto pt-2 font-semibold text-indigo-600">
                                        R$ {{ number_format($produto->preco_final, 2, ',', '.') }}
                                    </span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </section>

            <div>
                <a href="{{ route('produtos.index') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                    Ver todos os produtos &rarr;
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
