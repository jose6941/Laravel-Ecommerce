<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Produtos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <form method="GET" action="{{ route('produtos.index') }}" class="mb-6 flex gap-3">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar produtos..."
                    class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                <x-primary-button type="submit">Buscar</x-primary-button>
            </form>

            @if ($produtos->isEmpty())
                <div class="bg-white rounded-lg shadow-sm p-6 text-gray-500">
                    Nenhum produto encontrado.
                </div>
            @else
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach ($produtos as $produto)
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

                <div class="mt-8">
                    {{ $produtos->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
