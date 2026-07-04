<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $produto->nome }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-6">
                    <div class="aspect-square bg-gray-100 rounded-lg flex items-center justify-center text-gray-400 overflow-hidden">
                        @if ($produto->imagens->isNotEmpty())
                            <img src="{{ $produto->imagens->first()->url }}" alt="{{ $produto->nome }}" class="w-full h-full object-cover">
                        @else
                            Sem imagem
                        @endif
                    </div>

                    <div class="flex flex-col">
                        <span class="text-sm text-gray-500">{{ $produto->categoria?->nome }}</span>
                        <h1 class="text-2xl font-bold text-gray-900 mt-1">{{ $produto->nome }}</h1>

                        <div class="mt-4">
                            @if ($produto->preco_promocional)
                                <span class="text-sm text-gray-400 line-through">R$ {{ number_format($produto->preco, 2, ',', '.') }}</span>
                            @endif
                            <div class="text-3xl font-bold text-indigo-600">
                                R$ {{ number_format($produto->preco_final, 2, ',', '.') }}
                            </div>
                        </div>

                        <p class="mt-4 text-gray-600">{{ $produto->descricao }}</p>

                        <div class="mt-4 text-sm text-gray-500">
                            @if ($produto->estoque > 0)
                                <span class="text-green-600 font-medium">Em estoque ({{ $produto->estoque }})</span>
                            @else
                                <span class="text-red-600 font-medium">Fora de estoque</span>
                            @endif
                        </div>

                        <form method="POST" action="{{ route('carrinho.store', $produto) }}" class="mt-6 flex items-end gap-3">
                            @csrf
                            <div>
                                <x-input-label for="quantidade" value="Quantidade" />
                                <x-text-input id="quantidade" name="quantidade" type="number" min="1" value="1"
                                    class="w-24" :disabled="$produto->estoque <= 0" />
                            </div>

                            <x-primary-button :disabled="$produto->estoque <= 0">
                                Adicionar ao carrinho
                            </x-primary-button>
                        </form>
                    </div>
                </div>

                {{-- Avaliações --}}
                <div class="border-t px-6 py-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Avaliações</h3>

                    @if ($produto->avaliacoes->isEmpty())
                        <p class="text-gray-500">Este produto ainda não tem avaliações.</p>
                    @else
                        <div class="space-y-4 mb-6">
                            @foreach ($produto->avaliacoes as $avaliacao)
                                <div class="border-b pb-3">
                                    <div class="text-yellow-500">{{ str_repeat('★', $avaliacao->nota) }}{{ str_repeat('☆', 5 - $avaliacao->nota) }}</div>
                                    <p class="text-gray-700 mt-1">{{ $avaliacao->comentario }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @auth
                        <form method="POST" action="{{ route('avaliacoes.store', $produto) }}" class="max-w-md space-y-3">
                            @csrf
                            <div>
                                <x-input-label for="nota" value="Sua nota (1 a 5)" />
                                <select id="nota" name="nota" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    @for ($i = 5; $i >= 1; $i--)
                                        <option value="{{ $i }}">{{ $i }} estrela{{ $i > 1 ? 's' : '' }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div>
                                <x-input-label for="comentario" value="Comentário (opcional)" />
                                <textarea id="comentario" name="comentario" rows="3"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                            </div>
                            <x-primary-button>Enviar avaliação</x-primary-button>
                        </form>
                    @else
                        <p class="text-sm text-gray-500">
                            <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">Entre</a> para avaliar este produto.
                        </p>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
