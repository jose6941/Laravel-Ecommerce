<x-app-layout>
    <x-slot name="header">
        <nav class="text-sm text-gray-500 mb-1">
            <a href="{{ route('produtos.index') }}" class="hover:text-violet-600">Produtos</a>
            @if ($produto->categoria)
                <span class="mx-1">/</span>
                <a href="{{ route('produtos.index', ['categoria' => $produto->categoria->slug]) }}" class="hover:text-violet-600">
                    {{ $produto->categoria->nome }}
                </a>
            @endif
        </nav>
        <h2 class="font-display font-semibold text-2xl text-gray-900">
            {{ $produto->nome }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-gray-100 shadow-sm rounded-2xl overflow-hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10 p-6 sm:p-8">

                    {{-- Galeria --}}
                    @if ($produto->imagens->isNotEmpty())
                        <div x-data="{ ativa: '{{ $produto->imagens->first()->url }}' }">
                            <div class="relative aspect-square bg-gray-100 rounded-xl overflow-hidden">
                                <img :src="ativa" alt="{{ $produto->nome }}" class="h-full w-full object-cover">

                                @if ($produto->preco_promocional)
                                    <span class="absolute top-3 left-3 inline-flex items-center rounded-full bg-rose-600 px-2.5 py-1 text-[11px] font-semibold text-white shadow-sm">
                                        -{{ round((1 - $produto->preco_promocional / $produto->preco) * 100) }}%
                                    </span>
                                @endif
                            </div>

                            @if ($produto->imagens->count() > 1)
                                <div class="mt-3 grid grid-cols-4 gap-3">
                                    @foreach ($produto->imagens as $imagem)
                                        <button type="button" @click="ativa = '{{ $imagem->url }}'"
                                                class="aspect-square rounded-lg overflow-hidden border-2 transition"
                                                :class="ativa === '{{ $imagem->url }}' ? 'border-violet-600' : 'border-transparent hover:border-gray-300'">
                                            <img src="{{ $imagem->url }}" alt="{{ $produto->nome }}" class="h-full w-full object-cover">
                                        </button>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="aspect-square bg-gray-100 rounded-xl flex items-center justify-center text-gray-400">
                            Sem imagem
                        </div>
                    @endif

                    {{-- Informações --}}
                    <div class="flex flex-col">
                        <span class="text-sm font-medium text-violet-600 uppercase tracking-wide">{{ $produto->categoria?->nome }}</span>
                        <h1 class="font-display text-3xl font-semibold text-gray-900 mt-1">{{ $produto->nome }}</h1>

                        @if ($produto->avaliacoesAprovadas->isNotEmpty())
                            <div class="mt-2 flex items-center gap-2 text-sm">
                                <span class="text-amber-500">
                                    {{ str_repeat('★', round($produto->avaliacoesAprovadas->avg('nota'))) }}{{ str_repeat('☆', 5 - round($produto->avaliacoesAprovadas->avg('nota'))) }}
                                </span>
                                <span class="text-gray-500">
                                    {{ number_format($produto->avaliacoesAprovadas->avg('nota'), 1, ',', '.') }}
                                    ({{ $produto->avaliacoesAprovadas->count() }} avaliaç{{ $produto->avaliacoesAprovadas->count() === 1 ? 'ão' : 'ões' }})
                                </span>
                            </div>
                        @endif

                        <div class="mt-5 flex items-baseline gap-3">
                            @if ($produto->preco_promocional)
                                <span class="text-base text-gray-400 line-through">R$ {{ number_format($produto->preco, 2, ',', '.') }}</span>
                            @endif
                            <div class="font-display text-3xl font-semibold text-gray-900">
                                R$ {{ number_format($produto->preco_final, 2, ',', '.') }}
                            </div>
                        </div>

                        <p class="mt-5 text-gray-600 leading-relaxed">{{ $produto->descricao }}</p>

                        <div class="mt-5 text-sm">
                            @if ($produto->estoque > 0)
                                <span class="inline-flex items-center gap-1.5 text-emerald-700 bg-emerald-50 rounded-full px-3 py-1 font-medium">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                    Em estoque &middot; {{ $produto->estoque }} unidades
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 text-rose-700 bg-rose-50 rounded-full px-3 py-1 font-medium">
                                    <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span>
                                    Fora de estoque
                                </span>
                            @endif
                        </div>

                        <form method="POST" action="{{ route('carrinho.store', $produto) }}" class="mt-6 flex items-end gap-3">
                            @csrf
                            <div>
                                <x-input-label for="quantidade" value="Quantidade" />
                                <x-text-input id="quantidade" name="quantidade" type="number" min="1" value="1"
                                    class="w-24" :disabled="$produto->estoque <= 0" />
                            </div>

                            <x-primary-button class="px-6 py-2.5" :disabled="$produto->estoque <= 0">
                                Adicionar ao carrinho
                            </x-primary-button>
                        </form>
                    </div>
                </div>

                {{-- Avaliações --}}
                <div class="border-t border-gray-100 px-6 sm:px-8 py-8 bg-gray-50/60">
                    <h3 class="font-display text-lg font-semibold text-gray-900 mb-4">Avaliações</h3>

                    @if ($produto->avaliacoesAprovadas->isEmpty())
                        <p class="text-gray-500 text-sm">Este produto ainda não tem avaliações.</p>
                    @else
                        <div class="space-y-4 mb-8">
                            @foreach ($produto->avaliacoesAprovadas as $avaliacao)
                                <div class="bg-white border border-gray-100 rounded-xl p-4">
                                    <div class="flex items-center justify-between">
                                        <span class="font-medium text-gray-900 text-sm">{{ $avaliacao->usuario?->nome ?? 'Cliente' }}</span>
                                        <span class="text-amber-500 text-sm">{{ str_repeat('★', $avaliacao->nota) }}{{ str_repeat('☆', 5 - $avaliacao->nota) }}</span>
                                    </div>
                                    @if ($avaliacao->comentario)
                                        <p class="text-gray-600 text-sm mt-2">{{ $avaliacao->comentario }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @auth
                        <form method="POST" action="{{ route('avaliacoes.store', $produto) }}" class="max-w-md space-y-3">
                            @csrf
                            <div>
                                <x-input-label for="nota" value="Sua nota (1 a 5)" />
                                <select id="nota" name="nota" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-violet-500 focus:border-violet-500">
                                    @for ($i = 5; $i >= 1; $i--)
                                        <option value="{{ $i }}">{{ $i }} estrela{{ $i > 1 ? 's' : '' }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div>
                                <x-input-label for="comentario" value="Comentário (opcional)" />
                                <textarea id="comentario" name="comentario" rows="3"
                                    class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-violet-500 focus:border-violet-500"></textarea>
                            </div>
                            <x-primary-button>Enviar avaliação</x-primary-button>
                        </form>
                    @else
                        <p class="text-sm text-gray-500">
                            <a href="{{ route('login') }}" class="text-violet-600 hover:underline font-medium">Entre</a> para avaliar este produto.
                        </p>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
